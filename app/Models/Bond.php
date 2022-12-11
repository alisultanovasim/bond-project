<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bond extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='bonds';
    protected $guarded='id';
    protected $fillable=[
        'emission_date',
        'last_turnover_date',
        'nominal_price',
        'pay_frequency',
        'percent_calculation_period',
        'coupon_percent'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class,'bond_id','id');
    }
}
