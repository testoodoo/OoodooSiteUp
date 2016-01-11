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
			<a href="/admin/ticket/index">Incident</a>
		</li>
		<li class="active">
			<a href="/admin/ticket/view/{{$ticket->id}}">View</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Incident
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			#{{{$ticket->ticket_no}}}
		</small>
	</h1>
</div>
<div class="page-content">
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-6">
					<!-- Ticket Information -->
					<div class="row">
						<div class="col-xs-12">
							@include('admin.networks.view.info')
							@include('admin.networks.view.eta_update')
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<!-- Ticket Information -->
					<div class="row">
						<div class="col-xs-12">
						@include('admin.networks.view.status')
						@include('admin.networks.view.message')
						@include('admin.networks.view.otdr_det')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $('.date-timepicker1').datetimepicker({
     icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-arrows ',
        clear: 'fa fa-trash',
        close: 'fa fa-times'
     }
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('#timepicker1').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false,
        disableFocus: true
    }).on('focus', function() {
        $('#timepicker1').timepicker('showWidget');
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });

    $('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });
                
</script>
@stop