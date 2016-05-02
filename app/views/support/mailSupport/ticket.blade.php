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
                                    <div class="message"  style="background-color: #E5E4E2;">
                                        <span class="chat-arrow"></span>
                                        <a href="#" class="chat-name">{{$mail->from_mail}}</a>&nbsp; at
                                        <span title="{{$mail->time}}" data-livestamp="{{$mail->time}}"></span>
                                        <span class="chat-body">{{$mail->body}}</span>
                                    </div>                                    
                                @elseif($mail->label == 'NOTE')
                                    <li class="out"><img src="/assets/dist/support/images/avatar/note.jpg" class="avatar img-responsive" />
                                    <div class="message"  style="background-color: #E0FFFF;">
                                        <span class="chat-arrow"></span>
                                        <a href="#" class="chat-name">{{$mail->from_mail}}</a>&nbsp; at
                                        <span title="{{$mail->time}}" data-livestamp="{{$mail->time}}"></span>
                                        <span class="chat-body">{{$mail->body}}</span>
                                    </div> 
                                @elseif($mail->label == 'ASSIGN')
                                    <li class="out"><img src="/assets/dist/support/images/avatar/assign.png" class="avatar img-responsive" />
                                    <div class="message"  style="background-color: #F3E5AB;">
                                        <span class="chat-arrow"></span>
                                        <span class="chat-body">{{$mail->body}}</span> &nbsp; at &nbsp;
                                        <span title="{{$mail->time}}" data-livestamp="{{$mail->time}}"></span>
                                    </div>                                                                        
                                @else
                                	<li class="out"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
                                    <div class="message"  style="background-color: #E3E4FA;">
                                        <span class="chat-arrow"></span>
                                        <a href="#" class="chat-name">{{$mail->from_mail}}</a>&nbsp; at
                                        <span title="{{$mail->time}}" data-livestamp="{{$mail->time}}"></span>
                                        <span class="chat-body">{{$mail->body}}</span>
                                    </div>                                    
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
                                @endforeach
                                <br><div id="chatBox"></div>
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
                                    <a href="#replyJump" id="replyNote" class="jumper">
                                        <span class="btn btn-blue">Add Note</span>
                                    </a>
                                </div>
                                </li>
                                <li class="out" id="replyContent"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" />
                                    <div class="message" id="replyJump">
                                        <span class="chat-arrow"></span>
                                        <textarea style="height: 7cm;" class="form-control textarea"></textarea><br>
<div style="float: left;">
<input type="checkbox"> Test
</div>
<div class="col-lg-3">
<select class="form-control complaint_type">
<option value="">Select One</option>
@foreach($ticket_type as $ticket)
    @if($ticket->id == 2)
        <optgroup label="Complaint">
        @foreach($complaints as $complaint)
            <option value="{{$complaint->id}}">{{$complaint->name}}<option>
        @endforeach
        </optgroup>
    @endif

    @if($ticket->id != 2)
    <option value="{{$ticket->id}}">{{$ticket->name}} </option>
    @endif
@endforeach
</select>
</div>
<div class="col-lg-3" style="display :none;" id="team_type">
<select class="form-control" > 
<option value="">Select One</option>
@foreach($team_type as $team)
<option value="{{$team->id}}">{{$team->name}} </option>
@endforeach
</select>
</div>
<div class="col-lg-3" style="display :none;" id="emp_det">
<select class="form-control " id="emp_subs"> 
<option value="">Select One</option>


</select>
</div>
                                        <span id="cancelMessage" class="btn btn-orange">Cancel</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span id="reply" class="btn btn-blue" style="display: none;">Reply</span>
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

    $('.complaint_type, #team_type').change(function() {
        var optionVal = $('.complaint_type').val();
        //var team_type = $('#team_type').val();
        alert(optionVal);
        if(optionVal == 27){
            window.open('/query','_blank');
        }
        $('#reply').toggle(optionVal != "" && optionVal != 27);
        $('#team_type').toggle(optionVal == 1);
        $.ajax({
            url: '/setEmployee',
            type: 'GET',
            data: { ticket_type : optionVal},
            dataType: 'json',
            success: function( json ) {
                $("#emp_subs").empty();
                  $('#emp_subs').append(new Option('Select One',0));
               $.each(json, function(i, optionHtml){
                $('#emp_det').show();
                  $('#emp_subs').append(new Option(optionHtml,i));
               });
            }            
        });
    });
});
</script>

@stop