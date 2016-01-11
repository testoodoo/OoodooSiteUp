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
			<a href="/admin/network/otdr">Otdr</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Otdr
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Otdr Details
		</small>
    <a href="/admin/network/otdr_create" class="pull-right"><button class="btn btn-primary">Add New</button></a>
	</h1>
</div>
<div class="col-sm-12">
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Location A</th>
				<th>Area A</th>
				<th>Location B</th>
				<th>Area B</th>
				<th>Distance</th>
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
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
                       "ajax": '/admin/network/otdr_ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
    		});

    	var tableTools = new $.fn.dataTable.TableTools( oTable, {
		    "sSwfPath": "/admin/swf/copy_csv_xls_pdf.swf",
		    "sRowSelect": "multi",
		    "aButtons": [
		        {
		            "sExtends":    "xls",
		            "sButtonText": 'Export CSV',
		            "fnInit": function ( nButton, oConfig ) {
		                $(nButton).addClass('btn btn-minier btn-primary m-r-5 m-b-5');
		                $(nButton).removeClass('DTTT_button');
		                $(nButton).removeClass('DTTT_button_xls');
		            },
		            "fnClick": function ( nButton, oConfig, oFlash ) {
		                if(oTable.fnGetData().length > 5000){
	               		alert("Record Details is Existed above 5000. Please Select below 5000 !!!!!")
	              		 $('.save-collection').removeClass("DTTT_disabled");
	                   }else{
	                   		this.fnSetText(oFlash, this.fnGetTableData(oConfig));
							console.log(oConfig);

	                   }
	                }
		        },
		    ]
		} );
		 
		$( tableTools.fnContainer() ).insertBefore('.dataTables_filter');
});


</script>

@stop
