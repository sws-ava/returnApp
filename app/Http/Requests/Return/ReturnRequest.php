<?php

namespace App\Http\Requests\Return;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:191',
            'email' => 'required|email',
            'phone' => 'required|string',
            'order_number' => 'string',
            'order_date' => 'required|string',
            'pay-type' => 'required|string',
            // 'fio' => 'string',
            // 'bik' => 'string',
            // 'bank' => 'string',
            // 'sum' => 'string'
        ];
    }
}
