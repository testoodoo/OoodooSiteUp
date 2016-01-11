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
        <a href="/admin/users-old">Users-old</a>
    </li>
    <li class="active">
        <a href="/admin/users-old/show/{{$user->account_no}}">Show</a>
    </li>
</ul>
</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
                <div class="hr dotted"></div>
                <div class="">
                    <div id="user-profile-1" class="user-profile row">
                        <div class="col-xs-12 col-sm-3 center">
                            <div>
                                <span class="profile-picture">
                                    <img id="avatar" class="editable img-responsive editable-click editable-empty" alt="Alex's Avatar" src="/assets/dist/admin/images/profile-pic.jpg"></img>
                                </span>
                                <div class="space-4"></div>
                                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                    <div class="inline position-relative">
                                        <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                            <i class="ace-icon fa fa-circle light-green"></i>
                                            &nbsp;
                                            <span class="white">{{$user->first_name}} {{$user->last_name}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="space-6"></div>
                            <div class="row">
                                        <div class="btn-group">
                                                <button class="btn btn-info btn-sm">
                                                    password send employee
                                                </button>
                                                <div class="col-xs-12"></div>
                                                <form action="/admin/users-old/notify-password/{{$user->account_no}}">
                                                <input class="input-medium" type="text" name="employee_id" placeholder="Enter Employee ID">
                                                <div class="col-xs-12"></div>
                                                        <button class="btn btn-info btn-sm">submit</button>
                                                </form>
                                            </div>
                                    </div>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="center">
                                <a href="/admin/bills?account_id={{$user->account_id}}">
                                    <span class="btn btn-app btn-sm btn-light no-hover">
                                        <span class="line-height-1 bigger-400 blue"> {{count($user->bills())}} </span>
                                        <br>
                                            <span class="line-height-1 smaller-90"> Bills </span>
                                        </span>
                                    </a>
                                    <a href="/admin/payments/transactions?account_id={{$user->account_id}}">
                                        <span class="btn btn-app btn-sm btn-yellow no-hover">
                                            <span class="line-height-1 bigger-400"> {{count($user->transactions())}} </span>
                                            <br>
                                                <span class="line-height-1 smaller-90"> Payments </span>
                                            </span>
                                        </a>
                                        <a href="/admin/ticket/index?mobile={{$user->mobile}}">
                                            <span class="btn btn-app btn-sm btn-primary no-hover">
                                                <span class="line-height-1 bigger-400"> {{count($user->tickets())}} </span>
                                                <br>
                                                    <span class="line-height-1 smaller-90">Complaints</span>
                                                </span>
                                            </a>
                                            <a href="/admin/usage/index?query={{$user->account_id}}">
                                                <span class="btn btn-app btn-sm btn-pink no-hover">
                                                    <span class="line-height-1 bigger-400">
                                                    @if(count($user->datausages())!=0)
                                                   {{ $user->datausages()->gb_percent }}
                                                    @else 0 @endif</span>
                                                </br>
                                                <span class="line-height-1 smaller-90">Data </span>
                                            </span>
                                        </a>
                                        <div class="btn-group">
                                            <button class="btn btn-app btn-pink btn-xs" style="width:100px">
                                                password
                                            </button>

                                            <button data-toggle="dropdown" class="btn btn-app btn-pink btn-xs dropdown-toggle" aria-expanded="false">
                                                <span class="bigger-110 ace-icon fa fa-caret-down icon-only"></span>
                                            </button>

                                            <ul class="dropdown-menu dropdown-pink">
                                                <li><a class="btn btn-info" onclick="cust_password_acc_id()">show password</a></li>
                                                <li><a class="btn btn-primary" href="/admin/users-old/notify-password/{{$user->account_no}}?password=change">Network forgot password link</a></li>
                                                <li><a class="btn btn-success" href="/admin/users-old/notify-password/{{$user->account_no}}" >password send User</a></li>
                                                <li></li>
                                            </ul>
                                        </div>
                                        <a href="/admin/users-old/edit/{{$user->account_id}}" class="btn btn-primary">Edit for user</a>                                    </div>
                                    <div class="space-12"></div>
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Account ID </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">{{ $user->account_id }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Phone </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">{{ $user->phone }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Email </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Address </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">
                                            {{ $user->address1 }}, {{ $user->address2 }}, {{ $user->address3 }}
                                        </span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> DOB </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">{{ $user->dob }}</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Plan </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">@if($user->plan()) {{ $user->plan()->plan }}@else Plan Not Found @endif</span>
                                            </div>
                                        </div>
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Plan Cycle </div>
                                            <div class="profile-info-value">
                                                <span class="editable editable-click" id="username">@if($user->plan()) {{ $user->plan()->plan_start_date }}@else Plan Not Found @endif
                                                                                                TO @if($user->plan()) {{ $user->plan()->plan_end_date }}@else Plan Not Found @endif
                                                                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-20"></div>
                                    
                                    <div class="space-6"></div>
                                </div>
                            </div>
                        </div>
                        <!-- PAGE CONTENT ENDS -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-30 tab-size-bigger-100" id="myTab">
                                    <li class="active">
                                        <a data-toggle="tab" href="#faq-tab-7" aria-expanded="false">
                                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                                            Active Sessions
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#faq-tab-4" aria-expanded="false">
                                            <i class="purple ace-icon fa fa-magic bigger-120"></i>
                                                            Bills 
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#payment" aria-expanded="false">
                                            <i class="orange ace-icon fa fa-credit-card bigger-120"></i>
                                                            Payments 
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#faq-tab-2" aria-expanded="false">
                                            <i class="green ace-icon fa fa-user bigger-120"></i>
                                                            Data Usages 
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#faq-tab-5" aria-expanded="false">
                                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                                            Tickets 
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#faq-tab-8" aria-expanded="false">
                                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                                            Sessions History
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#faq-tab-1" aria-expanded="false" onclick="Logs({{$user->account_no}})">
                                            <i class="blue ace-icon fa fa-question-circle bigger-120" ></i>
                                                            Logs
                                        </a>
                                    </li>
                                    <!-- /.dropdown -->
                                </ul>
                                <div class="tab-content no-border padding-24">
                                   <div id="faq-tab-7" class="tab-pane fade active in">
                                        <h4 class="blue"></h4>
                                        <div class="space-8"></div>
                                        <div id="faq-list-7" class="panel-group accordion-style1 accordion-style2">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <table id="active_session" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Account ID</th>
                                                            <th>MAC Address</th>
                                                            <th>IP Address</th>
                                                            <th>Bytes down</th>
                                                            <th>Bytes up</th>
                                                            <th>Download Rate</th>
                                                            <th>Upload Rate</th>
                                                            <th>Start Time</th>
                                                            <th>Duration</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                <div id="faq-tab-4" class="tab-pane fade">
                                    <div class="space-8"></div>
                                    <div id="faq-list-4" class="panel-group accordion-style1 accordion-style2">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <table id="bills" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Bill No.</th>
                                                            <th>For Month</th>
                                                            <th>Plan</th>
                                                            <th>Bill Date</th>
                                                            <th>Due Date</th>
                                                            <th>Previous Balance</th>
                                                            <th>Last Payments</th>
                                                            <th>Adjustments</th>
                                                            <th>Current Charges</th>
                                                            <th>Amount before Due Date</th>
                                                            <th>Amount After Due Date</th>
                                                            <th>Amount Paid</th>
                                                            <th>Status</th>
                                                            <th>Send SMS</th>
                                                            <th>view</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                              
                                                    </tbody>
                                                </table>
                                            </div>
                                         </div>
                                       </div>
                                    </div>
                                <div id="payment" class="tab-pane fade">
                                    <h4 class="blue"></h4>
                                    <div class="space-8"></div>
                                    <div id="payment" class="panel-group accordion-style1 accordion-style2">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <table id="payments" class="table table-striped table-bordered table-hover">
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
                                                    <tbody>
                                                       
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div id="faq-tab-2" class="tab-pane fade">
                                        <h4 class="blue"></h4>
                                        <div class="space-8"></div>
                                        <div id="faq-list-2" class="panel-group accordion-style1 accordion-style2">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <table id="usages" class="table table-striped table-bordered table-hover">
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
                                                        <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div id="faq-tab-5" class="tab-pane fade">
                                    @if(count($tickets)==0)
                                        <button class="btn btn-white btn-info btn-bold pull-right raise_ticket">
                                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                            Raise Ticket
                                        </button>
                                    @else
                                        <h5 class="red">Ticket cannot be raised because ticket status is open. validity available till 24 hours</h5>
                                    @endif
                                        <h4 class="blue"></h4>
                                        <div class="space-8"></div>
                                        <div id="faq-list-5" class="panel-group accordion-style1 accordion-style2">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                @include('admin.users_old.tickets')
                                                     <table id="ticket" class="table table-striped table-bordered table-hover">
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
                                                        <tbody>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                   <div id="faq-tab-8" class="tab-pane fade">
                                   <a href="/admin/session_history/index" class="btn btn-white btn-info btn-bold pull-right ">
                                                        <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                                               SESSIONS MORE
                                                        </a>
                                        <div class="space-8"></div>
                                        <div id="faq-list-4" class="panel-group accordion-style1 accordion-style2">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <table id="session" class="table table-striped table-bordered table-hover">
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
                                                        <tbody>
                                                  
                                                        </tbody>
                                                    </table>
                                                </div>
                                             </div>
                                           </div>
                                        </div>
                                        <div id="faq-tab-1" class="tab-pane fade">
                                            <a href="/admin/session/session_logs" class="btn btn-white btn-info btn-bold pull-right ">
                                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                                   LOGS MORE
                                            </a>
                                                <h4 class="blue"></h4>
                                                <div class="space-8"></div>
                                                <div id="faq-list-1" class="panel-group accordion-style1 accordion-style2">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <table id="records_table" class="table table-striped table-bordered table-hover">
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
                                                </div>
                                        </div>
            </div><!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div>
@include('admin.users_old.showpage_javascript')
@stop