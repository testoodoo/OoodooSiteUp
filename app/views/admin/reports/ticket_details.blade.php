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
        <a href="/admin/reports/ticket_details">Ticket Details</a>
    </li>
</ul>
</div>
<div class="page-header">
  <h1>
    Reports
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      Ticket Details
    </small>
  </h1>
</div>
  <div class="col-sm-12">
        {{ Form::open(array('route' => 'admin.reports.employee_work_ajax', 'method' => 'get')) }}  
        <div class="form-group">
            <label class="col-sm-2 control-label">
                    <span class="blue bolder">FORM TO DATE</span>
            </label>
            <span class="btn btn-minier btn-primary findarea">
                Submit
            </span>
            <div class="col-sm-3">
                <div class="input-daterange input-group">
                    <input type="text" class="input-sm form-control from" name="from_date" placeholder="From Date">
                    <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                    </span>
                    <input type="text" class="input-sm form-control to" name="to_date" placeholder="To Date">
                </div>
            </div>
        </div>
</div>
{{ Form::close() }}
    <label class="col-sm-3 control-label">
            <span class="blue bolder"></span>
    </label>
  </div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Assigned By</th>
                <th>Open</th>
                <th>Close</th>
                <th>Assigned To</th>
                <th>Open</th>
                <th>Close</th>
            </tr>
        </thead>
    </table>
</div>
<script type="text/javascript">

 jQuery(document).ready(function() {
      var table = jQuery('#sample-table-1').dataTable({
          "bProcessing": true,
             "ajax": '/admin/reports/ticket_details_ajax',
             "type":'get',
              "aoColumns": [
                              { mData: 'employee_id' },
                              { mData: 'assign_by' },
                              { mData: 'by_open' },
                              { mData: 'by_close' },
                              { mData: 'assign_to' },
                              { mData: 'to_open' },
                              { mData: 'to_close' }
                           ]
      });
});



$('.findarea').click(function(){
      var from=$('.from').val();
      var to=$('.to').val();
      var oTable = jQuery('#sample-table-1').dataTable({
          "bDestroy": true,
          "bProcessing": true,
          "ajax": '/admin/reports/ticket_details_ajax?from='+from+'&to='+to,
          "type":'get', 
          "aoColumns": [
                        { mData: 'employee_id' },
                        { mData: 'assign_by' },
                        { mData: 'by_open' },
                        { mData: 'by_close' },
                        { mData: 'assign_to' },
                        { mData: 'to_open' },
                        { mData: 'to_close' }
                      ]        
      });
});




</script>
<style type="text/css">
    td.details-control {
      background: url('/assets/dist/admin/avatars/details_open.png') no-repeat center center;
      cursor: pointer;
  }
  tr.shown td.details-control {
      background: url('/assets/dist/admin/avatars/details_close.png') no-repeat center center;
  }
</style>


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
        $('.input-daterange').datepicker({autoclose:true});

     $('select.employee').change(function(){
            var emp=$(this).val();
            $('.assign').val(emp);
        });

     $('select.feasible').change(function(){
            var emp=$(this).val();
            $('.feas').val(emp);
        });

</script>
@include('admin.partials.js_validation');

@stop
