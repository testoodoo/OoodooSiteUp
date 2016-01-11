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
            <a href="/admin/session/index">Session</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Session
    </h1>
</div>
<div class="row">
    <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
        {{ Form::open(array('route' => 'admin.session_history.show','class'=>'form-horizontal','method'=>'GET')) }}
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="blue bolder">ACCOUNT ID</span>
                    </label>
                    <div class="col-sm-5">
                        <label class="col-sm-10 control-label">
                            {{ Form::text('account_id',$account_id, array('class' => 'form-control')) }}
                        </label>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-sm-3 control-label">
                      <span class="blue bolder"> START & END DATE </span>
                    </label>
                  <div class="col-sm-5">
                      <label class="col-sm-10 control-label">
                            <div class="input-daterange input-group">
                                <input type="text" class="input-sm form-control" name="from_date" value="{{$from_date}}">
                                <span class="input-group-addon">
                                    <i class="fa fa-exchange"></i>
                                </span>
                                <input type="text" class="input-sm form-control" name="to_date" value="{{$to_date}}">
                            </div>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">submit</button>
                    @if(count($bytes_up)!=0) 
                    <button type="submit" name="mail" value="mail" class="btn btn-primary">send mail</button>
                    @endif
                </div>
            </div>
        {{ Form::close() }}
    </div>
@if(count($bytes_up)!=0) 
<div class="col-sm-5">
  <table id="sample-table-1" class="table table-striped table-bordered table-hover">
      <tbody>
      <tr>
          <th>Account ID</th>
          <th>From Date</th>
          <th>To Date</th>
          <th>Upload</th>
          <th>Download</th>
          <th>Total GB</th>
          </tr>
          <tr>
              <td>{{$account_id}}</td>
              <td>{{$from_date}}</td>
              <td>{{$to_date}}</td>
              <td>{{$bytes_up}}</td>
              <td>{{$bytes_down}}</td>
              <td>{{$bytes_total}}GB</td>
          </tr>
      </tbody>
  </table>
</div>
<button class="btn btn-white btn-info btn-bold pull-right raise_map">
                                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                            Session Map
                                        </button>
    </div>

@include('admin.session.session_map')
@endif
 <div class="col-sm-12">
          @if($from_date=='1970-01-01 00:00:00' && $to_date=='1970-01-02 00:00:00')
          @endif
              @if(count($usages)!=0)        
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <tbody>
                    <tr>
                        <th>Session ID</th>
                        <th>IP Address</th>
                        <th>MAC address</th>
                        <th>Start Time</th>
                        <th>Stop Time</th>
                        <th>Data In</th>
                        <th>Data Out</th>
                        <th>Total Data</th>
                        </tr>
                        @foreach($usages as $usage)
                          <tr>
                              <td>{{$usage->session_id}}</td>
                              <td>{{$usage->ip_address}}</td>
                              <td>{{$usage->mac_address}}</td>
                              <td>{{$usage->start_time}}</td>
                              <td>{{$usage->stop_time}}</td>
                              <td>{{$usage->data_usage_in_gb($usage->bytes_down)}}GB</td>
                              <td>{{$usage->data_usage_in_gb($usage->bytes_up)}}GB</td>
                              <td>{{$usage->data_usage_in_gb($usage->bytes_total)}}GB</td>     
                          </tr>
                        @endforeach
                    </tbody>
                </table>
              @else
              @endif
              @if(count($usages)!=0)                                             
                  <div style="float:right;">
                      @if($from_date!='1970-01-01 00:00:00')
                        {{ $usages->appends(Input::except('page'))-> links();}} 
                      @else
                        {{ $usages->links(); }}
                      @endif
                  </div>
              @endif
<script type="text/javascript">
  $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true
        })
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
        $('.input-daterange').datepicker({autoclose:true});
        $('button.raise_map').click(function(){
                $(".show_map").slideToggle("slow");
            });
         @if(count($usages)!=0) 
    $(function () {

      $('#container').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Session Map {{$from_date}} TO {{$to_date}}'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
             dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'Data IN (GB)'
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y} GB'
        },

        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        series: [{
            name: "date",
                data:[
              @for($i=0;$i<count($bytes);$i++)
                [Date.UTC({{date("Y",strtotime($date[$i]))}},{{date('m',strtotime($date[$i]))-1}},{{date('d',strtotime($date[$i]))}}),{{$bytes[$i]}}],
              @endfor
            ]
            }]
        });
    });
@endif
  </script>

@stop