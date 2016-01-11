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
		<a href="/admin/billwaiver/index">Bill Viewer</a>
	</li>
	<li class="active">
		<a href="/admin/billwaiver/create">Create</a>
	</li>
</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.billwaiver.store'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Bill Waiver
					</h1>
				</div>
				<div class="form-group">
					{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('account_id','', array('class' => 'col-xs-10 col-sm-5 account_id','required')) }}
					</div>
				</div>
                <div class="form-group">
                    {{ Form::label('Select Waiver Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="waiver_type" class="form-control col-sm-6 select_waiver_type required" style="width:340px;" required>
                            <option value="">Select Waiver type</option>
                            <option value="waiver_amount">Waiver Amount</option>
                            <option value="waiver_data">Waiver Data</option>
                            <option value="waiver_plan">Waiver Plan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group waiver_start-date">
                    {{ Form::label('Waiver Start Date','Waiver Start Date', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-9">
                        {{ Form::text('waiver_start_date','', array('class' => 'col-xs-10 col-sm-5 date-picker')) }}
                    </div>
                </div>
                <div class="form-group select_plan_type">
                    {{ Form::label('Select Plan Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="waiver_plan_code" class="form-control col-sm-6 plan_type" style="width:340px;">
                            <option value="">Select Plan type</option>
                        </select>
                    </div>
                </div>
                <div class="form-group select_plan_days">
                    {{ Form::label('Plan No Of days', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="waiver_no_of_days" class="form-control col-sm-6 plan_days" style="width:340px;">
                            <option value="">Plan No Of days</option>
                        </select>
                    </div>
                </div>
                <div class="form-group select_waiver_data">
					{{ Form::label('Waiver Data','Waiver Data', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-5">
						{{ Form::text('waiver_data','', array('class' => 'col-xs-10 col-sm-5 digits data','placeholder'=>'Data In GB')) }}
					</div>
				</div>
				<div class="form-group select_waiver_amount">
					{{ Form::label('Waiver Amount','Waiver Amount', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('waiver_amount','', array('class' => 'col-xs-10 col-sm-5 digits amount')) }}
					</div>
				</div>
				<div class="form-group current for_month">
					{{ Form::label('for_month','Select For Month', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
                    <input name="for_month" type="radio" value="current" class="required" /> Current Month 
                                              
                    <input name="for_month" type="radio" value="next" class="required" /> Next Month
						<!-- {{ Form::text('for_month','', array('class' => 'col-xs-10 col-sm-5 date-picker for_month ','onchange' =>'datevalue()','required ')) }} -->
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('remarks','Remarks', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::textarea('remarks','', array('class' => 'col-xs-10 col-sm-5 required',)) }}
					</div>
				</div>
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close(); }}
</div>
<script type="text/javascript">
	$('.date-picker').datepicker({
	autoclose: true,
	todayHighlight: true,
	format : 'yyyy-mm-dd',
})
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
        $('.input-daterange').datepicker({autoclose:true});
$(document).ready(function(){
	$('.select_plan_days').hide();
	$('.select_plan_type').hide();
    $('.select_waiver_amount').hide();
    $('.select_waiver_data').hide();
    $('.waiver_start-date').hide();
    $('.for_month').hide();
});

$('select.select_waiver_type').change(function(){
            if ($(this).val() == "waiver_plan") {
            	$('.select_waiver_amount').hide();
            	$('.select_waiver_data').hide();
            	$('.amount').val(0);
            	$('.data').val(0);
    			$('.for_month').hide();
                $('.select_plan_type').show();
                $('.waiver_start-date').show();
                $('.plan_type').empty();
                $('.plan_type').append(new Option("Select Plan Type",""));
                $('.plan_type').append(new Option("10-Mbps UNLIMITED PLAN","1439"));
                $('.plan_type').append(new Option("25-Mbps UNLIMITED PLAN","1440"));
                $('.select_plan_days').show();
                $('.plan_days').empty();
                $('.plan_days').append(new Option("Select Plan Days",""));
                $('.plan_days').append(new Option("10 plan days","10"));
                $('.plan_days').append(new Option("8 plan days","8"));
                $('.plan_days').append(new Option("5 plan days","5"));
            }else if($(this).val() == "waiver_amount"){
            	$('.data').val(0);
            	$('.plan_type').empty();
            	$('.plan_days').empty();
                $('.select_waiver_amount').show();
                $('.for_month').show();
                $('.select_waiver_data').hide();
                $('.select_plan_days').hide();
				$('.select_plan_type').hide();
                $('.waiver_start-date').hide();
            }else if($(this).val() == "waiver_data"){
            	$('.amount').val(0);
            	$('.plan_type').empty();
            	$('.plan_days').empty();
            	$('.select_waiver_amount').hide();
   				$('.for_month').hide();
                $('.select_waiver_data').show();
                $('.select_plan_days').hide();
				$('.select_plan_type').hide();
                $('.waiver_start-date').hide();
            }
        });
</script>
@stop