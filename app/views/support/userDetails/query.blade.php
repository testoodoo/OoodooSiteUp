@include('support.partials.css_assets')
<body class="pace-done" style="background:#e0e3ed">
    <div class="col-lg-5 form-horizontal" style="margin-top: 100px; margin-left: 450px">
        <div class="panel panel-blue" style="background:#fff;">
            <div class="panel-heading">
                PLEASE ENTER <i><b>ACCOUNT ID</b></i> OR <i><b>MOBILE NUMBER</b></i>
            </div>
            <div class="panel-body pan ">
                    <div class="form-body pal" id="exsistConn">
                        <div class="chat-form">
                            <div class="input-group">
                                <input name="query" id="input-chat" type="text" placeholder="Account ID or Mobile number..." class="form-control"><span id="btn-chat" class="input-group-btn">
                                <button class="btn btn-default" onclick="userDet();">
                                    Explore
                                </button>
                                </span>
                            </div>
                        </div>
                    <div class="panel-heading" style="display:none;" id="errorMsg">
                    <h3 style="color:red;"> Please enter valid credentials<h3>
                    </div>
                    </div>
                <div class="col-lg-9" id="content" style="display:none;">
                    <div class="form-body pal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <input id="inputName" type="text" placeholder="Name" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <input id="inputMobile" type="text" placeholder="Mobile No" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon right">
                                <i class="fa fa-envelope"></i>
                                <input id="inputEmail" type="text" placeholder="Email address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea rows="5" class="form-control" placeholder="Address"></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control">
                                <option value="">Select Area</option>
                                @foreach($areas as $area)
                                    <option value="{{$area->name}}">{{$area->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea rows="5" class="form-control" placeholder="Remarks"></textarea>
                        </div>  
                    </div>
                </div> 

                <div class="text-left pal">
                    <button type="submit" class="btn btn-primary" onclick="hello();" value='hide/show'>
                    New Connection</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 form-horizontal" style="margin-top: 10px; margin-left: 450px; display:none; " id="userDet">
        <div class="panel panel-blue" style="background:#fff;">
            <div class="panel-heading">
                Account Details
            </div>
            <div class="panel-body">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                </table>                
            </div>
        </div>
    </div>
</body>

<script>
    function hello(){ 
             jQuery('#content').toggle('hide');
             jQuery('#exsistConn').toggle('hide');
             jQuery('#userDet').toggle('hide')
    };
    function userDet(){
        $('#myTable > thead').empty();
        var query = $('#input-chat').val();
        if(query.length != 0){
            $.ajax({
                url:'userDetails',
                type:'POST',
                dataType: 'json',
                data: { query : query },
                success:function(json){
                    $.each(json, function(index, value){
                        if(value.length != 0){
                            $.each(value, function(index, value){
                                $("#errorMsg").hide();
                                $("#userDet").show();
                                $("#myTable > thead").append("<tr><td>"+value.first_name+"</td><td>"+value.address1+value.address2+value.address3+"</td></tr>");                   
                            });
                        }
                        else{
                            $("#errorMsg").show();
                            $("#userDet").hide();
                        }

                    });
                }
            });
        }
    };
</script>

@include('support.partials.js_assets')