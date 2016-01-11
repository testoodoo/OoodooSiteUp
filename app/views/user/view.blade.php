@extends ('user._layouts.default')
@section('main')
    <div class="row">
        @include('user.profile_sidebar')
        <aside class="profile-info col-lg-9">
            <section class="panel">
                <div class="panel-header">
                    <b>Profile</b>
                </div>
                <div class="panel-body bio-graph-info">
                    <h1>Bio Graph</h1>
                    <div class="row">
                        <div class="bio-row">
                          	<p><span>First Name </span>: {{$user->first_name}}</p>
                      	</div>
                      	<div class="bio-row">
                          	<p><span>Last Name </span>: {{$user->last_name}}</p>
                      	</div>
                      	<div class="bio-row">
                          	<p><span>Email </span>: {{$user->email}}</p>
                      	</div>
                      	<div class="bio-row">
                          	<p><span>Account ID </span>: {{$user->account_id}}</p>
                      	</div>
                      	<div class="bio-row">
                          	<p><span>Mobile </span>: {{$user->mobile}}</p>
                      	</div>
                      	<div class="bio-row">
                          	<p><span>DOB </span>: {{$user->dob}}</p>
                      	</div>
                      	<div class="bio-row">
                          	<p><span>Address </span>: {{$user->address}} </p>
                      	</div>
                        <div class="bio-row">
                            <p><span>City </span>: {{$user->city}} </p>
                        </div>
                        <div class="bio-row">
                            <p><span>State </span>: {{$user->state}} </p>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
    </div>
@stop