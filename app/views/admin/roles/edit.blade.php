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
			<a href="/admin/roles">Roles</a>
		</li>
		<li class="active">
			<a href="/admin/roles/edit/{{$role->id}}">Edit</a>
		</li>
	</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.roles.update'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Role ({{$role->name}})
					</h1>
				</div>
				@include('admin.roles.form')
				{{ Form::hidden('role_id',$role->id) }}
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						{{ Form::submit('update', array('class' => 'btn btn-info')) }}
						<a href="/roles" class="btn btn-grey tab-buttons" style="margin-left: 10px;">
							<i class="ace-icon icon-reply icon-only"></i>
							Back To List
						</a>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop