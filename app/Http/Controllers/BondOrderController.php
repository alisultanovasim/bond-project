<?php

namespace App\Http\Controllers;

use App\Http\Repostories\OrderRepostory;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Bond;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BondOrderController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->dataResponse(Order::all(),Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderCreateRequest $request,$id,OrderRepostory $orderRepostory)
    {
        $bond=Bond::query()->findOrFail($id);

        if ($bond->emission_date >= $request->order_date){
            return $this->errorResponse('Sifariş tarixi emissiya tarixindən az ola bilməz',Response::HTTP_BAD_REQUEST);
        }
        if ($bond->last_turnover_date <= $request->order_date){
            return $this->errorResponse('Sifariş tarixi son tədavül tarixindən çox ola bilməz',Response::HTTP_BAD_REQUEST);
        }
        $orderRepostory->create($request);

        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'Sifaris yaradıldı!'],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->dataResponse(Order::query()->findOrFail($id),Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OrderUpdateRequest $request, $id,OrderRepostory $orderRepostory)
    {
        $orderRepostory->update($id,$request);
        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'İstiqraz yenilendi!'],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $bond=Order::query()->findOrFail($id);
        $bond->delete();
        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'Sifaris silindi!'],Response::HTTP_OK);
    }
}
