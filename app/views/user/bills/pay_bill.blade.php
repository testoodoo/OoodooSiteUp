@extends ('user._layouts.default')
@section('main')
<section class="panel">
	<header class="panel-heading">
    	Confirm the Below Details
  	</header>
  	<div class="panel-body">
      	{{ Form::open( array( 'route' => array('payments.confirmPayment'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}

            {{ Form::hidden('bill_no',Auth::user()->get()->payableBill()->bill_no) }}

            <div class="form-group">
                <label class="col-lg-3 col-sm-3 control-label">Name</label>
                <div class="col-lg-9">
                    <div class="iconic-input">
                        {{ Form::text('first_name', Auth::user()->get()->first_name ." ". Auth::user()->get()->last_name, array('class' => 'form-control required')) }}
                    </div>
                </div>
            </div>
          	<div class="form-group">
              	<label class="col-lg-3 col-sm-3 control-label">Email</label>
              	<div class="col-lg-9">
                  	<div class="iconic-input">
                  		{{ Form::email('email', Auth::user()->get()->email, array('class' => 'form-control required')) }}
                  	</div>
              	</div>
          	</div>
          	<div class="form-group">
              	<label class="col-lg-3 col-sm-3 control-label">Phone</label>
              	<div class="col-lg-9">
                  	<div class="iconic-input">
                  		{{ Form::text('phone', Auth::user()->get()->mobile, array('class' => 'form-control required')) }}
                  	</div>
              	</div>
          	</div>
          	<div class="form-group">
              	<label class="col-lg-3 col-sm-3 control-label">Enter the Amount</label>
              	<div class="col-lg-9">
                  	<div class="iconic-input">
                  		{{ Form::text('payable_amount',Auth::user()->get()->payableAmount(), array('class' => 'form-control required digits payable_amount',
                            'min' => '1', 'max' => '10000000', 'maxlength' => "8",'disabled')) }}
                      {{ Form::text('payable_amount',Auth::user()->get()->payableAmount(), array('hidden'))}}

                  	</div>
              	</div>
          	</div>

            <div class="form-group">
                <label class="col-lg-3 col-sm-3 control-label">Total Amount <br>(Payment Gateway Charges 2%)</label>
                <div class="col-lg-9">
                    <div class="iconic-input">
                        <input class="form-control required total_payment" name="amount" type="text" disabled>
                        <input class="form-control required total_payment" name="amount" type="hidden">               
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-sm-3 control-label">
                    <input type="checkbox" name="tc" value="tc" class="required">
                        I accept 
                        <a href="http://www.oodoo.co.in/legal/" target="_blank">
                            Terms and Conditions
                        </a>
                    <br>
                </label>
            </div>

          	<button type="submit" class="btn btn-info">Confirm</button>

      	{{ Form::close() }}
  </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){

        $('.error').css('color','red');

        var payable_amount = $('.payable_amount').val();
        var gateway_amount = parseInt(payable_amount * 0.02);
        var total_amount = parseInt(payable_amount) + parseInt(gateway_amount);
        $('.total_payment').val(total_amount);


        $('.payable_amount').keyup(function(){
            var payable_amount = $(this).val();
            if ( (payable_amount.length != 0) &&(!isNaN(payable_amount))){
                var gateway_amount = parseInt(payable_amount * 0.02);
                var total_amount = parseInt(payable_amount) + parseInt(gateway_amount);
                $('.total_payment').val(total_amount);    
            }
            
        })
    });
</script>
@stop