<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BondCreateRequest extends FormRequest
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
            'emission_date'=>['required','date'],
            'last_turnover_date'=>['required','date'],
            'nominal_price'=>['required','numeric'],
            'pay_frequency'=>['required','numeric','in:1,2,4,12'],
            'percent_calculation_period'=>['required','numeric','in:360,364,365'],
            'coupon_percent'=>['required','numeric','min:1','max:100']
        ];
    }
}
