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
			<a href="/admin/stock_report/stock-report_meter/{{$material->id}}">Stock Report Meters</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Stock Report Meters
	</h1>
</div>
<div class="row">
	<div class="col-sm-6">
	<h4 class="blue">Employee Details</h4>
	@if($type!="others")
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>ID</th>
					<th>Material Brand</th>
					<th>Employee Identity</th>
					<th>Drum No</th>
					<th>Total Meter</th>
					<th>Used</th>
					<th>Damage</th>
					<th>Leftover</th>
				</tr>
				@foreach($meters as $key)
				<tr>
					<th>{{$key->id}}</th>
					<th>{{$key->material_brand}}</th>
					<th>{{$key->employee_identity}}</th>
					<th>{{$key->drum_no}}</th>
					<th>{{$key->total_meter}}</th>
					<th>{{$key->used}}</th>
					<th>{{$key->damage}}</th>
					<th>{{$key->left_over}}</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>ID</th>
					<th>Material Brand</th>
					<th>Employee Identity</th>
					<th>Total</th>
					<th>Used</th>
					<th>Damage</th>
					<th>Leftover</th>
				</tr>
				@foreach($meters as $key)
				<tr>
					<th>{{$key->id}}</th>
					<th>{{$key->material_brand}}</th>
					<th>{{$key->employee_identity}}</th>
					<th>{{$key->total}}</th>
					<th>{{$key->used}}</th>
					<th>{{$key->damage}}</th>
					<th>{{$key->left_over}}</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	@endif
	</div>
	<div class="col-sm-6">
	<h4 class="blue">Customer Details</h4>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<th>Crf No</th>
					<th>Account Id</th>
				</tr>
				@foreach($stockout as $key)
				<tr>
					<th>{{$key->crf_no}}</th>
					<th>{{$key->account_id}}</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop