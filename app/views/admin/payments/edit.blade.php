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
            <a href="/admin/payments/edit/{{$payment->id}}">Off-line-bill</a>
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
            {{ Form::open( array( 'route' => array('admin.payments.update'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
               {{ Form::hidden('id',$payment->id,array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
               {{ Form::hidden('status_check',$payment->status,array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right status_pending'))}}
            <div class="form-group">
            {{ Form::label('date', 'Payment Date',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-9">
                    <span class="block input-icon input-icon-right">
                        <input type="text" class="col-xs-10 col-sm-5 required pending" name="payment_date" value="{{$payment->created_at}}">
                    </span>
                </div>
               
            </div>
            <div class="form_payment_cash">
                    <div class="single_bill">
                        <div class="exit_customers">
                            <div class="form-group">
                                {{ Form::label('account_id', 'Account ID',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                                <div class="col-sm-9">
                                    <span class="block input-icon input-icon-right">
                                        <input type="text" class="col-xs-10 col-sm-5 pending" name="account_id" value="{{$payment->account_id}}">
                                    </span>
                                </div>
                            </div>
                            <div class="form_billno">
                                <div class="form-group">
                            {{ Form::label('bill_no','bill no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right '))}}
                                    <div class="col-sm-9">
                                        <span class="block input-icon input-icon-right">
                                            <input type="text" class="col-xs-10 col-sm-5 required digits pending" name="bill_no" value="{{$payment->bill_no}}">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                       {{ Form::label('amount','amount',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required digits pending" name="amount" value="{{$payment->amount}}">
                                </span>
                            </div>
                        </div>
                       @if($payment->status == "pending" || $payment->status == "failure" || $payment->status == "failed")
                         <div class="form-group">
                       {{ Form::label('Select Status','Select Status',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <select name="status" class="form-control col-sm-6 required" style="width:340px;" required>
                                 <option value="">Select status</option>
                                <option value="success">success</option>
                                <option value="pending">pending</option>
                                <option value="failure">failure</option>
                                <option value="cancelled">cancelled</option>
                            </select>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if(count($cheque)!=0)
                    <div class="cheque_fields">
                        <div class="form-group">
                        {{ Form::label('cheque_no', 'cheque no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="cheque_no" value="{{$cheque->cheque_no}}">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('cheque_account_no', 'cheque account no',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="cheque_account_no" value="{{$cheque->cheque_account_no}}">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('cheque_holder_name', 'cheque holder name',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="cheque_holder_name" value="{{$cheque->cheque_holder_name}}">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('ifsc_code', 'ifsc code',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" class="col-xs-10 col-sm-5 required" name="ifsc_code"  value="{{$cheque->ifsc_code}}">
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(count($card)!=0)
                    <div class="card_payment">
                        <div class="form-group">
                        {{ Form::label('terminal_id', 'Treminal id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="terminal_id" value="{{$card->terminal_id}}" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('merchant_id', 'Merchant id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="merchant_id" value="{{$card->merchant_id}}" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('invoice_id', 'Invoice id',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="invoice_id" value="{{$card->invoice_id}}" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::label('Card_last_four_digit', 'Card last four digit',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                            <div class="col-sm-9">
                                <span class="block input-icon input-icon-right">
                                    <input type="text" name="card_last_four_digit" value="{{$card->card_last_four_digit}}" class="col-xs-10 col-sm-5 required">
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                    {{ Form::label('Remarks', 'remarks',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                        <div class="col-sm-9">
                            <span class="block input-icon input-icon-right">
                                {{ Form::textarea('remarks', $payment->remarks , array('class' => 'col-xs-10 col-sm-5 required')) }}
                            </span>
                        </div>
                    </div>
                </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                         @if($payment->status == "pending" || $payment->status == "failure" || $payment->status == "failed")
                            <button class="btn btn-info" name="transaction_code" value="{{$re_transaction}}"> Re Transaction </button>
                        @else 
                            <button class="btn btn-info" type="submit" onclick="check()">
                                <i class="icon-ok bigger-110"></i>
                                Pay
                            </button>
                        @endif
                        </div>
                    </div>
            {{ Form::close();}}
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
if($(".status_pending").val()=="pending"){
    $(".pending").prop("readonly", true);
}else{
    $(".pending").prop("readonly", false);   
}
});
</script>

@stop