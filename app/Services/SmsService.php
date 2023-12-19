<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SmsService
{
    public function __construct()
    {

    }

    public static function sendSms($orderNum, $phone){

        $login = 'Selfmade';
        $pass = 'Selfmade2023';
        $orderNumber = '';
        if($orderNum){
            $orderNumber = $orderNum;
        }else{
            return;
        }
        $message = 'Ваше заявление №'.$orderNumber.' принято. SELFMADE.';

        $or_id = Http::get('https://smsimple.ru/http_origins.php?user='.$login.'&pass='.$pass);
        $response =  Http::get('https://smsimple.ru/http_send.php?user='.$login.'&pass='.$pass.'&or_id='.$or_id.'&phone='.$phone.'&message='.$message);
        return $response;
    }
}
