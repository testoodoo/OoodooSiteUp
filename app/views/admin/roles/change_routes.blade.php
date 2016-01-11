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
			<a href="/admin/roles">Roles</a>
		</li>
		<li class="active">
			<a href="/admin/roles/{{$role->id}}/change-permission">Change-Permission</a>
		</li>
	</ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>
					Role 
				</h1>
            </div>
			{{ Form::open( array( 'route' => array('admin.roles.update_permission'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
			{{ Form::hidden('role_id',$role->id) }}
<!--    		@foreach($routevalues as $routes)
                <?php global $base_url ?>
		            <div class="row">
		                <div class="form-group">
		                    <label  class="col-sm-3 control-label no-padding-right" for="form-input-readonly">Route access </label>
		                    <div class="col-sm-9">
							
								{{ Form::text('name',$base_url.$routes->getPath(), array('class' => 'col-xs-10 col-sm-5 required ')) }}
										
		                        <span class="help-inline col-xs-12 col-sm-7">
		                            <label class="middle">
									@if(Rolepermission::checkRouteExists($role->id,$base_url.$routes->getPath()))
		                                <input class="ace" name="route_ids[]" type="checkbox" checked 
													 value="{{$base_url.$routes->getPath()}}" />
		                                <span class="lbl"></span>
		                             @else
		                                         
		                                <input class="ace" name="route_ids[]" type="checkbox" 
													 value="{{$base_url.$routes->getPath()}}" />
		                                <span class="lbl"></span>
		                              @endif
											
		                            </label>
		                        </span>
		                    </div>
		                </div>
		            </div>
				@endforeach -->
				<div id="example">
					<div class="demo-section">
						<div class="box-col">
							<h4>Roles for permissions Details</h4>
							<div id="treeview"></div>
						</div>
						<div class="box-col">
							<h4>unpermisssion details</h4>
							<p id="result"></p>
							<input type="hidden" name="route_ids[]" id="sult" value="" >
						</div>
					</div>
					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit">
								<i class="icon-ok bigger-110"></i>
								update
							</button>
						</div>
					</div>
            {{ Form::close();}}

		    <script>
		        $("#treeview").kendoTreeView({
		            checkboxes: {
		                checkChildren: true
		            },

		            check: onCheck,

		            dataSource: 
		            [{ 
		            	id:"admin", text: "admin", expanded: true,items: [
				            @for($i=1;$i < count($gateway)-1;$i++)
				            {
				                id:"{{$gateway[$i]}}", text: "{{$gateway[$i]}}", expanded: true,items: [
				                @foreach($roots as $root)
				                @if(in_array($gateway[$i],explode('/',$root)))
				                    @if(Rolepermission::checkRouteExists($role->id,$root))
				                    {
				                        id:"{{$root}}", text: "{{$root}}", expanded: true,checked:true
				                    },
				                    @else
				                	{
				                        id:"{{$root}}", text: "{{$root}}", expanded: true
				                    },
				                    @endif
				                @endif
				                @endforeach
				              ]
			            	},
			            @endfor
			            ]

		            }]
		        });

		        // function that gathers IDs of checked nodes
		        function checkedNodeIds(nodes, checkedNodes) {
		            for (var i = 0; i < nodes.length; i++) {
		                if (nodes[i].checked) {
		                    checkedNodes.push(nodes[i].id);
		                }

		                if (nodes[i].hasChildren) {
		                    checkedNodeIds(nodes[i].children.view(), checkedNodes);
		                }
		            }
		        }

		        // show checked node IDs on datasource change
		        function onCheck() {
		            var checkedNodes = [],
		                treeView = $("#treeview").data("kendoTreeView"),
		                message;
		            checkedNodeIds(treeView.dataSource.view(), checkedNodes);

		            if (checkedNodes.length > 0) {
		                message =checkedNodes.join(",");
		            } else {
		                message = "No nodes checked.";
		            }

		            $("#result").html(message);
		            $("#sult").val(message);
		        }
		    </script>
		     <style>
        #treeview .k-sprite {
            background-image: url("http://test.heat.oodoo.co.in:8000/assets/dist/admin/css/kendo/Material/sprite.png");
        }

        
        .k-icon { width:50px; }
        .k-icon { height:20px; }
        

    </style>
		</div>





@stop


				
													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

													

    			

		

