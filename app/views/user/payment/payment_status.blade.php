@extends ('user._layouts.default')
@section('main')

@if(isset($option))
<div class="alert alert-success alert-block fade in">
	<button data-dismiss="alert" class="close close-sm" type="button">
		<i class="fa fa-times"></i>
	</button>
	<h4>
		<i class="fa fa-ok-sign"></i>
		{{$option}}
	</h4>
	<p>Your request towards {{$option}} is received. It will be activated in a short time.</p>
</div>
@endif

<section class="panel">
	@if($transaction->status == 'success')
		<div class="panel-heading">
				<h3>
					<font color="green"><b>Payment Succeed</b>
					</font>
				</h3>
		</div>
		<div class="panel-body bio-graph-info">
			<h1>
				<font color="green">Payment Details
				</font>
			</h1>
	@else
		<div class="panel-heading">
				<h3>
					<font color="red"><b>Payment Failed</b>
					</font>
				</h3>
		</div>
		<div class="panel-body bio-graph-info">
			<h1>
				<font color="red">Payment Details
				</font>
			</h1>

	@endif
			<div class="row">
				<h4>
					<div class="bio-row">
						<p>
							<span>Bill No</span>: {{$transaction->bill_no}}
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Txn Code </span>: {{$transaction->transaction_code}}
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Amount </span>: Rs. {{$transaction->amount}}
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Account ID </span>: {{$transaction->account_id}}
						</p>
					</div>
					@if ($transaction->status == "success")
						<div class="bio-row">
							<p>
								<span>Status</span>: <span class="label label-success">{{$transaction->status}}</span>
							</p>
						</div>

	                @elseif ($transaction->status == "pending")
						<div class="bio-row">
							<p>
								<span>Status</span>: <span class="label label-warning">{{$transaction->status}}</span>
							</p>
						</div>

	        	    @elseif ($transaction->status == "cancelled")
						<div class="bio-row">
							<p>
								<span>Status</span>: <span class="label label-danger">{{$transaction->status}}</span>
							</p>
						</div>
               		@endif
				</h4>

			</div>
	</div>
</section>
@stop