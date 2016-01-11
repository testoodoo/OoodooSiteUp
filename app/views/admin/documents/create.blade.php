<div class="header blue">
        <h3></h3>
</div>
<div class="row">
    <div class="col-sm-6"> 
        {{ Form::open( array( 'route' => array('admin.documents.store'), 'method' => 'POST','class' => 'form-horizontal document-validate-form', 'role' => 'form', 'files' =>true)  ) }}
        {{ Form::hidden('owner_type','new_customer') }}
        {{ Form::hidden('owner_id',$customer->id) }}
            <div class="form-group">
                {{ Form::label('document_type','Proof Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                <div class="col-sm-9">
                    <select name="document_type_id" class="document_type" style="width:42%;" 
                    class="required">
                        <option value="">Document Type</option>
                            <option value="13">customer application</option>
                            <option value="14">customer photo</option>
                            <option value="15">proof of address</option>
                            <option value="16">proof of identity</option>
                    </select>
                </div>
            </div>
            <div class="proof_type">
                <div class="form-group">
                    {{ Form::label('proof_type','Proof Type', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-9">
                        <select name="proof_type" style="width:42%;" 
                        class="required">
                            <option value="">Proof Type</option>
                            <option value="ration_card">Ration Card</option>
                            <option value="driving_license">Driving License</option>
                            <option value="pan_card">Pan Card</option>
                            <option value="aadhar_card">Aadhar Card</option>
                            <option value="passport">Passport</option>
                            <option value="govt_id_card">Govt ID Card</option>
                            <option value="hr_letter">HR Letter</option>
                            <option value="lease_rental_agreement">Lease/Rental Agreement</option>
                            <option value="eb_gas_telephone_bill">EB/Gas/Telephone Bill</option>
                            <option value="others">Others</option>
                        </select>
                        <input type="text" name="document_type_others" hidden class="other_document_type" >
                    </div>
                </div>
            </div>
            <div class="document_upload">
                <div class="form-group">
                    {{ Form::label('document','Document', array('class' => 'col-sm-3 control-label no-padding-right'))}}
                    <div class="col-sm-9">
                        <input type="file" class="col-xs-10 col-sm-5" name="document">
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
    @if(!is_null($photo_view))
    <h5 class="blue">Click and Crop Customer photo</h5>
        <span  data-toggle="modal" data-target="#myModal" >
            {{ HTML::image($app_view,'') }}
        </span>
    @endif
    @if(!is_null($photo_view))
      @include('admin.new_customers.imagecrop')
    @endif
    <h6></h6>
</div>
    @if(count($customer->documents()) != 0)
        <div class="col-xs-12">
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
                            <td>@if($document->document_type){{ $document->document_type }}@else photo @endif</td>
                            <td>
                             <input type="hidden" class="image" value="{{ $document->document->file_name }}">
                                <a data-rel="tooltip" title="Image for user profile" href="{{ $document->document->file_name }}" target="_blank" class="hover">
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
<script type="text/javascript">
    jQuery(function($){
        //select
        $('.select2').css('width','200px').select2({allowClear:true})

        $('#select2-multiple-style .btn').on('click', function(e){
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            if(which == 2) $('.select2').addClass('tag-input-style');
             else $('.select2').removeClass('tag-input-style');
        });

        $('select[name="document_type"]').click(function(){
            if($(this).val() == "others"){
                $('input.other_document_type').show();

            } else {
                $('input.other_document_type').hide();  
            }
        });

    });
</script>
<script type="text/javascript">
    //image crop
        $(document).ready(function(){

        $( '[data-rel="tooltip"]' ).tooltip({ content: '<img src="{{public_path()}}{{$app_view}}" />' });   
        
         $('select.document_type').change(function(){
            if($(this).val()=="13")
            {
                $('.document_upload').show();
                $('.proof_type').hide();
            }else if($(this).val()=="14"){
                $('.document_upload').show();
                $('.proof_type').hide();
            }else{ 
                $('.proof_type').show();
            }
        });
           $('select.document_type').change(function(){
            if($('.image').val()){
                $('.document_upload').hide();
            }
           }); 

        //hover for image.. 

     
           

        //image crop...
            $('#crop').Jcrop({
                aspectRatio: 1,
                onChange: showPreview,
                onSelect: showPreview,
                onSelect:atualizaCoordenadas        
            });
            
            $('input[type="file"]').each(function () {
                $(this).rules('add', {
                    required: true
                    
                });
            });
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
        function showPreview(coords)
        {
            var rx = 100 / coords.w;
            var ry = 100 / coords.h;

            $('#preview').css({
                width: Math.round(rx * 500) + 'px',
                height: Math.round(ry * 370) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });
        }



</script>


            
           

