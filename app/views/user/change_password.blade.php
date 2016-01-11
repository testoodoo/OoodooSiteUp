@extends ('user._layouts.default')
@section('main')
    <div class="row">
        @include('user.profile_sidebar')
        <aside class="profile-info col-lg-9">
            <section class="panel">
                <div class="bio-graph-heading">
                    <h3>Change Your OODOO Account password</h3>
                </div>
                <div class="panel-body bio-graph-info">
                    <h1> Change Password </h1>
                    {{ Form::model($user, array('route' => array('users.update'), 'method' => 'POST', 'class' => 'form-horizontal validate-form','id' => 'password_change')) }}                    
                        @include('user.change_password_form')      
                    {{ Form::close() }}
                  </div>
              </section>
            </aside>
      </div>

      <script type="text/javascript">
        $( "#password_change" ).validate({
            rules: {
                password: "required",
                password_confirmation: {
                equalTo: "#new_password"
                }
            }
        });
    </script>
@stop
