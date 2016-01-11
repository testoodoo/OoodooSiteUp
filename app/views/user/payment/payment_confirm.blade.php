@extends ('user._layouts.default')
@section('main')
<section class="panel">
	<header class="panel-heading" style="color:forestgreen">
    	<b>Confirm the Below Details</b>
        <div style = "float:right">
        <h6>[Do not refresh this page]</h6>
        </div>
  	</header>
    <div class="panel-body">
        {{ Form::open( array( 'route' => array('users.payment.payment_process'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
            {{ Form:: hidden('bill_no', $bill_no, array('class'=>'form-control'))}}
            {{ Form:: hidden('gateway_charge',$gateway_charge,array('class' => 'gateway_charge '))}}
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
                <label class="col-lg-3 col-sm-3 control-label">Payable amount</label>
                <div class="col-lg-9">
                    <div class="iconic-input">
                        {{ Form::text('payable_amount', $payable_amount, array('class' => 'form-control required payable_amount','readonly')) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-sm-3 control-label">
                    Total Amount
                    <sup>[Gateway charge {{$gateway_charge * 100}}%]</sup>
                </label>
                <div class="col-lg-9">
                    <div class="iconic-input">
                        <input name = "total_amount" class = "form-control total_amount required" readonly>
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
        var gateway_charge = $('.gateway_charge').val();
        var gateway_amount = payable_amount * gateway_charge;
        var total_amount = Math.round(payable_amount) + Math.round(gateway_amount);
        $('.total_amount').val(total_amount);

    });
</script>
@stop