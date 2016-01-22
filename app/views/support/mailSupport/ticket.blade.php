@extends('support.layouts.default')
@section('main')
<div class="page-content">
	<div class="col-lg-9">
	    <div class="panel panel-blue" style="background:#FFF;">
	        <div class="panel-heading">Mail Support</div>
	        <div class="panel-body">
	        <h3>{{$subject}}</h3>
			@foreach($mails as $mail)
				<table class="table table-hover table-bordered">
				    <thead>
				        <tr>
				            <th>
				            <div class="pull-right">
				            {{$mail->time}} </th>
				            </div>
				        </tr>
				    </thead>
				</table>
	        @endforeach
	        </div>
	    </div>
	</div>
</div>

@stop