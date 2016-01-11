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
			<a href="/admin/switch_router/updates">Stock Update</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Stock Update
	</h1>
</div>
{{ Form::hidden('type','', array('class' => 'col-xs-10 col-sm-5 type')) }}
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Material Name</th>
			<th>Brand</th>
			<th>Material Typ</th>
			<th>Material Details</th>
			<th>Update</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		</tr>
	</tbody>
</table>

@stop