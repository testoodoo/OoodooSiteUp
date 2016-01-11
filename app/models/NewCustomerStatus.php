<?php
class NewCustomerStatus extends Eloquent {

	protected $table = 'new_customer_application_status';

	public function viewStatus($id){
        $name = Masterdata::where('id','=',$id)->get()->first();
        if(!is_null($name)){
			return $name->name;

          }
	}

    public function checkStatus($customer_id){
		$status_exist = NewCustomerStatus::where('customer_id','=',$customer_id)
		                ->where('done','=',1)->get();
		                //var_dump($status_exist);die;
		if($status_exist) {
			return true;
		} else {
			return false;
		}
        
	}

}