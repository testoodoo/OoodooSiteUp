<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
	<title>OODOO Fiber Bill | {{$user->account_id}} | {{$bill->bill_no}}</title>
        <link href="/assets/dist/user/css/view_bill/style.css" rel="stylesheet">
    </head>
    <body style="margin: 0;padding: 0;">
       
        <header>
            <div class="container" style="margin: 0 auto;width: 960px;">
                <div class="logo">
                    <a href="#"><img src="/assets/dist/user/img/oodoo_logo.png"
                         width="55px" height="80px" alt="OODOO Fiber"></a>
                </div>
                <div class="address">
                    OODOO Fiber, <br>#15, Govindaswamy Street, <br>Sholinganallur, Chennai - 600119
                </div>
                <h1 class="prepaid">Your Prepaid Bill </h1>

				<div class="acc_details">
				    Account No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$user->account_id}} <br>
                    {{$user->first_name}} {{$user->last_name}}<br>
                    {{$user->address}}<br>
                    {{$user->city}}-{{$user->state}}-{{$user->pincode}}<br>
                </div>

                <div class="bill_details">
                    <ul>
                        <li>Your OODOO Fiber Bill</li>
                        <li>Account No</li>
                        <li>Your Tariff</li>
                        <li>Bill Number</li>
                        <li>Bill Date</li>
                        <li>Bill Period</li>
                        <li>Security Deposit</li>
                    </ul>
                </div>
                <div class="bill_details">
                    <ul>
                        <li>&nbsp;</li>
                        <li>{{$user->account_id}}</li>
                        <li>{{$bill->cust_current_plan}}</li>
                        <li>{{$bill->bill_no}}</li>
                        <li>{{$bill->bill_date}}</li>
                        <li>{{$bill->bill_start_date}} to {{$bill->bill_end_date}}</li>
                        <li>{{$bill->security_deposit}} /-</li>
                    </ul>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="payment_details">
                    Previous <br>Balance <span>Rs. {{$bill->prev_bal}}</span>
                </div>
                <div class="symbol">-</div>
                <div class="payment_details">
                    Last <br>Payment <span>Rs. {{$bill->last_payment}}</span>
                </div>
                <div class="symbol">+/-</div>
                <div class="payment_details">
                    <h3>Adjustments</h3>  <span>Rs. {{$bill->adjustments}}</span>
                </div>
                <div class="symbol">+</div>
                <div class="payment_details">
                    Current <br>Charges  <span>Rs. {{$bill->current_rental}}</span>
                </div>
                <div class="symbol">=</div>
                <div class="payment_details">
                    ^ Amount Due before due date <span>Rs.{{$bill->amount_before_due_date}}</span>
                </div>
                <div class="payment_details">
                    # Amount Due after Due date <span>Rs. {{$bill->amount_after_due_date}}</span>
                </div>
                <div class="payment_details">
                    Due <br>Date <span>{{$bill->due_date}}</span>
                </div>
                <div class="bill_round">
                    ^ Bill is rounded off to nearest rupee. # It includes late payment charges.
                </div>
				<div class="offer">
                    <a href="#"><img src="/assets/dist/user/img/offer.jpg" alt="OODOO Fiber offer"></a>
                </div>
                <div class="current_charges">
                    Summary of Current Charges
                    <ol type="1">
                        <li>Monthly Rental</li>
                        <li>Device Charges</li>
                        <li>One Time Charges</li>
                        <li>Discounts</li>
                        <li>Other Charges</li>
						<li type="none"><b style="padding-left:2.7em">Sub Total</b></li>
                        <li>Service Tax</li>
                    </ol>
					
                    <b>TOTAL Current Charges</b>
                </div>
                <div class="current_charge">
                   Rs.
                    <ul>
                        <li> {{$bill->current_rental}}</li>
                        <li>    {{$bill->device_cost}}</li>
                        <li>    {{$bill->onetime_charges}}</li>
                        <li>    {{$bill->other_charges}}</li>
                        <li>    {{$bill->discount}}</li>
                        <li><b style="padding-right:2em"> {{$bill->sub_total}}</b></li>
                        <li>  {{$bill->service_tax}}</li>_______________________________________________
                    </ul>
                     {{$bill->total_charges}}
                </div>
                <div class="reg_num">
                    Service Tax Registration Number : AADFO7651GSD001, Service Category: Internet Telecommunication Services, PAN Number: AADFO7651G <br> Tear this slip off and submit it with your payment
                </div>
                <div class="cash_details">
                    <div class="payment">
                        <h4 class="pay_order">Cheque/DD/Payorder</h4>
                        <ul class="order_details">
                            <li>Bill Number : {{$bill->bill_no}} </li>
                            <li>Cheque/DD/Payorder Number _________________________</li>
                            <li>Amount Rs. ________________________________________</li>
                            <li>Date. _____________________________________________</li>
                            <li>Bank & Branch _____________________________________</li>
                            <li>Signature _________________________________________</li>
                        </ul>
                    </div>
                     <div class="payment_cash">
                        <h4 class="pay_order">Cash</h4>
                        <ul class="order_details">
                            <li>Bill Number : {{$bill->bill_no}} </li>
                            <li>Amount Rs. __________________________________</li>
                            <li>Signature ____________________________________</li>
                        </ul>
                        <img src="/assets/dist/user/img/oodoo_logo.png" style="margin:0px 20px 0px;" width="40px" height="55px" alt="OODOO Fiber"/>
                    </div>

                </div>
                <h6 class="terms_condition">
                    <sup>*</sup>Terms and Conditions Apply, please visit www.oodoo.co.in/legal/ for more information on terms and conditions<br>
		              Powered by VIVA</h6>
                </div>
            </div>
	</section>

        </div>

</html>