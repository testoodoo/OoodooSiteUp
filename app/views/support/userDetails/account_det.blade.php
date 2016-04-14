@extends ('support.layouts.default')
@section('main')
<div class="page-content">
    <div id="tab-general">
        <div class="row mbl">
            <div class="col-lg-12">
                <div class="col-md-12">
                    <div id="area-chart-spline" style="width: 100%; height: 300px; display: none; padding: 0px; position: relative;">
                        <canvas class="flot-base" width="1176" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1176px; height: 300px;"></canvas>
                        <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                            <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 10px;">Jan</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 203px;">Feb</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 395px;">Mar</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 588px;">Apr</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 781px;">May</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 973px;">Jun</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 1166px;">Jul</div>
                            </div>
                            <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 290px; left: 1px;">0</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 250px; left: 1px;">25</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 210px; left: 1px;">50</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 170px; left: 1px;">75</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 130px; left: 1px;">100</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 90px; left: 1px;">125</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 50px; left: 1px;">150</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 10px; left: 1px;">175</div>
                            </div>
                        </div>
                        <canvas class="flot-overlay" width="1176" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1176px; height: 300px;"></canvas>
                        <div class="legend">
                            <div style="position: absolute; width: 0px; height: 0px; top: 15px; right: 15px; opacity: 0.85; background-color: rgb(255, 255, 255);"></div>
                            <table style="position:absolute;top:15px;right:15px;;font-size:smaller;color:#545454">
                                <tbody>
                                    <tr>
                                        <td class="legendColorBox">
                                            <div style="border:1px solid #ccc;padding:1px">
                                                <div style="width:4px;height:0;border:5px solid #66b0ea;overflow:hidden"></div>
                                            </div>
                                        </td>
                                        <td class="legendLabel">Upload</td>
                                    </tr>
                                    <tr>
                                        <td class="legendColorBox">
                                            <div style="border:1px solid #ccc;padding:1px">
                                                <div style="width:4px;height:0;border:5px solid #3f516b;overflow:hidden"></div>
                                            </div>
                                        </td>
                                        <td class="legendLabel">Download</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
