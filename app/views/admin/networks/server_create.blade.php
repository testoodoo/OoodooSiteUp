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
            <a href="/admin/network/server_create">Network Details</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
       Network
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Network Details
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        {{ Form::open(array('route' => 'admin.network.server_post', 'method' => 'POST', 'class' => 'form-horizontal validate-form ')) }}
            <div class="form-group">
                <label class="col-sm-3 control-label">IP</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="ip" placeholder="IP" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="name" placeholder="Name" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Host Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="hostname" placeholder="Host Name" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Port</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="port" placeholder="Port" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Purpose</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="purpose" placeholder="Purpose" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Description</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="discription" placeholder="Description" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Select Location</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="location" class="select2 required"
                             data-placeholder="Select Location" required>
                                <option value=""></option>
                             @foreach($areas as $area)
                                <option value="value">{{$area->name}}</option>
                            @endforeach
                    </select>
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