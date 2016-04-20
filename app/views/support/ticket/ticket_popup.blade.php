@include('support.partials.css_assets')
@include('support.partials.js_assets')
@if( $errors->has() || Session::has('failure') )
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <i class="icon-remove red"></i>
        @foreach ($errors->all() as $message) 
            <span>{{$message}}</span><br/>
        @endforeach
        {{Session::get('failure')}}
    </div>
@endif
@if( Session::has('success') )
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <i class="icon-ok green"></i>
        {{Session::get('success')}}
    </div>
@endif
<div class="page-content" style="background-color:white;">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <!-- Ticket Information -->
                    <div class="row">
                        <div class="col-xs-12">
                            @include('support.ticket.info')
                            @include('support.ticket.reassgin')
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <!-- Ticket Information -->
                    <div class="row">
                        <div class="col-xs-12">
                            @include('support.ticket.status')
                            @include('support.ticket.message')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                  
    
 