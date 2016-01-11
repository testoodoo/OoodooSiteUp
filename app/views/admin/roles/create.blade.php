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
			<a href="/admin/roles/create">Create</a>
		</li>
	</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.roles.store'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						New Role
					</h1>
				</div>
				@include('admin.roles.form')
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						{{ Form::submit('create', array('class' => 'btn btn-info')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>
@stop