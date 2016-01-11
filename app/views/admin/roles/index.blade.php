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
			<a href="/admin/roles">Index</a>
		</li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<a href="/admin/roles/create" class="pull-right">
			<button class="btn btn-primary">Create New Role</button>
		</a>
		<h1>
			Roles
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<tbody>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Level</th>
						<th>Operations</th>
					</tr>
					@foreach($roles as $role)
						<tr>
							<td>{{$role->id}}</td>
							<td>{{$role->name}}</td>
							<td>{{$role->level}}</td>
							<td>
								<div class="hidden-sm hidden-xs action-buttons">
									<a href="/admin/roles/edit/{{$role->id}}">
										<i class="ace-icon fa fa-pencil bigger-130"></i>
									</a>&nbsp;&nbsp;
									<a href="/admin/roles/delete/{{$role->id}}">
										<i class="ace-icon fa fa-trash-o bigger-130"></i>
									</a>&nbsp;&nbsp;
									<a href="roles/{{$role->id}}/change-permission">
										<i class="ace-icon fa fa-search-plus bigger-130"></i>
									</a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div style="float:right;">
	{{ $roles->links(); }}
</div>
@stop