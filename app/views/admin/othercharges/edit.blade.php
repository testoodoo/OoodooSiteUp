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
			<a href="/admin/othercharges">Adjustments</a>
		</li>
		<li class="active">
			<a href="/admin/othercharges/edit/{{$othercharges->id}}">Edit</a>
		</li>
	</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.othercharges.update'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Edit Discounts
					</h1>
				</div>
				{{ Form::hidden('id',$othercharges->id) }}
				@include('admin.othercharges.form')
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close(); }}
</div>
@stop