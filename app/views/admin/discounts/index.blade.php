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
			<a href="/admin/discounts">Discounts</a>
		</li>
		<li class="active">
			<a href="/admin/discounts">Index</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Discounts
		<a href="discounts/create" class="pull-right"><button class="btn btn-primary">Add New</button></a>
	</h1>
</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Account ID</th>
			<th>For Month</th>
			<th>Amount</th>
			<th>Remarks</th>
			<th>Considered</th>
			<th>Operations</th>
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
                       "ajax": '/admin/discounts/ajax',
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