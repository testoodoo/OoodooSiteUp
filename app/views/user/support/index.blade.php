@extends ('user._layouts.default')
@section('main')
    <style>
    .bottom {
        margin-bottom: 3cm;
    }
    </style>

<div class="panel panel-primary">
    <div class="text-center corporate-id">
        <img src="assets/dist/user/img/call-group.png" alt="">
    </div>
    <div class="row invoice-list">
        <div class="text-center col-lg-4 col-sm-6">
            <p>
                <a href="tel:+918940808080">
                </a>
            </p>
            <div class="corporate-id">
                <a href="tel:+918940808080">
                    <img src="assets/dist/user/img/mobile.png" alt="" height="200">
                </a>
            </div>
            <a href="tel:+918940808080">
                <h3>Call us</h3>
            </a>
            <h5>
                Tel: +91 8940 80 80 80
            </h5> 
            Open 9/6
            <p></p>
        </div>
        <div class="text-center col-lg-4 col-sm-6 bottom">
            <div class="bottom">
            </div>
            <p>
                <a href="mailto:support@oodoo.co.in">
                </a>
            </p>
            <div class="corporate-id">
                <a href="mailto:support@oodoo.co.in">
                    <img src="assets/dist/user/img/email.png" alt="" height="200">
                </a>
            </div>
            <a href="mailto:support@oodoo.co.in">
                <h3>Email us</h3>
            </a>
            <h4>Mail: support@oodoo.co.in </h4>
            Available 9/6
            <p></p>
        </div>
        <div class="text-center col-lg-4 col-sm-6">
            <p>
                <a href="/complaint">
                </a>
            </p>
            <div class="corporate-id">
                <a href="/complaint">
                    <img src="assets/dist/user/img/complaint.png" alt="" height="200">
                </a>
            </div>
            <a href="/complaint">
                <h3>Complaint</h3>
            </a>
            <h4> Register your complaint here</h4>
            <p></p>
        </div>
    </div>
</div>
@stop
