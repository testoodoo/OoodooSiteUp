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
			<a href="/admin/switch_router/stock_update">Stock Update</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Stock Update
		<a href="/admin/switch_router/category" class="pull-right"><button class="btn btn-primary">Add New</button></a>
	</h1>

</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Date</th>
			<th>Employee Identity</th>
			<th>Material</th>
			<th>Taken</th>
			<th>Left</th>
			<th>Update</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
	   jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	autoWidth: false,
                       "ajax": '/admin/switch_router/update_stock_det_ajax',
                       "type":'get',
    		});
@stop

