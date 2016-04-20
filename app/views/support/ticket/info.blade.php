<div class="header blue">
	<h3>Ticket Information</h3>
</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<tbody>
		<tr>
			<th>Ticket No</th>
			<td>{{$ticket->ticket_no}}</td>
		</tr>
		<tr>
			<th>Ticket Type</th>
			<td>{{$ticket->ticket_type()}}</td>
		</tr>
		<tr>
			<th>Requirement</th>
			<td>{{$ticket->requirement}}</td>
		</tr>
		@if($ticket->account_id)
			<tr>
				<th>Account ID</th>
				<td>{{$ticket->account_id}}</td>
			</tr>
		@else
			<tr>
				<th>Crf No</th>
				<td>{{$ticket->crf_no}}</td>
			</tr>
		@endif
		<tr>
			<th>Name</th>
			<td>{{$ticket->name}}</td>
		</tr>
		<tr>
			<th>Mobile</th>
			<td>{{$ticket->mobile}}</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>{{$ticket->email}}</td>
		</tr>
		<tr>
			<th>Address</th>
			<td>{{$ticket->address}}</td>
		</tr>
		<tr>
			<th>Status</th>
			@if(!is_null($ticket->status()))
				<td>{{$ticket->status()->name}}</td>
			@else
				<td>Status Not Found</td>
			@endif
		</tr>
	</tbody>
</table>
