<header class="header white-bg">
      <div class="sidebar-toggle-box">
          <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
    <!--logo start-->
    <a href="/" class="logo">OODOO&nbsp;<span>FIBER</span></a>
    <!--logo end-->
    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    
                    @if (Auth::user()->get()->gender == "m")
                        <img src="/assets/dist/user/img/default_male.jpg" alt="" width="25">
                    @else
                        <img src="/assets/dist/user/img/default_female.jpg" alt="" width="25">
                    @endif
                    <span class="username">{{Auth::user()->get()->first_name}}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="/profile"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="/users/edit"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                    <li><a href="/user/logout"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <li class="sb-toggle-right">
                <i class="fa  fa-align-right"></i>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>
