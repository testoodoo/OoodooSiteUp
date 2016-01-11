@extends ('user._layouts.default')
@section('main')

<!-- Topup block start-->
{{ Form::open( array( 'route' =>'users.topup.topup', 'method' => 'POST'))}}
    <div class="row">
        <div class="col-lg-12">
            <div class = "panel" align="center">
                <div class = "modal-header">
                    <h3><b>TOP UP</b></h3>
                </div>
                <section class = "panel-body">
                    <b> SELECT SPEED : </b>
                        @foreach($topup as $top)
                            <button  type = "submit" name = "speed_mbps" class="btn btn-primary btn-lg" value = "{{$top->speed}}" ><b>{{ $speed_value[0] }} mbps</b></button>   &nbsp;
                        @endforeach
                </section>
            </div>
        </div>
    </div>
{{Form::close() }}
<!-- Topup block end-->

<!--Data packs blocks start-->
@if($data_gb!= NULL)
    {{ Form::open( array( 'route' =>'users.topup.topup_store', 'method' => 'POST'))}}
    {{ Form::hidden('old_plan_code',$old_plan_code, array('class' => 'form-control')) }}
    {{ Form::hidden('data_used',$data_used, array('class' => 'form-control')) }}
    <div class="col-lg-6">
        <div class = "panel">
            <div class="modal-header">
                <h3>Data Packs</h3>
            </div>
            <input type = "hidden" name = "speed_mbps" value = "{{$speed_mbps}}">
            <table class="table table-hover personal-task"><br>
                @foreach($data_gb as $data)
                    <tbody>
                        <tr>
                            <td>
                                <span class = "btn btn-xs btn-info" style = "width:60px;">{{$data->data}} GB</span>
                                <input type = "hidden" name="gb{{$data->data}}" value ="{{$data->data}}">
                            </td>
                            <td>
                                <span class = "btn btn-xs btn-success" style="width:60px;">₹ {{$data->cost}}</span>
                            </td>      
                            <td>
                                <section class = "fa fa-times">
                                </section>
                            </td>
                            <td>
                                <input type="text" style="width:50px;" name = "gbr{{$data->data}}" value = "" id="{{$data->data}}gb" oninput="function{{$data->data}}()">
                                </td>
                            <td>
                                <b>=</b>
                            </td>
                            <td>
                                <span class = "btn-group  btn-group-justified" style="width:100px;" >
                                    <input type="text" name = "data" value="" class="btn btn-info" id="{{$data->data}}gbr"  style="width:50px;height:23px;" readonly>
                                    <input class = "btn btn-info" style="width:50px;height:23px;" value ="GB" readonly>
                                </span>
                                <input type="hidden" name ="cost" value="" id ="{{$data->cost}}cost">
                            </td>
                        </tr>
                    </tbody>

                        <script type="text/javascript">
                            function function{{$data->data}}(){
                                var x =  document.getElementById("{{$data->data}}gb").value;
                                if(x>=0){
                                    y=x;
                                }else{
                                    alert('Please enter a valid number');
                                    y=0;
                                }
                                document.getElementById("{{$data->data}}gbr").value = {{$data->data}} * y;
                                document.getElementById("{{$data->cost}}cost").value = {{$data->cost}} * y;
                                totalset("{{$data->data}}gb");
                            }
                        </script>
                @endforeach
            </table>
        </div>
    </div>

<!--Data packs block end-->

<!-- Topup summary block start-->
    <div class="col-lg-6">
        <section class="panel">
            <div class="modal-header">
               <h3>Topup Summary</h3>
            </div>
                    <div class="weather-category twt-category">
                        <ul>
                            <b>
                            <li class="active">
                                <span class = "btn-group btn-group-justified">
                                    <input type="text" class = "btn btn-success" style = "width:135px" value="{{$speed_value[0]}} Mbps" readonly>
                                    <input name = "speed_mbps" type="hidden" value="{{$speed_mbps}}">
                                </span>
                                Speed
                            </li>
                            <li class="active">
                                <span class = "btn-group btn-group-justified">
                                    <input type = "text" name = "total_data" class = "btn btn-success" id = "total_data" style="width:50px;" value ="0" readonly>
                                    <input class = "btn btn-success" value = "GB" style = "width:50px" readonly>
                                </span>
                                Total Data
                            </li>                
                            <li>
                                <span class = "btn-group btn-group-justified">
                                    <input class = "btn btn-success" value = "₹" style = "width:50px" readonly>
                                    <input type="text" name = "total_cost" class = "btn btn-success" id = "total_cost" style = "width:100px" value="0" oninput="buttons();" readonly>
                                </span>
                                Total Amount
                            </li>
                            </b>
                        </ul>
                    </div>
                    <footer class="twt-footer">
                        <p>
                            (This Topup is valid till the end date of Bill cycle)
                        </p>
                        <input value = "Pay" type = "submit" class="btn btn-space btn-success" id="button" disabled>
                    </footer>
                {{Form::close() }}
        </section>
@endif
    </div>

<script type="text/javascript">
    @if($data_gb != NULL)
    function totalset(z)
        {
        //total for gb calculation get value from individual id by using array
            @foreach($data_gb as $value)
            var minus=document.getElementById("{{$value->data}}gbr").value;
                if(minus>0){
                    gbvalue{{$value->data}}=minus;
                }else{
                    gbvalue{{$value->data}}=0;
                }
                @endforeach
                //values set into array
                var xvalue=[
                        @foreach($data_gb as $value)
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
                @foreach($data_gb as $value)
                var minus=document.getElementById("{{$value->cost}}cost").value;
                 if(minus>0){
                    gbcost{{$value->cost}}=minus;
                }else{
                    gbcost{{$value->cost}}=0;
                }
                @endforeach

                //values set into array
                var xcost=[
                            @foreach($data_gb as $value)
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
                 if(totalCost > 0){
                    document.getElementById("button").disabled = false;
                 }
                 else{
                    $('#'+z).val('');
                    $('#'+z+'r').val('');
                    document.getElementById("button").disabled = true;                
                 }
                   
    }

    @else
@endif

    
</script>



<!-- Topup summary block end-->
@stop