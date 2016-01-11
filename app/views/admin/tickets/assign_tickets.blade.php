@extends('admin.layouts.default')
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
	</ul>
</div>
	<div class="page-content">
		{{ Form::open( array( 'route' => array('admin.tickets.send_tickets'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
			{{ Form::hidden('ticket_no',$ticket->ticket_no) }}
			<div class="row">
				<div class="col-xs-12">
					<div class="page-header">
						<h1>
							New Ticket
						</h1>
					</div>
					<div class="form-group">
						{{ Form::label('Select Area','Select Area', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							<select name="ticket_area" style="width:335px;" class="required ticket_type">
								<option value="">Select Area</option>
								@foreach($ticket_area as $area)
									<option value="{{$area->name}}">{{$area->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
		                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
		                     Assign Ticket For Employee
		                </label>
		                <div class="col-xs-12 col-sm-9">
		                    <select  name="employee_id" class="select2 employee_id"
		                             data-placeholder="Sales Employee" required>
		                        <option value=""></option>
		                        @foreach($employees as $employee)
		                            <option value="{{$employee->employee_identity}}">
		                               {{$employee->name}} ({{$employee->employee_identity}})
		                            </option>
		                        @endforeach
		                    </select>
		                </div>
		            </div>
		            @if($ticket->account_id)
					<div class="form-group account_id_field">
						{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('account_id',$ticket->account_id, array('class' => 'col-xs-10 col-sm-5 required account_id')) }}
						</div>
					</div>
					@else
					<div class="form-group account_id_field">
						{{ Form::label('CRF NO','CRF NO', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('crf_no_',$ticket->crf_no, array('class' => 'col-xs-10 col-sm-5 required account_id')) }}
						</div>
					</div>
					@endif
					<div class="form-group">
						{{ Form::label('name','Name', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('name',$ticket->name, array('class' => 'col-xs-10 col-sm-5 required')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('mobile','Mobile', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('phone',$ticket->mobile, array('class' => 'col-xs-10 col-sm-5 required digits')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('email','Email', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::text('email',$ticket->email, array('class' => 'col-xs-10 col-sm-5')) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('address','Address', array('class' => 'col-sm-3 control-label no-padding-right'))}}
						<div class="col-sm-9">
							{{ Form::textarea('address',$ticket->address, array('class' => 'col-xs-5 col-sm-5 required')) }}
						</div>
					</div>
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							{{ Form::submit('send', array('class' => 'btn btn-info')) }}
						</div>
					</div>
				</div>
            </div>
		{{ Form::close() }}
	</div>

@include('admin.partials.js_validation');
@stop