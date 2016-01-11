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
			<a href="/admin/ticket/index">Tickets</a>
		</li>
		<li class="active">
			<a href="/admin/ticket/view/{{$ticket->id}}">View</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Ticket
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
							@include('admin.tickets.view.info')
							@include('admin.tickets.view.reassgin')
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<!-- Ticket Information -->
					<div class="row">
						<div class="col-xs-12">
							@include('admin.tickets.view.status')
							@include('admin.tickets.view.message')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop