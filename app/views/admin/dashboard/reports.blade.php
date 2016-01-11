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
            <a href="/admin/reports">Reports</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Reports
    </h1>
</div>

    <div class="col-sm-12">
     <h4 class="blue bolder">Tickets</h4>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#ticket_now" aria-expanded="true">Now</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#till_now" aria-expanded="false">Till Now</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="ticket_now" class="tab-pane active">
                {{ Form::open(array('route' => 'admin.reports','class'=>'form-horizontal','method'=>'GET')) }}
                    <label class="col-sm-3 control-label">
                      <span class="blue bolder"> START & END DATE </span>
                    </label>
                    <div class="col-sm-3">
                         <label class="col-sm-10 control-label">
                            <div class="input-daterange input-group">
                                <input type="text" class="input-sm form-control from_ticket" name="from_date" value="" placeholder="from">
                                <span class="input-group-addon">
                                    <i class="fa fa-exchange"></i>
                                </span>
                                <input type="text" class="input-sm form-control to_ticket" name="to_date" value="" placeholder="to">
                            </div>
                         </label>
                    </div>
                {{ Form::close() }}
                    <button type="submit" class="btn btn-sm btn-primary from_to_ticktet">submit</button>
                <div id="cont" style="min-width: 610px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>

                <div id="till_now" class="tab-pane">
                <div id="co" style="min-width: 610px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
     <h4 class="blue bolder">Operations</h4>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#home4" aria-expanded="true">Now</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#dropdown14" aria-expanded="false">Till Now</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home4" class="tab-pane active">
                {{ Form::open(array('route' => 'admin.reports','class'=>'form-horizontal','method'=>'GET')) }}
                    <label class="col-sm-3 control-label">
                      <span class="blue bolder"> START & END DATE </span>
                    </label>
                    <div class="col-sm-3">
                         <label class="col-sm-10 control-label">
                            <div class="input-daterange input-group">
                                <input type="text" class="input-sm form-control from" name="from_date" value="" placeholder="from">
                                <span class="input-group-addon">
                                    <i class="fa fa-exchange"></i>
                                </span>
                                <input type="text" class="input-sm form-control to" name="to_date" value="" placeholder="to">
                            </div>
                         </label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">submit</button>
                {{ Form::close() }}
                <div id="new_map" style="min-width: 310px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                <!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
                <pre id="tsv" style="display:none"></pre>
                </div>
                <div id="dropdown14" class="tab-pane">
                          <div id="mani" style="min-width: 610px; max-width: 600px; height: 400px; margin: 0 auto"></div>
                <!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
                <pre id="tsv" style="display:none"></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
     <h4 class="blue bolder">New Customers</h4>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#mani" aria-expanded="true">New Customers</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="mani" class="tab-pane active">
                <div id="vannan" style="min-width: 410px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>

                </div>
            </div>
        </div>
     <div class="col-sm-12">
     <h4 class="blue bolder">New Customers To be Processing</h4>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#new_custoemr1" aria-expanded="true">Now</a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#new_custoemr3" aria-expanded="false">Till Now</a>
                </li>
            </ul>

            <div class="tab-content">         
                <div id="new_custoemr1" class="tab-pane active">
                {{ Form::open(array('route' => 'admin.reports','class'=>'form-horizontal','method'=>'GET')) }}
                    <label class="col-sm-3 control-label">
                      <span class="blue bolder"> START & END DATE </span>
                    </label>
                    <div class="col-sm-3">
                         <label class="col-sm-10 control-label">
                            <div class="input-daterange input-group">
                                <input type="text" class="input-sm form-control" name="from_date" value="" placeholder="from">
                                <span class="input-group-addon">
                                    <i class="fa fa-exchange"></i>
                                </span>
                                <input type="text" class="input-sm form-control" name="to_date" value="" placeholder="to">
                            </div>
                         </label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">submit</button>
                {{ Form::close() }}
                <div id="date1" style="min-width: 610px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>

                <div id="new_custoemr3" class="tab-pane">
                <div id="date3" style="min-width: 710px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
     <h4 class="blue bolder">Payments</h4>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#payment1" aria-expanded="true">Current Month</a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#payment3" aria-expanded="false">More</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="payment1" class="tab-pane active">
                <div id="pay1" style="min-width: 410px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>

                <div id="payment3" class="tab-pane">
                <div class="col-xs-12 col-sm-4"></div>
                <div class="col-xs-12 col-sm-4">
                    <select name="for_month" id="state" class="for_month select2" data-placeholder="Click to Choose for_month...">
                        <option value="">&nbsp;</option>
                        @foreach($for_month as $key)
                        <option value="{{$key->for_month}}">{{$key->for_month}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-minier btn-purple pay">check</button>
                </div>
                <div id="pay3" style="min-width: 810px; height: 400px; max-width: 800px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>
            </div>
        </div>
    </div>
     <div class="col-sm-12">
     <h4 class="blue bolder">Bills</h4>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#success" aria-expanded="true">Current Month</a>
                </li>

                <li class="">
                    <a data-toggle="tab" href="#pending" aria-expanded="false">More</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="success" class="tab-pane active">
                <div id="for_month" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>

                <div id="pending" class="tab-pane">
                <div class="col-xs-12 col-sm-4"></div>
                <div class="col-xs-12 col-sm-4">
                    <select name="for_month" id="state" class="for_months select2" data-placeholder="Click to Choose for_month...">
                        <option value="">&nbsp;</option>
                        @foreach($for_month as $key)
                        <option value="{{$key->for_month}}">{{$key->for_month}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-minier btn-purple bills">check</button>
                </div>
                <div id="third_month" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <pre id="tsv" style="display:none"></pre>
                </div>
            </div>
        </div>
    </div>
    </div>

<script type="text/javascript">
    
    $('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });
</script>
@include('admin.dashboard.tickets_map')
@include('admin.dashboard.new_customer_map')
@include('admin.dashboard.bills_map')
@include('admin.dashboard.payments_map')
@include('admin.dashboard.feasible_map')
@include('admin.dashboard.new_cust_line')
@stop