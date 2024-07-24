<?php

namespace App\Services\BankService;

use App\Interface\BankInterface;

class Saman implements BankInterface
{
    protected $totalPrice;
    protected $urlBack;
    protected $bannkUrl;
    protected $action;
    protected $terminalId;
    protected $orderID;
    protected $data=[];

    public function payment()
    {
        $this->orderID = rand(100000, 999999);



        $res=$this->GetToken();
        if ($res[0] == 0) {
            return false;
        } elseif ($res[0] == 1) {
            $token = $res[1];
            return $token;
        }

    }

    public function GetToken()
    {
        $this->generateData();
        $data = json_encode($this->data);


        $curl = curl_init($this->getBankUrl());
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');
        $result = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($result);

        if ($result->status == 1) {
            $token = $result->token;
            return array(1, $token);
        } else {
            return array(0, $result->errorDesc);
        }
    }


    private function generateData()
    {
        $this->data = array(
            'action' => 'Token',
            'TerminalId' => $this->getTerminalId(),
            'ResNum' => $this->orderID,
            'Amount' => $this->getTotalPrice(),
            'RedirectUrl' => $this->getUrlBack()
        );

    }
    public function setTotalPrice($price)
    {
        $this->totalPrice=$price;
    }
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
    public function setBankUrl($url)
    {
        $this->bannkUrl=$url;
    }
    public function getBankUrl()
    {
        return $this->bannkUrl;
    }
    public function setTerminalId($terminalId)
    {
        $this->terminalId=$terminalId;
    }
    public function getTerminalId()
    {
        return $this->terminalId;
    }


    public function setUrlBack($urlBack)
    {
        $this->urlBack=$urlBack;
    }
    public function getUrlBack()
    {
        return $this->urlBack;
    }

}
