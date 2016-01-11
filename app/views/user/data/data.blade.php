<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keyword" content="OODOO Fiber, pay OODOO Fiber, Pay BIll, payment, Bill Payment">
    <link rel="shortcut icon" href="img/favicon.png">


    <title>Data | OODOO Fiber</title>

    {{ HTML::style('/assets/dist/user/css/bootstrap.min.css') }}
    {{ HTML::style('/assets/dist/user/css/bootstrap-reset.css') }}
    {{ HTML::style('/assets/dist/user/css/font-awesome.css') }}
    {{ HTML::style('/assets/dist/user/css/owl.carousel.css') }}
    {{ HTML::style('/assets/dist/user/css/slidebars.css') }}
    {{ HTML::style('/assets/dist/user/css/style.css') }}
    {{ HTML::style('/assets/dist/user/css/style-responsive.css') }}
    {{ HTML::style('/assets/dist/user/css/payment-process.css')}}


    {{ HTML::script('/assets/dist/user/js/jquery.js') }}
    {{ HTML::script('/assets/dist/user/js/bootstrap.min.js') }}
    {{ HTML::script('/assets/dist/user/js/jquery.validate.js') }}
    {{ HTML::script('/assets/dist/user/js/jquery.dcjaccordion.js') }}
    {{ HTML::script('/assets/dist/user/js/jquery.scrollTo.js') }}
    {{ HTML::script('/assets/dist/user/js/jquery.nicescroll.js') }}
    {{ HTML::script('/assets/dist/user/js/sparkline.js') }}
    {{ HTML::script('/assets/dist/user/js/count.js') }}
    {{ HTML::script('/assets/dist/user/js/oodoo.js') }}

<style type = "text/css">
#content {
  width: 100% ;
  margin-left: 25% ;
}
</style>

<header class="header white-bg">
      <div class="sidebar-toggle-box">
          <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
    <a href="/" class="logo">OODOO&nbsp;<span>FIBER</span></a>
</header><br><br><br>




@if($use != NULL)
    <div class="alert alert-success alert-block fade in">
          <p><h3><i class="fa fa-home"></i>
           Data Summary
          </h3></p>
    </div>
<div id = "content">
    <div class="row state-overview">
              <div class="col-lg-3 col-sm-6">
                  <section class="panel">
                     <div class="symbol blue">
                        <i class="fa fa-user" ></i>
                    </div>
                    <div class="value">
                        <h4 class="count">{{$usage->account_id}}</h4>
                        <p><b>User ID</b></p>
                    </div>
                   </section>
              </div>
              <div class="col-lg-3 col-sm-6">
                  <section class="panel">
                     <div class="symbol blue">
                        <i class="fa fa-bar-chart-o" ></i>
                    </div>
                    <div class="value">
                        <h4 class="count">{{$use}} MB</h4>
                        <p><b>Usage</b></p>
                    </div>
                   </section>
              </div>
    </div>

    <div class="row state-overview">

              <div class="col-lg-3 col-sm-6">
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
              <div class="col-lg-3 col-sm-6">
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
</div>
@else
    
    <section class="main-info info">
        <p style="color:brown"> You're not connected with <span style="font-family:italic"> OODOO </span> communications </p>
    </section>

@endif
</html>