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
        <a href="/admin/new-customers/list">New Customer List</a>
    </li>
</ul>
</div>
<div class="page-header">
  <h1>
    Users
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      Assign Feasible
    </small>
  </h1>
<div class="col-sm-12">
  <div class="col-sm-3"></div>
  <div class="col-sm-5">  
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                            <span class="blue bolder">FORM TO DATE</span>
                    </label>
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control from" name="from_date" placeholder="From Date">
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control to" name="to_date" placeholder="To Date">
                        </div>
                    </div>
                    <label class="col-sm-3 control-label">
                            <span class="blue bolder">SELECT STATUS</span>
                    </label>
                    <select multiple  name="area[]" class="areas select2" data-placeholder="Select area">
                            <option value="all">All Area</option>
                        @foreach($area as $key)
                            <option value="{{$key->name}}">{{$key->name}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-minier btn-primary findarea">
                        Submit
                    </button>                    
    <label class="col-sm-3 control-label">
            <span class="blue bolder"></span>
    </label>
  </div>
</div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>  
            <tr>
                <th> CRF No </th>
                <th>Name</th>
                <th>Application Date</th>
                <th>Address1</th>
                <th>Address1</th>
                <th>Address3</th>
                <th>Phone</th>
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
                       "ajax": '/admin/feasible/reject_ajax',
                       "type":'get',
            });
     });
$('.findarea').click(function(){
            var from=$('.from').val();
            var to=$('.to').val();
            var area=$('select.areas').val();
            var oTable = jQuery('#sample-table-1').dataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                       "ajax": '/admin/feasible/reject_ajax?from='+from+'&to='+to+'&area='+[area],
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

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });

    $('select.areas').change(function(){
            var emp=$(this).val();
            $('.area').val(emp);
        });

</script>
@include('admin.partials.js_validation');
@stop
