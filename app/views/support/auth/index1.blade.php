
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Umega App - Login</title>
    @include('support.partials.css_assets1')
  </head>
  <body class="user-page">
    <h1 class="fw-600 mt-0 mb-20">OoDoO Support</h1>
    <form method="get" action="index.html" class="form-horizontal">
      <div class="form-group has-feedback">
        <div class="col-xs-12">
          <input type="text" aria-describedby="exampleInputEmail" placeholder="Employee ID" class="form-control rounded"><span aria-hidden="true" class="ti-user form-control-feedback"></span><span id="exampleInputEmail" class="sr-only">(default)</span>
        </div>
      </div>
      <div class="form-group has-feedback">
        <div class="col-xs-12">
          <input type="password" aria-describedby="exampleInputPassword" placeholder="Password" class="form-control rounded"><span aria-hidden="true" class="ti-key form-control-feedback"></span><span id="exampleInputPassword" class="sr-only">(default)</span>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12">
          <div class="checkbox-inline checkbox-custom pull-left">
            <input id="exampleCheckboxRemember" type="checkbox" value="remember">
            <label for="exampleCheckboxRemember">Remember me</label>
          </div>
          <div class="pull-right"><a href="javascript:;" class="inline-block form-control-static">Forgot a Passowrd?</a></div>
        </div>
      </div>
      <button type="submit" class="btn btn-lg btn-success btn-raised btn-block">Sign In</button>
    </form>
    <hr>
    <p class="text-muted">Sign In with your Facebook Or Twitter accounts</p>
    <div class="clearfix">
      <div class="pull-left">
        <button type="button" class="btn btn-raised btn-primary"><i class="ti-facebook mr-5"></i> Facebook</button>
      </div>
      <div class="pull-right">
        <button type="button" class="btn btn-raised btn-info"><i class="ti-twitter-alt mr-5"></i> Twitter</button>
      </div>
    </div>
    <hr>
    <div class="form-horizontal">
      <div class="clearfix">
        <div class="pull-left">
          <p class="form-control-static">Want new account?</p>
        </div>
        <div class="pull-right"><a href="register.html" class="btn btn-outline btn-default">Sign Up</a></div>
      </div>
    </div>
    <!-- jQuery-->
    <script type="text/javascript" src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap JavaScript-->
    <script type="text/javascript" src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>