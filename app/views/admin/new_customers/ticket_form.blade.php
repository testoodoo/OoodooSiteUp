<div class="row ticket_form" style="display:none;">
    <div class="col-xs-12">
		<div class="widget-box widget-color-blue2">
			<div class="widget-header">
				<h4 class="widget-title lighter smaller">Any Issue?</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-8">
					<div class="row">
					    <div class="col-xs-12">
					      	{{ Form::open(array('route' => 'admin.tickets.generic_store', 'class' => 'form-horizontal', 'method' => 'POST')) }}
					      		{{ Form::hidden('belonging_id',$customer->id) }}
					      		{{ Form::hidden('belonging_type','new_customer') }}
					      		{{ Form::hidden('ticket_type_id',$ticket_type_id) }}
					        	{{ Form::open(array('route' => array('admin.tickets.store'), 'class' => 'form-horizontal validate-form', 'method' => 'POST')) }}
				                        
				                {{Form::hidden('crf_no',$customer->application_no,array('class'=>'form-control'))}}
					        	<div class="form-group">
					            	<label class="col-sm-1 control-label">Name</label>
				            		<div class="col-sm-4">
				                        {{Form::text('name',$customer->first_name,array('class'=>'form-control'))}}
				                    </div>
				                <div class="form-group">
					            	<label class="col-sm-1 control-label">Mobile</label>
				            		<div class="col-sm-4">
				                        {{Form::text('mobile',$customer->phone,array('class'=>'form-control'))}}
				                    </div>
				                </div>
				                </div>
				                	<div class="form-group">
					            	<label class="col-sm-1 control-label">Address</label>
				            		<div class="col-sm-4">
                                    <input type="text" class="form-control" name="address" value="{{$customer->address1}},{{$customer->address2}},{{$customer->address3}}" />
				                    </div>
				                    <div class="form-group">
					            	<label class="col-sm-1 control-label">Email</label>
				            		<div class="col-sm-4">
				                        {{Form::text('email',$customer->email,array('class'=>'form-control'))}}
				                    </div>
				                </div>
							      <div class="form-group">
									{{ Form::label('Ticket Type','Ticket Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
									<div class="col-sm-9">
										<select name="ticket_type_id" style="width:335px;" class="required ticket_type">
											<option value="">Select Ticket Type</option>
											@foreach($customer->ticket_type() as $ticket_type)
												<option value="{{$ticket_type->id}}">{{$ticket_type->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
				                <div class="form-group">
					            	<label class="col-sm-3 control-label">Requirement</label>
				            		<div class="col-sm-5">
				                        {{Form::textarea('requirement','',array('class'=>'form-control new_cust_remarks required','rows' => "5",'cols' => "10"))}}
				                    </div>
				                </div>
				               </div>
		
				               <div class="form-group">
									{{ Form::label('city','City', array('class' => 'col-sm-3 control-label no-padding-right'))}}
									<div class="col-sm-9">
										<select name="city_id" style="width:335px;" class="required">
											<option value="">Select City</option>
											@foreach($customer->city() as $city)
												<option value="{{$city->id}}">{{$city->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group">
					                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
					                     Select Area
					                </label>
					                <div class="col-xs-12 col-sm-9">
					                    <select  name="area" class="select2 employee_id"
					                             data-placeholder="Areas" required>
					                        <option value=""></option>
					                        @foreach($area	 as $employee)
					                            <option value="{{$employee->name}}">
					                               {{$employee->name}}
					                            </option>
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
					                             data-placeholder="Employees" required>
					                        <option value=""></option>
					                        @foreach($employees	 as $employee)
					                            <option value="{{$employee->employee_identity}}">
					                               {{$employee->name}} ({{$employee->employee_identity}})
					                            </option>
					                        @endforeach
					                    </select>
					                </div>
					            </div>
					            <div class="form-group">
						            <div class="col-sm-9 col-sm-offset-3">
						                <button type="submit" class="btn btn-success new_cut_ticket_create">Save</button>
						            </div>
						        </div>
						    {{ Form::close(); }}
						 </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>