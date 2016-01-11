<div class="header blue">
	<h3>Status History</h3>
</div>
<div class="row">
	{{ Form::open( array('route' => array('status.store'),
		 'method' => 'POST','class' => 'form-horizontal status-validate-form')  ) }}
		{{ Form::hidden('object_type','incident') }}
		{{ Form::hidden('object_id[]',$ticket->id) }}
			<div class="form-group">
            <label class="col-sm-3 control-label">Map Incidents</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="object_id[]" class="select2 required"
                             data-placeholder="Map Incidents" multiple="">
                                <option value=""></option>
                             @foreach($incident as $inc)
                                <option value="{{$inc->id}}">{{$inc->name}} ({{$inc->location}}) </option>
                            @endforeach
                    </select>
                </div>
            </div>
		<div class="col-xs-8">
			<div class="form-group">
				<select name="status_id" class="required" style="width:100%" required>
					<option value="">Select Status</option>
					@foreach($status_list as $list)
						<option value="{{ $list->id }}">{{ $list->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn btn-info center" type="submit" value="Update Status">
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