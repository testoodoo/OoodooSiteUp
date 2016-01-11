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
			<a href="/admin/payments/transactions">Payments</a>
		</li>
		<li class="active">
			<a href="/admin/payments/transactions">Transactions-List</a>
		</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1>
			Transactions
		</h1>
	</div>
<div class="row">
	<div class="col-xs-12 col-sm-4"></div>
		 <div class="col-xs-12 col-sm-8">
		<!-- <select name="for_month" multiple="" id="state" name="state" class="select2 for_month" data-placeholder="Click to Choose for_month...">
			<option value="">&nbsp;</option>
			@foreach($for_month as $key)
			<option value="{{$key->for_month}}">{{$key->for_month}}</option>
			@endforeach
		</select> -->
		<select name="status[]" multiple="" id="state" name="state" class="select2 status" data-placeholder="Click to Choose status...">
			<option value="">&nbsp;</option>
			<option value="success">success</option>
			<option value="pending">pending</option>
			<option value="failure">failure</option>
			<option value="cancelled">cancelled</option>
			<option value="online">online</option>
			<option value="offline">offline</option>
			<option value="online-anpay">online-anpay</option>
			<option value="online-acpay">online-acpay</option>
		</select>
		 <button class="btn btn-minier btn-purple findstatus">check</button>
		<h4></h4>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Account ID</th>
						<th>Bill No</th>
						<th>Amount</th>
						<th>Transaction ID</th>
						<th>Transaction Type</th>
						<th>Remarks</th>
						<th>Date</th>
						<th>Payment Type</th>
						<th>Status</th>
						<th>Operations</th>
					</tr>
				</thead>
				<tbody>
						<tr>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
<script type="text/javascript">
			   jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
                       "ajax": 'payment_ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
		              
               "createdRow": function ( row, data, index ) {
        			if(data[8] == "offline"){
            				$('td:eq(8)', row).html('<p style="color:green;">offline</p>');
					}else if(data[8] == "online"){
            				$('td:eq(8)', row).html('<p style="color:orange;">online</p>');
					}else if(data[8] == "online-anpay"){
            				$('td:eq(8)', row).html('<p style="color:orange;">online-anpay</p>');
					}else{
            				$('td:eq(8)', row).html('<p style="color:red;">online-acpay</p>');
					}
    			},
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
<script type="text/javascript">
$('.findstatus').click(function(){
            var status=$('select.status').val();
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	"bDestroy": true,
                       "ajax": 'payment_ajax?status='+status,
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
		              	
               "createdRow": function ( row, data, index ) {
        			if(data[8] == "offline"){
            				$('td:eq(8)', row).html('<p style="color:green;">offline</p>');
					}else if(data[8] == "online"){
            				$('td:eq(8)', row).html('<p style="color:orange;">online</p>');
					}else if(data[8] == "online-anpay"){
            				$('td:eq(8)', row).html('<p style="color:orange;">online-anpay</p>');
					}else{
            				$('td:eq(8)', row).html('<p style="color:red;">online-acpay</p>');
					}
    			},
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
<script type="text/javascript">
	
	$('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });
</script>	    
@stop