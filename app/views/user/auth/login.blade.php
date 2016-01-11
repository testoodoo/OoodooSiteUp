@extends ('user._layouts.login')
@section('main')
<div class="container">
	{{ Form::open( array( 'route' => array('user.login'), 'files' => true, 'method' => 'POST','class' => 'form-signin validate-form', 'role' => 'form')  ) }}
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">
        	{{ Form::text('account_id',Input::old('account_id'),['class' => 'form-control','placeholder'=>'Your Account ID']) }}
            {{ Form::password('password',['class' => 'form-control','placeholder'=>'Your Password']) }}
            <label class="checkbox">
                <!-- <input type="checkbox" value="remember-me"> Remember me -->
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

            <div class="space"></div>
            @include('user._partials.messages')
            <div class="space-4"></div>
        </div>
        {{ Form::close() }}

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            {{ Form::open( array( 'route' => array('users.forgotPasswordRequest'), 'method' => 'POST','class' => 'validate-form')  ) }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Forgot Password ?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Enter your Account ID below to reset your password.</p>
                            <input type="text" name="account_id" placeholder="Account ID" autocomplete="off" class="form-control placeholder-no-fix required">
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
        <!-- modal -->

    

    </div>
@stop