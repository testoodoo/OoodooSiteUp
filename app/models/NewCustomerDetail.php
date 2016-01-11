<?php

class NewCustomerDetail extends Eloquent {

	protected $table = 'new_customer_details';

	protected $fillable = ['status','crf_no','account_id'];

}