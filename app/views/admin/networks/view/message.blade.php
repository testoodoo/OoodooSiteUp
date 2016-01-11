
<div class="header blue">
	<h3>Message History</h3>
</div>
		{{ Form::open( array('route' => array('messages.store'),'method' => 'POST','class' => 'form-horizontal message-validate-form')  ) }}
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
			<div class="form-group">
				Message:
				<textarea class="required" name="message" cols="50" rows="10" id="message" style="width: 100%; overflow: hidden; word-wrap: break-word; resize: horizontal; height: 100px;" required></textarea>
			</div>
	<div class="row">
			<div class="col-xs-12 center">
				<div class="form-group">
					<input class="btn btn-info" type="submit" name="msg" value="save">
				</div>
			</div>
	</div>
{{ Form::close(); }}
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