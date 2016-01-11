@extends ('user._layouts.login')
@section('main')
	<div class="container">
      	{{ Form::open( array( 'route' => array('users.resetPassword'), 'method' => 'POST','class' => 'form-signin validate-form-reset-password')  ) }}
      		{{ Form::hidden('user_id',$user->id) }}
	        <h2 class="form-signin-heading">Reset Password</h2>
	        <div class="login-wrap">
	            <p>Enter the Password</p>
	            <input type="password" class="form-control" placeholder="New Password" name="password" autofocus="" id="password">
	            <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" autofocus="">
	            <button class="btn btn-lg btn-login btn-block" type="submit">Submit</button>
	        </div>
      	{{ Form::close() }}
    </div>

    <script>
    	$(document).ready(function(){
    		$('form.validate-form-reset-password').validate({
    			rules: {
               		"password": { 
                 		required: true
               		} , 
                   	"password_confirmation": { 
                    	equalTo: "#password"
               		}
               	}
    		});	
    	});
    </script>
@stop