@extends ('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="/admin/index">Home</a>
		</li>
		<li class="active">
			<a href="/admin/employees">Employees</a>
		</li>
		<li class="active">
			<a href="/admin/employees/assign">Attendance Details</a>
		</li>
	</ul>
</div>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Attendance
			</h1>
	</div>
		<button class="btn btn-white btn-info btn-bold pull-right raise_map">
                                        <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                        Assign Roles
                                    </button>
		</div>
		@include('admin.employees.assign_roles')
		<div class="row">
			<div class="col-xs-12">
			{{ Form::open( array( 'route' => array('admin.employees.assign_roles'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
				@foreach($roles as $role)
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-top" for="duallist"> {{$role->name}} </label>
						<div class="col-sm-8">
							<select multiple="multiple" size="5" name="roles[]" id="duallist">
							@foreach($employees as $employee)
								@if($employee->role_id==$role->id)
								@if($employee->is_onduty==1)
									<option value="{{$employee->employee_identity}}"  selected="selected">{{$employee->name}}</option>
								@else
									<option value="{{$employee->employee_identity}}" >{{$employee->name}}</option>
								@endif
								@endif
							@endforeach
							</select>

							<div class="hr hr-16 hr-dotted"></div>
						</div>
					</div>
				@endforeach
				<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
						</div>
					</div>
			{{ Form::close() }}
			</div>
		</div><!-- /.page-header -->
	<div><!-- /.page-content -->
	<script type="text/javascript">
		$(document).ready(function(){
			var demo1 = $('select[name="roles[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
				var container1 = demo1.bootstrapDualListbox('getContainer');
				container1.find('.btn').addClass('btn-white btn-info btn-bold');

		});
		 $('button.raise_map').click(function(){
                $(".show_map").slideToggle("slow");
            });
	</script>
@stop