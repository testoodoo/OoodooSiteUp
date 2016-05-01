@include('support.partials.css_assets')
@include('support.partials.js_assets')
<title> OoDoO | Support </title>
<div class="page-content" style="width:800px; margin:0 auto;">
    <div class="portlet box mbl" align="center">
        <div class="portlet-header">
            <div class="chat-form">
                <input type="radio" name="connection_type" value="1" checked> Existing Connection
                <input type="radio" name="connection_type" value="2"> New Connection<br>
            </div>
        <div class="caption" id="exist_conn"  style="padding-left: 3.5cm;">
            <div class="chat-form">
                <input name="query" style="width:12cm;" id="input-chat" type="text" placeholder="Please Enter Account ID or Mobile Number..." class="form-control animated fadeInUp">
            </div>
        </div>
<div class="portlet-body" id="new_conn" style="display: none;">
 <form action="/ticket/store" method="post">
                    <div class="form-body pal">
                        <div class="row chat-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">
                                                                    Name</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-user"></i>
                                        
                                        <input id="inputName" name="name" type="text" placeholder="" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPhone" class="control-label">
                                                                    Phone</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-phone"></i>
                                            <input id="inputPhone" name="mobile" pattern="([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})" id="mobisle" placeholder="Phone" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputEmail" class="control-label">
                                                                    E-mail</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-envelope"></i>
                                            <input id="inputEmail" name="email" type="email" placeholder="" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label">Area  </label>
                                    <select class="form-control" name="area" required>
                                        <option value="">Select Area</option>
                                        @foreach($areas as $area )
                                                <option value="{{$area->name}}">
                                                   {{$area->name}}                                                </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputSubject" class="control-label">
                                                                Address</label>
                                        <div class="input-icon right">
                                            <textarea style="height: 3cm;" id="inputSubject" name="address" type="text" placeholder="" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputSubject" class="control-label">
                                                                Remarks</label>
                                        <div class="input-icon right">
                                            <textarea style="height: 3cm;" name="remarks" type="text" placeholder="" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                </div> 
                                    <div class="form-group">
                                        <label for="inputSubject" class="control-label">
                                                                Message</label>
                                        <div class="input-icon right">
                                            <textarea style="height: 3cm;" name="message" type="text" placeholder="" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                </div>                                   
                                </div>

                                    <div class="text-right pal">
                                        <button class="btn btn-primary submitBtn">
                                                        Create</button>
                                    </div>
                                </form>

    </div>
</div>


<div class="portlet-body" id="exist_conn" style="background:#e0e3ed">
    <div class="form-horizontal" id="userDet">
        <div class="panel panel-blue" style="background:#fff;">
            <div class="panel-body">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Door No</th>
                            <th>Address</th>
                            <th style="display: none;">Account ID</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>                
            </div>
        </div>
    </div>
</div>
</div>

