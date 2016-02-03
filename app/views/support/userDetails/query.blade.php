@include('support.partials.css_assets')
<body class="pace-done" style="background:#e0e3ed">
    <div class="col-lg-5 form-horizontal" style="margin-top: 100px; margin-left: 450px">
        <div class="panel panel-blue" style="background:#fff;">
            <div class="panel-heading" id="exsistCon">
                PLEASE ENTER <i><b>ACCOUNT ID</b></i> OR <i><b>MOBILE NUMBER</b></i>
            </div>
            <div class="panel-heading" id="newCon" style="display:none;">
                Enter the below details
            </div>            
            <div class="panel-body pan ">
                    <div class="form-body pal" id="exsistConn">
                        <div class="chat-form">
                            <div>
                                <input name="query" id="input-chat" type="text" placeholder="Account ID or Mobile number..." class="form-control" onInput="userDet();">
                            </div>
                        </div>
                    <div class="panel-heading" style="display:none;" id="errorMsg">
                    <h3 style="color:red;"> Please enter valid credentials<h3>
                    </div>
                    </div>
                <form action="#" class="form-horizontal">
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
                                <input id="inputEmail" type="email" placeholder="Email address" class="form-control">
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
                </form>
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
                    <tbody>
                    </tbody>
                </table>                
            </div>
        </div>
    </div>
</body>

<script>
    function hello(){ 
             jQuery('#content').toggle('hide');
             jQuery('#exsistConn').toggle('hide');
             jQuery('#newCon').toggle('hide');
             jQuery('#exsistCon').toggle('hide');
    };
    function userDet(){
        $('#myTable > tbody').empty();
        var query = $('#input-chat').val();
        if(query.length > 4){
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
                                $("#myTable > tbody").append("<tr style='cursor:pointer;' onclick='rowClick(\""+value.account_id+"\")'><td>"+value.first_name+"</td><td>"+value.address1+"&nbsp;&nbsp;"+value.address2+"&nbsp;&nbsp;"+value.address3+"</td></tr>");
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

function rowClick(account_id){
    window.location.href="/userDet/"+account_id;
};
</script>

@include('support.partials.js_assets')