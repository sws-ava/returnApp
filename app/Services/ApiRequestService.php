<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ApiRequestService
{
    public function __construct()
    {

    }

    public static function getReturnReasonsList(){
        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get('erp_token')
        ])->get(env('API_URL').'/api/v2/reason-returns');

        $response = json_decode($response);
        return $response->data;
    }

    public static function getOrderData($barcode){
        $query = self::encodeQuery($barcode);
        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get('erp_token')
        ])->get(env('API_URL').'/api/v2/document-return-requests?filters='.$query.'&include=userRows');
        
        $response = json_decode($response);
        if(!empty($response->data[0])){
            return $response->data[0];
        }else{
            return false;
        }
    }



    public static function storeDataToErp($request){
        $newReturnRequestDoc = self::getReturnDocumentId($request);
        self::storeReturnDocumentRows($newReturnRequestDoc->data->id, $request);
        return $newReturnRequestDoc;
    }

    public static function getReturnDocumentId($request){
        $prepareData = [
            'document_return_request_status_id' => 1,
            'document_return_request_type_id' => $request['pay-type'],
            'structure_id' => 1,
            'date' => Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i'),
            'return_barcode' => $request['return_barcode'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'client_fio' => $request['name'],
            'order_number' => $request['order_number'],
            'order_date' => Carbon::createFromFormat('d.m.Y', $request['order_date'])->add(1, 'day')->setTimezone('Europe/Moscow')->format('Y-m-d')
        ];
        
        $userBank = [
            'recipient_fio' => $request['fio'],
            'bik' => $request['bik'],
            'bank' => $request['bank'],
        ];

        if($request['pay-type'] == 2){
            $prepareData = array_merge($prepareData, $userBank);
        }

        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get('erp_token')
        ])->post(env('API_URL').'/api/v2/document-return-requests', $prepareData);
        
        $response = json_decode($response);
        
        if(isset($response->data)){
            return $response;
        }
        return $response;
    }

    public static function storeReturnDocumentRows($docId, $request){
        foreach($request->rows as $row){
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . Cache::get('erp_token')
            ])->post(env('API_URL').'/api/v2/document-return-request-user-rows', [
                'document_return_request_id' => $docId,
                'article' => $row['article'],
                'quantity' => $row['count'],
                'product_name' =>  $row['name'],
                'price' => $row['price'],
                'reason_return_id' =>   $row['reason'],
                'size' =>  $row['size']
            ]);            
        }
    }










    public static function encodeQuery($query){
        $search = [
            [
                'key' => 'document-return-request-searches',
                'value' => [
                    'query' => strval($query)
                ]
            ]
        ];
        return base64_encode(json_encode($search));
    }
}
