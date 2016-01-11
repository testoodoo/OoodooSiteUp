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
        <a href="/admin/users-old">Users-old</a>
    </li>
    <li class="active">
        <a href="/admin/users-old/edit/{{$user->account_no}}">Edit</a>
    </li>
</ul>
</div>
	<h3 class="blue bolder"> User Edit </h3>
        {{ Form::open(array('route' => 'admin.users_old.update', 'class' => 'form-horizontal validate-form', 'method' => 'POST')) }}
	           <div class="form-group">
                <label class="col-sm-3 control-label">Account No</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="account_no"  value="{{$user->account_no}}" readonly="true" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Account ID</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="account_id" value="{{$user->account_id}}"  readonly="true" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Title</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="title"  value="{{$user->title}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">First Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="first_name"  value="{{$user->first_name}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Last Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="last_name"  value="{{$user->last_name}}" />
                </div>
            </div>  
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="email"  value="{{$user->email}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Flat / Door No</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="address1"  value="{{$user->address1}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Apartment / Building name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="address2"  value="{{$user->address2}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Street</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="address3"  value="{{$user->address3}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">City</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="city"  value="{{$user->city}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" > State</label>
                <div class="col-sm-5">
                    <select name="state" class="required" style="width:100%">
                        <option value="">State</option>
                        <option value="TN" <?= $user->state == "TN" ? "selected" : "" ?>>Tamil Nadu</option>
                    </select>
                </div>
            </div>>
              <div class="form-group">
                <label class="col-sm-3 control-label">Pincode</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="pincode" value="{{$user->pincode}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="phone"  value="{{$user->phone}}" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Date Of Birth</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control datepicker" name="dob" value="{{$user->dob}}" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label">Gender</label>
                <div class="col-sm-5">
                    <input name="gender" type="radio" value="M" class="required"
                    <?= $user->gender == "m" ? "checked" : "" ?> /> Male 
                                              
                    <input name="gender" type="radio" value="F" class="required" 
                    <?= $user->gender == "f" ? "checked" : "" ?>/> Female 
                                              
                    <span class="val_gen"></span>
                </div>
            </div>
             <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        {{ Form::close()}}
@include('admin.partials.js_validation');
@stop