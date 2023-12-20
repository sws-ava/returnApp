<?php

namespace App\Http\Controllers\Return;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Return\ReturnRequest;
use Illuminate\Support\Facades\Redirect;
use PDF;


use App\Services\TokenService;
use App\Services\ApiRequestService;
use App\Services\SmsService;

use Illuminate\Support\Facades\Mail;


use App\Mail\ReturnRequestMail;

class ReturnController extends Controller
{
    public function index(){
        TokenService::checkErpToken();

        $returnReasonsList = ApiRequestService::getReturnReasonsList();

        return view('return.index', [
            'returnReasonsList' => $returnReasonsList,
        ]);
    }

    public function show($barcode){

        TokenService::checkErpToken();

        $returnReasonsList = ApiRequestService::getReturnReasonsList();
        $item = ApiRequestService::getOrderData($barcode);

        if($item){
            $total = 0;
            foreach($item->relationships->userRows as $row){
                if($row->attributes->quantity && $row->attributes->price){
                    $total += $row->attributes->quantity * $row->attributes->price;
                }
            }
            // $document_barcode = $item->attributes->return_barcode;
            return view('return.show', [
                'returnReasonsList' => $returnReasonsList,
                'item' => $item,
                'total' => $total
            ]);
        }

        return view('return.index', [
            'returnReasonsList' => $returnReasonsList,
        ]);
        
    }

    public function create(Request $request){

        TokenService::checkErpToken();
        $request['phone'] = $this->normilizePhone($request['phone']);
        $newReturnRequestDoc = ApiRequestService::storeDataToErp($request);
        $returnReasonsList = ApiRequestService::getReturnReasonsList();
        if(!empty($newReturnRequestDoc->data->id)){
            $sms = SmsService::sendSms($newReturnRequestDoc->data->id, $request['phone']);
        }

        $document_barcode = $newReturnRequestDoc->data->attributes->return_barcode;
        $item = ApiRequestService::getOrderData($document_barcode);

        $total = 0;
        $pdf = PDF::loadView('return.return_pdf', [
            'data' => $item,
            'total' => $total,
            'returnReasonsList' => $returnReasonsList
        ]);

        Mail::to($request['email'])->send(new ReturnRequestMail($newReturnRequestDoc->data->id, $pdf->output()));

        return redirect()->route('return.show', $document_barcode);
    }

    public function return_pdf($barcode){

        TokenService::checkErpToken();
        $returnReasonsList = ApiRequestService::getReturnReasonsList();
        $item = ApiRequestService::getOrderData($barcode);

        if(!empty($item->id)){
            $total = 0;
            $pdf = PDF::loadView('return.return_pdf', [
                'data' => $item,
                'total' => $total,
                'returnReasonsList' => $returnReasonsList
            ]);
            return $pdf->stream('returnReqest.pdf');
        }
        
        return view('return.index', [
            'returnReasonsList' => $returnReasonsList,
        ]);
    }
    public function normilizePhone($phone){
        return str_replace(['+', ' ', '(', ')', '-'], ['', '', '', '', '',], $phone);
    }
}
