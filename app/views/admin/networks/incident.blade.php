@extends('admin.layouts.default')
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
            <a href="/admin/network/incident">Incident</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Incident
    </h1>
</div>
<div class="row">
    
        <div class="col-sm-6">
            {{ Form::open(array('route' => 'admin.tickets.ajax_ticket', 'method' => 'get')) }}
            <div class="form-group">
                        <label class="col-sm-3 control-label">
                                <span class="blue bolder">FORM TO DATE</span>
                        </label>
                <div class="input-daterange input-group col-sm-5">
                    <input type="text" class="input-sm form-control from" name="from" placeholder="From Date">
                    <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                    </span>
                    <input type="text" class="input-sm form-control to" name="to" placeholder="To Date">
                </div>
                <div class="space-8"></div>
                <label class="col-sm-3 control-label">
                        <span class="blue bolder">SELECT STATUS & AREA</span>
                </label>
                <select id="food"  name="area[]" class="multiselect area" multiple="" style="display: none;">
                                <option value="all_area">All Area</option>
                            @foreach($areas as $key)
                                <option value="{{$key->name}}">{{$key->name}}</option>
                            @endforeach
                </select>
                 <select id="food"  name="status[]" class="multiselect status" multiple="" style="display: none;">
                    <label  for="food" class="blue"></label>
                        <option value="1">New connection</option>
                        <option value="2">complaint</option>
                        <option value="3">open</option>
                        <option value="4">closed</option>
                        <option value="5">processing</option>
                        <option value="6">invaild</option>
                        <option value="7">Trash</option>
                        <option value="28">Technical Compliant</option>
                        <option value="29">Billing Compliant</option>
                </select>
                <span class="btn btn-minier btn-success findstatus">Submit</span>
                <button type="submit"  name ="print" value="print" class="btn btn-minier btn-success findstatus">Print</button>
            </div>
            {{ Form::close() }}
        </div>
</div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ticket No </th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Area</th>
                <th>Requirement</th>
                <th>Ticket Type</th>
                <th>Status</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
  <script type="text/javascript">

        jQuery(function($){
                var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
                var container1 = demo1.bootstrapDualListbox('getContainer');
                container1.find('.btn').addClass('btn-white btn-info btn-bold');
            
                
                $('.rating').raty({
                    'cancel' : true,
                    'half': true,
                    'starType' : 'i'
                
                })
                //////////////////
                $('.multiselect').multiselect({
                 enableFiltering: true,
                 buttonClass: 'btn btn-white btn-primary',
                 templates: {
                    button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"></button>',
                    ul: '<ul class="multiselect-container dropdown-menu"></ul>',
                    filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
                    filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',

                    divider: '<li class="multiselect-item divider"></li>',
                    li: '<li><a href="javascript:void(0);"><label></label></a></li>',
                    liGroup: '<li class="multiselect-item group"><label class="multiselect-group"></label></li>'
                 }
                });
        });
</script>
<script type="text/javascript">
  $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true
        })
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
        $('.input-daterange').datepicker({format: 'yyyy-mm-dd',autoclose:true});
</script>
<script type="text/javascript">
 jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                       "ajax": '/admin/network/incident_ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
                       
            });

            var status=$('select.status').val();
            var area=$('select.area').val();
            var from=$('.from').val();
            var to=$('.to').val();

            $.ajax({
            url : '/admin/ticket/status_details',
            type : 'GET',
            data : {'status':status,'area':area,'from':from,'to':to},
            success : function(data){
                $('.open').text('Open : '+data['open']);
                $('.cls').text('Close : '+data['close']);
                $('.process').text('Process : '+data['process']);
                $('.invaild').text('Invaild : '+data['invaild']);
                $('.trash').text('Trash : '+data['trash']);
            }
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
    $('.findstatus').click(function(){
            var status=$('select.status').val();
            var area=$('select.area').val();
            var from=$('.from').val();
            var to=$('.to').val();

            var oTable = jQuery('#sample-table-1').dataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                       "ajax": '/admin/network/incident_ajax?status='+status+'&area='+area+'&from='+from+'&to='+to,
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