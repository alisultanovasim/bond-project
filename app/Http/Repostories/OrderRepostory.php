<?php

namespace App\Http\Repostories;

use App\Models\Bond;
use App\Models\Order;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderRepostory
{
    use ApiResponse;
    public function create($bond_id,$orderData)
    {
        $order              = new Order();
        $order->bond_id     = $bond_id;
        $order->order_date  = $orderData->order_date;
        $order->bond_amount = $orderData->bond_amount;
        $order->save();

        return $order;
    }

    public function update($id,$orderData)
    {
        $order=Order::query()->findOrFail($id);
        if ($orderData->order_date){
            $order->update(['order_date'=>$orderData->order_date]);
        }
        if ($orderData->bond_amount){
            $order->update(['bond_amount'=>$orderData->bond_amount]);
        }
        $order->save();

        return $order;
    }
}
