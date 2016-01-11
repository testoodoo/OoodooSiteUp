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
            <a href="/admin/planActivation1">Users</a>
        </li>
        <li class="active">
            <a href="/admin/planActivation1">Activation</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>User
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
                            Activation
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-sm-12">
        <h3 class="header red center">ACTIVATED CUSTOMER DETAILS</h3>
        <div class="well well-lg">
            <h3 class="green center">ACCOUNT ACTIVATED SUCCESSFULLY</h3>
        </div>

        <div class="well">
            <h3 class="blue center">          CRF NO :: {{$cust_details->crf_no}} </h3>
            <h3 class="blue center">      ACCOUNT ID :: {{$account_id}}</h3>
            <h3 class="blue center">   CUSTOMER NAME :: {{$cust_details->first_name}}&nbsp;{{$cust_details->last_name}}</h3>
            <h3 class="blue center"> PLAN START DATE :: {{$plan_details->plan_start_date}}</h3>
            <h3 class="blue center">            PLAN :: {{$plan_details->plan}}</h3>
        </div>

    </div>
</div>
@stop
