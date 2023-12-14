<?php

namespace App\Http\Controllers\Return;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Return\ReturnRequest;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use PDF;
// use Picqer\Barcode\BarcodeGeneratorPNG;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ReturnController extends Controller
{
    public function index(){
        Cache::put('erp_token', $this->getErpToken());
        $returnReasonsList = $this->getReturnReasonsList();
        
        return view('return.index', [
            'returnReasonsList' => $returnReasonsList->data,
        ]);
    }

    public function getReturnReasonsList(){
        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . Cache::get('erp_token')
        ])->get(env('API_URL').'/api/v2/reason-returns');

        $response = json_decode($response);
        return $response;
    }

    public function return_pdf(Request $request){

        $data = $request;

        $data['phone'] = str_replace(['+', ' ', '(', ')', '-'], ['', '', '', '', '',], $data['phone']);

        $isStoreDataToErp = $this->storeDataToErp($data);
        $returnReasonsList = $this->getReturnReasonsList();

        if($isStoreDataToErp){
            $total = 0;
            foreach($data->rows as $row){
                if($row['count'] && $row['price']){
                    $total += $row['count'] * $row['price'];
                }
            }
            $rows = $data->rows;
            $pdf = PDF::loadView('return.return_pdf', [
                'data' => $data,
                'total' => $total,
                'returnReasonsList' => $returnReasonsList->data
            ]);
            return $pdf->stream('returnReqest.pdf');
        }
    }
    
    public function storeDataToErp($request){

        $docId = $this->getReturnDocumentId($request);
        if($docId){
            $this->storeReturnDocumentRows($docId, $request);
            return true;
        }else{
            return Redirect::back();
        }

        return false;
    }

    public function getReturnDocumentId($request){
        $prepareData = [
            'document_return_request_status_id' => 1,
            'document_return_request_type_id' => $request['pay-type'],
            'structure_id' => 2,
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
            return $response->data->id;
        }
        return $response;
    }

    public function storeReturnDocumentRows($docId, $request){
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

    
    public function getErpToken(){

        $response = Http::post(env('API_URL').'/api/v1/auth/login', [
            'login' => env('SECRET_LOGIN'),
            'password' => env('SECRET_PASSWORD'),
        ]);

        $response = json_decode($response);

        if(isset($response->data->user->token)){
            return $response->data->user->token;
        }
        return 000;
    }

}
