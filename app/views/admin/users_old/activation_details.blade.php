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
            <a href="/admin/users-old/activation_details">Activation Details</a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="page-header">
        <h1>
            Activation Details
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            {{ Form::open( array( 'route' => array('admin.users_old.post_activation_details'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
            <div class="form-group">
                {{ Form::label('account_id', 'Account ID',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-9">
                    <span class="block input-icon input-icon-right">
                        <input type="text" class="col-xs-10 col-sm-5 required" name="account_id" value="">
                    </span>
                </div>
            </div>
           <!-- <div class="form-group">
            {{ Form::label('date', 'Expiry Date',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-9">
                    <span class="block input-icon input-icon-right">
                        <input type="text" class="col-xs-10 col-sm-5 datepicker required" name="expiry_date" value="">
                    </span>
                </div>
            </div> -->
            <div class="form-group select_bill_type">
                {{ Form::label('Select Extiry Time', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-5" >
                    <select name="expiry_time" class="form-control col-sm-6" style="width:340px;"required>
                        <option value="">Select hours</option>
                        <option value="1">1 hour</option>
                        <option value="12">12 hour</option>
                        <option value="24">24 hour</option>
                        <option value="48">48 hour</option>
                        <option value="72">72 hour</option>
                        <option value="168">1 week</option>
                        <option value="month_fully">1 month</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
            {{ Form::label('Remarks', 'Remarks',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-9">
                    <span class="block input-icon input-icon-right">
                        <textarea name="remarks" class="col-xs-10 col-sm-5 required" rows="10"></textarea>
                    </span>
                </div>
            </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" type="submit" onclick="check()">
                                <i class="icon-ok bigger-110"></i>
                                Save
                            </button>
                        </div>
                    </div>
            {{ Form::close();}}
        </div>
    </div>
</div>

@include('admin.payments.javascript_offline_transactions')

@stop