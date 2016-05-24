@extends('support.layouts.login_default')
@section('main')
  <body class="user-page">
    <h3 class="fw-600 mt-0 mb-20">Forgot Password</h3>
    <form method="post" action="/request-forget-password" class="form-horizontal">
      <p class="text-muted">Enter the email address associated with your account to reset your password</p>
      <div class="form-group has-feedback">
        <div class="col-xs-12">
          <input type="text" name="email" aria-describedby="exampleInputEmail" placeholder="Email" class="form-control rounded"><span aria-hidden="true" class="ti-user form-control-feedback"></span><span id="exampleInputEmail" class="sr-only">(default)</span>
        </div>
      </div>
      <button type="submit" class="btn btn-success btn-raised btn-block">Reset password</button>
    </form>
  </body>
@stop