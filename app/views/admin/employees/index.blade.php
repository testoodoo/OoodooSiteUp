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
			<a href="/admin/employees">Index</a>
		</li>
	</ul>
</div>
<div class="page-content">
<div class="page-header">
		<h1>
			Employees
			<small><i class="icon-double-angle-right"></i>List</small>
		</h1>
	<div class="pull-right">
        {{ Form::open(array('route' => 'admin.employees.index', 'method' => 'get')) }}
          <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" name="query" placeholder="Search ..." class="nav-search-input" value="{{$query}}" id="nav-search-input" autocomplete="off">
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div>                          
        {{ Form::close() }}
    </div>
	<div class="col-xs-12 col-sm-6">
	{{ HTML::decode( HTML::linkRoute("admin.employees.create",'<button class="btn btn-primary">Add New</button>', array(), array('class'=>'pull-right'))) }}
	</div>
</div>
	<div class="row">
	<div class="space-8"></div>	
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Mobile</th>
						<th>Role</th>
						<th>Operations</th>
					</tr>
				</thead>
				<tbody>
					@foreach($employees as $employee)
						<tr>
							<td>{{ $employee->employee_identity }}</td>
							<td>{{ $employee->name }}</td>
							<td>{{ $employee->mobile }}</td>
							<td>
								@if(!is_null($employee->Role($employee->role_id)))
									{{ $employee->role($employee->role_id)->name }}
								@else
									Role Not Found
								@endif
							</td>
							<td>
								<div class="hidden-sm hidden-xs action-buttons">
									<a href="/admin/employees/edit/{{$employee->id}}">
										<i class="ace-icon fa fa-pencil bigger-130"></i>
									</a>&nbsp;&nbsp;
									<a href="/admin/employees/delete/{{$employee->id}}">
									    <i class="red"> 
										<i class="ace-icon fa fa-trash-o bigger-130"></i>
									    </i>
									</a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<div style="float:right;">
	 @if(!empty($query))
        {{ $employees->appends(array('query' => $query))->links(); }}
    @else
		{{$employees->links();}}
    @endif
</div> 
@stop