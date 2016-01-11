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
            <a href="/admin/ticket/index">Tickets</a>
        </li>
        <li class="active">
            <a href="/admin/ticket/exo_call_missed">Call Missed</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Call Missed
    </h1>
</div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td>Call Sid</td>
                <td>start time</td>
                <td>end time</td>
                <td>call from</td>
                <td>call to</td>
                <td>call status</td>
                <td>call Back</td>
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
                       "ajax": '/admin/ticket/exo_call_missed_ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
                
                "createdRow": function ( row, data, index ) {
                            if(data[5] == "missed"){
                                    $('td:eq(5)', row).html('<i class="fa fa-phone fa-2x red"></i>');
                            }else if(data[5] == "answered"){
                                    $('td:eq(5)', row).html('<i class="fa fa-phone fa-2x green"></i>');
                            }else if(data[5] == "ongoing"){
                                    $('td:eq(5)', row).html('<i class="fa fa-phone fa-2x orange"></i>');
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

function callback(y,x,z){
        $.ajax({
            url : '/admin/ticket/exo_call_back',
            type : 'GET',
            data : {'from':x,'to':y },
            success : function(data){
                    if(data['found']=='false'){
                        $('.status'+z).addClass('btn-danger');
                        $('.status'+z).removeClass('btn-success');
                        $('.status'+z).text('disconnected');
                        alert(data['status']);
                    }else{
                        $('.status'+z).text('processing ..');
                    }
               }
        })
    }

 </script>

@stop