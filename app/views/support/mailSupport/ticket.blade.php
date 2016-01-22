@extends('support.layouts.default')
@section('main')
<div class="page-content">
	<div class="row">
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
						            <span class="pull-right" onLoad="time_elapsed_string({{$mail->time}});">
						            {{$mail->time}}
						            </span> </th>
					            <tr>
					            	<th> {{$mail->body}} </th>
					            </tr>
						        </tr>
						    </thead>
						</table>
			        @endforeach
			        <div class="pull-right">
			        <button class="btn btn-blue"> Forward </button> &nbsp; &nbsp;
			        <button class="btn btn-blue" onclick="sendmail();"> Reply </button>			        
			        </div>
			        <div class="mbxl"></div>
			        <div id="replyMessage"  style="display:none;">
						<table class="table table-hover table-bordered">
						    <thead>
						        <tr>
						            <th>
						            	<span>To : {{$mail->from_mail}}</span>
						            </th>
					            <tr>
					            	<th>
					            		<textarea class="form-control" name="replayMessage"> </textarea>
					            	</th>
					            </tr>
						        </tr>
						    </thead>
						</table>
						<button class="btn btn-blue pull-right" onclick="mailio();"> Send </button>
					</div>
		        </div>
		    </div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
			<div class="panel panel-blue" style="background:#FFF;">
				<div class ="panel-heading"> Ticket Status </div>
				<div class="panel-body">
					hello
				</div>
			</div>
			</div>
			<div class="form-group">
			<div class="panel panel-blue" style="background:#FFF;">
				<div class ="panel-heading"> Remarks </div>
					<div>
					    <div class="mbxl"></div>
					    <ul class="list-group">
					    @if($messages)
					    @foreach($messages as $message)
					        <li class="list-group-item list-group-item-info">{{$message->message}}</li>
					    @endforeach
					    @endif
					    </ul>
					</div>

				<form action="/mailSupport/ticket/{{$mail->id}}" method="post">
					<div class="panel-body">
						<textarea name="remark" class="form-control"></textarea><hr>
						<button class="btn btn-blue pull-right"> Submit </button>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>

<script>
function sendmail(){
             jQuery('#replyMessage').toggle('hide');	
}
function mailio(){
	alert('thread_id group');
}
</script>
@stop