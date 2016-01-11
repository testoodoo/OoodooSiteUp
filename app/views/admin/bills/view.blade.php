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
			<a href="/admin/bills/view/{{$bill->bill_no}}">View</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Bill
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			{{$bill->bill_no}}
		</small>
	<a href="/admin/bills/create" class="pull-right"><button class="btn btn-primary">Add New</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
	</h1>
</div>
<div class="row">
	<a href="/admin/bills/retransaction/{{$bill->bill_no}}"><button class="btn btn-primary">Re Transaction</button></a>
	<div class="col-sm-5">
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Bill No.</th>
					<td>{{$bill->bill_no}}</td>
				</tr>
				<tr>
					<th>Account ID</th>
					<td>{{$bill->account_id}}</td>
				</tr>
				<tr>
					<th>For Month</th>
					<td>{{$bill->for_month}}</td>
				</tr>
				<tr>
					<th>Plan</th>
					<td>{{$bill->cust_current_plan}}</td>
				</tr>
				<tr>
					<th>Cureent Rental</th>
					<td>{{$bill->current_rental}}</td>
				</tr>
				<tr>
					<th>Bill Date</th>
					<td>{{$bill->bill_date}}</td>
				</tr>
				<tr>
					<th>Bill Start Date</th>
					<td>{{$bill->bill_start_date}}</td>
				</tr>
				<tr>
					<th>Bill End Date</th>
					<td>{{$bill->bill_end_date}}</td>
				</tr>
				<tr>
					<th>Due Date</th>
					<td>{{$bill->due_date}}</td>
				</tr>
				<tr>
					<th>Security Deposit</th>
					<td>{{$bill->security_deposit}}</td>
				</tr>
				<tr>
					<th>Previous Balance</th>
					<td>{{$bill->prev_bal}}</td>
				</tr>
				<tr>
					<th>Last Payments</th>
					<td>{{$bill->last_payment}}</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	<div class="col-sm-5">
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Device Cost</th>
					<td>{{$bill->device_cost}}</td>
				</tr>
				<tr>
					<th>One Time Charges</th>
					<td>{{$bill->onetime_charges}}</td>
				</tr>
				<tr>
					<th>Discount</th>
	                             
					<td>{{$bill->discount}}</td>
				</tr>
				<tr>
					<th>Other Charges</th>
					<td>{{$bill->other_charges}}</td>
				</tr>
				<tr>
					<th>Adjustments</th>
					<td>{{$bill->adjustments}}</td>
				</tr>
				<tr>
					<th>Sub Total</th>
					<td>{{$bill->sub_total}}</td>
				</tr>
				<tr>
					<th>Service Tax</th>
					<td>{{$bill->service_tax}}</td>
				</tr>
				<tr>
					<th>Total Charges</th>
					<td>{{$bill->total_charges}}</td>
				</tr>
				<tr>
					<th>Amount before Due Date</th>
					<td>{{$bill->amount_before_due_date}}</td>
				</tr>
				<tr>
					<th>Amount After Due Date</th>
					<td>{{$bill->amount_after_due_date}}</td>
				</tr>
				<tr>
					<th>Amount Paid</th>
					<td>{{$bill->amount_paid}}</td>
				</tr>
				<tr>
					<th>Status</th>
					<td>{{$bill->status}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="col-sm-12">
	@if(!empty($adjustment))
		<span class="blue bolder"><h5>Adjustments<h5></span>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Id</th>
					<th>Amount</th>
					<th>Remarks</th>
				</tr>
				@for ($i = 0; $i < count($adjustment); $i++)
					@foreach($adjustment[$i] as $value)
					<td>{{$value->id}}</td>
					<td>{{$value->amount}}</td>
					<td>{{$value->remarks}}</td>
					</tr>
					@endforeach
				@endfor
			</tbody>
		</table>
	@else
	@endif
</div>
<div class="col-sm-12">
	@if(count($devicecost))
		<span class="blue bolder"><h5>Device cost<h5></span>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Id</th>
					<th>Amount</th>
					<th>Remarks</th>
				</tr>
				@for ($i = 0; $i < count($devicecost); $i++)
					@foreach($devicecost[$i] as $value)
						<td>{{$value->id}}</td>
						<td>{{$value->amount}}</td>
						<td>{{$value->remarks}}</td>
					</tr>
					@endforeach
				@endfor
			</tbody>
		</table>
	@else
	@endif
</div>
<div class="col-sm-12">
	@if(!empty($discount))
		<span class="blue bolder"><h5>Discount<h5></span>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Id</th>
					<th>Amount</th>
					<th>Remarks</th>
				</tr>
				@for ($i = 0; $i < count($discount); $i++)
					@foreach($discount[$i] as $value)
							<td>{{$value->id}}</td>
							<td>{{$value->amount}}</td>
							<td>{{$value->remarks}}</td>
						</tr>
					@endforeach
				@endfor
			</tbody>
		</table>
	@else
	@endif
</div>
<div class="col-sm-12">
	@if(!empty($othercharges))
		<span class="blue bolder"><h5>Other charges<h5></span>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Id</th>
					<th>Amount</th>
					<th>Remarks</th>
				</tr>
				@for ($i = 0; $i < count($othercharges); $i++)
				@foreach($othercharges[$i] as $value)
					<td>{{$value->id}}</td>
					<td>{{$value->amount}}</td>
					<td>{{$value->remarks}}</td>
				</tr>
				@endforeach
				@endfor
			</tbody>
		</table>
	@else
	@endif
</div>
@stop
