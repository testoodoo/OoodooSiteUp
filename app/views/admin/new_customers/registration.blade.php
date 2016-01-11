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
            <a href="/admin/new-customers/registration">Users</a>
        </li>
        <li class="active">
            <a href="/admin/new-customers/registration">RegistrationForm</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Users 
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Costumer RelationshipForm
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        {{ Form::open(array('route' => 'admin.users.registrationstore', 'method' => 'POST', 'class' => 'form-horizontal validate-form ')) }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Title</label>
                <div class="col-sm-5">
                    <input name="title" type="radio" class="requiredsss title_radio" value="Dr" /> Dr 
                    <input name="title" type="radio" class="requiredsss title_radio" value="Mr" /> Mr 
                    <input name="title" type="radio" class="requiredsss title_radio" value="Ms" /> Ms 
                    <input name="title" type="radio" class="requiredsss title_radio" value="Mrs" /> Mrs 
                    <input type="checkbox" class="others_radio" /> Others 
                    <input name="other_title" type="text" value=""  
                        placeholder="Others" class="others_input" hidden/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Application No</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="application_no" placeholder="Enter the CRF Number" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">First name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="first_name" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Last name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="last_name" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-5">
                    <input type="email" class="form-control required" name="email" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Flat / Door No / Building name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="address1" placeholder="Door No / Flat / Building name" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Apartment / Street Name </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="address2" placeholder="Apartment / Street Name" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Area</label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="address3" class="select2 required"
                             data-placeholder="Select Area" required>
                        <option value=""></option>
                        @foreach($area as $key)
                            <option value="{{$key->name}}">
                                {{$key->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">City</label>
                <div class="col-sm-5">
                    <select name="city" style="width:100%" class="required"required >
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{$city->name}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" > State</label>
                <div class="col-sm-5">
                    <select name="state" class="required" style="width:100%">
                        <option value="">State</option>
                        <option value="TN">Tamil Nadu</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Pincode</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required digits" name="pincode" maxlength="6" minlength="6"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required digits" name="phone" minlength="10" maxlength="11" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Date of Birth</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required datepicker" name="dob" maxlength="10" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Application Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required datepicker" name="application_date" maxlength="10" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
                     Plan
                </label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="sales_employee_id" class="select2"
                             data-placeholder="Select the Plan">
                        <option value=""></option>
                        @foreach($plans as $plan)
                            <option value="{{$plan->plan_code}}">
                                {{$plan->plan_desc}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-sm-3 control-label">Plan</label>
                <div class="col-sm-5">
                    <select id="type" name="type" onchange="getSubs()" class="required">
                        <option value="">Type</option>
                        <option value="Fiber">Fiber</option>
                        <option value="Normal">Normal</option>
                    </select>
                    <select id="Fiber_subs" name="subscribe" onchange="getPlans()" class="required">
                        <option value="">Subscription</option>
                    </select>
                    <select id="Fiber_plans" name="plan_code" class="required">
                        <option value="">Plans</option>
                    </select>
                    <span class="val_plan"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Gender</label>
                <div class="col-sm-5">
                    <input name="gender" type="radio" value="M" class="required" /> Male 
                                              
                    <input name="gender" type="radio" value="F" class="required" /> Female 
                                              
                    <span class="val_gen"></span>
                </div>
            </div>

           
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
                     Application get by Employee(Sales)
                </label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="sales_employee_id" class="select2 required"
                             data-placeholder="Sales Employee">
                        <option value=""></option>
                        @foreach($employees as $employee)
                            <option value="{{$employee->employee_identity}}">
                                {{$employee->name}} ({{$employee->employee_identity}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        {{ Form::close(); }}
    </div>
</div>
@include('admin.partials.js_validation');


@stop