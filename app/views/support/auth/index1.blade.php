@extends('support.layouts.login_default')
@section('main')
  <body style="background-image: url(../build/images/backgrounds/16.jpg)" class="body-bg-full">
    <div class="container page-container">
      <div class="page-content">
        <div class="logo"><i class="ti-underline"></i></div>
        <form method="POST" action="/login" class="form-horizontal">
          <div class="form-group">
            <div class="col-xs-12">
              <input type="text" name="employee_id" placeholder="Employee ID" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input type="password" name="password" placeholder="Password" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <div class="checkbox-inline checkbox-custom pull-left">
                <input id="exampleCheckboxRemember" type="checkbox" value="remember">
                <label for="exampleCheckboxRemember" class="checkbox-muted text-muted">Remember me</label>
              </div>
              <div class="pull-right"><a href="forgot.html" class="inline-block form-control-static">Forgot a Passowrd?</a></div>
            </div>
          </div>
          <button type="submit" class="btn-lg btn btn-primary btn-rounded btn-block">Sign in</button>
        </form>
        <hr>
      </div>
    </div>
  </body>
  @stop