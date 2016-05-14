@extends('support.layouts.default1')
@section('main')
<div class="col-md-5">
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
              <li class="media">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox1" type="checkbox" value="value1">
                  <label for="mailboxCheckbox1"></label>
                </div><a href="javascript:;">
                  <div class="media-left avatar"><img src="build/images/users/02.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                  <div class="media-body">
                    <h6 class="media-heading">Mark Barnett</h6>
                    <h5 class="title">Posuere convallis sociis nisi euismod</h5>
                    <p class="summary">Arcu sed in tortor non convallis laoreet commodo ullamcorper ultrices...</p>
                  </div>
                  <div class="media-right text-nowrap">
                    <time datetime="2015-12-10T20:50:48+07:00" class="fs-11">9 mins</time>
                  </div></a>
              </li>
              <li class="media">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox2" type="checkbox" value="value2">
                  <label for="mailboxCheckbox2"></label>
                </div><a href="javascript:;">
                  <div class="media-left avatar"><img src="build/images/users/11.jpg" alt="" class="media-object img-circle"><span class="status bg-danger"></span></div>
                  <div class="media-body">
                    <h6 class="media-heading">Alexander Gilbert</h6>
                    <h5 class="title">Posuere convallis sociis nisi euismod</h5>
                    <p class="summary">Arcu sed in tortor non convallis laoreet commodo ullamcorper ultrices...</p>
                  </div>
                  <div class="media-right text-nowrap"><i class="ti-clip"></i>
                    <time datetime="2015-12-10T20:42:40+07:00" class="fs-11">15 mins</time>
                  </div></a>
              </li>
              <li class="media read">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox3" type="checkbox" value="value3">
                  <label for="mailboxCheckbox3"></label>
                </div><a href="javascript:;">
                  <div class="media-left avatar"><img src="build/images/users/12.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                  <div class="media-body">
                    <h6 class="media-heading">Amanda Collins</h6>
                    <h5 class="title">Posuere convallis sociis nisi euismod</h5>
                    <p class="summary">Arcu sed in tortor non convallis laoreet commodo ullamcorper ultrices...</p>
                  </div>
                  <div class="media-right text-nowrap">
                    <time datetime="2015-12-10T20:35:35+07:00" class="fs-11">22 mins</time>
                  </div></a>
              </li>
              <li class="media active">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox4" type="checkbox" value="value4">
                  <label for="mailboxCheckbox4"></label>
                </div><a href="javascript:;">
                  <div class="media-left avatar"><img src="build/images/users/13.jpg" alt="" class="media-object img-circle"><span class="status bg-warning"></span></div>
                  <div class="media-body">
                    <h6 class="media-heading">Christian Lane</h6>
                    <h5 class="title">Posuere convallis sociis nisi euismod</h5>
                    <p class="summary">Arcu sed in tortor non convallis laoreet commodo ullamcorper ultrices...</p>
                  </div>
                  <div class="media-right text-nowrap"><i class="ti-clip"></i>
                    <time datetime="2015-12-10T20:27:48+07:00" class="fs-11">30 mins</time>
                  </div></a>
              </li>
              <li class="media read">
                <div class="checkbox-custom pull-left">
                  <input id="mailboxCheckbox5" type="checkbox" value="value5">
                  <label for="mailboxCheckbox5"></label>
                </div><a href="javascript:;">
                  <div class="media-left avatar"><img src="build/images/users/01.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                  <div class="media-body">
                    <h6 class="media-heading">Edward Garcia</h6>
                    <h5 class="title">Posuere convallis sociis nisi euismod</h5>
                    <p class="summary">Arcu sed in tortor non convallis laoreet commodo ullamcorper ultrices...</p>
                  </div>
                  <div class="media-right text-nowrap">
                    <time datetime="2015-12-10T20:35:35+07:00" class="fs-11">Yesterday</time>
                  </div></a>
              </li>
            </ul>
          </div>




          

@stop