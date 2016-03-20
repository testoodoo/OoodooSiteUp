@extends('support.layouts.default')
@section('main')
<div class="page-content">
		@if (Session::has('message'))
			<div class="alert alert-success">{{ Session::get('message') }}</div>
		@endif
    <div id="tab-general" class="layout-block">
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet box">
                    <div class="portlet-header">
                        <div class="caption">{{$list->subject}}</div>
                    </div>
                    <div class="portlet-body">
                        <div class="chat-scroller">
                            <ul class="chats">
                            @foreach($mails as $mail)
                                @if($mail->label =='INBOX')
                                	<li class="in"><img src="/assets/dist/support/images/avatar/48.jpg" class="avatar img-responsive" />
                                @else
                                	<li class="out"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
					            	@if($mail->attachment)
								        @foreach(json_decode($mail->attachment) as $attachment)</br>
							        		<a href="//assets/dist/support/images/adminbills.csv" class="btn btn-green">
							        			<i class="fa fa-download"> 
							        				{{ $attachment->filename }} 
							        			</i>
							        		</a>
							        	@endforeach
							        @endif                                       
                                @endif
                                    <div class="message">
                                        <span class="chat-arrow"></span>
                                        <a href="#" class="chat-name">{{$mail->from_mail}}</a>&nbsp; at
                            			<span title="{{$mail->time}}" data-livestamp="{{$mail->time}}"></span>
<!--                                         <span
                                                            class="chat-datetime">at July 06, 2014 17:06</span> -->
                                        <span class="chat-body">{{$mail->body}}</span>
                                    </div>
                                @endforeach
                                </li>
                                <li class="out" id="replyHide"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
                                <div class="message" id="replyJump">
                                <span class="chat-arrow"></span>
	                                <a href="#replyJump" id="replyMessage" class="jumper">
	                                	<span class="btn btn-blue">Reply</span>
	                                </a>&nbsp;&nbsp;&nbsp;&nbsp;
	                                <a href="#replyJump" class="jumper">
	                                	<span class="btn btn-blue">Forward</span>
	                                </a>&nbsp;&nbsp;&nbsp;&nbsp;
	                                <a href="#replyJump" class="jumper">
	                                	<span class="btn btn-blue">Add Note</span>
	                                </a>
                                </div>
                                </li>
<li class="out chat-form" id="replyConten"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
    <div class="input-group message">
    <span class="chat-arrow"></span>
        <input id="input-chat" type="textarea" placeholder="Type a message here..." class="form-control">
            <span id="btn-chat" class="input-group-btn">
                
            </span>
        </div>
</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>













	<div class="page-content">
		@if (Session::has('message'))
			<div class="alert alert-success">{{ Session::get('message') }}</div>
		@endif
		<div class="row">
			<div class="col-lg-9">
			    <div class="panel panel-blue" style="background:#FFF;">
			        <div class="panel-heading">{{$list->subject}}</div>
			        <div class="panel-body">
						@foreach($mails as $mail)
						<div class="list-group mail-box">
				            	<span class="label label-info pull-left">check</span>
				            	<span class="label label-default pull-right" title="{{$mail->time}}" data-livestamp="{{$mail->time}}"></span>
				            <div class="well well-lg">
				            	{{$mail->body}}
				            	@if($mail->attachment)
							        @foreach(json_decode($mail->attachment) as $attachment)</br>
						        		<a href="/assets/dist/support/images/adminbills.csv" class="btn btn-green">
						        			<i class="fa fa-download"> 
						        				{{ $attachment->filename }} 
						        			</i>
						        		</a>
						        	@endforeach
						        @endif
				            </div>
						</div>
				        @endforeach
				        <div class="pull-right">
				        <button class="btn btn-blue"> Forward </button> &nbsp; &nbsp;
				        <button class="btn btn-blue" onclick="sendmail();"> Reply </button>			        
				        </div>
				        <div class="mbxl"></div>
				        <div id="replyMessage"  style="display:none;">
							<table class="table table-hover table-bordered">

							    <form action="/replyMessage/{{$list->thread_id}}" class="form-group" method="POST">
							    <thead>
							        <tr>
							            <th>
							            	To : <input class="form-control" name="to_mail" value="{{$list->from_mail}}" readonly>
							            </th>
						            <tr>
						            	<th>
						            		<textarea class="form-control" name="body" placeholder="Type your message here..."> </textarea>
						            	</th>
						            </tr>
							        </tr>
							    </thead>
							</table>
							<button class="btn btn-blue pull-right"> Send </button>
							    </form>
						</div>
			        </div>
			    </div>
			</div>
			<div class="col-lg-3">
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
$(document).ready(function() {
		$('#replyContent').hide();
	$("#replyMessage").click(function() {
		$('#replyHide, #replyContent').toggle();
	});
});
</script>
@stop