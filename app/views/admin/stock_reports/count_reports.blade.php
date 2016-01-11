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
			<a href="/admin/stock_report/stock-report/{{$material->id}}">Stock Report Count</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Stock Report Count
	</h1>
</div>
{{ Form::hidden('id',$material->id, array('class' => 'col-xs-10 col-sm-5 id')) }}
{{ Form::hidden('type',$material->material_details, array('class' => 'col-xs-10 col-sm-5 type')) }}
<div class="col-sm-12">
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Onu ID</th>
				<th>Material Brand</th>
				<th>Srl No</th>
				<th class="switch">Mac Address</th>
				<th>Sender</th>
				<th>Receiver</th>
				<th>Process</th>
				<th>Waiting</th>
				<th>Damage</th>
				<th>Complete</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
            var type=$('.type').val();
            var id=$('.id').val();
            if($('.type').val()=="switch"){
            	$('.switch').remove();
            }
           var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	autoWidth: false,
                       "ajax": '/admin/stock_report/stock-report_ajax?id='+id+'&type='+type,
                       "type":'get',
         
    		});
	 });
</script>
@stop