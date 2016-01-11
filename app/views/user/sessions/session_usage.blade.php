@extends ('user._layouts.default')
@section('main')
@if($from_date != NULL && $to_date != NULL)
    <div class="row state-overview">
        
        <div class="col-lg-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-cloud-download" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{$bytes_down}} GB </h4>
                    <p><b>Download</b></p>
                </div>
            </section>
        </div>

        <div class="col-lg-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-cloud-upload" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{$bytes_up}} GB</h4>
                    <p><b>Upload</b></p>
                </div>
            </section>
        </div>

        <div class="col-lg-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-cloud" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{$bytes_total}} GB</h4>
                    <p><b>Total</b></p>
                </div>
            </section>
        </div>
    </div>
@endif
<div class = "panel">
    
    <header class="bio-graph-heading">
        <b>SESSION</b>
    </header>

    <div class = "panel-body">  
        {{ Form::open( array( 'route' =>'users.sessions.session_usage', 'method' => 'POST'))}}
            <div class="form-group">
                <label class="control-label col-md-4"></label>
                <div class="col-md-4">
                    <div class="input-group input-large">
                        <input type="text" class="form-control dpd1" name="from_date" placeholder="From Date">
                        <span class="input-group-addon">To</span>
                        <input type="text" class="form-control dpd2" name="to_date" placeholder="To Date">
                    </div>
                </div>
            </div>
        {{ Form::submit('Check', array('class' => 'btn btn-info')) }}
        <button class="btn btn-info" name="print" value="print">Download</button>
        {{ Form::close() }}

        @if($from_date == NULL && $to_date == NULL)
            <center><sup>(Please enter both the From Date and To Date )</sup></center>
        @endif

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Session ID</th>
                    <th>IP Address</th>
                    <th>MAC address</th>
                    <th>Start Time</th>
                    <th>Data dowload</th>
                    <th>Data upload</th>
                    <th>Total Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usages as $usage)
                    <tr>
                        <td>{{$usage->session_id}}</td>
                        <td>{{$usage->ip_address}}</td>
                        <td>{{$usage->mac_address}}</td>
                        <td>{{$usage->start_time}}</td>
                        <td>{{$usage->data_usage_in_gb($usage->bytes_down)}}GB</td>
                        <td>{{$usage->data_usage_in_gb($usage->bytes_up)}}GB</td>
                        <td>{{$usage->data_usage_in_gb($usage->bytes_total)}}GB</td>     
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div style="float:right;">
    @if($from_date!='NULL')
        {{ $usages->appends(Input::except('page'))-> links();}} 
    @else
        {{ $usages->links(); }}
    @endif
</div>

@stop