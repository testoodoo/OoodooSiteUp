@extends('support.layouts.default1')
@section('main')
<div class="col-md-12">
            <ul class="media-list inbox">
              @foreach($mails as $mail)
              <li class="media">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox1" type="checkbox" value="value1">
                  <label for="mailboxCheckbox1"></label>
                </div><a href="/mailSupport/{{$mail->thread_id}}">
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