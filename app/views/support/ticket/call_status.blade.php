@extends('support.layouts.default')
@section('main')
<div class="page-content">
<!-- <button class="btn btn-white btn-info btn-bold pull-right status_map">
    <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
    Exo Call day
</button> -->
<div class="panel panel-blue" background="#FFF;">
    <div class="panel-heading">
        Call Details
    </div>
    <div class="panel-body">
        <table class="table table-hover table-bordered" id="sample-table-1">
            <thead>
                <bold><tr>
                    <td>Call Sid</td>
                    <td>start time</td>
                    <td>end time</td>
                    <td>call from</td>
                    <td>call to</td>
                    <td>call status</td>
                    <td>Records</td>
                </tr></bold>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>        
</div>
</div>
<!--
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

          $('button.raise_map').click(function(){
                $(".show_map").slideToggle("high");
            });
          $('button.status_map').click(function(){
                $(".view_map").slideToggle("high");
            });

</script>-->
<script type="text/javascript">
 jQuery(document).ready(function() {
          
            var oTable = jQuery('#sample-table-1').dataTable({
                processing: true,
                serverSide: true,
                       "ajax": '/exo_call_status',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],

                        "createdRow": function ( row, data, index ) {
                            if(data[5] == "missed"){
                                    $('td:eq(5)', row).html('<i style="color:red;" class="fa fa-phone"></i>');
                            }else if(data[5] == "answered"){
                                    $('td:eq(5)', row).html('<i style="color:green;" class="fa fa-phone"></i>');
                            }else if(data[5] == "ongoing"){
                                    $('td:eq(5)', row).html('<i style="color:orange;" class="fa fa-phone"></i>');
                            }
                            if(data[6] == "Array"){
                                    $('td:eq(6)', row).html('<i class="red">Not Found</i>');
                            }else{
                                    $('td:eq(6)', row).html('<audio controls><source src='+data[6]+' type="audio/mpeg"></audio>');
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

@stop