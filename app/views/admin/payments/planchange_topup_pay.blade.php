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
            <a href="/admin/planActivation1">Users</a>
        </li>
        @if($topup_id)
        <li class="active">
            <a href="/admin/topup/index">Top Up</a>
        </li>
        @else
        <li class="active">
            <a href="/admin/planchange/index">Plan Change</a>
        </li>
        @endif
    </ul>
</div>
<div class="page-header">
    <h1>User
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
                            User Request
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-sm-12">
    	@if($topup_id!=0)
        <h3 class="header red center">TOPUP REQUEST DETAILS</h3>
        <div class="well well-lg">
            <h3 class="green center">TOPUP REQUEST HAS BEEN GENERATED SUCCESSFULLY</h3>
        </div>
        @else
        <h3 class="header red center">PLANCHANGE REQUEST DETAILS</h3>
        <div class="well well-lg">
            <h3 class="green center">PLANCHANGE REQUEST HAS BEEN GENERATED SUCCESSFULLY</h3>
        </div>
        @endif

        <div class="well">
            <h3 class="blue center">      ACCOUNT ID :: {{$account_id}} </h3>
            <h3 class="blue center">      BILL NO 	 :: {{$bill_no}}</h3>
            <h3 class="blue center"> 	  AMOUNT     :: {{$amount}}</h3>
        </div>

    </div>
</div>
@stop