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
			<a href="/admin/usages/index">Usages</a>
		</li>
		<li class="active">
			<a href="/admin/usages/index">Index</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Data Usage
	</h1>
	<div class="row">
		<div class="col-xs-12 col-sm-12">
		<!--  <div class="nav-search" id="nav-search">
		      {{ Form::open(array('route' =>array('admin.usages.index'), 'method' => 'get')) }}
		          <span class="input-icon">
		                <input name="query" placeholder="Search ..." class="nav-search-input">
		                <i class="ace-icon fa fa-search nav-search-icon"></i>
		          </span>
		     {{ Form::close() }}
		  </div><!-- /.nav-search -->
		</div>
	</div><!-- /.span -->
</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Account ID</th>
			<th>Rate Plan</th>
			<th>Status</th>
			<th>Current Speed</th>
			<th>Duration</th>
			<th>Bytes Down</th>
			<th>Bytes Up</th>
			<th>Bytes Total</th>
			<th>Total GB</th>
		</tr>
	</thead>
	<tbody>
		@foreach($usages as $usage)
			<td>{{$usage->account_id}}</td>
			<td>{{$usage->plan}}</td>
			<td>{{$usage->status}}</td>
			<th>{{$usage->current_plan}}</th>
			<td>{{$usage->duration}}</td>
			<td>{{$usage->bytes_down}}</td>
			<td>{{$usage->bytes_up}}</td>
			<td>{{$usage->bytes_total}}</td>
			<td>{{$usage->data_usage_in_gb()}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
<!--<div style="float:right;">
    @if(!empty($query))
        {{ $usages->appends(Input::except('page'))->links(); }}
    @else
	    {{ $usages->links(); }}
    @endif
</div> -->
@if(count($usage))
 <script type="text/javascript" charset="utf-8">
            jQuery(document).ready(function() {
            var oTable = jQuery('#sample-table-1').dataTable({
            	processing: true,
            	serverSide: true,
                       "ajax": '/admin/usages/usage_ajax',
                       "type":'get',
                       "lengthMenu": [[10,50,100,500,1000,-1], [10,50,100,500,1000,"All"]],
                      
                    "createdRow": function ( row, data, index ) {
                    	var total_gb=data[8]/1000000000;
                    	var gb=total_gb.toFixed(2);
            			$('td:eq(8)', row).html(gb);
    			},
                   });
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
@endif

@stop
