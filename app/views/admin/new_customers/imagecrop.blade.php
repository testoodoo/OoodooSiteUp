<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">profile image crop</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                    {{ Form::open( array( 'route' => array('admin.documents.crop'), 'method' => 'POST','onsubmit'=>'return checkCoords();')) }}
                    	{{ Form::hidden('image',$photo_view->file_name) }}
                    	{{ HTML::image($photo_view->file_name,'',['id'=>'crop']) }}
                        <input type="hidden" id="src" name="src" value="{{$photo_view->file_name }}" />
                        <input type="hidden" id="x" name="x"  />
                        <input type="hidden" id="y" name="y"  />
                        <input type="hidden" id="w" name="w"  />
                        <input type="hidden" id="h" name="h"  />
                    </div>
                        <div class="col-sm-6">         
                            <div style="width:150px;height:150px;overflow:hidden;margin-left:5px;">
                            {{ HTML::image($photo_view->file_name,'',['id'=>'preview']) }}
                            </div>
                       </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>







       