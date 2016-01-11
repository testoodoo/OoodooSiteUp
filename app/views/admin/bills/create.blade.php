@extends ('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
<ul class="breadcrumb">
	<li>
		<i class="ace-icon fa fa-home home-icon"></i>
		<a href="/admin/index">Home</a>
	</li>
		<li class="active">
			<a href="/admin/bills">Bills</a>
		</li>
	<li class="active">
		<a href="/admin/bills/create">Create</a>	
	</li>
</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.bills.store'), 'method' => 'POST','class' => 'form-horizontal validate-form','id' => 'bills_form' ,'role' => 'form')  ) }}
			{{ Form::hidden('adjustments_id',0, array('class' => 'col-xs-10 col-sm-5  adjustment')) }}
			{{ Form::hidden('discount_id', 0 , array('class' => 'col-xs-10 col-sm-5  discount')) }}
			{{ Form::hidden('devicecost_id', 0 , array('class' => 'col-xs-10 col-sm-5  devicecost')) }}
			{{ Form::hidden('othercharges_id', 0 , array('class' => 'col-xs-10 col-sm-5 othercharges')) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						New Bill
					</h1>
				</div>
				<div class="form-group">
					{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('account_id', '' , array('class' => 'col-xs-10 col-sm-5 account_id','required')) }}

						{{ Form::hidden('for_month','', array('class' => 'col-xs-10 col-sm-5 required for_month')) }}

						<input class="btn btn-info fetch_plan_det" type="button" value="fetch" style="float:right;">
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('plan_name','Plan Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('plan_name', '' , array('class' => 'col-xs-10 col-sm-5 plan_name','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('bill_date','Bill Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('bill_date', '' , array('class' => 'col-xs-10 col-sm-5 date-picker','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('bill_start_date','Bill Start Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('bill_start_date', '' , array('class' => 'col-xs-10 col-sm-5 bill_start_date date-picker ','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('bill_end_date','Bill End Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('bill_end_date', '' , array('class' => 'col-xs-10 col-sm-5 bill_end_date date-picker','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('due_date','Due Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('due_date', '' , array('class' => 'col-xs-10 col-sm-5 bill_due_date date-picker','readonly','required')) }}
						
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('security_deposit','Security Deposit', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('security_deposit', 0 , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('previous_balance','Previous Balance', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('previous_balance', 0 , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('last_payment','Last Payment', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('last_payment', 0 , array('class' => 'col-xs-10 col-sm-5  digits','readonly','required')) }}
						
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('adjustments','Adjustments', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('adjustments', 0 , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
						
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('current_rental','Current Rental', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('current_rental', '' , array('class' => 'col-xs-10 col-sm-5 ','readonly','required')) }}
						
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('device_cost','Device Cost', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('device_cost', '' , array('class' => 'col-xs-10 col-sm-5  device_cost','readonly','required')) }}
						
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('onetime_charges','One Time Charges', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('onetime_charges', '' , array('class' => 'col-xs-10 col-sm-5 one_time_charges','readonly','required')) }}
						
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('discount','Discount', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('discount', 0 , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
				
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('other_charges','Other Charges', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('other_charges', 0 , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('sub_total','Sub Total', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('sub_total', '' , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('service_tax','Service Tax', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('service_tax', '' , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('total_charges','Total Charges', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('total_charges', '' , array('class' => 'col-xs-10 col-sm-5 digits','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('for_month','For Month', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('for_month','', array('class' => 'col-xs-10 col-sm-5 for_month','readonly','required')) }}
					
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('amount_before_due_date','Amount Before Due Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('amount_before_due_date', '' , array('class' => 'col-xs-10 col-sm-5 digits', 'readonly','required')) }}
				
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('amount_after_due_date','Amount After Due Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('amount_after_due_date', '' , array('class' => 'col-xs-10 col-sm-5  digits', 'readonly','required')) }}
			
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('amount_paid','Amount Paid', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('amount_paid', $bill->amount_paid , array('class' => 'col-xs-10 col-sm-5', 'id' => 'bill-amount-paid-field','required')) }}
			
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('status','Status', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						<select name="status" class="required" id="bill-status-field" required>
							<option value="">Select the status</option>
							<option value="not_paid">Not Paid</option>
							<option value="partially_paid">Partially Paid</option>
							<option value="paid">Paid</option>
						</select>
					</div>
				</div>

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						{{ Form::submit('create', array('class' => 'btn btn-info')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>
	<script type="text/javascript">
  $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true
        })
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
        $('.input-daterange').datepicker({autoclose:true});
          function ServiceTaxFactor() {
        	var service_tax=0.1400;
        	return service_tax;
        }
</script>

@stop
