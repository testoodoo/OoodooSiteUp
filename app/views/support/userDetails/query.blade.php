@include('support.partials.css_assets')
<body class="pace-done" style="background:#e0e3ed">
    <div class="col-lg-5 form-horizontal" style="margin-top: 100px; margin-left: 450px">
        <div class="panel panel-blue" style="background:#fff;">
            <div class="panel-heading">
                PLEASE ENTER <i><b>ACCOUNT ID</b></i> OR <i><b>MOBILE NUMBER</b></i>
            </div>
            <div class="panel-body pan ">
                <form action="/query" method="POST">
                    <div class="form-body pal" id="exsistConn">
                        <div class="chat-form">
                            <div class="input-group">
                                <input name="query" id="input-chat" type="text" placeholder="Account ID or Mobile number..." class="form-control"><span id="btn-chat" class="input-group-btn">
                                <button type="submit" class="btn btn-default">
                                    Explore
                                </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
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
</body>

<script>
    function hello(){ 
             jQuery('#content').toggle('hide');
             jQuery('#exsistConn').toggle('hide');
             jQuery('')
    };
</script>

@include('support.partials.js_assets')