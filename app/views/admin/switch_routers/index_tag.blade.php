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
		<a href="/admin/switch_router-tag/index">Switch and Routers Tag</a>
	</li>
</ul>
</div>
	<div class="page-header">
		<h1>
			Switch and Routers
		</h1>
		<div  class="filters center">
        	<a href="/admin/switch_router-tag/create"  class="filters center"><button class="btn btn-primary">create</button></a>
    	</div>
	</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Account ID</th>
			<th>HT BOX ID</th>
			<th>ONU ID</th>
			<th>Switch ID</th>
			<th>Router ID</th>
			<th>Sign Up Employee</th>
            <th>Created By</th>
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
                       "ajax": '/admin/switch_router-tag/tag_ajax',
                       "type":'get',
           
    		});
	 });

</script>
@stop