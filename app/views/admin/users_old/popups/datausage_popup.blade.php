@include('admin.partials.css_assets')
  @include('admin.partials.js_assets')
@if(count($data)!=0)
    <div class="page-content">
        <span class="blue bolder"><h3>Datausage Details</h3></span>
        <div class="row">
           <div class="col-sm-5">
                <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                    <div class="profile-info-name"> Current Plan </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click" id="username">{{$data->current_plan}}</span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Account Id </div>

                    <div class="profile-info-value">
                        <span class="editable editable-click" id="age">{{$data->account_id}}</span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Rate plan </div>

                    <div class="profile-info-value">
                        <span class="editable editable-click" id="signup">{{$data->plan}}</span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Duration </div>

                    <div class="profile-info-value">
                        <span class="editable editable-click" id="login">{{$data->duration}}</span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Bytes In </div>

                    <div class="profile-info-value">
                        <span class="editable editable-click" id="about">{{$data->bytes_up}}</span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Bytes out </div>

                    <div class="profile-info-value">
                        <span class="editable editable-click" id="about">{{$data->bytes_down}}</span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Plan Start Date </div>

                    <div class="profile-info-value">
                        <span class="editable editable-click" id="about">{{$data->plan_start_date}}</span>
                    </div>
                </div>
                    <div class="profile-info-name"> Plan End Date </div>
                    <div class="profile-info-value">
                        <span class="editable editable-click" id="about">{{$data->plan_end_date}}</span>
                    </div>
                </div>
            </div>
        </div>
    @else
    <h5>Empty</h5>
    @endif
                                                        
               
                  
