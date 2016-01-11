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
		<a href="/admin/switch_router-tag/index">Switch and Routers Tag</a>
	</li>
	<li class="active">
		<a href="/admin/switch_router-tag/create">Create</a>
	</li>
</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.switch_router_tag.store'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Switch and Routers Tags
					</h1>
				</div>
				<div class="form-group">
					{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('account_id','',array('class' => 'col-xs-10 col-sm-5','required ')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('ht_box_id','HT BOX ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('ht_box_id','',array('class' => 'col-xs-10 col-sm-5 account_id','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('oun_id','ONU ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('onu_id','',array('class' => 'col-xs-10 col-sm-5','required ')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('switch_id','Switch ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('switch_id','',array('class' => 'col-xs-10 col-sm-5','required ')) }}
					</div>
				</div><div class="form-group">
					{{ Form::label('router_id','Router ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('router_id','',array('class' => 'col-xs-10 col-sm-5','required ')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('sign_up_employee','Sign Up Employee', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-xs-12 col-sm-9">
		                    <select  name="sign_up_employee" class="select2 required"
		                             data-placeholder="Employees" required>
								<option value="">Select Area</option>
								@foreach($employees as $employee)
									<option value="{{$employee->employee_identity}}">({{$employee->employee_identity}}){{$employee->name}}</option>
								@endforeach
							</select>
						</div>
				</div><div class="form-group">
					{{ Form::label('created_by','Created By', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-xs-12 col-sm-9">
		                    <select  name="created_by" class="select2 required"
		                             data-placeholder="Employees" required>
								<option value="">Select Area</option>
								@foreach($employees as $employee)
									<option value="{{$employee->employee_identity}}">({{$employee->employee_identity}}){{$employee->name}}</option>
								@endforeach
							</select>
						</div>
				</div>
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close(); }}
</div>
<script type="text/javascript">
    $(document).ready(function(){
	    $('.validate-form').validate();

	    $('.datepicker').datepicker({
	        format: 'yyyy-mm-dd'
	    });

	    $('.select2').css('width','200px').select2({allowClear:true})

	    $('#select2-multiple-style .btn').on('click', function(e){
	        var target = $(this).find('input[type=radio]');
	        var which = parseInt(target.val());
	        if(which == 2) $('.select2').addClass('tag-input-style');
	         else $('.select2').removeClass('tag-input-style');
	    });

   });
</script>
@stop