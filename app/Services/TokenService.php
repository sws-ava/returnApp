<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TokenService
{
    public function __construct()
    {

    }

    public static function checkErpToken(){

        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get('erp_token')
        ])->get(env('API_URL').'/api/v2/reason-returns');

        $response = json_decode($response);

        if(!empty($response->message)){
            Cache::put('erp_token', self::getErpToken());
        }

        return true;
    }


    public static function getErpToken()
    {
        $response = Http::post(env('API_URL').'/api/v1/auth/login', [
            'login' => env('SECRET_LOGIN'),
            'password' => env('SECRET_PASSWORD'),
        ]);

        $response = json_decode($response);

        if(isset($response->data->user->token)){
            return $response->data->user->token;
        }
    }
}
