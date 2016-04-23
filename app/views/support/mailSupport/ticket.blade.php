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
                            <input type="hidden" id="threadId" value="{{$mail->thread_id}}">
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
                                        <span class="chat-body">{{$mail->body}}</span>
                                    </div>
                                @endforeach
                                <br><div id="chatBox"></div>
                                </li>
                                <li class="out" id="replyHide"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
                                <div class="message" id="replyJump">
                                <span class="chat-arrow"></span>
                                <div class="col-lg-4">

                                            <button type="button" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true" class="btn btn-primary dropdown-toggle"><i class="fa fa-angle-down"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Billing Complaint
                                                    </a></li>
                                                <li><a href="#">Technical Complaint
                                                    </a></li>
                                            </ul>

                                </div>
	                                <a href="#replyJump" id="replyMessage" class="jumper">
	                                	<span class="btn btn-blue">Reply</span>
	                                </a>&nbsp;&nbsp;&nbsp;&nbsp;
	                                <a href="#replyJump" class="jumper">
	                                	<span class="btn btn-blue">Forward</span>
	                                </a>&nbsp;&nbsp;&nbsp;&nbsp;
	                                <a href="#replyJump" id="replyNote" class="jumper">
	                                	<span class="btn btn-blue">Add Note</span>
	                                </a>
                                </div>
                                </li>
                                <li class="out" id="replyContent"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
	                                <div class="message" id="replyJump">
		                                <span class="chat-arrow"></span>
		                                <textarea style="height: 7cm;" class="form-control textarea"></textarea><br>
		                                <span id="cancelMessage" class="btn btn-orange">Cancel</span>&nbsp;&nbsp;&nbsp;&nbsp;
		                                <span id="reply" class="btn btn-blue">Reply</span>
	                                </div>
                                </li>
                                <li class="out" id="noteContent"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
	                                <div class="message" id="replyJump">
		                                <span class="chat-arrow"></span>
		                                <textarea style="height: 7cm;" class="form-control notetext"></textarea><br>
		                                <span id="cancelNote" class="btn btn-orange">Cancel</span>&nbsp;&nbsp;&nbsp;&nbsp;
		                                <span id="note" class="btn btn-blue">Add Note</span>
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
<script type="text/javascript">
jQuery(document).ready(function() {
    $('#complaint_type').change(function() {
        
    });
});
</script>

@stop