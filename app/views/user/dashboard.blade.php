@extends ('user._layouts.default')
@section('main')
  	@include('user.data_header_box')
    <section class="panel">
        <div class="bio-graph-heading">
            Profile
        </div>
        <div class="panel-body bio-graph-info">
            <h1>
                Bio Graph
            </h1>
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
                        <p><span>State </span>:@if($user->state=='TN')Tamil Nadu @endif </p>
                    </div>
                </div>
        </div>
    </section>
@stop