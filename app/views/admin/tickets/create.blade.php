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
			<a href="/admin/ticket/index">Tickets</a>
		</li>
		<li class="active">
			<a href="/admin/ticket/create">Create</a>
		</li>
	</ul>
</div>
	<div class="page-content">
		{{ Form::open( array( 'route' => array('admin.tickets.store'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
			{{Form::hidden('belonging_type','new_customer',array('class'=>'form-control'))}}
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header">
						<h1>
							New Ticket New Connection Only 
						</h1>
					</div>
					<div class="form-group account_id_field" style="display:none">
						{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('account_id', '' , array('class' => 'col-xs-10 col-sm-5 account_id')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('name','Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('name', '' , array('class' => 'col-xs-10 col-sm-5','required')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('mobile','Mobile', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('mobile', '' , array('class' => 'col-xs-10 col-sm-5 required digits','required' )) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('email','Email', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('email', '' , array('class' => 'col-xs-10 col-sm-5')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('address','Address', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::textarea('address', '' , array('class' => 'col-xs-10 col-sm-5','required' )) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('area','Select Area', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-xs-12 col-sm-9">
		                    <select  name="area" class="select2 required"
		                             data-placeholder="Employees" required>
								<option value="">Select Area</option>
								@foreach($areas as $area)
									<option value="{{$area->name}}">{{$area->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('city','City', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							<select name="city_id" style="width:335px;" class="required"required >
								<option value="">Select City</option>
								@foreach($cities as $city)
									<option value="{{$city->id}}">{{$city->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('requirement','Requirement', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::textarea('requirement', '' , array('class' => 'col-xs-10 col-sm-5','required')) }}
						</div>
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							{{ Form::submit('create', array('class' => 'btn btn-info')) }}
						</div>
					</div>
				</div>
            </div>
		{{ Form::close() }}
	</div>
	<script type="text/javascript">
		$('.ticket_type').click(function(){
			var ticket_type = $(this).val();

			if (ticket_type == "2") {
				$('.account_id_field').show();
			} else {
				$('.account_id_field').hide();
			}
		});
	</script>
@include('admin.partials.js_validation');
	@stop