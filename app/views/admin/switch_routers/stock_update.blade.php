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
<script type="text/javascript">
	   jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	autoWidth: false,
                       "ajax": '/admin/switch_router/stock_update_ajax',
                       "type":'get',

                 "createdRow": function ( row, data, index ) {
            		$('td:eq(0)', row).addClass('details-control');
    			},
         
    		});
        
    	// Add event listener for opening and closing details
     $('#sample-table-1 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = oTable.api().row(tr);

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data() )).show();
            tr.addClass('shown');
        }
    } );

	 });
	function format ( d ) {
	    return 'Full name: '+d[0]+'<br>'+
	        'Salary: '+d[1]+'<br>'+
	        '<a href="/admin/switch_router/category" class="pull-right"><button class="btn btn-primary">Add New</button></a>';
	}

</script>

<style type="text/css">
	td.details-control {
    background: url('/assets/dist/admin/avatars/details_open.png') no-repeat center center;
    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('/assets/dist/admin/avatars/details_close.png') no-repeat center center;
	}
</style>
@stop

