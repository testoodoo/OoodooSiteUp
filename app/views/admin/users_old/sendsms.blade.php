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
            <a href="/admin/users-old/getsendsms">Session</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Session
    </h1>
</div>
<div class="row">
    <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
        {{ Form::open(array('route' => 'admin.sms.postsendsms','class'=>'form-horizontal','method'=>'POST')) }}
            <div class="row">
               <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="blue bolder">Account Id</span>
                    </label>
                  <div class="col-sm-5">
                        <label class="col-sm-7 control-label">
                            {{ Form::text('account_id','', array('class' => 'form-control')) }}
                        </label>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
 </div>

@stop

