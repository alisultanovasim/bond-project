<?php

namespace App\Http\Controllers;

use App\Http\Repostories\BondRepostory;
use App\Http\Requests\BondCreateRequest;
use App\Http\Requests\BondUpdateRequest;
use App\Models\Bond;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BondController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->dataResponse(Bond::all(),Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BondCreateRequest $request, BondRepostory $bondRepostory)
    {
        $bondRepostory->create($request);
        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'İstiqraz uğurla yaradıldı!'],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->dataResponse(Bond::query()->findOrFail($id),Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BondUpdateRequest $request, $id,BondRepostory $bondRepostory)
    {
        $bondRepostory->update($id,$request);
        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'İstiqraz uğurla olundu!'],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $bond=Bond::query()->findOrFail($id);
        $bond->delete();
        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'İstiqraz silindi!'],Response::HTTP_OK);
    }
}
