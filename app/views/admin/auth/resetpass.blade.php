@extends('admin._layouts.login')
@section('main')
<div class="login-container">
    <div class="center">
        <h1>
            <i class="ace-icon fa fa-leaf green"></i>
            <span class="red">Oodoo</span>
            <span class="white" id="id-text2">Communication</span>
        </h1>
        <h4 class="blue" id="id-company-text">
            &copy; OODOO
        </h4>
    </div>
    <div class="space-6"></div>
    <div class="position-relative">
        <div id="login-box" class="login-box visible widget-box no-border">
            <div class="widget-body">
                <div class="widget-main">
                    <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-coffee green"></i>
                        Enter Your Password
                    </h4>
                    <div class="space-6"></div>
                    {{ Form::open(array('route' => 'admin.resetPassword','class'=>'form-horizontal','method'=>'POST'))}}
                        {{Form::hidden('employee_identity',$employee->employee_identity)}}                                    
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                {{ Form::password('password',['class' => 'form-control','placeholder'=>'Your Password']) }}
                                <i class="icon-lock"></i>
                            </span>
                        </label>
                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                {{ Form::password('password',['class' => 'form-control','placeholder'=>'Conform Password']) }}
                                <i class="icon-lock"></i>
                            </span>
                        </label>
                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        <div class="space"></div>
                        <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-key"></i>
                                <span class="bigger-110">Reset</span>
                            </button>
                        </div>
                        <div class="space-4"></div>
                    {{Form::close();}}
                </div><!-- /.widget-body -->
            </div>
        </div>
    </div><!-- /.login-box -->
</div>
@stop
