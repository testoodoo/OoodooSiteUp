@extends ('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/admin/index">Home</a>
        </li>
        <li class="active">
            <a href="/admin/topup/index">Topup</a>
        </li>
    </ul>
</div>
    <div class="page-header">
        <h1>
            Top up
        </h1>
    </div>
<div class="row">
    {{ Form::open(array('route' => 'admin.topup.showdata','method'=>'post')) }}
    <div class="col-xs-12"><!-- PAGE CONTENT BEGINS -->
        <div class="row form-horizontal">
           <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">ACCOUNT ID</span>
                </label>
              <div class="col-sm-5">
                    <label class="col-sm-6 control-label">
                        @if(count($topup)==0) 
                        {{ Form::text('account_id','', array('class' => 'form-control account_id')) }}
                        {{ Form::hidden('waiver',$waiver, array('class' => 'form-control')) }}
                        @else
                        {{ Form::text('account_id',$plan->account_id, array('class' => 'form-control account_id')) }}
                        @endif
                    </label>
                    @if(count($topup)==0) 
                    <button class="btn btn btn-primary" type="submit">fetch</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{Form::close() }}
 </div>
 @if(count($topup)!=0) 
 <div class="col-sm-12">
        <div class="col-sm-1"></div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">CURRENT PLAN</div>
                <div class="alert alert-danger" >
                {{ Form::text('plan_name',$plan->plan, array('class' => 'form-control plan_name red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">PLAN STRAT DATE</div>
                <div class="alert alert-warning">
                {{ Form::text('plan_start_date',$plan->plan_end_date, array('class' => 'form-control plan_start_date red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">PLAN END DATE </div>
                <div class="alert alert-block alert-success">
                {{ Form::text('plan_end_date',$plan->plan_start_date, array('class' => 'form-control plan_end_date red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
    </div>
        {{ Form::open(array('route' => 'admin.topup.store','method'=>'post')) }}
            {{ Form::hidden('waiver',$waiver, array('class' => 'form-control')) }}
            {{ Form::hidden('speed',$plan_det[0], array('class' => 'form-control')) }}
            {{ Form::hidden('account_id',$plan->account_id, array('class' => 'form-control accountid')) }}
            {{ Form::hidden('old_plan_code',$plan->plan_code, array('class' => 'form-control plan_name')) }}
                <div class="col-sm-12 well">
                    <div class="table-header" align="center">
                     DATA PACKS AND TOP UP SUMMARY
                   </div>
                            <div class="col-sm-5">
                            <table class ="table table-hover personal-task">
                              @foreach($topup  as $value)
                                <tbody>
                                    <tr>
                                        <td>
                                            <span  class="btn btn-xs btn-info">{{$value->data}} GB</span>
                                            <input type="hidden" name="gb{{$value->data}}"  value="{{$value->data}}" class="input-mini">

                                        </td>
                                        <td>
                                            <span  class="btn btn-xs btn-info">र {{$value->cost}}</span>
                                        </td>
                                        <td>
                                            <span class="blue bolder">
                                                <span class='fa fa-close fa-2x'></span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" name="gbr{{$value->data}}"  value="" id="{{$value->data}}gb" oninput="function{{$value->data}}()" class="input-mini requiredone">
                                        </td>
                                        <td>
                                            <input type="text" name="data" value="" id="{{$value->data}}gbr" class="btn btn-xs btn-info "  style="width:50px;">
                                            <input type="text"  value="GB" class="btn btn-xs btn-info"  style="width:50px;">
                                            <input type="hidden" name="cost"  value="" id="{{$value->cost}}cost" class="btn btn-xs btn-info" style="width:50px;">
                                        </td>
                                    </tr>
                                </tbody>
                                <script type="text/javascript">
                                    function function{{$value->data}}() {
                                        var x = document.getElementById("{{$value->data}}gb").value;
                                        if(x>=0){
                                                y=x;
                                            }else{
                                                document.getElementById("{{$value->data}}gb").value='';
                                                alert('Please enter a valid number');

                                                y=0;
                                            }
                                        document.getElementById("{{$value->data}}gbr").value = y *{{$value->data}};
                                        document.getElementById("{{$value->cost}}cost").value = y *{{$value->cost}};
                                        totalset("{{$value->data}}gb");
                                     }
                                </script>
                              @endforeach
                            </table>
                        </div>
                            <div class="col-sm-5">
                                <div class="center">
                                    <h4></h4>
                                    <h4 class="red"> Speed</h4>
                                    <span class="blue bolder">
                                        <h4>{{$plan_det[0]}} Mpbs</h4>
                                    </span>
                                    <h4 class="red"> Total Data</h4>
                                    <input name = "total_data"  id="total_data" type="text" value="0" class="input-mini blue" readonly="true">
                                    <h4 class="red"> Total Amount<h4>
                                    <input name = "total_cost"  id="total_cost" type="text" value="0" class="input-mini blue amount" readonly="true">
                                    <h4></h4>
                                </div>
                       </div>
@else
@endif
                </div>
            <div class="center">
                <button class="btn btn-info button" type="submit">
                                <i class="icon-ok bigger-110"></i>
                                Submit
                </button>
            </div>
        {{Form::close()}}
<script type="text/javascript">
        @if(count($topup)!=0)
            function totalset(z)
            {

                //total for gb calculation get value from individual id by using array
                @foreach($topup as $value)
                var minus=document.getElementById("{{$value->data}}gbr").value;
                if(minus>0){
                    gbvalue{{$value->data}}=minus;
                }else{
                    gbvalue{{$value->data}}=0;
                }
                @endforeach
                //values set into array
                var xvalue=[
                        @foreach($topup as $value)
                        gbvalue{{$value->data}},
                        @endforeach
                       ]
                // array value sum by using for loob
                var xValue = xvalue.length; 
                var totalSum = 0;
                for(var x = 0; x <xValue; x++){
                totalSum += +xvalue[x];
                }

                 //total for gb cost calculation get value from individual id by using array
                @foreach($topup as $value)
                var minus=document.getElementById("{{$value->cost}}cost").value;
                 if(minus>0){
                    gbcost{{$value->cost}}=minus;
                }else{
                    gbcost{{$value->cost}}=0;
                }
                @endforeach

                //values set into array
                var xcost=[
                            @foreach($topup as $value)
                            gbcost{{$value->cost}},
                            @endforeach
                          ]
                  // array value sum by using for loob
                var xCost = xcost.length;  
                var totalCost = 0;

                for(var x = 0; x <xCost; x++){
                totalCost += +xcost[x];
            }
                 document.getElementById("total_cost").value = totalCost;
                 document.getElementById("total_data").value = totalSum;
                 if(totalSum>0){
                      $(".button").show();
                    }else{
                      $(".button").hide();
                    }
            }
        @else
        @endif
    
</script>
<script type="text/javascript">
            $( document ).ready(function() {

                    $( "form" ).submit(function( event ) {
                        if($("#total_data").val()==0){
                          event.preventDefault();
                        }
                    });
                 
                      $(".button").hide();
                  });
              //fetch details by using account id current plan name.. and start_date
                  $('input.fetch_plan_details').click(function()
                  {
                  var account_id = $('.account_id').val();
                  if(account_id.length != 0)
                       {
                            $.ajax(
                            {
                                url :'plandetails',
                                type : 'get',
                                data : { account_id : account_id },
                                success : function(data) {
                                    if (data["found"] == "false") {
                                        alert('Account Id not Found');
                                    } else {
                                        $('.plan_name').val(data['plan_name']);
                                        $('.plan_end_date').val(data['plan_end_date']);
                                        $('.plan_start_date').val(data['plan_start_date']);
                                        $('.accountid').val(account_id);
                                        }
                                    }
                            });
                        }
                    });
    </script>
@stop