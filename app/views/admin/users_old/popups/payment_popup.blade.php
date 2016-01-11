@include('admin.partials.css_assets')
  @include('admin.partials.js_assets')
      @if(count($user)!=0) 
      <div class="page-content">
            <span class="blue bolder"><h3>Payment Details</h3></span>
                <div class="row">
                    <div class="col-sm-5"> 
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Id </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username">{{$user->id}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Account Id </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="age">{{$user->account_id}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Bill No </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="signup">{{$user->bill_no}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Amount </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="login">{{$user->amount}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Transactions code </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="about">{{$user->transaction_code}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Transactions type </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="about">{{$user->transaction_type}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Payment type </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="about">{{$user->payment_type}}</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Status </div>

                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="about">{{$user->status}}</span>
                                </div>
                            </div>
                        </div> 
                    @else
                    <h5>Empty</h5>
                    @endif
                  
    
 