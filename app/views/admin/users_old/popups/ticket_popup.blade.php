
@include('admin.partials.css_assets')
@include('admin.partials.js_assets')
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
</div>


                  
    
 