@extends ('user._layouts.default')
@section('main')
<div class="panel" align= "center">
    <p>
        <div class="modal-header">
            <h3><b>BILLS</b></h3>
        </div>
    </p>
    <div class="panel-body">
        @if(Auth::user()->get()->payableAmount()>0)
            <div align="center">
                <table>
                    <tr>
                        <td>
                            <span class="btn btn-danger"> 
                                <b>Your Outstanding Bill Amount: ₹ {{Auth::user()->get()->payableAmount()}} </b>
                            </span>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <a class="btn btn-success" href="/pay-bill">
                                <b> Pay Bill</b> 
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        @endif
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Bill No #</th>
                    <th>For Month</th>
                    <th class="hidden-phone">Description</th>
                    <th class="">Bill Amount</th>
                    <th class="">Amount Paid</th><center>
                    <th class="">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($bills as $key => $bill)
                    <tr>
                        <td>{{$bill->bill_no}}</td>
                        <td>{{$bill->for_month}}</td>
                        <td class="hidden-phone">{{$bill->cust_current_plan}}</td>
                        <td class="">₹ {{$bill->amount_before_due_date}}</td>
                        <td class="">₹ {{$bill->amount_paid}}</td>
                        @if ($bill->status == "not_paid")
                            <td>
                                <span class ="label label-danger">
                                        Not Paid
                                </span>
                            </td>
                        @elseif ($bill->status == "partially_paid")
                            <td>
                                <span class ="label label-warning">
                                    Partially Paid
                                </span>
                            </td>
                        @elseif ($bill->status == "paid")
                            <td >
                                <span class ="label label-success">
                                    Paid
                                </span>
                            </td>
                        @else
                            <td >
                                <span class ="label label-sm label-warning">
                                    Data Not found
                                </span>
                            </td>
                        @endif
                        <td>
                            <a class = "label label-info label-white middle" href="/bills/view/{{$bill->bill_no}}" target="_blank">View Bill</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center invoice-btn">
            <a class="btn btn-info" onclick="javascript:window.print();">
                <i class="icon-print"></i> 
                <b>Print</b> 
            </a>
        </div>
    </div>
</div>
<div style="float:right;">
  <?php echo $bills->links(); ?>
</div>
@stop