<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OoDoO Support - Login</title>
    @include('support.partials.css_assets1')
  </head>
  <body class="user-page">
    <h1 class="fw-600 mt-0 mb-20">OoDoO</h1>
    <form method="POST" action="/login" class="form-horizontal">
      <div class="form-group has-feedback">
        <div class="col-xs-12">
          <input type="text" name="employee_id" aria-describedby="exampleInputEmail" placeholder="Email" class="form-control rounded" autocomplete="off"><span aria-hidden="true" class="ti-user form-control-feedback"></span><span id="exampleInputEmail" class="sr-only">(default)</span>
        </div>
      </div>
      <div class="form-group has-feedback">
        <div class="col-xs-12">
          <input type="password" name="password" aria-describedby="exampleInputPassword" placeholder="Password" class="form-control rounded"><span aria-hidden="true" class="ti-key form-control-feedback"></span><span id="exampleInputPassword" class="sr-only">(default)</span>
        </div>
      </div>
      <div class="form-group">
      </div>
      <button type="submit" class="btn btn-lg btn-success btn-raised btn-block">Sign In</button>
    </form>
    <hr>
        <div class="col-xs-12">
          <div class="pull-right"><a href="javascript:;" class="inline-block form-control-static">Forgot Passowrd?</a></div>
        </div>
    <hr>
    <div class="form-horizontal">
    @include('support.partials.js_assets1')
  </body>
</html>