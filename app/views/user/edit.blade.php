@extends ('user._layouts.default')
@section('main')
    <div class="row">
        @include('user.profile_sidebar')
        <aside class="profile-info col-lg-9">
            <section class="panel">
                <div class="bio-graph-heading">
                    Edit Your Profile!!
                </div>
                <div class="panel-body bio-graph-info">
                    <h1> Profile Info</h1>
                    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'POST', 'class' => 'form-horizontal validate-form')) }}                    
                        @include('user.form')      
                    {{ Form::close() }}
                  </div>
              </section>
        </aside>
    </div>
@stop