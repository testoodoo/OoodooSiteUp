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
			<a href="/admin/discounts">Adjustments</a>
		</li>
		<li class="active">
			<a href="/admin/discounts">Create</a>
		</li>
	</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.discounts.store'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						New Discounts
					</h1>
				</div>
				<div class="form-group">
					{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('account_id', $discounts->account_id , array('class' => 'col-xs-10 col-sm-5 account_id','required ')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('amount','Amount', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('amount', $discounts->amount , array('class' => 'col-xs-10 col-sm-5 digits','required ')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('for_month','Select For Month', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
                    <input name="for_month" type="radio" value="current" class="required" /> Current Month 
                                              
                    <input name="for_month" type="radio" value="next" class="required" /> Next Month
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('remarks','Remarks', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::textarea('remarks', $discounts->remarks , array('class' => 'col-xs-10 col-sm-5 required')) }}
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
})
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
        $('.input-daterange').datepicker({autoclose:true});
</script>
<script type="text/javascript">
function datevalue()
{
	var x=$(".for_month").val();
	var d=x.slice(0,2);
	var today= new Date();
	var mm =  x.slice(3,5);
	var yy = x.slice(8,10);
		var monthNames = [ "","Jan", "Feb", "Mar", "Apr", "May", "Jun",
		"Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

	if(d<25){
			var for_month=monthNames[Number(mm)]+'-'+yy  
		}else{
			if(d>=25 && "Dec"==monthNames[Number(mm)] ){
				var for_month=monthNames[01]+'-'+(Number(yy)+1)
			}else{
				var for_month=monthNames[Number(mm)+1]+'-'+yy
			}  
		} 
	$(".for_month").val(for_month);
}
</script>
@stop