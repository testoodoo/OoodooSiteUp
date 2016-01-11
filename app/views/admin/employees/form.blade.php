<div class="form-group">
	{{ Form::label('name','Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('name', $employee->name, array('class' => 'col-xs-10 col-sm-5', 'required')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('email','Email', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('email', $employee->email, array('class' => 'col-xs-10 col-sm-5' ,'required')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('office email','Office Email', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('office_email', $employee->office_email, array('class' => 'col-xs-10 col-sm-5' ,'required')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('password','Password', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::password('password', array('class' => 'col-xs-10 col-sm-5', 'minlength' => 8, 'placeholder'=>'Password')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('password_confirmation','Confirm Password', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::password('password_confirmation', array('class' => 'col-xs-10 col-sm-5','placeholder'=>'Enter Password Again')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('role','Role', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		<select name="role_id" class="required" style="width:330px;">
			<option value="">Select Role</option>
			@foreach($roles as $role)
				@if($employee->role_id == $role->id)
					<option value="{{$role->id}}" selected>{{$role->name}}</option>
				@else
					<option value="{{$role->id}}">{{$role->name}}</option>
				@endif
			@endforeach
		</select>
	</div>
</div>
<div class="form-group">
	{{ Form::label('mobile','Mobile', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('mobile', $employee->mobile, array('class' => 'col-xs-10 col-sm-5 digits' ,'required','minlength' => 10,'maxlength' => 10)) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('office mobile','Office Mobile', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('office_mobile', $employee->office_mobile, array('class' => 'col-xs-10 col-sm-5 digits' ,'required','minlength' => 10,'maxlength' => 10)) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('father_husband_name','Father Husband Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('father_husband_name', $employee->father_husband_name, array('class' => 'col-xs-10 col-sm-5', 'required')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('qualification','Qualification', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('qualification', $employee->qualification, array('class' => 'col-xs-10 col-sm-5', 'required' )) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('dob','Date of Birth', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('dob', $employee->dob, array('class' => 'col-xs-10 col-sm-5 datepicker' ,'required' )) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('current_address','Current Address', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::textarea('current_address', $employee->current_address, array('class' => 'col-xs-10 col-sm-5' ,'required' )) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('permanent_address','Permanent Address', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::textarea('permanent_address', $employee->permanent_address, array('class' => 'col-xs-10 col-sm-5','required' )) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('active','Active', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		@if( $employee->active == 1)
			{{ Form::checkbox('active', $employee->active, null, array('checked' => 'checked')) }}
		@else
			{{ Form::checkbox('active') }}
		@endif
	</div>
</div>
@include('admin.partials.js_validation');