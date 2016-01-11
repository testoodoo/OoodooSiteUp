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
            <a href="/admin/planchange/index">Planchange</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Plan Change
    </h1>
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            {{ Form::open( array( 'route' => array('admin.planchange.store'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
            <label class="col-sm-3 control-label">
                <span class="blue bolder">ACCOUNT ID
                </label>
            </span>
            <div class="col-sm-5">
                <label class="col-sm-10 control-label">
                    {{ Form::text('account_id','', array('class' => 'form-control account_id')) }}
                    {{ Form::hidden('used_days','', array('class' => 'form-control used_days')) }}
                    {{ Form::hidden('old_plan_code','', array('class' => 'form-control old_plan_code')) }}

                </label>
                <input class="btn btn-info fetch_account_id" type="button" value="fetch">
            </div>
        </div>
    </div>
</div>
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div class="center">
            <div class="table-header">
                              PLAN CHANGE
                              </div>
        </div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">
                              CURRENT PLAN
                              </div>
                <div class="alert alert-danger" >
                      {{ Form::text('old_plan','None', array('class' => 'form-control old_plan red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">
                                STRAT DATE
                              </div>
                <div class="alert alert-warning">
                      {{ Form::text('start_date','None', array('class' => 'form-control start_date red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">
                                DATA USED
                              </div>
                <div class="alert alert-block alert-success">
                      {{ Form::text('gb_percent','None', array('class' => 'form-control gb_percent red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="center">
                <div class="table-header">
                                BALANCE  र 
                              </div>
                <div class="alert alert-info">
                      {{ Form::text('bill_balance','None', array('class' => 'form-control bill_balance red','readonly'=>'true')) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <div class="dd2-content btn-info no-hover" align="center">PLAN CHANGE
          </div>
        <div class="well">
            <div class="form-group">
                <label for="exampleInputPassword1">Plan Start Date</label>
                <input name = "plan_start_date" value="" class="form-control date-picker red plan_start" placeholder="Plan Start Date">
            </div>
            <div>
                <label>Subscription</label>
                <select class="form-control"  name="monthly_subs" onChange="plandet();">
                    <option value="">Subscription</option>
                    @foreach($normal_plan as $plan)
                    <option value = "{{$plan->subs}}">{{$plan->subs}}</option>
                    @endforeach
               </select>
            </div>
              <div>
                <label>Plans</label>
                <select class="form-control" name = "new_plan_code" id="month_sub" onChange = "plan_change();">
                    <option value="">Plans</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Plan Amount</label>
                <input name = "plan_amount" value="" class="form-control plan_cost_tax red" placeholder="Plan Amount" readonly>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Prorata Balance</label>
                {{ Form::text('prorata_balance','None', array('class' => 'form-control prorate_balance red','readonly'=>'true')) }}
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Prorata Cost</label>
                <input name = "prorata_cost" value="" class="form-control prorata_cost red" placeholder="Prorata Balance" readonly>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Prorata Discount</label>
                <input name = "prorata_discount" value="" class="form-control prorata_dis red" placeholder="Prorata Discount" readonly>
            </div>                
            <div class="form-group">
                <label for="exampleInputPassword1">Payable Amount</label>
                <input name = "payable_amount" value="" class="form-control payable_amt red" placeholder="Payable Amount" readonly>
            </div>
            <div>
            (Plan change is valid till end of the bill cycle)              
            <button type="submit" class="btn btn-info">Submit</button>
                      </div>
                  </section>
            </div>
            {{ Form::close() }}
        </div>
    </div>
<script type="text/javascript">

$('.date-picker').datepicker({
    autoclose: true,
    todayHighlight: true,
    format : 'yyyy-mm-dd',
});
  
                 function plandet() 
                   {
                   var month_sub = $('select[name="monthly_subs"]').val();
                   //alert(month_sub);
                    if (month_sub.length != 0) {
                      $.ajax({
                            url:'monthSub',
                            type:'GET',
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
                    var plan = $('select[name="new_plan_code"]').val();
                    var prodata_bal = $('.prorate_balance').val();
                    var account_id=$('.account_id').val();
                    var plan_start=$('.plan_start').val();


                    if (plan.length != 0) {
                      $.ajax({
                            url:'fetchPlanDet',
                            type:'GET',
                            data: { plan_code : plan, prodata_bal : prodata_bal,account_id:account_id,plan_start:plan_start},
                            success : function(data) {
                                if (data["found"] == "false") {
                                    alert('Plan not Found');
           
                                } else {
                                    $('.plan_desc').val(data['plan_desc']);
                                    $('.plan_cost_tax').val(data['plan_cost_tax']);
                                    $('.plan_amt').val(data['plan_amt']);
                                    $('.payable_amt').val(data['payable_amt']);
                                    $('.prorata_cost').val(data['prorata_cost']);
                                    $('.prorata_dis').val(data['prorata_dis']);
                                  
                                    }
                            }
                        });
                    }
                    };


</script>
@stop