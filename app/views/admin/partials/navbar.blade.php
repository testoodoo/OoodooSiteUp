 {{ HTML::script('/assets/dist/admin/js/jquery.min.js') }}
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>
    <div class="navbar-container profile" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="javascript:void(0);" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    OoDoo Admin
                </small>
            </a>
        </div>
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="grey">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                  <i class="fa fa-bar-chart-o fa-2x blue"></i>
                    <span class="badge badge-grey active_session">0</span>
                  </a>

                 <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                <li class="dropdown-header">
                  <i class="icon-ok"></i>
                  Active Sessions
                </li>

                <li>
                    <div class="clearfix">
                      <span class="pull-left">Active Session</span>
                      <span class="pull-right active_session"></span>
                    </div>
                </li>

              </ul>
                
                </li>

                <li class="purple">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                    <i class="fa fa-laptop fa-2x blue"></i>
                    <span class="badge badge-important network_status">0</span>
                  </a>
                  <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                    <li class="dropdown-header">
                      <i class="icon-warning-sign"></i>
                      <span class=""> Network Status </span>
                    </li>
                    <li class="network_area">
                    </li>
                  </ul>
                </li>

                <li class="green">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                    <i class="fa fa-phone fa-2x blue"></i>
                    <span class="badge badge-success exo_call">0</span>
                  </a>
                  <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                    <li class="dropdown-header">
                      <i class="icon-envelope-alt"></i>
                      Call Status
                    </li>
                    <li>
                        <span class="msg-body">
                          <span class="msg-title">
                            <span class="blue call_status">Status</span>
                          </span>
                        </span>
                    </li>
                  </ul>
                </li>

                <li class="light-blue">
                    <a data-toggle="dropdown"  class="dropdown-toggle" href="javascript:void(0);">
                    <img class="nav-user-photo" src="/assets/dist/admin/avatars/user.jpg" alt="Jason's Photo">
                        <span class="user-info">
                            <small>Welcome</small>
                           {{ Auth::employee()->get()->name }}
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="/admin/employees/edit/{{Auth::employee()->get()->id}}">
                                <i class="ace-icon fa fa-cog"></i>
                                Edit Profile
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="admin-logout" href="/admin/logout">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <button class="aside-trigger btn btn-primary pro" data-target="#right-menu" data-toggle="modal" onclick="profile()" value="0" type="button">
                      <i data-icon1="fa-plus" data-icon2="fa-minus" class="fa fa-tasks"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.navbar-container -->
</div>


<script type="text/javascript">
    jQuery(document).ready(function() {

    function Refersh(){
        $.ajax({
            url : '/admin/navbar/nav',
            type : 'GET',
            success : function(data){
                $('.active_session').text(data['active_session']);
                var network=data['server_1'] + data['server_0'];
                $('.network_status').text(data['server_0']+'/'+network);
                $(".network_area").empty();
                $.each(data['network'], function(i,j){
                  $(".network_area").append('<div class="clearfix"><span class="pull-left"><i class="btn btn-xs no-hover btn-pink icon-comment"></i> '+j['location']+'</span></div>');
                });
                if(data['exo_call']==0){
                   $('.call_status').text('CALL STATUS DOWN');
                   $('.exo_call').text('DOWN');  
                }else{
                   $('.call_status').text('CALL STATUS UP');
                   $('.exo_call').text('UP');  
                }
            }
        });
    }

    Refersh();
    
        setInterval( function () {
                Refersh()
                    }, 15000 );
    });
function profile(){
    var pro=$('.pro').val();
    if(pro==0){
      $('.profile').addClass('container');
      $('.pro').val(1);
    }else{
      $('.profile').removeClass('container');
      $('.pro').val(0);
    }
 }
</script>