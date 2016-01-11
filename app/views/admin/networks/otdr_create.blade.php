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
            <a href="/admin/network/otdr_create">Otdr</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
       Otdr
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Otdr Details
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        {{ Form::open(array('route' => 'admin.network.otdr_post', 'method' => 'POST', 'class' => 'form-horizontal validate-form ')) }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Location A</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="location_a" placeholder="Location A" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Select Area A</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="area_a" class="select2 required"
                             data-placeholder="Select Area" required>
                                <option value=""></option>
                            @foreach($areas as $area)
                                <option value="{{$area->name}}">{{$area->name}}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Location B</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="location_b" placeholder="Location B" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Select Area B</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="area_b" class="select2 required"
                             data-placeholder="Select Area" required>
                                <option value=""></option>
                             @foreach($areas as $area)
                                <option value="{{$area->name}}">{{$area->name}}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Distance</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="distance" placeholder="Distance" />
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