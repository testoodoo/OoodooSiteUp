<div class="form-group">
	{{ Form::label('account_id','Account ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('account_id', $devicecosts->account_id , array('class' => 'col-xs-10 col-sm-5 required account_id')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('amount','Amount', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('amount', $devicecosts->amount , array('class' => 'col-xs-10 col-sm-5 required digits')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('for_month','For Month', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::text('for_month', $devicecosts->for_month , array('class' => 'col-xs-10 col-sm-5 date-picker for_month ','onchange' =>'datevalue()','required ')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('remarks','Remarks', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		{{ Form::textarea('remarks', $devicecosts->remarks , array('class' => 'col-xs-10 col-sm-5 required')) }}
	</div>
</div>
<div class="form-group">
	{{ Form::label('is_considered','Is considered', array('class' => 'col-sm-3 control-label no-padding-right'))}}
	<div class="col-sm-9">
		@if( $devicecosts->is_considered == 1)
			{{ Form::checkbox('is_considered', $devicecosts->is_considered, null, array('checked' => 'checked'),'disabled') }}
		@else
			{{ Form::checkbox('is_considered','disabled') }}
		@endif
	</div>
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