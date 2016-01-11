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
          <li class="active"><a href="/admin/payments/transactions">Payments</a></li>
          <li class="active"><a href="/admin/payments/show_cheque/{{ $cheque->id }}">Show Cheque</a></li>
    </ul>
</div>
<div class="page-header">
	<div class="pull-right">
		<a href="/admin/payments/resend-notification?transaction_id={{ $cheque->id }}">
			<button class="btn btn-primary">Notify Customer</button>
		</a>		
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<?php $cheque_columns = Schema::getColumnListing('cheque_transactions'); ?>
		<h3 class="lighter smaller center">Cheque Transaction Details</h3>
		<div class="profile-user-info profile-user-info-striped">
			@foreach($cheque_columns as $column)
			@if(!empty($cheque->$column))
			@if($column!="transaction_details")
				<div class="profile-info-row">
					<div class="profile-info-name"> @if(!empty($cheque->$column)) {{ $column }} @else @endif  </div>
					<div class="profile-info-value">
						<span class="editable editable-click">
							@if(!empty($cheque->$column))
								{{ $cheque->$column }}
							@else
								&nbsp;&nbsp;&nbsp;
							@endif
							
						</span>
					</div>
				</div>
			@endif
			@else 
			@endif 
			@endforeach
		</div>
		<div class="col-sm-6">
			@if(count($cheque->transaction_details) != 0)
			<h5>Transaction Details</h5>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover">
					<tbody>
						<tr>
						    <th>Account Id</th>
						    <th>Bill No</th>
						    <th>Amount</th>
						    <th>Remarks</th>
						</tr>
						@foreach($pay as $payment)
							<tr>
							    <td>{{$payment->account_id}}</td>
							    <td>{{$payment->bill_no}}</td>
							    <td>{{$payment->amount}}</td>
							    <td>{{$payment->remarks}}</td>
						    @endforeach
							</tr>
					</tbody>
				</table>
			@endif
		</div>
	</div>
	<div class="col-sm-6">
			<h3 class="blue">Cheque status update</h3>
			{{ Form::open( array( 'route' => array('admin.payments.update_cheque'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
			   {{ Form::hidden('id',$cheque->transaction_id,array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
		       
			<div class="form-group">
			    {{ Form::label('Select Status', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
			        <div class="col-sm-5" >
			            <select name="status" class="form-control col-sm-6" style="width:340px;" required>
			                <option value="">Select Status type</option>
			                <option value="bounced">bounced</option>
			                <option value="cleared">cleared</option>
			                <option value="deposited">deposited</option>
			                <option value="rejected">rejected</option>
			            </select>
			        </div>
			</div>
			 <div class="form-group">
			   {{ Form::label('remarks', 'remarks',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
			    <div class="col-sm-7">
				    <span class="block input-icon input-icon-right">
				         <textarea name="remarks" class="form-control col-sm-8 required" rows="7"></textarea>
				    </span>
			    </div>
			</div>
			<div class="col-md-offset-3 col-md-9">
			    <button class="btn btn-info" type="submit">
			        <i class="icon-ok bigger-110"></i>
			          update
			    </button>
			</div>
		{{Form::close()}}
		@if(count($multi_cheque) != 0)
		<h5>Status</h5>
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<tbody>
					<tr>
						<th>Status</th>
						<th>Updated at</th>
						<th>Updated by</th>
					</tr>
						@foreach($multi_cheque as $cheque_in)
						<tr>
							<td>{{$cheque_in->cheque_status}}</td>
							<td>{{$cheque_in->created_at}}</td>
							<td>{{$cheque_in->status_updated_by}}</td>
						@endforeach
						</tr>
				</tbody>
			</table>
		@endif
	</div>
</div>
@stop