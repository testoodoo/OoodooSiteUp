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
            <a href="/admin/reports/send_reports">Send Reports</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
       Reports
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Send Report Details
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        {{ Form::open(array('route' => 'reports.send_reports_post', 'method' => 'POST', 'class' => 'form-horizontal validate-form ')) }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Report Tittle</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="report_tittle" placeholder="Tittle For Reports" />
                </div>
            </div>
            <div class="form-group">
				{{ Form::label('Wirte Query','Write Query', array('class' => 'col-sm-3 control-label no-padding-right'))}}
				<div class="col-sm-9">
					{{ Form::textarea('query', '' , array('class' => 'col-xs-10 col-sm-7','required')) }}
				</div>
			</div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Select Report Format</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="address3" class="select2 required multiulti"
                             data-placeholder="Select Area" required>
                        <option value=""></option>
                            <option value="value"></option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label">Application Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required datepicker" name="application_date" maxlength="10" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
                     Reports To
                </label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="sales_employee_id" class="select2" multiple=""
                             data-placeholder="Send To">
                        <option value=""></option>
                            <option value="aluev}">
                            </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"> Date and Time</label>
                <div class="col-sm-5 input-group">
                    <input type="text" class="form-control date-timepicker1">
                     <span class="input-group-addon">
                    <i class="fa fa-clock-o bigger-110"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"> Date and Time</label>
                <div class="col-sm-5 input-group bootstrap-timepicker">
                    <input id="timepicker1" type="text" class="form-control">
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o bigger-110"></i>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        {{ Form::close(); }}
    </div>
</div>
<script type="text/javascript">
                $('.date-timepicker1').datetimepicker({
                 icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-arrows ',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                 }
                }).next().on(ace.click_event, function(){
                    $(this).prev().focus();
                });

                $('#timepicker1').timepicker({
                    minuteStep: 1,
                    showSeconds: true,
                    showMeridian: false,
                    disableFocus: true
                }).on('focus', function() {
                    $('#timepicker1').timepicker('showWidget');
                }).next().on(ace.click_event, function(){
                    $(this).prev().focus();
                });

    $('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });
                
    </script>
                
            
               



@stop