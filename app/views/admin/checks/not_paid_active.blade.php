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
            <a href="/admin/checks/not_paid_active">Not paid Activation</a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="page-header">
        <h1>
            Not Paid Acitvation
        </h1>
    </div>
<!-- <div class="row">
    <div class="col-xs-12 col-sm-4"></div>
        <div class="col-xs-12 col-sm-8">
            <select name="status[]" multiple="" id="state" name="state" class="select2 status" data-placeholder="Click to Choose status...">
                <option value="">&nbsp;</option>
                <option value="new_customers">New customers</option>
                <option value="exit_customers">Existing customers</option>
            </select>
             <button class="btn btn-minier btn-purple findstatus">check</button>
               <h4></h4>
    </div>
</div> -->
<div class="page-content">
</div>
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Bill No</th>
                        <th>Account ID</th>
                        <th>For Month</th>
                        <th>Amount Before Due date</th>
                        <th>Amount Paid</th>
                        <th>Status</th>
                        <th>Payment Amount</th>
                        <th>Cust Status</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	   jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
                       "ajax": '/admin/checks/not_paid_active_ajax',
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
<script type="text/javascript">
$('.findstatus').click(function(){
            var status=$('select.status').val();
            var oTable = jQuery('#sample-table-1').dataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                       "ajax": '/admin/checks/not_paid_active_ajax?status='+status,
                       "type":'get',
                       "dataType":'json',
         
            });
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