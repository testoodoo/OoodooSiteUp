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
        <a href="/admin/feasible/assign">Assigan Feasible</a>
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
            {{ Form::open(array('route' => 'admin.feasible.assign_ajax', 'method' => 'get')) }}  
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
                                <span class="blue bolder">SELECT FEASIBLE</span>
                        </label>
                        <div class="col-sm-6">
                            <select multiple  name="area[]" class="select2 areas" data-placeholder="Select Area">
                                    <option value="all">All Area</option>
                                @foreach($area as $key)
                                    <option value="{{$key->name}}">{{$key->name}}</option>
                                @endforeach
                            </select>
                            <select  name="feasible" class="feasible select2">
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
                            <button type="submit" name="print" value="print" class="btn btn-minier btn-primary print findarea">
                                Print
                            </button>
                            {{ Form::close() }}
                        </div>
                    </div>
    <label class="col-sm-3 control-label">
            <span class="blue bolder"></span>
    </label>
    <label class="col-sm-3 control-label">
            <span class="blue bolder">Select To Assign Employee</span>
            <select name="assign_employee" class="select2 employee"
                                             data-placeholder="Sales Employee">
                <option value="">Select Employee</option>
                @foreach($employees as $key)
                    <option value="{{$key->employee_identity}}">{{$key->name}}</option>
                @endforeach
            </select>
    </label>
</div>
<div class="alert alert-info success col-sm-12">
        <span class="status"></span>
         <button class="close"  data-dismiss="alert">
                <i class="ace-icon fa fa-times"></i>
        </button>
</div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th> CRF No </th>
                <th>Name</th>
                <th>Application Date</th>
                <th>Address1</th>
                <th>Address</th>
                <th>Address3</th>
                <th>Phone</th>
                <th>Remarks</th>
                <th>Assigned To</th>
                <th>Feasible</th>
                <th>Assign</th>
                <th>Satus</th>
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
            var table = $('#sample-table-1').dataTable({
                processing: true,
                serverSide: true,
                       "ajax": '/admin/feasible/assign_ajax',
                       "type":'get',
            });
     });
$('.findarea').click(function(){
            var from=$('.from').val();
            var to=$('.to').val();
            var area=$('select.areas').val();
            var feasible=$('select.feasible').val();
            var oTable = jQuery('#sample-table-1').dataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                       "ajax": '/admin/feasible/assign_ajax?from='+from+'&to='+to+'&area='+[area]+'&feasible='+feasible,
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

    $('.select2').css('width','200px').select2({allowClear:true})

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

     $('select.feasible').change(function(){
            var emp=$(this).val();
            $('.feas').val(emp);
        });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".success").hide();

    $('.assign').click(function(){
            var crf_no = $(this).val();
    });
});
    function assign(y,x){
        if(x==1){
            var employee = $('select.employee').val();
            var crf_no = y;
        }else{
            var employee ="completed";
            var crf_no =y;
        }
        var feasible=$('select.feasible').val();
        $(this).css('color','orange');
        $.ajax({
            url : '/admin/feasible/assign_update',
            type : 'GET',
            data : {'employee':employee,'crf_no':crf_no,'feasible':feasible},
            success : function(data){
                if (data['found'] == "true") {
                    if( "success" == data['pre_status']){
                        if(employee == "completed"){
                            $('.comp_'+crf_no).removeClass("finish");
                            $('.comp_'+crf_no).removeClass("btn-danger");
                            $('.comp_'+crf_no).addClass("btn btn-sm btn-success");
                            $('.comp_'+crf_no).prop("disabled", true);
                            $('.comp_'+crf_no).html('completed');
                        }else{
                            $('.'+crf_no).removeClass("assign");
                            $('.'+crf_no).addClass("btn btn-sm btn-success");
                            $('.'+crf_no).prop("disabled", true);
                        }
                        $(".success").show();
                        if( "success" == data['pre_status']){
                            $(".status").text('updated SuccessFully!!!!');
                        }else{
                            $(".status").text(data['pre_status']);
                        }
                        setTimeout(function() { $(".success").hide(); }, 3000);}
                }else if("nothing" == data['pre_status']) {
                         $(".success").show();
                        $(".status").text('Nothing updated!!!!!');
                        setTimeout(function() { $(".success").hide(); }, 3000);
                }else if("invaild" == data['pre_status']){
                        $(".success").show();
                        $(".status").text('invaild Inputs Select Area and Feasible and Employee !!!!');
                        setTimeout(function() { $(".success").hide(); }, 3000);
                }
                
            }
        })
    }
</script>
@stop
