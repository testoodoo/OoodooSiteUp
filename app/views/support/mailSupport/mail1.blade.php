@extends('support.layouts.default1')
@section('main')
<div class="col-md-4">
            <ul class="media-list inbox">
              <li class="media">
                <div class="pull-left">
                  <div class="form-group has-feedback mb-0">
                    <input type="text" aria-describedby="inputSearchInbox" placeholder="Search inbox..." class="form-control rounded" autocomplete="off"><span aria-hidden="true" class="ti-search form-control-feedback"></span><span id="inputSearchInbox" class="sr-only">(default)</span>
                  </div>
                </div>
                <div class="pull-right">
                  <div role="toolbar" aria-label="Toolbar with button groups" class="btn-toolbar">
                    <div role="group" aria-label="First group" class="btn-group">
                      <button type="button" class="btn btn-outline btn-default"><i class="ti-archive"></i></button>
                      <button type="button" class="btn btn-outline btn-default"><i class="ti-heart"></i></button>
                      <button type="button" class="btn btn-outline btn-default"><i class="ti-trash"></i></button>
                    </div>
                  </div>
                </div>
              </li>
              @foreach($mails as $mail)
              <li class="media">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox1" type="checkbox" value="value1">
                  <label for="mailboxCheckbox1"></label>
                </div><a href="javascript:;">
                  <div class="media-left avatar"><img src="/assets/dist/support/images/avatar/48.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                  <div class="media-body">
                    <h6 class="media-heading">{{$mail->from_mail}}</h6>
                    <h5 class="title">{{$mail->subject}}</h5>
                    <p class="summary">{{ Str::limit($mail->body, 150)}}</p>
                  </div>
                  <div class="media-right text-nowrap">
                    <time datetime="{{$mail->time}}" class="fs-11" data-livestamp="{{$mail->time}}"></time>
                  </div></a>
              </li>
              @endforeach

            </ul>
          </div>




          

@stop