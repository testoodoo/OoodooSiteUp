<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsPayuTable extends Migration {

	public function up()
	{
		Schema::create('payments_payu', function(Blueprint $table) {
			$table->increments('id');
			$table->string('mihpayid',40);
			$table->string('mode',10);
			$table->string('status',20);
			$table->string('unmappedstatus',20);
			$table->string('key',20);
			$table->string('txnid',40)->unique();
			$table->string('amount',50);
			$table->string('addedon',50);
			$table->string('productinfo',100);
			$table->string('firstname',50);
			$table->string('lastname',50);
			$table->string('address1',50);
			$table->string('address2',50);
			$table->string('city',50);
			$table->string('state',50);
			$table->string('country',50);
			$table->string('zipcode',50);
			$table->string('email',50);
			$table->string('phone');
			$table->string('udf1',50);
			$table->string('udf2',50);
			$table->string('udf3',50);
			$table->string('udf4',50);
			$table->string('udf5',50);
			$table->string('udf6',50);
			$table->string('udf7',50);
			$table->string('udf8',50);
			$table->string('udf9',50);
			$table->string('udf10',50);
			$table->string('hash',240);
			$table->string('field1',50);
			$table->string('field2',50);
			$table->string('field3',50);
			$table->string('field4',50);
			$table->string('field5',50);
			$table->string('field6',50);
			$table->string('field7',50);
			$table->string('field8',50);
			$table->string('field9',250);
			$table->string('PG_TYPE',50);
			$table->string('bank_ref_num',50);
			$table->string('bankcode',50);
			$table->string('error',50);
			$table->string('error_Message',250);
			$table->string('card_Token',100);
			$table->string('name_on_card',50);
			$table->string('cardnum',50);
			$table->string('cardhash',50);
			$table->string('amount_split',50);
			$table->string('payuMoneyId',50);
			$table->timestamps();
		});
	}


	public function down()
	{
		Schema::drop('payments_payu');
	}

}
