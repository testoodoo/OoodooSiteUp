@extends ('user._layouts.default')
@section('main')
{{ Form::open( array( 'route' =>'users.planchange.planchange_store', 'method' => 'POST','class'=>'validate-form'))}}
    <input name = "used_day" type = "hidden" value = "{{$used_day}}">
    <input name ="old_plan_code" type="hidden" value ="{{$old_plan_code}}">
    
<!-- Current plan block start-->

    <div class = "panel">
        <div class = "modal-header" align="center">
            <h3> Current Plan</h3>
        </div>
    </div>
            
    <div class="row state-overview">
        
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-bars" ></i>
                </div>
                <div class="value">
                    <h4 class="count">{{$plan->plan}}</h4>
                    <p>Current Plan</p>
                </div>
            </section>
        </div>

        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                  <i class="fa fa-calendar-o"></i>
                </div>
                <div class="value">
                    <h4 class="count4">{{Auth::user()->get()->plan()->plan_start_date}}</h4>
                    <input name ="plan_start_date" type="hidden" value = "{{Auth::user()->get()->plan()->plan_start_date}}">
                    <p>Plan Start Date</p>
                </div>
            </section>
        </div>

        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-download"></i>
                </div>
                <div class="value">
                    <h4 class=" count4">{{Auth::user()->get()->data_usage_in_gb()}} GB</h4>
                    <input name ="total_usage" type="hidden" value = "{{Auth::user()->get()->data_usage_total_gb()}}">
                    <p>Data Used</p>
                </div>
            </section>
        </div>

        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-money"></i>
                </div>
                <div class="value">
                    <h4 class="count4">₹ {{$bill_bal}}</h4>
                    <input name = "old_balance" type = "hidden" value ="{{$bill_bal}}">
                    <p>Balance</p>
                </div>
            </section>
        </div>

    </div>

<!-- Current plan block end-->

<!-- plan change block start-->
    <div class = "col-lg-3"></div>
    <div class="col-lg-6">
        <section class="panel">
            <header class="modal-header">
                <b><h3>Plan Change</h3></b>
            </header>

            <div class="panel-body">
                <div class="form-group">
                    <label for="exampleInputPassword1">Plan Start Date</label>
                    <input name = "plan_start_date" value="" class="form-control date-picker red plan_start" placeholder="Plan Start Date">
                </div>
                <div class="form-group">
                    <label>Subscription</label>
                        <select name = "monthly_subs" class="form-control discount" onChange = "Plandet();">
                           <option value = " ">Subscription</option>
                            @foreach($normal_plan as $plan)
                                <option value = "{{$plan->subs}}">{{$plan->subs}}</option>
                            @endforeach
                        </select> 
                </div>
                <div class="form-group">
                    <label>Select Plan</label>
                        <select name = "plan_code" id = "month_sub" class="form-control plan" onChange = "plan_change();">
                            <option value = "">Select Plan</option>
                        </select> 
                </div>
                <div class="form-group">
                    <label>
                        Plan Amount 
                    </label>
                    <sup> 
                        [Inclusive Tax]
                    </sup>
                    <input class="form-control plan_cost_tax" name = "plan_amount" placeholder="Plan Amount" readonly>
                </div>
                <div class="form-group" title = "Number of used days or data converted to amount.it is applicable only with in plancycle">
                        <label>
                            Usage Prorata Cost [?] 
                        </label>                                   
                    <!-- <div style="float:right;">
                        <a href = "/faq" target = "blank">
                            [FAQ]
                        </a>
                    </div> -->
                    <input name = "prorata_bal" id="prorata_bal" type="value" class="form-control prorata_balance" placeholder="Usage Prorata Cost NULL" value="{{$prorata_bal}}" readonly>
                </div>
                <div class="form-group" title = "Amount to be paid from today till the end date of current bill cycle">
                        <label>
                            Prorata Cost [?]
                        </label>                                   
                    <input class="form-control prorata_cost" name = "prorata_cost" placeholder="Prorata Cost" readonly>
                </div>
                <div class="form-group discount_field" title = "Amount for the unused days in the New plan" style="display:none">
                        <label>
                            Prorata Discount [?]
                        </label>
                    <input class="form-control prorata_dis" name = "prorata_dis" placeholder="Prorata Discount" value = "0" readonly>
                </div>                
                <div class="form-group">
                    <label>
                        Payable Amount
                        <sup>*</sup>
                    </label>
                    <input class="form-control payable_amount" name = "payable_amount" placeholder="Payable Amount" readonly>
                </div>
                <sup>* minimum charge applicable.</sup><br>
                <sup>* existing balance amount and plan data will be expired.</sup>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="tc" value="tc" class="required">
                            I accept 
                            <a href="http://www.oodoo.co.in/legal/" target="_blank">
                                Terms and Conditions
                            </a>
                        <br>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" id = "btn" class="btn btn-success"  disabled>Pay</button>
                </div>
        </section>
    </div>
{{ Form::close() }}
<!-- plan change block end-->



<script type="text/javascript">
$('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true,
    format : 'yyyy-mm-dd',
});

        $('.discount').click(function(){
            var discount = $(this).val();
            if (discount == "Monthly") {
                $('.discount_field').show();
            } else {
                $('.discount_field').hide();
            }
        });

    function Plandet() 
       {
       var month_sub = $('select[name="monthly_subs"]').val();
        if (month_sub.length != 0) {
          $.ajax({
                url:'month_sub',
                type:'POST',
                data: {month_sub : month_sub},
                dataType: 'json',
                success : function(json) {
                    $('#month_sub').empty();                                   
                    $.each(json, function(i, optionHtml){
                    $('#month_sub').append(new Option(optionHtml,i));

                    });
                    }
                  });

                }
        };

    function plan_change() {
        var plan = $('select[name="plan_code"]').val();
        var plan_start=$('.plan_start').val();
        document.getElementById("btn").disabled = false;
        var prorata_bal = document.getElementById("prorata_bal").value;


        if (plan.length != 0) {
          $.ajax({
                url:'plan_change/fetch_plan_det',
                type:'GET',
                data: { plan_code : plan, prorata_bal : prorata_bal,plan_start:plan_start},
                success : function(data) {
                    if (data["found"] == "false") {
                        alert('Plan not Found');

                    } else {
                        $('.plan_cost_tax').val(data['plan_cost_tax']);
                        $('.plan_amt').val(data['plan_amt']);
                        $('.payable_amount').val(data['payable_amt']);
                        $('.prorata_cost').val(data['prorata_cost']);
                        $('.prorata_dis').val(data['prorata_dis']);
                    }
                }
            });
          }
        };


</script>

@stop






        if(query.length != 0){
            $.ajax({
                url:'userDetails',
                type:'POST',
                data: { query : query },
                success: function(result){
                    $.each(result, function(index, value){
                        alert(index.length);
                        $('#responsecontainer').append('<tr>><td>'.value[i].account_id.'</td></tr>');
                        i = i+1;
                        $('#responsecontainer').append(accDet);
                    });
                }

            });
        }