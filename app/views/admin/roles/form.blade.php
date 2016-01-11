<div class="form-group">
	{{ Form::label('name','Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('name', $role->name , array('class' => 'col-xs-10 col-sm-5 required')) }}
		<em>*</em>
	</div>
</div>
<div class="form-group">
	{{ Form::label('level','Level', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		<select name="level" class="required" style="width:333px;">
			<option value="">Select Level</option>
			@foreach($levels as $level)
				@if (($role->level == $level))
					<option value="{{$level}}" selected>{{$level}}</option>
				@else
					<option value="{{$level}}">{{$level}}</option>
				@endif
			@endforeach
		</select>
		<em>*</em>
	</div>
</div>
<div class="form-group">
	{{ Form::label('active','Active', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		@if( $role->active == 1)
			{{ Form::checkbox('active', $role->active, null, array('checked' => 'checked')) }}
		@else
			{{ Form::checkbox('active') }}
		@endif
	</div>
</div>