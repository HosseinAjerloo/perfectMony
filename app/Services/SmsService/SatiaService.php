<?php

namespace App\Services\SmsService;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SatiaService
{
    private $status = false;


    public function send($message, $mobile, $number_service='30006928', $username_service='New137', $password_service='140101101', $url_service = null, $token_service = null)
    {

        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'text/xml; charset=utf-8'
            ];
            $body = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <SendMessage xmlns="http://tempuri.org/">

                <Username>' . $username_service . '</Username>

                <Password>' . $password_service . '</Password>

                <Number>' . $number_service . '</Number>

                <Mobile>
                    <string>' . $mobile . '</string>
                </Mobile>

                <Message>' . $message . '</Message>

                <Type>1</Type>
            </SendMessage>
        </soap:Body>
        </soap:Envelope>';
            //IP: http://srv.satiaisp.com
            //Port: 8105
            $request = Http::withOptions([

                "curl" => [
//                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                    // CURLOPT_SSL_VERIFYHOST=>2,
                    // CURLOPT_SSL_VERIFYPEER =>true,
                    // CURLOPT_SSL_CIPHER_LIST=>'ECDHE-RSA-AES256-GCM-SHA384,ECDHE-RSA-AES128-GCM-SHA256,DHE-RSA-AES256-GCM-SHA384,DHE-RSA-AES128-GCM-SHA256'
                ]

            ])->withHeaders(['Content-Type' => 'text/xml; charset=utf-8'])->withBody($body, 'text/xml; charset=utf-8')->post("https://wssms.satia.co/");
            if (strpos($request->body(), 'ارسال با موفقیت')) {
                $this->status = true;
            }
        } catch (\Exception $e) {
            Log::emergency($e->getMessage());
        }

    }

    public function status(): bool
    {
        return $this->status;
    }

    public function getCharge($username, $password)
    {

        try {
            $body = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <credit xmlns="http://tempuri.org/">
                      <Username>' . $username . '</Username>
                      <Password>' . $password . '</Password>
                    </credit>
                </soap:Body>
            </soap:Envelope>';
            $request = Http::withOptions([

                "curl" => [
//                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                    //  CURLOPT_SSL_VERIFYHOST=>2,
                    // CURLOPT_SSL_VERIFYPEER =>true,
                    // CURLOPT_SSL_CIPHER_LIST=>'ECDHE-RSA-AES256-GCM-SHA384,ECDHE-RSA-AES128-GCM-SHA256,DHE-RSA-AES256-GCM-SHA384,DHE-RSA-AES128-GCM-SHA256'
                ]

            ])->withHeaders(['Content-Type' => 'text/xml; charset=utf-8'])->withBody($body, 'text/xml; charset=utf-8')->post("https://wssms.satia.co/");

            $response = $request->body();

            if (str_contains($response, 'creditResult')) {
                $start = strpos($response, "<creditResult>");
                $startContent = $start + strlen("<creditResult>");
                $end = strpos($response, "</creditResult>");
                $content = substr($response, $startContent, $end - $startContent);
                $response = $content;
            }
            return $response == 'error' ? 'محاسبه نشد' : $response;
        } catch (\Exception $e) {
            EmergencyLog::create(
                [
                    "user_id" => Auth::user()->id,
                    "data" => null,
                    "is_success" => 1,
                    'client_ip' => request()->ip(),
                    'group' => "پیامک",
                    "message" => 'خطا در سرویس ارسال پیامک رخ داده است لطفا فایل لاگ مشاهده شود'
                ]
            );
            Log::emergency($e->getMessage());
        }

    }
}
