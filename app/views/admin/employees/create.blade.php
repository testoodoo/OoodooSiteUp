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
			<a href="/admin/employees/create">Create</a>
		</li>
	</ul>
</div>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Add New Employee
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-12">
				{{ Form::open( array( 'route' => array('admin.employees.store'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
				<div class="form-group">
					{{ Form::label('Employee ID','Employee ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('employee_id','',array('class' => 'col-xs-10 col-sm-5 sr')) }}
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label class="middle">
							<input class="ace" id="s" type="checkbox" />
							<span class="lbl">&nbsp;&nbsp;&nbsp;Auto Genrantion</span>
						</label>
					</div>
				</div>
					@include('admin.employees.form')
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
    if($('#s:checked').length){
        $('#sr').attr('readonly',true);
    }

    $('#s').change(function(){
        if($('#s:checked').length){
            $('.sr').attr('readonly',true);
            $('.sr').attr('placeholder',"Auto Genrantion Employee Id");

        }else{
            $('.sr').attr('readonly',false);
            $('.sr').attr('placeholder',"Entery Employee Id");
        }
    });
});
</script>
@stop