<!--                 <div class="row">
                    <div class="col-md-12"> -->
                        <h2>{{$user->first_name}}&nbsp;{{$user->last_name}}</h2>
                        <div class="row mtl">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-center mbl">
                                        <img src="/assets/dist/support/images/photo5.png" class="img-responsive">
                                        </div>
                                        <div class="text-center mbl">
                                            <a href="#" class="btn btn-green">
                                                <i class="fa fa-upload"></i>&nbsp;
                                        Upload
                                            </a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <table class="table table-striped table-hover" id="theTable">
                                        <tbody>
                                            <tr>
                                                <td>Account ID</td>
                                                <td>{{$user->account_id}}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <span class="label label-success">Active</span>
                                                </td>
                                            </tr>                                                                                      
                                            <tr>
                                                <td>Phone</td>
                                                <td>{{$user->phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{$user->address1}}<br>{{$user->address2}}<br>{{$user->address3}}</td>
                                            </tr>
                                            <tr>
                                                <td>Usage</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="col-md-3">
                                    <input class="tableid"></input>
                                    <table class="table table-striped table-hover">
                                    <tbody>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{$user->email}}</td>
                                            </tr>
                                            <tr>
                                                <td>Plan</td>
                                                <td>{{ $user->plan()->plan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Plan Cycle</td>
                                                <td>{{$user->plan()->plan_start_date}}&nbsp;To&nbsp;{{$user->plan()->plan_start_date}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-content">
                                            <ul class="list-inline item-details">
                                                <li>
                                                    <a href="http://themifycloud.com">Admin templates</a>
                                                </li>
                                                <li>
                                                    <a href="http://themescloud.org">Bootstrap themes</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab-bill" data-toggle="tab">Bill</a>
                                        </li>
                                        <li>
                                            <a href="#tab-payment" data-toggle="tab">Payments</a>
                                        </li>
                                        <li>
                                            <a href="#tab-dataUsage" data-toggle="tab">Data Usage</a>
                                        </li>
                                        <li>
                                            <a href="#tab-sessionHistory" data-toggle="tab">Session History</a>
                                        </li>
                                        <li>
                                            <a href="#tab-logs" data-toggle="tab" onclick="log({{$user->account_no}});">Logs</a>
                                        </li>
                                        <li>
                                            <a href="#tab-ticket" data-toggle="tab">Ticket</a>
                                        </li>
                                        <li>
                                            <a href="#tab-activeSession" data-toggle="tab">Active Session</a>
                                        </li>                                         

                                    </ul>
                                    <div id="generalTabContent" class="tab-content">
                                        <div id="tab-bill" class="tab-pane fade in active" onload="thisis()">
                                        <div class="panel panel-blue">
                                        <table id="billTable" class="table table-hover table-bordered">
                                        	<thead>
                                        		<tr>
                                        			<th>Bill No</th>
                                        			<th>Month</th>
                                        			<th>Plan</th>
                                        			<th>Bill Date</th>
                                        			<th>Previous Balance</th>
                                        			<th>Last Payment</th>
                                        			<th>Adjustment</th>
                                        			<th>Current Charge</th>
                                        			<th>Amount Before Due Date</th>
                                        			<th>Amount Paid</th>
                                        			<th>Status</th>
                                        			<th>test+send+sms</th>                                        			                                        			                                        			
                                        		</tr>
                                        	</thead>
                                        	<tbody>
                                        	</tbody>
                                        </table>
                                        </div>
                                        </div>
			                            <div id="tab-payment" class="tab-pane fade in">
                                        <div class="panel panel-blue">			                            
                                        <table id="paymentTable" class="table table-hover table-bordered">
                                        	<thead>
                                        		<tr>
	                                                <th>Created At</th>
	                                                <th>Bill No</th>
	                                                <th>Amount</th>
	                                                <th>Transaction Code</th>
	                                                <th>Payment Type</th>
	                                                <th>Remarks</th>
	                                                <th>Transaction Type</th>
	                                                <th>Status</th>
	                                                <th>view</th>                                       			                                        			                                        			
                                        		</tr>
                                        	</thead>
                                        </table>
                                        </div>
                                        </div>
			                            <div id="tab-dataUsage" class="tab-pane fade in">
                                        <div class="panel panel-blue">                                        
                                        <table id="usageTable" class="table table-hover table-bordered">
                                        	<thead>
                                        		<tr>
	                                                <th>Account ID</th>
	                                                <th>Rate Plan</th>
	                                                <th>Status</th>
	                                                <th>Current Speed</th>
	                                                <th>Duration</th>
	                                                <th>Bytes Down</th>
	                                                <th>Bytes Up</th>
	                                                <th>Bytes Total</th>
	                                                <th>Total GB</th>
	                                                <th>view</th>                                        			                                       			                                   			                                        			
                                        		</tr>
                                        	</thead>
                                        </table>
                                        </div>
                                        </div>
			                            <div id="tab-sessionHistory" class="tab-pane fade in">
                                        <div class="panel panel-blue">                                        
                                        <table id="sessionTable" class="table table-hover table-bordered">
                                        	<thead>
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
                                        	</thead>
                                        </table>
                                        </div>
                                        </div> 
			                            <div id="tab-logs" class="tab-pane fade in">
                                        <div class="panel panel-blue">                                        
                                        <table id="logTable" class="table table-hover table-bordered" onload='functon hello();'>
                                        	<thead>
                                        		<tr>
                                                    <th>Created</th>
                                                    <th>User name</th>
                                                    <th>MAC Address</th>
                                                    <th>IP Address</th>
                                                    <th>Message</th>                                       			                                        			                                        			
                                        		</tr>
                                        	</thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        </div>
                                        </div>                                                                                                                       
			                            <div id="tab-ticket" class="tab-pane fade in">
                                        <div class="panel panel-blue">                                        
                                        <table id="ticketTable" class="table table-hover table-bordered" onclick="ticket('{{$user->account_id}}')">
                                        	<thead>
                                        		<tr>
                                                    <th>ID</th>
                                                    <th>Requirement</th>
                                                    <th>Created_at</th>
                                                    <th>Updated_at</th>
                                                    <th>Assgined To</th>
                                                    <th>Ticket Type</th>
                                                    <th>status</th>
                                                    <th>view</th>                                       			                                        			                                        			
                                        		</tr>
                                        	</thead>
                                        </table>
                                        </div>
                                    </div> 
                                        <div id="tab-activeSession" class="tab-pane fade in">
                                        <div class="panel panel-blue">                                        
                                        <table id="activesessionTable" class="table table-hover table-bordered" onclick="ticket('{{$user->account_id}}')">
                                            <thead>
                                                <tr>
                                                    <th>Account ID</th>
                                                    <th>MAC Address</th>
                                                    <th>IP Address</th>
                                                    <th>Bytes Down</th>
                                                    <th>Bytes Up</th>
                                                    <th>Download Rate</th>
                                                    <th>Upload Rate</th>
                                                    <th>Start Time</th>
                                                    <th>Duration</th>                                                                                                                                                           
                                                </tr>
                                            </thead>
                                        </table>
                                        </div>
                                    </div>                                                                            
                                </div>
                            </div>
                        </div>
                    <!-- </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function() {
             var oTable = jQuery('#paymentTable').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 10,
                       "ajax": '/payment?account_id={{$user->account_id}}',
                       "type":'get',
                   });
});


            var oTable = jQuery('#billTable').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 10,
                       "ajax": '/bill?account_id={{$user->account_id}}',
                       "type":'get',

                        "createdRow": function ( row, data, index ) {
                    if(data[12] == "paid"){
                            $('td:eq(12)', row).html('<span style="color:green">Paid</span>');
                    }else if(data[12] == "not_paid"){
                            $('td:eq(12)', row).html('<span style="color:red">Not Paid</span>');
                    }else if(data[12] == "partially_paid"){
                            $('td:eq(12)', row).html('<span style="color:orange">Partially Paid</span>');
                    }
                },

                   });

              var oTable = jQuery('#usageTable').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/usage?account_id={{$user->account_id}}',
                       "type":'get',
                        "createdRow": function ( row, data, index ) {
                        var total_gb=data[8]/1000000000;
                        var gb=total_gb.toFixed(2);
                        $('td:eq(8)', row).html(gb);

                        $('#theTable tbody tr:nth-child(5),th:nth-child(2)').show(gb);
                },
                   });

              var oTable = jQuery('#sessionTable').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 25,
                       "ajax": '/session?account_id={{$user->account_id}}',
                       "type":'get',
                   });

              var oTable = jQuery('#activesessionTable').dataTable({
                processing: true,
                serverSide: true,
                       "ajax": '/active_session?account_id={{$user->account_id}}',
                       "type":'get',
                   });

              var oTable = jQuery('#ticketTable').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/ticket?account_id={{$user->account_id}}',
                       "type":'get',
                   });
           
                             
</script>
<script>
function hello(){
    alert('hi');
}

     function log(p) {
            var account_id =+p;
                $.ajax({
                    url : '/log',
                    type : 'GET',
                    data : {account_id :account_id},
                    dataType:'json',
                    success : function(data) {
                        if (data["found"] == "false") {
                                    alert('Logs Not available');
                                }else{
                        $('#logTable tbody').remove();
                         var trHTML = '';
                        $.each(data, function (i, item) {
                            trHTML += '<tr><td>' + item.created + '</td><td>' + item.username  + '</td><td>' + item.mac + '</td><td>'+ item.ap_mac + '</td><td>'+ item.message + '</td></tr>';
                        });
                    $('#logTable').append(trHTML);
                    }
                }
                });
    }
</script>    
@stop
