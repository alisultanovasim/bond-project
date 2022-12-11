<?php

namespace App\Http\Repostories;

use App\Models\Bond;

class BondRepostory
{
    public function create($bondData)
    {
        $bond                             = new Bond();
        $bond->emission_date              = $bondData->emission_date;
        $bond->last_turnover_date         = $bondData->last_turnover_date;
        $bond->nominal_price              = $bondData->nominal_price;
        $bond->pay_frequency              = $bondData->pay_frequency;
        $bond->percent_calculation_period = $bondData->percent_calculation_period;
        $bond->coupon_percent             = $bondData->coupon_percent;
        $bond->save();

        return $bond;
    }

    public function update($id,$bondData)
    {
        $bond=Bond::query()->findOrFail($id);
        if ($bondData->emission_date){
            $bond->update(['emission_date'=>$bondData->emission_date]);
        }
        if ($bondData->last_turnover_date){
            $bond->update(['last_turnover_date'=>$bondData->last_turnover_date]);
        }
        if ($bondData->nominal_price){
            $bond->update(['nominal_price'=>$bondData->nominal_price]);
        }
        if ($bondData->pay_frequency){
            $bond->update(['pay_frequency'=>$bondData->pay_frequency]);
        }
        if ($bondData->percent_calculation_period){
            $bond->update(['percent_calculation_period'=>$bondData->percent_calculation_period]);
        }
        if ($bondData->coupon_percent){
            $bond->update(['coupon_percent'=>$bondData->coupon_percent]);
        }
        $bond->save();

        return $bond;
    }
}
