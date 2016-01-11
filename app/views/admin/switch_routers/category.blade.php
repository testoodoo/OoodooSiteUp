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
			<a href="/admin/switch_router/category">category</a>
		</li>
	</ul>
</div>
	<div class="page-header">
		<h1>
			category
		</h1>
	</div>
<div class="page-content">
	{{ Form::open( array( 'route' => array('admin.switch_router.create_category'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<div class="row">
			<div class="col-xs-12">
				<div class="page-header">
					<h1>
						Add Category
					</h1>
				</div>
				<div class="form-group">
					{{ Form::label('NAME','NAME', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('name','', array('class' => 'col-xs-10 col-sm-5','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('BRAND','BRAND', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('brand','', array('class' => 'col-xs-10 col-sm-5','required')) }}
					</div>
				</div>
				<div class="form-group">
					{{ Form::label('DATE','DATE', array('class' => 'col-sm-3 control-label no-padding-right'))}}
					<div class="col-sm-9">
						{{ Form::text('date','', array('class' => 'col-xs-10 col-sm-5 datepicker','required')) }}
					</div>
				</div>
				<div class="form-group">
	                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
	                  MATERIAl TYPE
	                </label>
	                <div class="col-xs-12 col-sm-9">
	                    <select  name="material_type" class="select2"
	                             data-placeholder="Select Type" required>
	                        	<option value=""></option>
	                            <option value="meters">Meters</option>
	                            <option value="total_count">Total Count</option>
	                            <option value="individual_count">Individual Count</option>
	                    </select>
	                </div>
            	</div>
            	<div class="form-group">
	                <label class="control-label col-xs-12 col-sm-3 no-padding-right">
	                  MATERIAL DETAILS
	                </label>
	                <div class="col-xs-12 col-sm-9">
	                    <select  name="material_details" class="select2"
	                             data-placeholder="Select Material Details" required>
	                             <option value=""></option>
	                            <option value="fiber">FIBER</option>
	                            <option value="ethernet">ETHERNET</option>
	                            <option value="onu">ONU</option>
	                            <option value="router">ROUTER</option>
	                            <option value="switch">SWITCH</option>
	                            <option value="olt">OLT</option>
	                            <option value="others">OTHERS</option>
	                    </select>
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


</script>
	

@stop