<html lang="en">
<head>
    <title>Login | Support</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    @extends('support.partials.css_assets')
</head>
<body style="background: linear-gradient(to bottom, #e0e3ed 50%, #414C71 50%);">
    <div class="page-form">
        <div class="panel panel-blue">
            <div class="panel-body pan">
                <form action="/login" method="POST" class="form-horizontal">
                <div class="form-body login-padding">
                    <div class="col-md-12 text-center">
                        <h1 style="margin-top: -100px; font-size:42px; text-transform:uppercase; letter-spacing:-1px; color:#000; font-weight:bold">
                           <a href="/login" style="color:#000;"><i style="color:red;">OODOO</i> Support</a></h1>
                        <br />
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">
                            <img src="assets/dist/support/images/oodoo.ico" class="img-responsive">
                        </div>
                        <div class="col-md-9">
                            <h2>Login</h2>
                                  <p>
                                Please enter your Employee Id and password</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName" class="col-md-3 control-label">
                            Username:</label>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <i class="fa fa-user"></i>
                                <input name="employee_id" id="inputName" type="text" placeholder="Employee ID" class="form-control" /></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-md-3 control-label">
                            Password:</label>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <i class="fa fa-lock"></i>
                                <input name="password" id="inputPassword" type="password" placeholder="Password" class="form-control" /></div>
                        </div>
                    </div>
                    <div class="form-group mbn">
                        <div class="col-lg-12">
                            <div class="form-group mbn">
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-9">
                                @if (Session::has('message'))
                                    <div style="color: red;">{{ Session::get('message') }}</div>
                                @endif
                                </div>
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-3 text-right pal">
                                    <button type="submit" name="Sign In" class="btn btn-default sign-btn">Sign In</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <p>
            <a href="/forgetPass" style="color: #e0e3ed">Forgot password ?</a></p>
        </div>
    </div>
</body>
</html>