<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='orders';
    protected $guarded='id';
    protected $fillable=[
        'bond_id',
        'order_date',
        'bond_amount'
    ];

    public function bond()
    {
        return $this->belongsTo(Bond::class,'id','bond_id');
    }
}
