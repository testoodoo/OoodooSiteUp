<div class="panel-body">
    @if( $errors->has() || Session::has('failure') )
        <div class="alert alert-block alert-danger fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-times"></i>
            </button>
            @foreach ($errors->all() as $message) 
                <strong>{{$message}}</strong> <br>
            @endforeach
            {{Session::get('failure')}}
        </div>
    @endif
    @if( Session::has('success') )
        <div class="alert alert-success alert-block fade in">
          <button data-dismiss="alert" class="close close-sm" type="button">
              <i class="fa fa-times"></i>
          </button>
          <h4>
              <i class="fa fa-ok-sign"></i>
              Success!
          </h4>
          <p>{{Session::get('success')}}</p>
        </div>
    @endif
</div>