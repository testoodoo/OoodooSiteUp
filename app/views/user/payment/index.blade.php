@extends ('user._layouts.default')
@section('main')

    <div class="panel" align= "center">
        <p>
            <div class="modal-header">
                <h3><b>PAYMENTS</b></h3>
            </div>
        </p>

        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Bill No</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Transaction Type</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                        <th>Created at</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($payment as $payments)
                    <tr>
                    <td>{{$payments->bill_no}}</td>
                    <td>{{$payments->transaction_code}}</td>
                    <td>₹ {{$payments->amount}}</td>
                    <td>{{$payments->transaction_type}}</td>
                    <td>{{$payments->payment_type}}</td>
                    <td>{{$payments->status}}</td>
                    <td>{{$payments->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div style="float:right;">
        <?php echo $payment->links(); ?>
    </div>
@stop
