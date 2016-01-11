@extends ('user._layouts.default')
@section('main')
<div class="panel">
    <header class="bio-graph-heading">
    <b>DATA SUMMARY</b>
    </header>
</div>
<div class="row state-overview">
    <div class="col-lg-4 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-cloud-download" ></i>
            </div>
            <div class="value">
                <h4 class="count">{{Auth::user()->get()->bytes_in_gb()}} GB</h4>
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
                <h4 class="count">{{Auth::user()->get()->bytes_out_gb()}} GB </h4>
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
                <h4 class="count">{{Auth::user()->get()->data_usage_in_gb()}} GB</h4>
                <p><b>Total</b></p>
            </div>
        </section>
    </div>
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol blue">
                        <i class="fa fa-laptop" ></i>
                    </div>
                    <div class="value">
                        <h4 class="count">{{$current_plan}}</h4>
                        <p><b>Current Plan</b></p>
                    </div>
                </section>
            </div>
    @if(($data_left)!='NA')
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol blue">
                        <i class="fa fa-gift" ></i>
                    </div>
                    <div class="value">
                        <h4 class="count">{{$plan_data}} GB</h4>
                        <p><b>Plan Data</b></p>
                    </div>
                </section>
            </div>
            <div class="col-lg-4 col-sm-6">
                <section class="panel">
                    <div class="symbol blue">
                        <i class="fa fa-info" ></i>
                    </div>
                    <div class="value">
                        <h4 class="count">{{$data_left}}</h4>
                        <p><b>Data Left</b></p>
                    </div>
                </section>
            </div>
        </div>
    @endif

    <div class="row">
        <div class = "pull-left">
            <div class="col-lg-12">
                <ul class="breadcrumb">
                    <li>
                        <a href="/session_usage">
                            <i class="fa fa-calendar"></i>
                            <b>View by date</b>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@if(!is_null($usage))
<div class="panel">
    <header class="bio-graph-heading">
        <b>CURRENT SESSION</b>
    </header>
</div>
    <div class="row state-overview">
        <div class="col-lg-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-bar-chart-o" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{Auth::user()->get()->data_usage_total_gb()}} MB</h4>
                    <p><b>Usage</b></p>
                </div>
            </section>
        </div>
        <div class="col-lg-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-globe" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{$usage->ip_address}}</h4>
                    <p><b>IP Address</b></p>
                </div>
            </section>
        </div>
        <div class="col-lg-4 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-desktop" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{$usage->mac_address}}</h4>
                    <p><b>MAC Address</b></p>
                </div>
            </section>
        </div>
    </div>
@else
    <div class="alert alert-block alert-danger fade in" style="color:red" align="center">
        <h3>You don't have any current session</h3>
    </div>
@endif        
@stop