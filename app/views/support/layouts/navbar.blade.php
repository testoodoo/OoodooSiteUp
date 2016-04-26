<div id="header-topbar-option-demo" class="page-header-topbar">
            <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
            <div class="navbar-header" style="width: 10%;">
                <a id="logo" class="navbar-brand">
                    <span class="fa fa-rocket"></span>
                    <span class="logo-text" style="display: none">Xperia</span>
                    <span class="logo-text-icon">
                        <img src="/assets/dist/support/images/logo.png" alt="xperia" class="img-responsive">
                        </span>
                    </a>
            </div>            
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
            
                <ul class="nav navbar navbar-top-links navbar-right mbn">
                    <li class="dropdown"  title="New Tickets"><a data-hover="dropdown" class="dropdown-toggle"><i class="fa fa-envelope fa-fw"></i><span class="badge badge-green" id="new_ticket"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a  href="/mailSupport"><i class="fa fa-envelope fa-fw"></i>Total Ticket<span id="total_ticket" class="badge badge-success"></span></a></li>
                        </ul>                        
                    </li>&nbsp;&nbsp;                
                    <li class="dropdown" title="Active Users"><a data-hover="dropdown" class="dropdown-toggle"><i class="fa fa-bar-chart-o fa-fw"></i><span class="badge badge-green active_session"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="#"><i class="fa fa-bar-chart-o"></i>Active Users</a></li>
                        </ul>                        
                    </li>&nbsp;&nbsp;
                    <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-phone fa-fw"></i><span class="badge badge-orange exo_call"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="#"><i class="fa fa-phone"></i>Call Status</a></li>                        
                        </ul>
                    </li>&nbsp;&nbsp;
                    <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i class="fa fa-tasks fa-fw"></i><span class="badge badge-yellow network_status"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right network_area"></ul>
                    </li>
                    <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="/assets/dist/support/images/avatar/48.jpg" alt="" class="img-responsive img-circle">&nbsp;<span class="hidden-xs">{{ Auth::employee()->get()->name }}</span>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            <li><a href="/logout"><i class="fa fa-key"></i>Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        </div>
