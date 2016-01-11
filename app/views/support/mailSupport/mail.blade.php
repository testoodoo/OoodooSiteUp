@extends ('support.layouts.default')
@section('main')
	<div class="page-content">
		<div id="tab-general">
			<div class="row mbl">
				<div class="col-lg-12">
					<div class="col-md-12">
						<div id="area-chart-spline" style="width: 100%; height: 300px; display: none; padding: 0px; position: relative;">
						<canvas class="flot-base" width="1176" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1176px; height: 300px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 10px;">Jan</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 203px;">Feb</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 395px;">Mar</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 588px;">Apr</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 781px;">May</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 973px;">Jun</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 1166px;">Jul</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 290px; left: 1px;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 250px; left: 1px;">25</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 210px; left: 1px;">50</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 170px; left: 1px;">75</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 130px; left: 1px;">100</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 90px; left: 1px;">125</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 50px; left: 1px;">150</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 10px; left: 1px;">175</div></div></div><canvas class="flot-overlay" width="1176" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1176px; height: 300px;"></canvas><div class="legend"><div style="position: absolute; width: 0px; height: 0px; top: 15px; right: 15px; opacity: 0.85; background-color: rgb(255, 255, 255);"> </div><table style="position:absolute;top:15px;right:15px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #66b0ea;overflow:hidden"></div></div></td><td class="legendLabel">Upload</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid #3f516b;overflow:hidden"></div></div></td><td class="legendLabel">Download</td></tr></tbody></table></div></div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="row">
						<div class="col-sm-3 col-md-2">
							<div class="btn-group btn-group-sm">
								<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
									Mail&nbsp;<span class="caret"></span>
								</button>
								<ul role="menu" class="dropdown-menu">
									<li><a href="#">Mail</a></li>
									<li><a href="#">Contacts</a></li>
									<li><a href="#">Tasks</a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-9 col-md-10">
							<div class="btn-group">
								<button type="button" class="btn btn-default">
									<div class="icheckbox_minimal-grey" style="position: relative;">
										<input type="checkbox" style="margin: 0px; vertical-align: middle; position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);" class="checkall">
											<ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
									</div>
								</button>
								<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
									<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul role="menu" class="dropdown-menu">
									<li><a href="#">All</a></li>
									<li><a href="#">None</a></li>
									<li><a href="#">Read</a></li>
									<li><a href="#">Unread</a></li>
									<li><a href="#">Starred</a></li>
									<li><a href="#">Unstarred</a></li>
								</ul>
							</div>
							<button type="button" data-toggle="tooltip" title="" class="btn btn-default mls mrs" data-original-title="Refresh">
								<span class="fa fa-refresh"></span>
							</button>
							<div class="btn-group">
								<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">More&nbsp;
									<span class="caret"></span>
								</button>
								<ul role="menu" class="dropdown-menu">
									<li><a href="#">Mark all as read</a></li>
									<li class="divider"></li>
									<li class="text-center pbm">
										<small class="text-muted">Select messages to see more actions</small>
									</li>
								</ul>
							</div>
							<div class="pull-right">
								<span class="text-muted"><b>1</b>&nbsp; – &nbsp;<b>50</b>&nbsp; of &nbsp;<b>277</b></span>
								<div class="btn-group mlm">
										<button type="button" class="btn btn-default"><span class="fa fa-chevron-left"></span></button>
										<button type="button" class="btn btn-default"><span class="fa fa-chevron-right"></span></button>
								</div>
							</div>
						</div>
					</div>
					<div class="mtl mbl"></div>
					<div class="row">
						<div class="col-sm-3 col-md-2 block-space"><a href="#" role="button" class="btn btn-danger btn-sm btn-block">COMPOSE</a>
							<div class="mtm mbm"></div>
							<div class="panel">
								<div class="panel-body pan">
									<ul style="background: #fff" class="nav nav-pills nav-stacked" id="mailType" onclick="love();">
										<li class="check active" value="INBOX"><a href="#"><span class="badge pull-right">42</span><i class="fa fa-inbox fa-fw mrs"></i>Inbox</a></li>
										<li class="check" value="SENT"><a href="#"><i class="fa fa-plane fa-fw mrs"></i>Sent Mail</a></li>
										<li class="check" value="DRAFT"><a href="#"><span class="badge pull-right">3</span><i class="fa fa-edit fa-fw mrs"></i>Drafts</a></li>
									</ul>
								</div>
							</div>
							<br>
						</div>
						<div class="col-sm-9 col-md-10">
							<div class="tab-content">
								<div id="home" class="tab-pane fade in active">
									@foreach($inbox as $mail)
										<div class="list-group mail-box">
											<a href="#" class="list-group-item">
												<div class="icheckbox_minimal-grey" style="position: relative;">
													<input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
													<ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
												</div>
												<span class="fa fa-star-o mrm mlm"></span>
												<span style="min-width: 120px; display: inline-block;" class="name">{{$mail->from_mail}}</span>
												<span>{{$mail->subject}}</span>&nbsp; - &nbsp;
												<span style="font-size: 11px;" class="text-muted">{{$mail->snippet}}</span>
												<span class="time-badge">{{$mail->time}}</span>
												<span class="pull-right mrl">
													@if($mail->attachment)
														<span class="fa fa-paperclip"></span>
													@endif
												</span>
										    </a>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-content">
							<ul class="list-inline item-details">
								<li><a href="http://themifycloud.com">Admin templates</a></li>
								<li><a href="http://themescloud.org">Bootstrap themes</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.check').on('click', function(){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
	});
});
$(document).ready(function(){
	$('#mailType').on('click', function(){
		
	});
});
	var a = $('#mailType').value;
	alert(a);
</script>
@stop
            