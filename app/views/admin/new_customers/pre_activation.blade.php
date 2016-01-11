@extends('admin.layouts.default')
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
</ul>
</div>
<!-- Modal -->
@if(!is_null($photo_view))
@include('admin.new_customers.imagecrop')
@endif
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
    <h4 class="widget-title lighter">Pre Activation</h4>
</div>
<div class="widget-body">
        <div class="widget-main">
            <div id="fuelux-wizard-container">
                <div>
                    <ul class="steps">
                        <li data-step="1" class="active">
                            <span class="step">1</span>
                            <span class="title">Pre Activation</span>
                        </li>
                        <li data-step="2">
                            <span class="step">2</span>
                            <span class="title">Activation</span>
                        </li>
                        <li data-step="3">
                            <span class="step">3</span>
                            <span class="title">Post Activation</span>
                        </li>
                    </ul>
                </div>
                <hr>
                <div class="step-content pos-rel">
                    <div class="step-pane active" data-step="1">
                        <h3 class="lighter block green">How Far the Work has been Finished?</h3>
						@if(is_null($ticket))
                            <button class="btn btn-white btn-info btn-bold pull-right raise_ticket">
                                <i class="ace-icon fa fa-comments bigger-120 blue"></i>
								Raise Ticket
							
                            </button>
						@endif
                        <!-- Ticket Form starts -->
						@if(is_null($ticket))
							@include('admin.new_customers.ticket_form')
						@endif
                        <!-- Ticket Form Ends -->
                        <div class="row">
                            <div class="col-xs-6">
							    @include('admin.new_customers.pre_activation_status')
                            </div>
                            <div class="col-xs-6">
								@if(!is_null($ticket))
									@include('admin.new_customers.ticket_status_history')
								@endif
							</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="header blue">
                                    <h3>Document Upload</h3>
                                </div>
			    				{{ Form::open( array( 'route' => array('admin.documents.store'), 'method' => 'POST','class' => 'form-horizontal document-validate-form', 'role' => 'form', 'files' =>true)  ) }}
			    					{{ Form::hidden('owner_type','new_customer') }}
			    					{{ Form::hidden('owner_id',$customer->id) }}
                                        <div class="form-group">
										    {{ Form::label('document_type','Document Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                                            <div class="col-sm-9">
                                                <select name="document_type_id" style="width:42%;" 
												class="required">
                                                    <option value="">Document Type</option>
											     	@foreach($document_types as $document_type)
                                                        <option value="{{ $document_type->id }}">
    														{{ $document_type->name }}
    													</option>
    												@endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
										    {{ Form::label('document_type','Document Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                                            <div class="col-sm-9">
										        {{ Form::text('document_type', '' , array('class' => 'col-xs-10 col-sm-5 required')) }}
                                                <em>*</em>
                                            </div>
                                        </div>
                                        <div class="form-group">
									        {{ Form::label('document','Document', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                                            <div class="col-sm-9">
                                                <input type="file" class="col-xs-10 col-sm-5" name="document">
                                                <em>*</em>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
											    {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
										    </div>
                                        </div>
			    				    {{ Form::close() }}
			    				    @if($customer->app_document() && !$customer->photo_document())
                                            <!-- <div class="img-container"><img src="/uploads/99_Courtyard_by_Marriott_Hinjewadi.jpg" width="500" height="250"></div><div class="img-preview"></div> -->
								    @endif
                                </div>
			    			    @if(count($customer->documents()) != 0)
                                    <div class="col-xs-6">
                                        <div class="header blue">
                                            <h3>Uploaded Documents</h3>
                                        </div>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Document Type</th>
                                                    <th>Document Name</th>
                                                    <th>Document</th>
                                                    <th>Operations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											    @foreach($customer->documents() as $document)
                                                    <tr>
                                                        <td>{{ $document->document->documentType->name }}</td>
                                                        <td>{{ $document->document_type }}</td>
                                                        <td>
                                                            <a href="{{ $document->document->file_name }}"
															target="_blank">
															File
													       </a>
                                                        </td>
                                                        <td>
                                                            <div class="hidden-sm hidden-xs action-buttons">
                                                                <a href="/admin/documents/delete/{{ $document->id }}?resource=document_mapping">
                                                                    <i class="ace-icon fa fa-trash-o bigger-130 red"></i>
                                                                </a>&nbsp;&nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>
											    @endforeach
                                            </tbody>
                                        </table>
									    @if($customer->app_document() && !$customer->photo_document())
									    @endif
                                    </div>
							    @else
                                    <h3>No Documents Uploaded</h3>
							    @endif
                            </div>
                            @if(!is_null($photo_view))
                                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" >
                                       {{ HTML::image($photo_view->file_name,'') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="wizard-actions">
                    <button class="btn btn-prev" disabled="disabled">
                        <i class="ace-icon fa fa-arrow-left"></i>
					       Prev
                    </button>
                    <button class="btn btn-success btn-next" data-last="Finish">
                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
		                Next
		            </button>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
//image crop
	$(document).ready(function(){

        $('#crop').Jcrop({
			aspectRatio: 1,
			onSelect:atualizaCoordenadas		
		});

		
		$('input[type="file"]').each(function () {
		    $(this).rules('add', {
		        required: true
		        
		    });
		});

        //preactivation
        $('.feasible_radio').click(function(){
            $('div.pre-activation-inputs').show();
        })

        $('.not_feasible_radio').click(function(){
            $('div.pre-activation-inputs').hide();
        })

	});
	$('form.ticket-status-validate-form').validate();
	$('form.document-validate-form').validate();
	$('button.raise_ticket').click(function(){
		$(".ticket_form").slideToggle("slow");
	});

    //image crop function
	function atualizaCoordenadas(c){
		$('#x').val(c.x);
		$('#y').val(c.y);	
		$('#w').val(c.w);	
		$('#h').val(c.h);	
     }
     function checkCoords(){
     	if(parseInt($('#w').val())) return ture;
     	alert('good');
     	return flase;
     }	

</script>



@stop