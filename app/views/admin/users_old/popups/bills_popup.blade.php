@include('admin.partials.css_assets')
  @include('admin.partials.js_assets')
       @if(count($bill)!=0)
        <div class="page-content">
            <span class="blue bolder"><h3>Bill Details</h3></span>
            <div class="row">
                <div class="col-sm-5">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Bill No </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="username">{{$bill->bill_no}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Account Id </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="age">{{$bill->account_id}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> For month </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="signup">{{$bill->for_month}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Current plan </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="login">{{$bill->cust_current_plan}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Bill date </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->bill_date}}</span>
                            </div>
                        </div>
                          <div class="profile-info-row">                                                            
                            <div class="profile-info-name"> Due date </div>

                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->due_date}}</span>
                            </div>
                        </div>
                            <div class="profile-info-row">
                        <div class="profile-info-name"> For month </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">  @if($bill->status == "not_paid")

                                <p style="color:red">Not Paid</p>
                                <p>
                                    <a href="javascript:void(0);" class="notify_user_for_bill"
                                data-bill-no="{{ $bill->Bill_No }}">Send SMS</a>
                                </p>
                                @elseif($bill->status == "paid")

                                <p style="color:green">Paid</p>
                                <p>----------</p>
                                @elseif($bill->status == "partially_paid")

                                <p style="color:orange">Partially Paid</p>
                                @endif  
                                </span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                        <div class="profile-info-name"> Send sms </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about"><p>
                                    <a href="javascript:void(0);" class="notify_user_for_bill"
                                 data-bill-no="{{ $bill->bill_no }}">Send SMS</a>
                                </p></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Previous balance </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->prev_bal}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Last payment </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->last_payment}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                        <div class="profile-info-name"> Adjustment </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->adjustments}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                        <div class="profile-info-name"> Total charges </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->total_charges}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                        <div class="profile-info-name"> Amount before due date </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->amount_before_due_date}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                        <div class="profile-info-name"> Amount after due date </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->amount_after_due_date}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                        <div class="profile-info-name"> Amount paid </div>
                            <div class="profile-info-value">
                                <span class="editable editable-click" id="about">{{$bill->amount_paid}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
@else
<h5>Empty</h5>
@endif
                                                
                            
                                        

                  
    
