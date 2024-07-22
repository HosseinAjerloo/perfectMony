<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
///beginpayment.php
$orderid= rand(100000, 999999);;
var_dump($orderid);
$bankRef= 13;
$TotalPrice=10000;


//$orderinfo = get_order_info($orderid);  // گرفتن اطلاعا پرداخت مشترک

// Redirect URL
$url = 'saman2.php';


//$bankinfo = get_bank_info('saman');//گرفتن اطاعات بانک

$bankinfo['Bank']="saman";
$bankUrl="https://sep.shaparak.ir/MobilePG/MobilePayment";
switch ($bankinfo['Bank']) {
    case "saman" :
        //ثبت اطلاعات بانک انتخابی
        //update_order_bank($orderid, 'SAMAN', $bankinfo['Serial']);

// گرفتن توکن پرداخت از بانک
        $res = samanGetToken($bankUrl,$orderid, $TotalPrice, $url);
        if ($res[0] == 0) {
            echo "<pre>";
            var_dump($res,$orderid,$TotalPrice,$url);
            echo "<pre>";
            die('تراکنش تکراری');
        } elseif ($res[0] == 1) {
            $token = $res[1];

            echo "<script language='javascript' type='text/javascript'>postSamanRefId('" . $token . "','" . $bankUrl . "');</script>";
        }
        break;
    default :
        $_SESSION['display_message'] = "بانک انتخاب شده از سوی شما جهت انجام پرداخت آنلاین نامعتبر می باشد !";
        $_SESSION['display_message_type'] = "error";
        header('Location:' . $url);
        die();
        break;
    /*#################################################################################################*/

}

function samanGetToken($bankUrl, $orderID, $amount, $url)
{
//    گرفتن اطلاعات بانک منتخب
//    $bankDetails = $bankDetails[1];

    $data = array(
        'action' => 'Token',
        'TerminalId' => 13595227,
        'ResNum' => $orderID,
        'Amount' => $amount,
        'RedirectUrl' => $url
    );
    $data = json_encode($data);

    $curl = curl_init($bankUrl);
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
?>
<script>
    function postSamanRefId(Token, Url) {
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", Url);
        form.setAttribute("target", "_self");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("name", "Token");
        hiddenField.setAttribute("value", Token);
        form.appendChild(hiddenField);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>


