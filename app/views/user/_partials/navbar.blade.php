<aside>
  <div id="sidebar" class="nav-collapse " tabindex="5000" style="overflow: hidden; outline: none;">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu" id="nav-accordion">
          <li>
                @if (Request::path() == "/")
                    <a class="active" href="/">
                @else
                    <a href="/">
                @endif
                
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
              </a>
          </li>
          <li>
                @if (stristr(Request::path(),"bills"))
                    <a class="active" href="/bills">
                @else
                    <a href="/bills">
                @endif
                  <i class="fa fa-book"></i>
                  <span>Bills</span>
              </a>
          </li>

          <li>
                @if (Request::path() == "payment")
                    <a class="active" href="/payment">
                @else
                    <a href="/payment">
                @endif
                  <i class="fa fa-credit-card"></i>
                  <span>Payments</span>
              </a>
          </li>          
           
          <li>

          <li class="sub-menu dcjq-parent-li">
                @if (Request::path() == "data_usage" || Request::path() == "session_usage")
                <a href="javascript:;" class="dcjq-parent active">
                @else
                <a href="javascript:;" class="dcjq-parent">
                @endif
                    <i class="fa fa-download"></i>
                    <span>Usage</span>
                </a>
                       
                <ul class="sub" style="display: block;">
                    <li><a href="/data_usage">Data Usage</a></li>
                    <li><a href="/session_usage">Session Usage</a></li>
                 </ul>

          </li>
         <!--  <li>
                  @if (Request::path() == "plan_change")
                      <a class="active" href="/plan_change">
                  @else
                      <a href="/plan_change">
                  @endif
                    <i class="fa fa-random"></i>
                    <span>Plan Change</span>
                </a>
          </li> -->
          <li>
                  @if (Request::path() == "topup")
                      <a class="active" href="/topup">
                  @else
                      <a href="/topup">
                  @endif
                    <i class="fa fa-gift"></i>
                    <span>Topup</span>
                </a>
            </li>

           <li class="sub-menu dcjq-parent-li">
                <a href="javascript:;" class="dcjq-parent">
                    <i class="fa fa-download"></i>
                    <span>Support</span>
                </a>
                       
                   <ul class="sub" style="display: block;">
                    <li><a href="/support">Support</a></li>
                    <!-- <li><a href="/complaint">Compliant</a></li>  -->
                 </ul>

          </li>
            <!-- <li>
                  @if (Request::path() == "faq")
                      <a class="active" href="/faq">
                  @else
                      <a href="/faq">
                  @endif
                    <i class="fa fa fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
            </li -->
      </ul>
      <!-- sidebar menu end-->
  </div>
</aside>
