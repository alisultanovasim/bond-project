<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BondUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emission_date'=>['nullable','date'],
            'last_turnover_date'=>['nullable','date'],
            'nominal_price'=>['nullable','numeric'],
            'pay_frequency'=>['nullable','numeric','in:1,2,4,12'],
            'percent_calculation_period'=>['nullable','numeric','in:360,364,365'],
            'coupon_percent'=>['nullable','numeric','min:1','max:100']
        ];
    }
}
