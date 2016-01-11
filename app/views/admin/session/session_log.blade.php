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
        <a href="/admin/session/session_logs">Session Logs</a>
    </li>
</ul>
</div>
<div class="page-header">
    <h1>
        Session Logs
    </h1>

</div>
<div class="row">
    <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
       <!-- {{ Form::open(array('route' => 'admin.session.post_session_logs','class'=>'form-horizontal','method'=>'POST')) }}-->
            <div class="row form-horizontal">
               <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="blue bolder">ACCOUNT ID</span>
                    </label>
                  <div class="col-sm-5">
                        <label class="col-sm-6 control-label">
                            {{ Form::text('account_id','', array('class' => 'form-control account_id')) }}
                        </label>
                        <button type="submit" class="btn btn-primary" onclick="sessionLogs()">check</button>
                    </div>
                </div>
            </div>
      <!--  {{ Form::close() }}-->
    </div>
 </div>
 <table id="sessions" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Created</th>
                                                    <th>User name</th>
                                                    <th>MAC Address</th>
                                                    <th>IP Address</th>
                                                    <th>Message</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
 <script type="text/javascript" charset="utf-8">
        function sessionLogs(){
            var account_id=$('.account_id').val();
            var oTable = $('#sessions').dataTable({
                       "ajax": '/admin/session/post_session_logs?account_id='+account_id,
                       "type":'get',
                       "dataType":'json',
                        "columns": [
                                        { "data": "created" },
                                        { "data": "username" },
                                        { "data": "mac" },
                                        { "data": "ap_mac" },
                                        { "data": "message" },
                                    ],
                   });
            }

        </script>
@stop