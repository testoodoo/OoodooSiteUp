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
			<a href="/admin/switch_router/stock_in">Stock In</a>
		</li>
	</ul>
</div>
{{ Form::open( array( 'route' => array('admin.switch_router.create_stock_in'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
	<div class="row">
		<div class="col-xs-12">
			<div class="page-header">
				<h1>
					Add Incomming Stock
				</h1>
			</div>
			<div class="form-group">
				{{ Form::label('MATERIAL TYPE','MATERIAL TYPE', array('class' => 'col-sm-3 control-label no-padding-right'))}}
				<div class="col-sm-9">
					<select  name="material_type" class="select2 material_type"
                             data-placeholder="Select Material Type" required>
                        	<option value=""></option>
                        	@foreach($stocks as $value)
                            <option value="{{$value->material_name}}-{{$value->brand}}">{{$value->material_name}}-{{$value->brand}}</option>
                   			@endforeach
                    </select>
				</div>
			</div>
			<input type="hidden" name='type' class="form-control type" readonly="true"/>
			<!-- <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
                     TYPE
                </label>
                <div class="col-xs-12 col-sm-9">
                    <select  name="type" class="select2 type"
                             data-placeholder="Select Type" required>
                        	<option value=""></option>
                            <option value="meters">Meters</option>
                            <option value="total_count">Multi Count</option>
                            <option value="individual_count">individual count</option>
                    </select>
                </div>
        	</div> -->
			<div class="form-group">
				{{ Form::label('DATE','DATE', array('class' => 'col-sm-3 control-label no-padding-right'))}}
				<div class="col-sm-9">
					{{ Form::text('date','', array('class' => 'col-xs-10 col-sm-5 datepicker','required')) }}
				</div>
			</div>
			<div class="form-group totals">
				{{ Form::label('TOTAL METER','TOTAL METER', array('class' => 'col-sm-3 control-label no-padding-right'))}}
				<div class="col-sm-9">
					{{ Form::text('final_meter','', array('class' => 'col-xs-10 col-sm-5 t_meters')) }}
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('TOTAL COUNT','TOTAL COUNT', array('class' => 'col-sm-3 control-label no-padding-right'))}}
				<div class="col-sm-9">
					{{ Form::text('final_count','', array('class' => 'col-xs-10 col-sm-5 final_count','required')) }}
				</div>
			</div>
			<div class="meter">
				<div class="col-sm-12">
					<h4 class="col-sm-2 blue">DRUM NO</h4>
					<h4 class="col-sm-2 blue">FORM</h4>
					<h4 class="col-sm-2 blue">TO</h4>
					<h4 class="col-sm-2 blue">TOTAL</h4>
				</div>
				<div class="form-group col-sm-12">
						<div class="col-sm-2">
							<input type="text" name='meter_drum_no[]' value="1"  placeholder='Drum No' class="form-control drum_no" readonly="true"/>
						</div>	
						<div class="col-sm-2">		
							<input type="text" name='from_meter[]' placeholder='From Meter' class="form-control from_meter1" />
						</div>
						<div class="col-sm-2">
							<input type="text" name='to_meter[]' placeholder='To Meter' class="form-control to_meter1" onchange="TotalMeterCalc(1)" />
						</div>
						<div class="col-sm-2">
							<input type="text" name='total_meter[]' placeholder='Total Meter' class="form-control t_meter1" readonly="true"/>
						</div>
						<span class="btn btn-minier btn-primary" onclick="addMeter()">ADD</span>
				</div>
			</div>
			<div class="count">
				<div class="col-sm-12">
					<h4 class="col-sm-2 blue">NO</h4>
					<h4 class="col-sm-2 blue">SRL NO</h4>
					<h4 class="col-sm-2 blue">MAC ADDRESS</h4>
					<h4 class="col-sm-2 blue">COUNT</h4>
				</div>
				<div class="form-group col-sm-12">
						<div class="col-sm-2">
							<input type="text" name='no[]' value="1" placeholder='No' class="form-control no" readonly="true"/>
						</div>	
						<div class="col-sm-2">		
							<input type="text" name='srl_no[]' placeholder='Srl No' class="form-control srl_no"  readonly="true"/>
						</div>
						<div class="col-sm-2">
							<input type="text" name='mac_address[]' placeholder='Mac Address' class="form-control mac_address" readonly="true"/>
						</div>
						<div class="col-sm-2">
							<input type="text" name='count[]' placeholder='Select Material Count' class="form-control m_count1" readonly="true"/>
						</div>
						<span class="btn btn-minier btn-primary" onclick="addCount()">ADD</span>
				</div>
			</div>
		</div>
	</div>
	<div class="space-8"></div>
	<div class="col-md-offset-4 col-md-9">
		{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
	</div>
{{ Form::close(); }}

<script type="text/javascript">
	$('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

	$('.select2').css('width','400px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });

    $("body").on("click", ".delete", function (e) {
    		var t=$('.final_count').val();
    		$('.final_count').val(t-1);
    		afterDelete(t-1);
            $(this).parent("div").remove();
         });

function afterDelete(x){
	var count=x;
	var type=$('.type').val();
	if(!type){
		alert('Please Select Type !!!!');
		$(this).val(0);
	}else{
		$('.dum').remove();
		for (var i=1; i < count; i++) {
				if(type=="others"){
					$(".count").append('<div class="form-group col-sm-12 dum"><div class="col-sm-2"><input type="text" name="no[]" value="'+(i+1)+'" placeholder="No" class="form-control no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="srl_no[]" placeholder="Srl No" class="form-control srl_no" /></div><div class="col-sm-2"><input type="text" name="mac_address[]" placeholder="Mac Address" class="form-control mac_address"/></div><div class="col-sm-2"><input type="text" name="count[]" placeholder="Select Material Count" class="form-control m_count'+(i+1)+'" readonly="true"/></div><span class="btn btn-minier btn-primary" onclick="addCount()">ADD</span>&nbsp;&nbsp;&nbsp;<span class="btn btn-minier btn-primary delete">DELETE</span></div>');
				}else{
					$(".meter").append('<div class="form-group col-sm-12 dum"><div class="col-sm-2"><input type="text" name="meter_drum_no[]" value="'+(i+1)+'" placeholder="Drum No" class="form-control drum_no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="from_meter[]" placeholder="From Meter" class="form-control from_meter'+(i+1)+'"/></div><div class="col-sm-2"><input type="text" name="to_meter[]" placeholder="To Meter" class="form-control to_meter'+(i+1)+'" onchange="TotalMeterCalc('+(i+1)+')"/></div><div class="col-sm-2"><input type="text" name="total_meter[]" placeholder="Total Meter" class="form-control t_meter'+(i+1)+'" readonly="true"/></div><span class="btn btn-minier btn-primary" onclick="addMeter()">ADD</span>&nbsp;&nbsp;&nbsp;<span class="btn btn-minier btn-primary delete">DELETE</span></div>');
				}
	     	}
	}
}

$('.final_count').change(function(){
	var count=$(this).val();
	var type=$('.type').val();
	if(!type){
		alert('Please Select Type !!!!');
		$(this).val(0);
	}else{
		$('.dum').remove();
		for (var i=1; i < count; i++) {
				if(type=="others"){
					$(".count").append('<div class="form-group col-sm-12 dum"><div class="col-sm-2"><input type="text" name="no[]" value="'+(i+1)+'" placeholder="No" class="form-control no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="srl_no[]" placeholder="Srl No" class="form-control srl_no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="mac_address[]" placeholder="Mac Address" class="form-control mac_address"/></div><div class="col-sm-2"><input type="text" name="count[]" placeholder="Select Material Count" class="form-control m_count'+(i+1)+'" readonly="true"/></div><span class="btn btn-minier btn-primary" onclick="addCount()">ADD</span>&nbsp;&nbsp;&nbsp;<span class="btn btn-minier btn-primary delete">DELETE</span></div>');
				}else{
					$(".meter").append('<div class="form-group col-sm-12 dum"><div class="col-sm-2"><input type="text" name="meter_drum_no[]" value="'+(i+1)+'" placeholder="Drum No" class="form-control drum_no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="from_meter[]" placeholder="From Meter" class="form-control from_meter'+(i+1)+'"/></div><div class="col-sm-2"><input type="text" name="to_meter[]" placeholder="To Meter" class="form-control to_meter'+(i+1)+'" onchange="TotalMeterCalc('+(i+1)+')"/></div><div class="col-sm-2"><input type="text" name="total_meter[]" placeholder="Total Meter" class="form-control t_meter'+(i+1)+'" readonly="true"/></div><span class="btn btn-minier btn-primary" onclick="addMeter()">ADD</span>&nbsp;&nbsp;&nbsp;<span class="btn btn-minier btn-primary delete">DELETE</span></div>');
				}
	     	}
		}
    });

function addMeter(){
	x=$('.final_count').val();
	y=(+x+1);
	$(".meter").append('<div class="form-group col-sm-12 dum"><div class="col-sm-2"><input type="text" name="meter_drum_no[]" value="'+y+'" placeholder="Drum No" class="form-control drum_no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="from_meter[]" placeholder="From Meter" class="form-control from_meter'+y+'"/></div><div class="col-sm-2" readonly="true"><input type="text" name="to_meter[]" placeholder="To Meter" class="form-control to_meter'+y+'" onchange="TotalMeterCalc('+y+')"/></div><div class="col-sm-2"><input type="text" name="total_meter[]" placeholder="Total Meter" class="form-control t_meter'+y+'"  readonly="true" /></div><span class="btn btn-minier btn-primary" onclick="addMeter()">ADD</span>&nbsp;&nbsp;&nbsp;<span class="btn btn-minier btn-primary delete">DELETE</span></div>');
	$('.final_count').val(0);
	$('.final_count').val(y);
}

function addCount(){
	x=$('.final_count').val();
	y=(+x+1);
	$(".count").append('<div class="form-group col-sm-12 dum"><div class="col-sm-2"><input type="text" name="no[]" value="'+y+'" placeholder="No" class="form-control no" readonly="true"/></div><div class="col-sm-2"><input type="text" name="srl_no[]" placeholder="Srl No" class="form-control srl_no" /></div><div class="col-sm-2"><input type="text" name="mac_address[]" placeholder="Mac Address" class="form-control mac_address"/></div><div class="col-sm-2"><input type="text" name="count[]" placeholder="Select Material Count" class="form-control m_count'+y+'" readonly="true"/></div><span class="btn btn-minier btn-primary" onclick="addCount()">ADD</span>&nbsp;&nbsp;&nbsp;<span class="btn btn-minier btn-primary delete">DELETE</span></div>');
	$('.final_count').val(0);
	$('.final_count').val(y);
}

$('select.material_type').change(function(){
			var material = $('select.material_type').val();
			if(material.length!=0){
	            $.ajax({
	                url : '/admin/switch_router/count_details',
	                type : 'get',
	                data : {'material':material },
	               success : function(data) {
	                       if (data["found"] == "false") {
                            alert('Not in Category !!!!');
                        } else {
                           		if(data['type']=="total_count"){
									$('.meter').hide();
									$('.count').hide();
									$('.totals').hide();
									$('.t_meters').hide();
									$('.final_count').val(0);
								}else if(data['type']=="meters"){
									$('.meter').show();
									$('.count').hide();
									$('.final_count').val(1);
								}else if(data['type']=="individual_count"){
									$('.meter').hide();
									$('.count').show();
									$('.totals').hide();
									$('.t_meters').hide();
									$('.final_count').val(1);
								}
							 $(".type").val(data['type']);
                            }
	                    }
	            	})
			}else{
				alert('Please Enter materials and type value !!!!');
			}

	});

function TotalMeterCalc(x){
	var start_meter=$('.from_meter'+x).val();
	var end_meter=$('.to_meter'+x).val();

	if(start_meter.length !=0 && end_meter.length !=0){
		var totalmeter= start_meter - end_meter;
        if(totalmeter < 0){
        	var meter=(-1*totalmeter);	
        }else{
        	var meter=(1*totalmeter);
        }
        $('.t_meter'+x).val(meter)
	}else{
		alert('Please Enter Start and End Meters !!!!');
	}

}


	$( "form" ).submit(function( event ) {
		if($(".type").val()=='meters'){
	        var count=$('.final_count').val();
	        var sum=0;
	        for (var i = 1; i <= count; i++) {
	        	var k=$('.t_meter'+i).val();
	        	sum+=+k;
	        };
	        if($('.t_meters').val()!=sum){
	        	alert("Total Meters Not Match !!!");
	        	event.preventDefault();
	        }
		}
    });

jQuery(function($) {
	$('.meter').hide();
	$('.count').hide();
});
</script>

	

@stop