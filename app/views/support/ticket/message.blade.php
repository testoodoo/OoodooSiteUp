
<div class="header blue">
	<h3>Message History</h3>
</div>
{{ Form::open( array('url' => '/ticket/message','method' => 'POST','class' => 'message-validate-form')  ) }}
		{{ Form::hidden('object_type','ticket') }}
		{{ Form::hidden('object_id',$ticket->id) }}
	<div class="form-group">
		Message:
		<textarea class="required" name="message" cols="50" rows="10" id="message" style="width: 100%; overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;" required></textarea>
	</div>
	<div class="row">
		<div class="col-xs-12">
				<input name="msg" type="radio" class="requiredsss title_radio" value="save" />Save Message
                <input name="msg" type="radio" class="requiredsss title_radio" value="update_support" />Update Support
                <input name="msg" type="radio" class="requiredsss title_radio" value="update_operation" />Update Operation
                <input name="msg" type="radio" class="requiredsss title_radio" value="update_customer" />Update Customer 
				<button class="btn btn-minier btn-primary" onclick="check()" type="submit">Save</button>
		</div>
	</div>
{{ Form::close(); }}
<div class="space-8"></div>
@if(count($ticket->message_history()) != 0)
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<th>Message</th>
				<th>Updated at</th>
				<th>Updated by</th>
			</tr>
			@foreach($ticket->message_history() as $history)
				<tr>
					<td>{{$history->message}}</td>
					<td>{{$history->created_at}}</td>
					<td>@if($history->assgined_to())
					{{$history->assgined_to()->name}}
					@else
					Not Found
					@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif
<div class="space-8"></div>
@if(count($ticket->alert_message()) != 0)
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<th>Updated at</th>
				<th>Message</th>
				<th>Alert Type</th>
				<th>Updated By</th>
			</tr>
			@foreach($ticket->alert_message() as $history)
				<tr>
					<td>{{$history->created_at}}</td>
					<td>{{$history->message}}</td>
					<td>
						@if($history->message_type=='update_operation')
							<span class="blue bolder">Update Operation</span>
						@elseif($history->message_type=='update_support')
							<span class="blue bolder">Update Support</span>
						@elseif($history->message_type=='update_customer')
							<span class="blue bolder">Update Customer</span>
						@endif
					</td>
					<td>@if($history->updatedBy())
							{{$history->updatedBy()->name}}
						@else
							Not Found
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif
<script type="text/javascript">
	function check(){
                $('form').submit(function() {
                $(this).find("button[type='submit']").prop('disabled',true);
                    });
            }
</script>