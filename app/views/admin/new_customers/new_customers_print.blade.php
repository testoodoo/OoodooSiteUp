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
        <a href="/admin/registration">RegistrationForm</a>
    </li>
</ul>
</div>
<div class="page-header">
  <h1>
    Users
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      New Customers list
    </small>
  </h1>
  <div class="col-sm-12">
            {{ Form::open(array('route' => 'admin.feasible.print_ajax', 'method' => 'get')) }}  
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                            <span class="blue bolder">FORM TO DATE</span>
                    </label>
                        <div class="input-daterange input-group col-sm-3">
                            <input type="text" class="input-sm form-control from" name="from_date" placeholder="From Date">
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control to" name="to_date" placeholder="To Date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                                <span class="blue bolder">SELECT EMPLOYEE</span>
                        </label>
                        <div class="col-sm-6">
                            <select name="employee" class="select2 employee"
                                             data-placeholder="Sales Employee">
                                <option value="">Select Employee</option>
                                @foreach($employees as $key)
                                    <option value="{{$key->employee_identity}}">{{$key->name}}</option>
                                @endforeach
                            </select>
                            <select id="food"  name="feasible" class="select2 feasible"
                                             data-placeholder="Sales Employee">
                                    <option value="">Select Feasible</option>
                                    <option value="fiber">fiber</option>
                                    <option value="ethernet">ethernet</option>
                                    <option value="splicing">splicing</option>
                                    <option value="hut_boxes">hut_boxes</option>
                                    <option value="configuration">configuration</option>
                            </select>
                            <span class="btn btn-minier btn-primary findarea">
                                Submit
                            </span>
                            <button type="submit" name="print" value="print" class="btn btn-minier btn-primary">
                                Print
                            </button>
                    {{ Form::close() }}
                        </div>
                    </div>
    <label class="col-sm-3 control-label">
            <span class="blue bolder"></span>
    </label>
  </div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th> CRF No </th>
                <th>Request ID</th>
                <th>Name</th>
                <th>Application Date</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Created By</th>
                <th>Feasible</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <tr> 
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
       jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
                processing: true,
                serverSide: true,
                       "ajax": '/admin/feasible/print_ajax',
                       "type":'get',
            });
     });
    $('.findarea').click(function(){
            var from=$('.from').val();
            var to=$('.to').val();
            var feasible=$('select.feasible').val();
            var employee=$('select.employee').val();
            var oTable = jQuery('#sample-table-1').dataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                       "ajax": '/admin/feasible/print_ajax?from='+from+'&to='+to+'&feasible='+feasible+'&employee='+employee,
                       "type":'get',         
            });
});

</script>
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