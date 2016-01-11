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
            <a href="/admin/registration">Users</a>
        </li>
        <li class="active">
            <a href="/admin/new-customers/{{$new_customer->id}}/edit">Edit</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>Users
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>Costumers Edit Form
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        {{ Form::open(array('route' => 'admin.users.update', 'class' => 'form-horizontal validate-form', 'method' => 'POST')) }}
            {{ Form::hidden('customer_id',$new_customer->id) }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Title</label>
                <div class="col-sm-5">
                    <input name="title" type="radio" class="requiredsss title_radio" value="Dr"
                    <?= $new_customer->title == "Dr" ? "checked" : "" ?> /> Dr 
                    <input name="title" type="radio" class="requiredsss title_radio" value="Mr"
                    <?= $new_customer->title == "Mr" ? "checked" : "" ?> /> Mr 
                    <input name="title" type="radio" class="requiredsss title_radio" value="Ms"
                    <?= $new_customer->title == "Ms" ? "checked" : "" ?> /> Ms 
                    <input name="title" type="radio" class="requiredsss title_radio" value="Mrs"
                    <?= $new_customer->title == "Mrs" ? "checked" : "" ?> /> Mrs 
                    <input type="checkbox" class="others_radio"
                    <?= !in_array($new_customer->title, array("Dr","Mr","Ms","Mrs")) ? "checked" : ""  ?> /> Others 
                    @if(in_array($new_customer->title, array("Dr","Mr","Ms","Mrs")))
                        <input name="other_title" type="text" value="" hidden 
                        placeholder="Others" class="others_input"/>    
                    @else
                        <input name="other_title" type="text" 
                        placeholder="Others" class="others_input" value="{{ $new_customer->title }}" />
                    @endif
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Application No</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="application_no" placeholder="Enter the CRF Number" value="{{ $new_customer->application_no }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">First name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="first_name"
                    value="{{ $new_customer->first_name }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Last name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="last_name"
                    value="{{ $new_customer->last_name }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-5">
                    <input type="email" class="form-control required" name="email"
                    value="{{ $new_customer->email }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Flat / Door No</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="address1"
                    value="{{ $new_customer->address1 }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Apartment / Building name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="address2"
                    value="{{ $new_customer->address2 }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Street Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="address3"
                    value="{{ $new_customer->address3 }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">City</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required" name="city"
                    value="{{ $new_customer->city }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" > State</label>
                <div class="col-sm-5">
                    <select name="state" class="required" style="width:100%">
                        <option value="">State</option>
                        <option value="TN" <?= $new_customer->state == "TN" ? "selected" : "" ?>>Tamil Nadu</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Pincode</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required digits" name="pincode" maxlength="6" minlength="6" value="{{ $new_customer->pincode }}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required digits" name="phone" minlength="10" maxlength="10" value="{{ $new_customer->phone }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Date of Birth</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control required datepicker" name="dob" maxlength="10"
                    value="{{ $new_customer->dob }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Plan</label>
                <div class="col-sm-5">
                    <select id="type" name="type" onchange="getSubs()" class="">
                        <option value="">Type</option>
                        <option value="Fiber">Fiber</option>
                        <option value="Normal">Normal</option>
                    </select>
                    <select id="Fiber_subs" name="subscribe" onchange="getPlans()" class="">
                        <option value="">Subscription</option>
                    </select>
                    <select id="Fiber_plans" name="plan_code" class="required">
                        <option value="">Plans</option>
                        @if(!empty($new_customer->plan_code))
                            <option value="{{$new_customer->plan_code}}" selected>
                                {{ $new_customer->plan_type()->plan }}
                            </option>
                        @endif
                    </select>
                    <span class="val_plan"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Gender</label>
                <div class="col-sm-5">
                    <input name="gender" type="radio" value="M" class="required"
                    <?= $new_customer->gender == "M" ? "checked" : "" ?> /> Male 
                                              
                    <input name="gender" type="radio" value="F" class="required" 
                    <?= $new_customer->gender == "F" ? "checked" : "" ?>/> Female 
                                              
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
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{$employee->employee_identity}}"
                                <?= $new_customer->sales_employee_id == $employee->employee_identity ? "selected" : "" ?>>
                                {{$employee->name}} ({{$employee->employee_identity}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        {{ Form::close()}}
    </div>
</div>

@include('admin.partials.js_validation');

@stop