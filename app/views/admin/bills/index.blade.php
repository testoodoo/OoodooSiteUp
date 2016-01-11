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
			<a href="/admin/bills">Bills</a>
		</li>
		<li class="active">
			<a href="/admin/bills">Index</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Bills
		<small></small>
		<a href="bills/create" class="pull-right"><button class="btn btn-primary">Add New</button></a>
	</h1>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-4"></div>
		<div class="col-xs-12 col-sm-8">
		<select name="for_month" multiple="" id="state" name="state" class="select2 for_month" data-placeholder="Click to Choose for_month...">
			<option value="">&nbsp;</option>
			@foreach($for_month as $key)
			<option value="{{$key->for_month}}">{{$key->for_month}}</option>
			@endforeach
		</select>
			<select name="status[]" multiple="" id="state" name="state" class="select2 status" data-placeholder="Click to Choose status...">
				<option value="">&nbsp;</option>
				<option value="paid">paid</option>
				<option value="not_paid">not paid</option>
				<option value="partially_paid">partially paid</option>
			</select>
			 <button class="btn btn-minier btn-purple findstatus">check</button>
			   <h4></h4>
	</div>
</div><!-- /.span -->
<div class="row">
   <div class="col-sm-12">
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
					<th>Send SMS</th>
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
                       "ajax": 'bills/bill_ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
                       
                       

                 "createdRow": function ( row, data, index ) {
        			if(data[13] == "paid"){
            				$('td:eq(13)', row).html('<span style="color:green">Paid</span>');
					}else if(data[13] == "not_paid"){
							$('td:eq(13)', row).html('<span style="color:red">Not Paid</span>');
					}else if(data[13] == "partially_paid"){
							$('td:eq(13)', row).html('<span style="color:orange">Partially Paid</span>');
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
			var for_month=$('select.for_month').val();
            var status=$('select.status').val();
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	"bDestroy": true,
                       "ajax": 'bills/bill_ajax?for_month='+for_month+'&status='+status,
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
                      
                  "createdRow": function ( row, data, index ) {
        			if(data[13] == "paid"){
            				$('td:eq(13)', row).html('<span style="color:green">Paid</span>');
					}else if(data[13] == "not_paid"){
							$('td:eq(13)', row).html('<span style="color:red">Not Paid</span>');
					}else if(data[13] == "partially_paid"){
							$('td:eq(13)', row).html('<span style="color:orange">Partially Paid</span>');
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
<style type="text/css">
	
td.highlight {
        font-weight: bold;
        color: blue;
    }
</style>

@stop


