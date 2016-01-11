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
		<a href="/admin/switch-router/index">Switch and Routers</a>
	</li>
	<li class="active">
		<a href="/admin/switch-router/create">Create</a>
	</li>
</ul>
</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.switch_router.store'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Switch and Routers
					</h1>
				</div>
				<div class="form-group">
					{{ Form::label('device_id','Device ID', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('device_id','',array('class' => 'col-xs-10 col-sm-5 account_id','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('catagory_type','Catagory Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-xs-12 col-sm-3">
		                    <select  name="catagory_type" class="form-control col-sm-6  required catagory_type" required>
									<option value="">Select Catagory Type</option>
									<option value="DCE">DCE</option>
									<option value="CPE">CPE</option>
							</select>
						</div>
				</div>
				<div class="form-group">
					{{ Form::label('device_type','Device Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-xs-12 col-sm-3">
		                    <select  name="device_type" class="form-control col-sm-6 required device_type" required>
									<option value="">Select Device type</option>
							</select>
						</div>
				</div>
				<div class="form-group">
					{{ Form::label('manufacture','Manufacture', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-xs-12 col-sm-3">
		                    <select  name="manufacture" class="form-control col-sm-6  required catagory_type" required>
									<option value="">Select Manufacture Type</option>
									<option value="DELL">DELL</option>
									<option value="HP">HP</option>
									<option value="CUSTOM">CUSTOM</option>
							</select>
						</div>
				</div>
				<div class="form-group">
					{{ Form::label('srl_no','Srl No', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('srl_no','',array('class' => 'col-xs-10 col-sm-5 ','required ')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('mac_address','Mac Address', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('mac_address','',array('class' => 'col-xs-10 col-sm-5','required ')) }}
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
    $(document).ready(function(){
	    $('.validate-form').validate();

	    $('.datepicker').datepicker({
	        format: 'yyyy-mm-dd'
	    });

	    $('.select2').css('width','200px').select2({allowClear:true})

	    $('#select2-multiple-style .btn').on('click', function(e){
	        var target = $(this).find('input[type=radio]');
	        var which = parseInt(target.val());
	        if(which == 2) $('.select2').addClass('tag-input-style');
	         else $('.select2').removeClass('tag-input-style');
	    });

	    $('select.catagory_type').change(function(){
            if($(this).val() =="DCE"){
                $('.device_type').empty();
                $('.device_type').append(new Option("Select Device Type",""));
                $('.device_type').append(new Option("OLT","OLT"));
                $('.device_type').append(new Option("ONU","ONU"));
                $('.device_type').append(new Option("Switch","switch"));
            }else{
                $('.device_type').empty();
                $('.device_type').append(new Option("Select Device Type",""));
                $('.device_type').append(new Option("ONU","ONU"));
                $('.device_type').append(new Option("Switch","switch"));
                $('.device_type').append(new Option("Router","router"));
            }
         });
   });
</script>
@stop