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
			<a href="/admin/session/index">Active Sessions</a>
		</li>
	</ul><!-- /.breadcrumb -->
</div>
<div class="page-header">
	<h1>
		Active Session >> @if(count($active_session)) {{count($active_session)}} @else <?php echo count($active_sessions); ?> @endif
	</h1>
	<div class="col-xs-12 col-sm-12">
		<!--<div class="nav-search" id="nav-search">
			{{ Form::open(array('route' =>array('admin.active_sessions.index'), 'method' => 'get')) }}
				<span class="input-icon">
					<input name="query" placeholder="Search ..." class="nav-search-input">
					<i class="ace-icon fa fa-search nav-search-icon"></i>
				</span>
			{{ Form::close() }}
		</div><!-- /.nav-search -->
	</div>
</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
			<th>Account ID</th>
			<th>MAC Address</th>
			<th>IP Address</th>
			<th>Bytes Down</th>
			<th>Bytes Up</th>
			<th>Download Rate</th>
			<th>Upload Rate</th>
			<th>Start Time</th>
			<th>Duration</th>
	</thead>
</table>
<!--<div style="float:right;">
	@if(!empty($query))
		{{ $active_sessions->appends(Input::except('page'))->links(); }}
	@else
		{{ $active_sessions->links(); }}
	@endif
</div>-->
 <script type="text/javascript" charset="utf-8">
            jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
            	processing: true,
            	serverSide: true,
                       "ajax": 'ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000-1], [10,50,100,500,1000,"All"]],
		              
                   });
            setInterval( function () {
  				    oTable.fnReloadAjax();
					}, 15000 );

	            var tableTools = new $.fn.dataTable.TableTools( oTable, {
			    "sSwfPath": "/admin/swf/copy_csv_xls_pdf.swf",
			    "sRowSelect": "multi",
			    "aButtons": [
			        {
			            "sExtends":    "xls",
			            "sButtonText": 'Export CSV',
			            "fnInit": function ( nButton, oConfig ) {
			                $(nButton).addClass('btn btn-minier btn-primary m-r-5 m-b-5');
			                $(nButton).removeClass('DTTT_button');
			                $(nButton).removeClass('DTTT_button_xls');
			            },
			            "fnClick": function ( nButton, oConfig, oFlash ) {
			                if(oTable.fnGetData().length > 5000){
		               		alert("Record Details is Existed above 5000. Please Select below 5000 !!!!!")
		              		 $('.save-collection').removeClass("DTTT_disabled");
		                   }else{
		                   		this.fnSetText(oFlash, this.fnGetTableData(oConfig));
								console.log(oConfig);

		                   }
		                }
			        },
			    ]
			} );
			 
			$( tableTools.fnContainer() ).insertBefore('.dataTables_filter');
            }); 
        </script>

@stop
