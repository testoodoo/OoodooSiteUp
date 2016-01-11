<div class="row show_form" style="display:none;">
    <div class="col-xs-12">
		<div class="widget-box widget-color-blue2">
			<div class="widget-header">
				<h4 class="widget-title lighter smaller">COMPLIANT</h4>
			</div>
			<div class="widget-body">
				<div class="widget-main padding-8">
					<div class="row">
					    <div class="col-xs-12">
					      	{{ Form::open(array('route' => array('admin.tickets.generic_store'), 'class' => 'form-horizontal validate-form', 'method' => 'POST')) }}
				                {{Form::hidden('account_id',$user->account_id,array('class'=>'form-control'))}}
					        	<div class="form-group">
					            	<label class="col-sm-1 control-label">Name</label>
				            		<div class="col-sm-4">
				                        {{Form::text('name',$user->first_name,array('class'=>'form-control'))}}
				                    </div>
				                <div class="form-group">
					            	<label class="col-sm-1 control-label">Mobile</label>
				            		<div class="col-sm-4">
				                        {{Form::text('mobile','',array('class'=>'form-control','required'))}}
				                    </div>
				                </div>
				                </div>
				                	<div class="form-group">
					            	<label class="col-sm-1 control-label">Address</label>
				            		<div class="col-sm-4">
                                    <input type="text" class="form-control" name="address" value="{{$user->address1}},{{$user->address2}},{{$user->address3}}" />
          
				                    </div>
				                    <div class="form-group">
					            	<label class="col-sm-1 control-label">Email</label>
				            		<div class="col-sm-4">
				                        {{Form::text('email',$user->email,array('class'=>'form-control'))}}
				                    </div>
				                </div>
							    <div class="form-group">
									{{ Form::label('Ticket Type','Ticket Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
									<div class="col-sm-9">
										<select name="ticket_type_id" style="width:335px;" class="required ticket_type">
											<option value="">Select Ticket Type</option>
											@foreach($user->ticket_type() as $ticket_type)
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
											@foreach($user->city() as $city)
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
					                    <select  id="emp_subs" name="employee_id" class="select2 employee_id"
					                             data-placeholder="Employees" required>
					                        <option value=""></option>
					                        @foreach($user->employee_identity()	 as $employee)
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
<script type="text/javascript">
   				 $('select.ticket_type').change(function(){
                    var plan = $(this).val();
                    if (plan.length != 0) {
                      $.ajax({
                            url:'/admin/users-old/set-employee',
                            type:'GET',
                            data: { ticket_type : plan},
                            dataType: 'json',
                            success: function( json ) {
                                $("#emp_subs").empty();
                               $.each(json, function(i, optionHtml){
                                  $('#emp_subs').append(new Option(optionHtml,i));
                               });
                            }
                        });
                    }else{
                        $("#emp_subs").empty();
                    }
                    });
</script>
@include('admin.partials.js_validation');