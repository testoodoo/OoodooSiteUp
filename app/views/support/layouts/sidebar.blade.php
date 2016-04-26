<div id="wrapper">
    <!--BEGIN SIDEBAR MENU-->

    <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has <b>many navigation styles</b>" data-position="right" class="navbar-default navbar-static-side" style="width: 10%;">
    <div class="sidebar-collapse menu-scroll" style="height: auto;">
        <ul id="side-menu" class="nav">
            
             <div class="clearfix"></div>
			<li><a href="/userDet"><i class="fa icon-lock fa-fw">
                <div class="icon-bg bg-pink"></div>
            </i><span class="menu-title">User Info</span></a>
               
            </li>
            <li><a href="/mailSupport"><i class="fa fa-envelope-o">
                <div class="icon-bg bg-primary"></div>
            </i><span class="menu-title">Ticket</span></a>
              
            </li>
            <li><a href="/callDet"><i class="fa fa-phone">
                <div class="icon-bg bg-primary"></div>
            </i><span class="menu-title">Call Log</span></a>
              
            </li>            
        </ul>
    </div>
</nav>

<!-- Sidebar menu end -->

<!-- breadcrumb start -->

<div id="page-wrapper">
@yield('main')
<!-- breadcrumb end -->
<div id="footer">
    <div class="copyright">
        <a href="#" style="float: bottom;">© OODOO Fiber Support {{Date('Y')}}</a>
    </div>
</div>
</div>


