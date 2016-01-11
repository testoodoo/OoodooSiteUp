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
	{{ Form::open( array( 'route' => array('admin.billwaiver.edit_update'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		{{ Form::hidden('id',$billwaiver->id, array('class' => 'col-xs-10 col-sm-5')) }}
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
						{{ Form::text('account_id',$billwaiver->account_id, array('class' => 'col-xs-10 col-sm-5 account_id','required')) }}
					</div>
				</div>
				<div class="form-group">
                    {{ Form::label('Select Waiver Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="waiver_type" class="form-control col-sm-6 select_waiver_type required" style="width:340px;" required>
                            @if($billwaiver->amount)
                            <option value="waiver_amount" selected>Waiver Amount</option>
                            @endif
                            @if($billwaiver->waiver_data)
                            <option value="waiver_data" selected>Waiver Data</option>
                            @endif
                            @if($billwaiver->waiver_plan_code)
                            <option value="waiver_plan" selected>Waiver Plan</option>
                            @endif
                        </select>
                    </div>
                </div>
                @if($billwaiver->waiver_plan_code)
                <div class="form-group select_plan_type">
                    {{ Form::label('Select Plan Type', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="waiver_plan_code" class="form-control col-sm-6 plan_type" style="width:340px;">
                            <option value="$billwaiver->waiver_plan_code" selected>{{$plan}}</option>
                            <option value="1439">10-Mbps UNLIMITED PLAN</option>
                            <option value="1440">25-Mbps UNLIMITED PLAN</option>

                        </select>
                    </div>
                </div>
                <div class="form-group select_plan_days">
                    {{ Form::label('Plan No Of days', '',array('class' => 'col-xs-12 col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-5" >
                        <select name="waiver_no_of_days" class="form-control col-sm-6 plan_days" style="width:340px;">
                            <option value="{{$billwaiver->waiver_plan_days}}" selected>{{$billwaiver->waiver_plan_days}} days</option>
                            <option value="5">5 days</option>
                            <option value="8">8 days</option>
                            <option value="10">10 days</option>
                        </select>
                    </div>
                </div>
                @endif
                @if($billwaiver->waiver_data)
                <div class="form-group select_waiver_data">
					{{ Form::label('Waiver Data','Waiver Data', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('waiver_data',$billwaiver->waiver_data, array('class' => 'col-xs-10 col-sm-5 digits data','required')) }}
					</div>
				</div>
				@endif
				@if($billwaiver->amount)
				<div class="form-group select_waiver_amount">
					{{ Form::label('Waiver Amount','Waiver Amount', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('waiver_amount',$billwaiver->amount, array('class' => 'col-xs-10 col-sm-5 digits amount','required')) }}
					</div>
				</div>
				<div class="form-group current for_month">
					{{ Form::label('for_month','Select For Month', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
                    <input name="for_month" type="radio" value="current" class="required"
                     <?= $billwaiver->for_month == date("M-y") ? "checked" : "" ?> /> Current Month
                                              
                    <input name="for_month" type="radio" value="next" class="required"
                    <?= $billwaiver->for_month == date("M-y",strtotime("+1 month")) ? "checked" : "" ?> /> Next Month
						<!-- {{ Form::text('for_month','', array('class' => 'col-xs-10 col-sm-5 date-picker for_month ','onchange' =>'datevalue()','required ')) }} -->
					</div>
				</div>
				@endif
				<div class="form-group">
					{{ Form::label('remarks','Remarks', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::textarea('remarks',$billwaiver->remarks, array('class' => 'col-xs-10 col-sm-5 required',)) }}
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
	format : 'dd-mm-yyyy',
});
</script>
@stop