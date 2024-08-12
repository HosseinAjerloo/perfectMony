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
    protected $data = [];

    public function payment()
    {


        $res = $this->GetToken();

        if ($res) {
            if ($res[0] == 0) {
                return false;
            } elseif ($res[0] == 1) {
                $token = $res[1];
                return $token;
            }
        } else {
            return false;
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
        if ($result) {
            if ($result->status == 1) {
                $token = $result->token;
                return array(1, $token);
            } else {
                return array(0, $result->errorDesc);
            }
        } else {
            return false;
        }


    }

    public function backBank()
    {
        $refNum = request()->input('RefNum');
        $resNum = request()->input('ResNum');
        if (isset($refNum) and isset($resNum)) {
            return true;
        } else
            return false;
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
        $this->totalPrice = $price;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setBankUrl($url)
    {
        $this->bannkUrl = $url;
    }

    public function getBankUrl()
    {
        return $this->bannkUrl;
    }

    public function setTerminalId($terminalId)
    {
        $this->terminalId = $terminalId;
    }

    public function getTerminalId()
    {
        return $this->terminalId;
    }


    public function setUrlBack($urlBack)
    {
        $this->urlBack = $urlBack;
    }

    public function getUrlBack()
    {
        return $this->urlBack;
    }

    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    }

    public function getOrderID()
    {
        return $this->orderID;
    }

    public function samanTransactionStatus($ErrorCode)
    {

        $return_value = match ($ErrorCode) {
            "1" => "کاربر انصراف داده است",
            "2" => "پرداخت با موفقیت انجام شد",
            "3" => "پرداخت انجام نشد",
            "4" => "کاربر در بازه زمانی تعیین شده پاسخی ارسال نکرده است",
            "5" => "پارامترهای ارسالی نامعتبر است",
            "8" => "آدرس سرور پذیرنده نامعتبر است (در پرداخت های بر پایه توکن)",
            "10" => "توکن ارسال شده یافت نشد",
            "11" => "با این شماره ترمینال فقط تراکنش های توکنی قابل پرداخت هستند",
            "12" => "شماره ترمینال ارسال شده یافت نشد",
            "43" => "قبلاً درخواست Verify شده است !",
            "502" => "ناتواني در اتصال به سرور بانک جهت تاييد تراکنش !",
            "504" => "رسيد ديجيتالي برگشت داده شده توسط بانک خالي مي باشد !",
            "505" => "رسيد ديجيتالي برگشت داده شده توسط بانک تکراري مي باشد !",
            "602" => "در عمليات تاييد تراکنش از سمت بانک خطايي رخ داده است !",
            "603" => "مبلغ پرداخت شده صحيح نمي باشد !",
            "909" => "ناتوانی در ذخیره کردن کد بانک",
            default => "کد ارور: " . $ErrorCode

        };
        return $return_value;


    }

    public function samanVerifyTransaction($ErrorCode)
    {

        $return_value = match ($ErrorCode) {
            "-1" => "خطای داخلی شبکه مالی",
            "-3" => "ورودیها حاوی کارکترهای غیرمجاز میباشند.",
            "-4" => "ed Authentication Merchant ) کلمه عبور یا کد فروشنده اشتباه است)",
            "-6" => "سند قبلا برگشت کامل یافته است.",
            "-7" => "رسید دیجیتالی تهی است",
            "-8" => "طول ورودی ها بیشتر از حد مجاز است",
            "-9" => "وجود کارکترهای غیرمجاز در مبلغ برگشتی",
            "-10" => "رسید دیجیتالی به صورت 64Base ین ست (حاو ی کارکترها یغ ی رمجاز است)",
            "-11" => "طول ورودیها کمتر از حد مجاز است",
            "-12" => "مبلغ برگشتی منفی است",
            "-13" => "مبلغ برگشتی برای برگشت جزئی بیش از مبلغ برگشت نخورده ی رسید دیجیتالی",
            "-14" => "چنین تراکنشی تعریف نشده است",
            "-15" => "مبلغ برگشت به صورت اعشاری داده شده است",
            "-16" => "خطای داخل سیستم",
            "-17" => "برگشت زدن جزیی تراکنشی که با کارت بانکی غیر از بانک سامان انجام پذیرفته است",
            "-18" => "Address IP فروشنده نا معتبر است. ",
            default => "کد ارور: " . $ErrorCode

        };
        return $return_value;


    }

}
