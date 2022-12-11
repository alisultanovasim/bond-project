<?php

namespace App\Http\Controllers;

use App\Http\Repostories\OrderRepostory;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Bond;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class BondActionController extends Controller
{
    use ApiResponse;
    public function createOrder(OrderCreateRequest $request,$id,OrderRepostory $orderRepostory)
    {
        $bond=Bond::query()->findOrFail($id);

        if ($bond->emission_date >= $request->order_date){
            return $this->errorResponse('Sifariş tarixi emissiya tarixindən az ola bilməz',Response::HTTP_BAD_REQUEST);
        }
        if ($bond->last_turnover_date <= $request->order_date){
            return $this->errorResponse('Sifariş tarixi son tədavül tarixindən çox ola bilməz',Response::HTTP_BAD_REQUEST);
        }
        $orderRepostory->create($bond->id,$request);

        return $this->successResponse(['status'=>'Uğurlu','mesaj'=>'Sifaris yaradıldı!'],Response::HTTP_CREATED);
    }
    public function payouts($id)
    {
        $bond=Bond::query()->findOrFail($id);
        $period=$bond->percent_calculation_period;
        $frequency=$bond->pay_frequency;

        $withDay1=0;
        $withDay2=0;
        $withMonth=0;

        switch ($period){
            case 360:
                $withDay1 = 12 /$frequency;
                $withDay1*=30;
            break;
            case 364:
                $withDay2 = 364 /$frequency;
            break;
            case 365:
                $withMonth = 12 /$frequency;
            break;
        }

        $date=$bond->selectRaw('DATE_FORMAT(emission_date,"%Y-%m-%d") as date')->get();
        $strDate=$date[0]['date'];
//        dd($strDate);
        $dueDateTime = Carbon::createFromFormat('Y-m-d', $strDate, 'Asia/Baku');
//        dd($dueDateTime->addDays('182')->format('Y-m-d'));
        $dateArr=array();
        if ($withDay1){
            $interval=$withDay1/30;
            for($i=0;$i<$interval;$i++){
                if ($dueDateTime->dayOfWeek=='0'){
                    $dueDateTime->addDay();
                }
                if ($dueDateTime->dayOfWeek=='6'){
                    $dueDateTime->addDays(2);
                }
                $dateArr[] = ['date' => $dueDateTime->addMonth()->format('Y-m-d')];

            }
            return response()->json(['dates'=>$dateArr]);
        }
        if ($withDay2){
            $interval=$withDay2/30;
            for($i=0;$i<$interval;$i++){
                if ($dueDateTime->dayOfWeek=='0'){
                    $dueDateTime=$dueDateTime->addDay();
                }
                if ($dueDateTime->dayOfWeek=='6'){
                    $dueDateTime=$dueDateTime->addDays(2);
                }
                $dateArr[] = ['date' => $dueDateTime->addMonth()->format('Y-m-d')];
            }
            return response()->json(['dates'=>$dateArr]);

        }
        if ($withMonth){
            for($k=0;$k<$withMonth;$k++){
                if ($dueDateTime->dayOfWeek=='0'){
                    $dueDateTime=$dueDateTime->addDay();
                }
                if ($dueDateTime->dayOfWeek=='6'){
                    $dueDateTime=$dueDateTime->addDays(2);
                }
                $dateArr[] = ['date' => $dueDateTime->addMonth()->format('Y-m-d')];
            }
            return response()->json(['dates'=>$dateArr]);
        }

        return $period;
    }

//    public function perPay($id)
//    {
//        $order=Order::query()->findOrFail($id);
//        $bond=Bond::query()->findOrFail($order->bond_id);
//        $period=$bond->percent_calculation_period;
//        $frequency=$bond->pay_frequency;
//
//        $withDay1=0;
//        $withDay2=0;
//        $withMonth=0;
//
//        switch ($period){
//            case 360:
//                $withDay1 = 12 /$frequency;
//                $withDay1*=30;
//                break;
//            case 364:
//                $withDay2 = 364 /$frequency;
//                break;
//            case 365:
//                $withMonth = 12 /$frequency;
//                break;
//        }
//   }
}
