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
	</h1>
</div>
{{ Form::hidden('id',$material->id, array('class' => 'col-xs-10 col-sm-5 id')) }}
{{ Form::hidden('type',$material->material_details, array('class' => 'col-xs-10 col-sm-5 type')) }}
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Material Brand</th>
			<th>Total Meter</th>
			<th>Used</th>
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
            var type=$('.type').val();
            var id=$('.id').val();
            if($('.type').val()=="others"){
            	$('.drum_no').hide();
            }
           var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	autoWidth: false,
                       "ajax": '/admin/switch_router/stock_updates?id='+id+'&type='+type,
                       "type":'get',
         
    		});
	 });
</script>
@stop