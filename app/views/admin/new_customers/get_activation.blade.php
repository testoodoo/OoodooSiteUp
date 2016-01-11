@extends('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
    try{
      ace.settings.check('breadcrumbs' , 'fixed')}
    catch(e){
    }
  </script>
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/admin/index">
        Home
      </a>
        </li>
        <li class="active">
            <a href="/admin/new-customers/list">
        User
      </a>
        </li>
        <li class="active">
            <a href="/admin/new-customers/customer-activation">
        Activation
      </a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
    Users
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
      Activation
    
        </small>
    </h1>
</div>
<!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
    {{ Form::open(array('route' =>'admin.users.fetchCustomer','class'=>'form-horizontal','method'=>'POST'))}}
        <div class="col-sm-11">
            <label class="col-sm-7 control-label">
                <span class="blue bolder">
          Customer Request Form No. or Application No.
        </span>
            </label>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="application_no" />
            </div>
        </div>
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-5">
            <label class="col-sm-6 control-label">
                <span class="blue bolder">
          OR
        </span>
            </label>
        </div>
        <div class="col-sm-10">
            <label class="col-sm-7 control-label">
                <span class="blue bolder">
          Request ID
        </span>
            </label>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="request_id" />
            </div>
        </div>
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-5">
            <label class="col-sm-7 control-label">
                <button type="submit"  class="btn btn-sm btn-success" onclick="myFunction()">
          Submit
        </button>
            </label>
        </div>
    {{Form::close()}}
    </div>
</div>
@stop