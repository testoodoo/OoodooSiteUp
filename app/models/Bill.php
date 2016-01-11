<?php

class Bill extends \LaravelBook\Ardent\Ardent {

	protected $table = 'bill_det';

	function billInfo($bill_no,$account_id,$for_month)
	{
            $discount=Discount::where('account_id','=',$account_id)
                                       ->where('for_month','=',$for_month)->get();
                                       foreach ($discount as $key => $value) {
                                         $discount_id[]=$value->id;
                                       }
            $adjustment=Adjustment::where('account_id','=',$account_id)
                                  ->where('for_month','=',$for_month)->get();
                                  foreach ($adjustment as $key => $value) {
                                         $adjustment_id[]=$value->id;
                                       }
            $othercharges=OtherCharges::where('account_id','=',$account_id)
                                      ->where('for_month','=',$for_month)->get();
                                      foreach ($othercharges as $key => $value) {
                                         $othercharges_id[]=$value->id;
                                       }
            $devicecost=DeviceCost::where('account_id','=',$account_id)
                                         ->where('for_month','=',$for_month)->get();
                                         foreach ($devicecost as $key => $value) {
                                         $devicecost_id[]=$value->id;
                                         //var_dump($devicecost[]);die;
                                       }
                   $discount=count($discount);
                   $adjustment=count( $adjustment);
                   $othercharges=count($othercharges);
                   $devicecost=count($devicecost);
                   $maximum=max($discount,$adjustment,$othercharges,$devicecost); 

            for($i=0;$i < $maximum;$i++) {
                 $bill_info=new Billinformation();
                 $bill_info->bill_no=$bill_no;
               if(!empty($adjustment_id[$i]))
                 {
                    $bill_info->adjustment_id =$adjustment_id[$i];
                    $considered=Adjustment::where('id','=',$adjustment_id[$i])->get()->first();
                    $considered->is_considered='1';
                    $considered->save();
                    //var_dump($considered);die;
                 }else{
                     $bill_info->adjustment_id=0;
                }


                 if(!empty($discount_id[$i]))
                 {
                    $bill_info->discount_id =$discount_id[$i];
                    $considered=Discount::where('id','=',$discount_id[$i])->get()->first();
                    $considered->is_considered=1;
                    $considered->save();
                  }else{
                       $bill_info->discount_id=0;
                 } 


                 if(!empty($othercharges_id[$i]))
                 {
                      $bill_info->other_charges_id = $othercharges_id[$i];
                      $considered=OtherCharges::where('id','=',$othercharges_id[$i])->get()->first();
                      $considered->is_considered=1;
                      $considered->save();
                    
                 }else{
                      $bill_info->other_charges_id=0;
                 }

                 if(!empty($devicecost_id[$i]))
                 {
                      $bill_info->device_cost_id = $devicecost_id[$i];
                      $considered=DeviceCost::where('id','=',$devicecost_id[$i])->get()->first();
                      $considered->is_considered=1;
                      $considered->save();
                       
                  }else{
                       $bill_info->device_cost_id=0;
                 }
                 
                 $bill_info->save();
               

               }


      }


}
