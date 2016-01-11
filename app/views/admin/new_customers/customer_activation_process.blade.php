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
        <li class="active">
            <a href="/admin/new-customers/list">new-customers</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>Users
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
                Activation
        </small>
    </h1>
</div>
<!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="form-horizontal">
            <div class="row">
                <div class="col-xs-10 col-sm-9">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            <span class="blue bolder" >Application No</span>
                        </label>
                        <div class="col-sm-6">
                            <label class="col-sm-11 control-label" >
                            {{ Form::text('applicationno', $new_customer->application_no, array('class' => 'form-control', 'readonly'=>'true')) }}</label>
                        </div>
                    </div>
                </div>
            <div class="col-xs-6 col-sm-2">
            @if($new_customer->postStatus()->activation != 1)
                    <i class="btn btn-success">Processing</i>
            @else
                    <i class="btn btn-danger">Rejected</i>
            @endif
            </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Title
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('title', $new_customer->title, array('class' => 'form-control', 'readonly'=>'true')) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Firstname
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('first_name', $new_customer->first_name, array('class' => 'form-control', 'readonly'=>'true')) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Lastname</span>
                </label>
                <div class="col-sm-5">
                  <label class="col-sm-10 control-label">
                     {{ Form::text('last_name', $new_customer->last_name, array('class' => 'form-control', 'readonly'=>'true')) }}
                 </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Email
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('email', $new_customer->email, array('class' => 'form-control', 'readonly'=>'true')) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Flat / Door No
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('address1', $new_customer->address1, array('class' => 'form-control', 'readonly'=>'true')) }}
                   </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Apartment / Building name
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('address2', $new_customer->address2, array('class' => 'form-control', 'readonly'=>'true')) }}
                   </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Street Name
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('address3', $new_customer->address3, array('class' => 'form-control', 'readonly'=>'true')) }}
                     </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">City
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('city', $new_customer->city, array('class' => 'form-control', 'readonly'=>'true')) }}
                   </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">State</span>
                </label>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('state', $new_customer->state, array('class' => 'form-control', 'readonly'=>'true')) }}
                   </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Pincode
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('pincode', $new_customer->pincode, array('class' => 'form-control', 'readonly'=>'true')) }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Phone
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                       {{ Form::text('phone', $new_customer->phone, array('class' => 'form-control', 'readonly'=>'true')) }}
                  </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Birthday
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                      {{ Form::text('dob', $new_customer->dob, array('class' => 'form-control datepicker', 'readonly'=>'true')) }}
                  </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Gender
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                     {{ Form::text('gender', $new_customer->gender, array('class' => 'form-control', 'readonly'=>'true')) }}
                   </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Plan
                    
                    </label>
                </span>
                <div class="col-sm-5">
                  <label class="col-sm-10 control-label">
                    {{ Form::text('plan', $new_customer->plan_type()->plan, array('class' => 'form-control', 'readonly'=>'true')) }}
                  </label>
                </div>
            </div>
        </div>
        {{ Form::open(array('route' => 'admin.users.activation', 'method' => 'POST',
             'class' => 'form-horizontal validate-form')) }}
             {{ Form::hidden('customer_id',$new_customer->id) }}
            <div class="form-group">
                <label for="id-date-picker-1" class="col-sm-3 control-label">
                    <span class="blue bolder">Plan Start Date
                    
                    </label>
                </span>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                        <input class="form-control datepicker required" type="text" name="plan_start_date" />
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">
                    <span class="blue bolder">Remark</span>
                </label>
                <div class="col-sm-5">
                    <label class="col-sm-10 control-label">
                        <textarea rows="3" class="form-control" name="remark"></textarea>
                    </label>
                </div>
            </div>
            @if(!is_null($new_customer->postStatus()))
                <div class="form-group">
                    <div class="col-sm-12 col-sm-offset-4">
                        @if($new_customer->postStatus()->activation != "1")
                            <button type="submit" class="btn btn-success">Activate</button>
                        @endif
                        @if($new_customer->postStatus()->activation != "1")
                            <a href="javascript:void(0);" class="btn btn-danger status-update-button" 
                                data-status="1" data-customer-id="{{ $new_customer->application_no }}">Reject</a>
                        @else
                            <a href="javascript:void(0);" class="btn btn-danger status-update-button" 
                                data-status="0" data-customer-id="{{ $new_customer->application_no }}">Un Reject</a>
                        @endif
                        <a href="/admin/new-customers/{{$new_customer->id}}/edit?activation_process=true" class="btn btn-warning">Edit</a>
                        <a href="javascript:history.back()"  class="btn btn-inverse">Back</a>
                    </div>
                </div>
            @endif
<div class="alert alert-info success col-sm-12">
    <span class="status"></span>
    <button class="close"  data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
    </button>
</div>
        {{ Form::close(); }}
    </div>
</div>
@include('admin.partials.js_validation');
@include('admin.partials.activation_script');

<script type="text/javascript">

    $(document).ready(function(){
        $(".success").hide();

        $('a.status-update-button').click(function(){
            var status = $(this).data('status');
            var customer_id = $(this).data('customer-id');
            $.ajax({
                url : '/admin/new-customers/status-update',
                type : 'POST',
                data : { status : status, customer_id : customer_id },
                success : function(data){
                    if (data['found'] == "true") {
                    if( "success" == data['status']){
                            $(".success").show();
                            $(".status").text('Rejected successFully!!!!!');
                            setTimeout(function() { $(".success").hide(); }, 3000);
                             location.reload();
                    }else{
                            $(".success").show();
                            $(".status").text('unRejected successFully!!!!!');
                            setTimeout(function() { $(".success").hide(); }, 3000);
                             location.reload();
                        }
                }
            }

            })
        });
    });
</script>



@stop
