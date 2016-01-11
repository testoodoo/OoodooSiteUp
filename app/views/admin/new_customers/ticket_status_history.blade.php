<div class="row">
	<div class="col-xs-12">
		<div class="header blue">
			<h3>Ticket Info</h3>
		</div>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Ticket No.</th>
					<th>Remarks</th>
					<th>Ticket type</th>
					<th>Status</th>
					<th>Raised By</th>
					<th>Assigned To</th>
		            <th>View</th>		
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ $ticket->ticket_no }}</td>
					<td>{{ $ticket->requirement }}</td>
					 <td>@if(!is_null($ticket->ticket_type()))
                        {{$ticket->ticket_type()}}
                    @else
                        Ticket Type Not Found
                    @endif</td>
					<td>{{ $ticket->getOwnStatus->name }}</td>
					<td>{{ $ticket->assigned_by}}</td>
					<td>{{ $ticket->assigned_to}}</td>
					 <td>
					 <a href="/admin/ticket/assign_tickets/{{$ticket->id}}" class="btn btn-minier btn-yellow">assign</a> 
					 <button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                     view
                    </button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="header blue">
			<h3>Ticket Status</h3>
		</div>
		<div class="row">
			{{ Form::open( array('route' => array('status.store'),
				 'method' => 'POST','class' => 'ticket-status-validate-form')  ) }}
				{{ Form::hidden('object_type','ticket') }}
				{{ Form::hidden('object_id',$ticket->id) }}
				{{ Form::hidden('owner_type',Auth::employee()->get()->employee_identity) }}
				{{ Form::hidden('owner_id',Auth::employee()->get()->id) }}
				<div class="form-group">
	            	<label class="col-sm-3 control-label">Ticket Reason message</label>
            		<div class="col-sm-5" required>
                        {{Form::textarea('message','',array('class'=>'form-control','rows' => "5",'cols' => "10","required"))}}
                    </div>
                </div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Status</label>
					<select name="status_id" required>
						<option value="">Select Status</option>
						@foreach($ticket_status_list as $list)
							<option value="{{ $list->id }}">{{ $list->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="center">
					<div class="form-group">
						<input class="btn btn-info center" type="submit" value="Update Status">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Status</th>
			<th>Message</th>
			<th>Updated By</th>
		</tr>
	</thead>

	<tbody>
		@foreach($ticket->status_history() as $status)
			<tr>
				<td>{{ $status->id }}</td>
				<td>{{ $status->status->name }}</td>
				<td>{{ $status->message }}</td>
				<td>{{ $status->updated_by }}</td>
			</tr>
		@endforeach

	</tbody>
</table>