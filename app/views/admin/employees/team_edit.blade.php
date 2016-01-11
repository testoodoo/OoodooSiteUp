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
            <a href="/admin/employees/team_edit/{{$team->id}}">Team Edit</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Team Edit
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small>
    </h1>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        {{ Form::open(array('route' => 'admin.employees.team_edit_post', 'method' => 'POST', 'class' => 'form-horizontal otdr-validate-form ')) }}
            <input type="hidden" class="form-control" name="id" value="{{$team->id}}"/>
            {{ Form::open(array('route' => 'admin.employees.team_post', 'method' => 'POST', 'class' => 'form-horizontal otdr-validate-form ')) }}
                <div class="form-group">
                    {{ Form::label('Select Team Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="team" class="form-control col-sm-6" style="width:340px;" required>
                        <option value="{{$team->team}}">{{$team->team}}</option>
                            <option value="Fiber">Fiber</option>
                            <option value="Splicing">Splicing</option>
                            <option value="Ethernet">Ethernet</option>
                            <option value="Power">Power</option>
                            <option value="Configuration">Configuration</option>
                        </select>
                    </div>
                </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">No Of Vehicles</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control count" name="vehicles" placeholder="Vehicles" value="{{$team->vehicles}}"/>
                </div>
            </div>
             @foreach($vehicles as $v)
            <div class="form-group add_count">
                <label class="col-sm-3 control-label">Vehicles No</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="vehicles_name[]" placeholder="Vehicles" value="{{$v}}"/>
                </div>
            </div>
            @endforeach
            <div class="form-group">
                <label class="col-sm-3 control-label">Select Employee</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="employees[]" class="select2" multiple="" 
                             data-placeholder="Select Select Employees" required>
                                <option value=""></option>
                             @foreach($employ as $emp)
                                <option value="{{$emp->employee_identity}}" selected>{{$emp->employee_identity}} ({{$emp->name}})</option>
                            @endforeach
                            @foreach($employee as $emp)
                                <option value="{{$emp->employee_identity}}">{{$emp->employee_identity}} ({{$emp->name}})</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-xs-12 col-sm-9">
                    <input class="btn btn-info" type="submit" value="Save">
                </div>
            </div>
        {{ Form::close(); }}
        </div>
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
<script type="text/javascript">
 function ticket(t) {
        window.open("<?php public_path() ?>/admin/users-old/ticket-popup/"+t, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }

$('.count').change(function(){
        $(".add_count").empty();
        var count=$(this).val();
        for (var i=1; i <= count; i++) {
            $(".add_count").append('<div class="form-group"><label class="col-sm-3 control-label">Vehicle No</label><div class="col-sm-5"><input type="text" class="form-control" name="vehicles_name[]" placeholder="Vehicles" required/></div></div>');
        }
    });
</script
@stop