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
			<a href="/admin/employees/edit/{{$employee->id}}">Edit</a>
		</li>
	</ul>
</div>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Edit Employee
			</h1>
	</div>
		<div class="row">
			<div class="col-xs-12">
				{{ Form::model($employee, array('route' => array('admin.employees.update', $employee->id), 'method' => 'POST', 'class' => 'form-horizontal employee-form', 'role' => 'form')) }}	
					{{ Form::hidden('id',$employee->id) }}				
					@include('admin.employees.form')
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
			$('.chosen-select').chosen();
		});
	</script>
@stop