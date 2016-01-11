@extends ('admin.layouts.default')
@section('main')
<div class="page-header">
<h1>
    Bill Checks
</h1>
</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Bill No.</th>
			<th>Account ID</th>
			<th>For Month</th>
			<th>Plan</th>
			<th>Bill Date</th>
			<th>Due Date</th>
			<th>Previous Balance</th>
			<th>Last Payments</th>
			<th>Adjustments</th>
			<th>Current Charges</th>
			<th>Amount before Due Date</th>
			<th>Amount After Due Date</th>
			<th>Amount Paid</th>
			<th>Status</th>
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
                       "ajax": '/admin/checks/billchecks_ajax',
                       "type":'get',
                       "dataType":'json',
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