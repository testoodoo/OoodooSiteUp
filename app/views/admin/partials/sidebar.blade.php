<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>
    <div id="sidebar" class="sidebar responsive ace-save-state">
        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>
        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>
                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>
                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>
                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>
            </div>
            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>
                <span class="btn btn-info"></span>
                <span class="btn btn-warning"></span>
                <span class="btn btn-danger"></span>
            </div>
        </div>
        <!-- /.sidebar-shortcuts -->
        <ul class="nav nav-list">
            <li class="active">
                <a href="/admin/index">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> Dashboard </span>
                </a>
                <b class="arrow"></b>
            </li>
            @if (stristr(Request::path(),"new-customers")|| stristr(Request::path(),"registration")
                ||stristr(Request::path(),"feasible")|| stristr(Request::path(),"ticket/create") 
                ||stristr(Request::path(),"customer-activation"))
            <li class="active">
            @else
            <li class="">
            @endif
                <a href="/admin/new-customers/list" class="dropdown-toggle">
                    <i class="menu-icon fa fa-desktop"></i>
                    <span class="menu-text"> New Customers </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                <li class="">
                        <a href="/admin/ticket/create">
                            <i class="menu-icon fa fa-caret-right"></i>
                            New Connection Request
                        </a>
                    </li>
                    <li class="">
                        <a href="/admin/new-customers/list">
                            <i class="menu-icon fa fa-caret-right"></i>
                            New Customers List
                        </a>
                    </li>
                    <li class="">
                        <a href="/admin/new-customers/registration">
                            <i class="menu-icon fa fa-desktop"></i>
                            Registration Form
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/feasible/assign">
                            <i class="menu-icon fa fa-desktop"></i>
                            Assign Employee
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/new-customers/print">
                            <i class="menu-icon fa fa-caret-right"></i>
                            New Customers Print
                        </a>
                    </li>
                    <li class="">
                        <a href="/admin/feasible/reject">
                            <i class="menu-icon fa fa-caret-right"></i>
                            New Customers Reject
                        </a>
                    </li>
                    <li class="">
                        <a href="/admin/new-customers/customer-activation">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Activation
                        </a>
                    </li>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
            @if (stristr(Request::path(),"employees")||stristr(Request::path(),"roles"))
            <li class="active">
            @else
            <li class="">
            @endif
                <a href="/admin/employees" class="dropdown-toggle">
                    <i  class="menu-icon fa fa-list"></i>
                    <span class="menu-text"> Admin</span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="/admin/employees">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Employees
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/roles">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Roles
                        </a>
                    </li>
                    <!-- <li class="">
                        <a href="/admin/employees/assign">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Employee Attendance
                        </a>
                    </li> -->
                </ul>
            @if (stristr(Request::path(),"ticket/my_tickets")||stristr(Request::path(),"ticket/index")
            ||stristr(Request::path(),"incident")||stristr(Request::path(),"support")||stristr(Request::path(),"operation")))
            <li class="active">
            @else
            <li class="">
            @endif
                <a href="/admin/ticket/index" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> Tickets </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="/admin/ticket/index">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Tickets
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/ticket/my_tickets">
                            <i class="menu-icon fa fa-caret-right"></i>
                            My tickets
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/network/incident">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Incidents
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/ticket/support">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Support Alert
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/ticket/operation">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Operation Alert
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
        </li>
        @if (stristr(Request::path(),"call"))
            <li class="active">
            @else
            <li class="">
            @endif
                <a href="/admin/ticket/index" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> Customer Calls </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="/admin/ticket/exo_call_status">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Call Status
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/ticket/exo_call_missed">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Call Missed
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
        </li>
        @if (stristr(Request::path(),"users-old"))
        <li class="active">
        @else
        <li class="">
        @endif
            <a href="/admin/users-old" class="dropdown-toggle">
                <i  class="menu-icon fa fa-list-alt"></i>
                <span class="menu-text"> Account Holders </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="">
                    <a href="/admin/users-old">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Users
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="/admin/users-old/activation_details">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Activation Details
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="/admin/users-old/plan_change_details">
                        <i class="menu-icon fa fa-caret-right"></i>
                        PlanChange Details
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="/admin/topup/topupdetails">
                        <i class="menu-icon fa fa-caret-right"></i>
                        TopUp Details
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
                @if (stristr(Request::path(),"bills")||stristr(Request::path(),"adjustments")||stristr(Request::path(),"discounts")
                        ||stristr(Request::path(),"devicecost")||stristr(Request::path(),"othercharges"))
                <li class="active">
                @else
                <li class="">
                @endif
                    <a href="/admin/bills" class="dropdown-toggle">
                        <i class="menu-icon fa fa-calendar"></i>
                        <span class="menu-text"> Bills </span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="">
                            <a href="/admin/bills?status=all">
                                <i class="menu-icon fa fa-caret-right"></i>
                                bills
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="">
                            <a href="/admin/billwaiver/index">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Billwaiver
                            </a>
                        </li>
                        <li class="">
                            <a href="/admin/adjustments">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Adjustments
                            </a>
                        </li>
                        <li class="">
                            <a href="/admin/discounts">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Discounts
                            </a>
                        </li>
                        <li class="">
                            <a href="/admin/devicecost">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Device cost
                            </a>
                        </li>
                        <li class="">
                            <a href="/admin/othercharges">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Other charges
                            </a>
                        </li>
                    </ul>
                </li>
                @if (stristr(Request::path(),"payments"))
                <li class="active">
                @else
                <li class="">
                @endif
                <a href="/admin/payments/transactions" class="dropdown-toggle">
                    <i class="menu-icon fa fa-calendar"></i>
                    <span class="menu-text"> Payments </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="/admin/payments/transactions?status=all" >
                            <i class="menu-icon fa fa-caret-right"></i>
                            Payment list
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="/admin/payments/pay-offline-bill">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Pay Offline Bill
                        </a>
                    </li>
                    <li class="">
                        <a href="/admin/payments/cheque">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Cheque List 
                        </a>
                    </li>
                    <li class="">
                        <a href="/admin/payments/card">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Card List
                        </a>
                    </ul>
                </li>
                    @if (stristr(Request::path(),"topup"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/topup/index" class="dropdown-toggle">
                            <i  class="menu-icon fa fa-list-alt"></i>
                            <span class="menu-text"> Topup </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                         <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                    <a href="/admin/topup/index">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        TopUp Details
                                    </a>
                                    <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                    @if (stristr(Request::path(),"planchange"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/planchange/index" class="dropdown-toggle">
                            <i class="menu-icon fa fa-desktop"></i>
                            <span class="menu-text"> Plan Change </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                    <a href="/admin/planchange/index">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Plan Change Details
                                    </a>
                                    <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                    @if (stristr(Request::path(),"session"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/session/index" class="dropdown-toggle">
                            <i class="menu-icon fa fa-calendar"></i>
                            <span class="menu-text">Session </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="/admin/session/index">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Active Session 
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/session/history_index">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Session History
                                </a>
                            </li>
                            <li class="">
                                <a href="/admin/session/session_logs">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Session Logs
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (stristr(Request::path(),"usages"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/usages/index" class="dropdown-toggle">
                            <i class="menu-icon fa fa-picture-o"></i>
                            <span class="menu-text"> Usages </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="/admin/usages/index">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Data Usages
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                    @if (stristr(Request::path(),"server"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/network/server-status" class="dropdown-toggle">
                            <i  class="menu-icon fa fa-list-alt"></i>
                            <span class="menu-text">Neworks</span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                         <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                    <a href="/admin/network/server-status">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Network Details
                                    </a>
                                    <b class="arrow"></b>
                            </li>
                            <li class="">
                                    <a href="/admin/network/otdr">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Otdr Details
                                    </a>
                                    <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/employees/team">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Employees Team
                                </a>
                            </li>
                            <li class="">
                                    <a href="/admin/network/session_area">
                                        <i class="menu-icon fa fa-caret-right"></i>
                                        Sessions Area Wise
                                    </a>
                                    <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                    @if (stristr(Request::path(),"switch") || stristr(Request::path(),"stock"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/switch-router/index" class="dropdown-toggle">
                            <i class="menu-icon fa fa-picture-o"></i>
                            <span class="menu-text">Stocks</span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <!-- <li class="">
                                <a href="/admin/switch-router/index">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Switchs Routers
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/switch_router-tag/index">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Switchs Routers Tag
                                </a>
                                <b class="arrow"></b>
                            </li> -->
                            <li class="">
                                <a href="/admin/switch_router/showcategory">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Stock Category
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/switch_router/stock_in">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Stock Incomming
                                </a>
                                <b class="arrow"></b>
                            </li><li class="">
                                <a href="/admin/switch_router/stock_out">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Stock Outgoing
                                </a>
                                <b class="arrow"></b>
                            </li><li class="">
                                <a href="/admin/switch_router/stock_update">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Stock Update
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/switch_router/update_stock_det">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Stock Update Details
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/stock_report/category_report">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Stock Reports
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                    @if (stristr(Request::path(),"checks"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/checks/billpaymentchecks" class="dropdown-toggle">
                            <i class="menu-icon fa fa-calendar"></i>
                            <span class="menu-text">Checks</span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="/admin/checks/billpaymentchecks">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Bill Paymets checks
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/checks/billchecks">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Bill checks
                                </a>
                            </li>
                            <li class="">
                                <a href="/admin/checks/paymentchecks">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Payment checks
                                </a>
                            </li>
                            <li class="">
                                <a href="/admin/checks/not_paid_active">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Not Paid Activations
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- @if (stristr(Request::path(),"sms"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/sms/getsendsms" class="dropdown-toggle">
                            <i class="menu-icon fa fa-pencil-square-o"></i>
                            <span class="menu-text"> Send Notificaton </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="/admin/sms/getsendsms">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    send sms
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li> -->
                    @if (stristr(Request::path(),"reports"))
                    <li class="active">
                    @else
                    <li class="">
                    @endif
                        <a href="/admin/reports" class="dropdown-toggle">
                            <i class="menu-icon fa fa-picture-o"></i>
                            <span class="menu-text"> Reports </span>
                            <b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="/admin/reports">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Reports Map
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/reports/employee_work">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Employee Work Details
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/reports/ticket_details">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Employee Ticket Details
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="/admin/reports/send_reports">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Send Reports Details
                                </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                    
                                <a href="/admin/reports/account_report_details">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Account Details
                                </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                </ul>
        <script type="text/javascript">
                    $(function () {
                            setNavigation();
                        });

                        function setNavigation() {
                            var path = window.location.pathname;
                            path = path.replace(/\/$/, "");
                            path = decodeURIComponent(path);
                            //path.substring(0, href.length)
                                $(".nav a").each(function () {
                                var href = $(this).attr('href');
                                @if(Auth::employee()->get()->roles())
                                @foreach(Auth::employee()->get()->roles() as $role)
                                if ("/{{$role->name}}" === href) {
                                    $(this).closest('li').addClass( "hide" );
                                }
                                @endforeach
                                @endif
                            });
                        }
        </script>
        <!-- /.nav-list -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
        <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
    </div>



              

              

          

          

             
        
        

             

          

          

