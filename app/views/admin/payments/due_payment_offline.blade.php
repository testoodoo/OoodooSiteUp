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
            <a href="/admin/payments/transactions">Payments</a>
        </li>
        <li class="active">
            <a href="/admin/payments/due-offline-bill">Due-Payment-bill</a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="page-header">
        <h1>
            Pay Bill
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            {{ Form::open( array( 'route' => array('admin.payments.post_offline_bill'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
            <div class="form_customers_type">
                <div class="form-group">
                    {{ Form::label('Select Coustomers Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="customer_type" class="form-control col-sm-6  select_payment_type required" style="width:340px;" required>
                            <option value="">Select Payment type</option>
                            <option value="new_customers">New customers</option>
                            <option value="exiting_customers">Exiting customers</option>
                            <option value="device_details">device details</option>
                        </select>
                    </div>
                    <a href="/admin/payments/pay-offline-bill" class="btn btn-info">Offline Payment</a>
                </div>
            </div>
            <div class="form-group select_bill_type">
                {{ Form::label('Select bill Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-5" >
                    <select name="bill_type" class="form-control col-sm-6 bill_type" style="width:340px;"required>
                        <option value="">Select bill type</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
            {{ Form::label('Select Payment Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-5" >
                    <select name="transaction_type" class="form-control col-sm-6  select_transaction_type required" style="width:340px;"required>
                        <option value="">Select Transaction Type</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('Payment Date', 'Payment Date',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-9">
                        <span class="block input-icon input-icon-right">
                            <input type="text" class="col-xs-10 col-sm-5 required datepicker" name="payment_date" value="">
                        </span>
                    </div>
                </div>
            <div class="new_customers">
                <div class="form-group">
                    {{ Form::label('crf_no','CRF NO',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right '))}}
                    <div class="col-sm-9">
                        <span class="block input-icon input-icon-right">
                            <input type="text" class="col-xs-10 col-sm-5 required" name="crf_no">
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('bill_no','bill no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right' ))}}
                    <div class="col-sm-9">
                        <span class="block input-icon input-icon-right">
                            <input type="text" class="col-xs-10 col-sm-5 required digits device_bill" name="bill_new_cust" value="300300" readonly>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form_payment_cash">
                    <div class="single_bill">
                        <div class="exit_customers">
                            <div class="form-group">
                                {{ Form::label('account_id', 'Account ID',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                                <div class="col-sm-9">
                                    <span class="block input-icon input-icon-right">
                                        <input type="text" class="col-xs-10 col-sm-5 accountid acct_id" onchange="billfetch()" name="account_id" value="">
                                    </span>
                                </div>
                            </div>
                            <div class="form_billno">
                                <div class="form-group">
                            {{ Form::label('bill_no','bill no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right '))}}
                                    <div class="col-sm-9">
                                        <span class="block input-icon input-icon-right">
                                            <input type="text" class="col-xs-10 col-sm-5 required digits billno bil_no" name="bill_no" value="">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                       {{ Form::label('amount','amount',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required digits amount amt eixt_cust_amount" name="amount"  value="">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="multi_bill_new">
                        <div class="form_multi_bill_new">
                            <div class="form-group">
                                {{ Form::label('crf_no','CRF NO',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right '))}}
                                <div class="col-xs-10 col-sm-8">
                                <input type="text" name="account_ids_new[]"  value="" >
                                Amount&nbsp;&nbsp;&nbsp;
                                <input type="hidden" name="bill_new_cust[]" value="300300">
                                <input type="hidden" name="bill_new_dev[]" value="400400">
                                <input type="text" name="amounts_new[]" value="" class="new_amount">
                                &nbsp;&nbsp;&nbsp;
                                <span class="btn btn-primary" id="addition_new" >ADD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="multi_bill">
                        <div class="form_multi_bill">
                            <div class="form-group">
                                {{ Form::label('account_id','Account Id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right '))}}
                                <div class="col-xs-10 col-sm-8">
                                <input type="text" class="acc_id" name="account_ids[]" onchange="billfetch()" value="">
                                Bill NO&nbsp;&nbsp;&nbsp;
                                <input type="text" class="bil_no" name="bill_nos[]" value="">
                                Amount&nbsp;&nbsp;&nbsp;
                                <input type="text" class="amt" name="amounts[]" value="">
                                &nbsp;&nbsp;&nbsp;
                                <span class="btn btn-primary" id="addition">ADD</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('Total Amount', 'Total Amount',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required total_amount" name="total_amount" value="0">
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display:none;" class="cheque_fields">
                        <div class="form-group">
                        {{ Form::label('cheque_no', 'cheque no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="cheque_no">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('cheque_account_no', 'cheque account no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="cheque_account_no">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('cheque_holder_name', 'cheque holder name',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="cheque_holder_name">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('ifsc_code', 'ifsc code',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="ifsc_code">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card_payment">
                        <div class="form-group">
                        {{ Form::label('terminal_id', 'Treminal id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="terminal_id" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('merchant_id', 'Merchant id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="merchant_id" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('invoice_id', 'Invoice id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="invoice_id" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('Card_last_four_digit', 'Card last four digit',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="card_last_four_digit" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                    {{ Form::label('Remarks', 'remarks',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                        <div class="col-sm-9">
                            <span class="block input-icon input-icon-right">
                                <textarea name="remarks" class="col-xs-10 col-sm-5 required" rows="10"></textarea>
                            </span>
                        </div>
                    </div>
                </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" type="submit" onclick="check()">
                                <i class="icon-ok bigger-110"></i>
                                Pay
                            </button>
                        </div>
                    </div>
            {{ Form::close();}}
        </div>
    </div>
</div>
@include('admin.payments.javascript_offline_transactions')
@stop
