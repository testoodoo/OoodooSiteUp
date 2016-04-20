<div class="header blue">
	<h3>Status History</h3>
</div>
<div class="row">
	{{ Form::open( array('url' => '/ticket/status',
		 'method' => 'POST','class' => 'status-validate-form')  ) }}
		{{ Form::hidden('object_type','ticket') }}
		{{ Form::hidden('object_id',$ticket->id) }}
		<div class="col-xs-9">
			<div class="form-group">
				<select name="status_id" class="required" style="width:100%" required>
					<option value="">Select Status</option>
					@foreach($status_list as $list)
						<option value="{{ $list->id }}">{{ $list->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="form-group">
				<button class="btn btn-minier btn-primary center" type="submit" onclick="check()" value="Update Status">Update Status</button>
			</div>
		</div>
	{{ Form::close() }}
</div>
@if(count($ticket->status_history()) != 0)
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<th>Status</th>
				<th>Updated at</th>
				<th>Updated by</th>
			</tr>
			@foreach($ticket->status_history() as $history)
				<tr>
					<td>{{$history->status->name}}</td>
					<td>{{$history->created_at}}</td>
					<td>
						@if(!is_null($history->assgined_to()))
							{{ $history->assgined_to()->name }} #{{$history->assgined_to()->employee_identity}}
						@else
							Not Available
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