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
			<a href="/admin/payments/transactions">Payments</a>
		</li>
		<li class="active">
			<a href="/admin/payments/show/{{ $transaction->id }}">Show</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<div class="pull-right">
		<a href="/admin/payments/resend-notification?transaction_id={{ $transaction->id }}">
			<button class="btn btn-primary">Notify Customer</button>
		</a>		
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<?php $transaction_columns = Schema::getColumnListing('payment_transactions'); ?>
		<h3 class="lighter smaller center">Payment Transaction Details</h3>
		<div class="profile-user-info profile-user-info-striped">
			@foreach($transaction_columns as $column)
			@if(!empty($transaction->$column))
				<div class="profile-info-row">
					<div class="profile-info-name"> {{ $column }} </div>
					<div class="profile-info-value">
						<span class="editable editable-click">
							@if(!empty($transaction->$column))
								{{ $transaction->$column }}
							@else
								&nbsp;&nbsp;&nbsp;
							@endif
							
						</span>
					</div>
				</div>
		    @else 
			@endif
			@endforeach
		</div>
	</div>
	<div class="col-sm-6">
		@if(!empty($transaction->payu_info()->txnid))
		<h3 class="lighter smaller center">Payu Information</h3>
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name"> Transaction ID </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->payu_info()->txnid))
							{{ $transaction->payu_info()->txnid }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Status </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->payu_info()->status))
							{{ $transaction->payu_info()->status }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Name</div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->payu_info()->firstname))
							{{ $transaction->payu_info()->firstname }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Email </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->payu_info()->email))
							{{ $transaction->payu_info()->email }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Phone </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->payu_info()->phone))
							{{ $transaction->payu_info()->phone }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> payu Money Id </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->payu_info()->payuMoneyId))
							{{ $transaction->payu_info()->payuMoneyId }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name">Wallet</div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty(json_decode($transaction->payu_info()->amount_split)->WALLET))
							{{ json_decode($transaction->payu_info()->amount_split)->WALLET }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name">Payu</div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty(json_decode($transaction->payu_info()->amount_split)->PAYU))
							{{ json_decode($transaction->payu_info()->amount_split)->PAYU }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
					</span>
				</div>
			</div>
		</div>	
		@endif
		@if(!empty($transaction->cheque()->cheque_no))
		<h3 class="lighter smaller center">Cheque Information</h3>
		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name"> Cheque No </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->cheque()->cheque_no))
							{{ $transaction->cheque()->cheque_no }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Cheque Holder Name </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->cheque()->cheque_holder_name))
							{{ $transaction->cheque()->cheque_holder_name }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Cheque Account No</div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->cheque()->cheque_account_no))
							{{ $transaction->cheque()->cheque_account_no }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Cheque Status </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->cheque()->cheque_status))
							{{ $transaction->cheque()->cheque_status }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Ifsc Code </div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->cheque()->ifsc_code))
							{{ $transaction->cheque()->ifsc_code }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
						
					</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Status Updated By</div>
				<div class="profile-info-value">
					<span class="editable editable-click">
						@if(!empty($transaction->cheque()->status_updated_by))
							{{ $transaction->cheque()->status_updated_by }}
						@else
							&nbsp;&nbsp;&nbsp;
						@endif
					</span>
				</div>
			</div>
		@endif
		</div>
	</div>
</div>
@stop
