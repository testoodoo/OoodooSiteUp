@extends ('admin.layouts.default')
@section('main')
<div class="page-header">
	<h1>
	    Amount Different Bills and Payments
	</h1>
</div>
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Bill No</th>
						<th>Account ID</th>
						<th>Bill Date</th>
						<th>Bill Amount</th>
						<th>Transaction Code</th>
						<th>Payment Amount</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
		</div>
	</div>
<script type="text/javascript">
	   jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
                       "ajax": '/admin/checks/bill_payment_ajax',
                       "type":'get',
                       "dataType":'json',
                      
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