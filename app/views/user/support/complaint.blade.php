@extends ('user._layouts.default')
@section('main')
<div class = "panel" align = "center">
    <div class = "modal-header">
        <h4><b>COMPLAINT</b></h4>
    </div>
    <div class="panel-body" align = "center">
        {{ Form::open( array( 'route' => array('users.support.complaint_store'), 'method' => 'POST','class' => 'form-horizontal validate-form')  ) }}
            {{ Form::hidden('address', Auth::user()->get()->address, array('class' => 'form-control required')) }}
            <div class="form-group">
            <div class = "col-lg-3"> </div>
                <label class="col-lg-2 col-sm-3 control-label">Name</label>
                <div class="col-lg-5">
                    <div class="iconic-input">
                        {{ Form::text('name', Auth::user()->get()->first_name ." ". Auth::user()->get()->last_name, array('class' => 'form-control required')) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
            <div class = "col-lg-3"> </div>
                <label class="col-lg-2 col-sm-3 control-label">Phone</label>
                <div class="col-lg-5">
                    <div class="iconic-input">
                        {{ Form::text('mobile', Auth::user()->get()->mobile, array('class' => 'form-control required')) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
            <div class = "col-lg-3"> </div>
                <label class="col-lg-2 col-sm-3 control-label">Email</label>
                <div class="col-lg-5">
                    <div class="iconic-input">
                        {{ Form::email('email', Auth::user()->get()->email, array('class' => 'form-control required')) }}
                    </div>
                </div>
            </div>
            <div class="form-group">
            <div class = "col-lg-3"> </div>
                <label class="col-lg-2 col-sm-3 control-label">Complaint type</label>
                <div class="col-lg-5">
                    <div class="iconic-input">
                    <select class="form-control m-bot15 required" name = "ticket_type_id" placeholder="Select type">
                        <option value="" disabled selected>Select your option</option>
                        @foreach($ticket_types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
            <div class = "col-lg-3"> </div>
                <label class="col-lg-2 col-sm-3 control-label">Select City</label>
                <div class="col-lg-5">
                    <div class="iconic-input">
                    <select class="form-control m-bot15 required" name = "city_id" placeholder="Select type">
                        <option value="" disabled selected>Select your option</option>
                        @foreach($cities as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
            </div>
         <div class="form-group">
            <div class = "col-lg-3"> </div>
                <label class="col-lg-2 col-sm-3 control-label">Remarks</label>
                <div class="col-lg-5">
                    <div class="iconic-input">
                        {{ Form::textarea('remarks','',array('class' => 'form-control required')) }}
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-info">Submit</button>
        {{ Form::close() }}
    </div>
</div>
</div>
@stop