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
		<a href="/admin/bills/edit/{{$bill->bill_no}}">Edit</a>
	</li>
</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' =>array('admin.bills.update'), 'method' => 'POST','class' => 'form-horizontal validate-form','id' => 'bills_form') )}}
		
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Edit Bill ({{$bill->bill_no}})
					</h1>
				</div>
				{{ Form::hidden('bill_no',$bill->bill_no) }}
				<div class="form-group">
					{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('account_id', $bill->account_id , array('class' => 'col-xs-10 col-sm-5 account_id','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('bill_date','Bill Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('bill_date', $bill->bill_date , array('class' => 'col-xs-10 col-sm-5 datepicker','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('bill_start_date','Bill Start Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('bill_start_date', $bill->bill_start_date , array('class' => 'col-xs-10 col-sm-5 datepicker','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('bill_end_date','Bill End Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('bill_end_date', $bill->bill_end_date , array('class' => 'col-xs-10 col-sm-5 datepicker','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('due_date','Due Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('due_date', $bill->due_date , array('class' => 'col-xs-10 col-sm-5 datepicker','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('plan_name','Plan Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('plan_name', $bill->cust_current_plan, array('class' => 'col-xs-10 col-sm-5 plan_name','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('security_deposit','Security Deposit', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('security_deposit', $bill->security_deposit , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('previous_balance','Previous Balance', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('previous_balance', $bill->prev_bal , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('last_payment','Last Payment', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('last_payment', $bill->last_payment , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('adjustments','Adjustments', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('adjustments', $bill->adjustments , array('class' => 'col-xs-10 col-sm-5')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('current_rental','Current Rental', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('current_rental', $bill->current_rental , array('class' => 'col-xs-10 col-sm-5','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('device_cost','Device Cost', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('device_cost', $bill->device_cost , array('class' => 'col-xs-10 col-sm-5 device_cost','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('one_time_charges','One Time Charges', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('one_time_charges', $bill->onetime_charges , array('class' => 'col-xs-10 col-sm-5 one_time_charges','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('discount','Discount', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('discount', $bill->discount , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('other_charges','Other Charges', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('other_charges', $bill->other_charges , array('class' => 'col-xs-10 col-sm-5','readonly')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('sub_total','Sub Total', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('sub_total', $bill->sub_total , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('service_tax','Service Tax', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('service_tax', $bill->service_tax , array('class' => 'col-xs-10 col-sm-5','required','readonly')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('total_charges','Total Charges', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('total_charges', $bill->total_charges , array('class' => 'col-xs-10 col-sm-5','readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('for_month','For Month', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('for_month', $bill->for_month , array('class' => 'col-xs-10 col-sm-5','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('amount_before_due_date','Amount Before Due Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('amount_before_due_date', $bill->amount_before_due_date , array('class' => 'col-xs-10 col-sm-5', 'readonly','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('amount_after_due_date','Amount After Due Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('amount_after_due_date', $bill->amount_after_due_date , array('class' => 'col-xs-10 col-sm-5', 'readonly','required')) }}
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
							@foreach($status_list as $status)
								@if($status == $bill->status)
									<option value="{{$status}}" selected>{{$status}}</option>	
								@else
									<option value="{{$status}}">{{$status}}</option>	
								@endif
							@endforeach
						</select>
					</div>
				</div>

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="submit">
							<i class="icon-ok bigger-110"></i>
							Save
						</button>
						<a href="bills?status=all"
							class="btn btn-grey tab-buttons" style="margin-left: 10px;">
							<i class="ace-icon icon-reply icon-only"></i>
							Back To List
						</a>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>

<script type="text/javascript">
  $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
        function ServiceTaxFactor() {
        	var service_tax={{$service_tax}};
        	return service_tax;
        }
</script>

@stop
