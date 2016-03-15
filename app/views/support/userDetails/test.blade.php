@extends ('support.layouts.default')
@section('main')
<div class="page-content">
    <div id="tab-general" class="layout-block">
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet box">
                    <div class="portlet-header">
                        <div class="caption">
                                            Chats</div>
                    </div>
                    <div class="portlet-body">
                        <div class="chat-scroller">
                            <ul class="chats">
                                <li class="in">
                                    <img src="assets/dist/support/images/avatar/48.jpg" class="avatar img-responsive" />
                                    <div class="message">
                                        <span class="chat-arrow"></span>
                                        <a href="#" class="chat-name">Admin</a>&nbsp;
                            
                                        <span
                                                            class="chat-datetime">at July 06, 2014 17:06</span>
                                        <span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod.</span>
                                    </div>
                                </li>
                                <li class="out">
                                    <img src="assets/dist/support/images/avatar/48.jpg" class="avatar img-responsive" />
                                    <div class="message">
                                        <span class="chat-arrow"></span>
                                        <a href="#" class="chat-name">Admin</a>&nbsp;
                            
                                        <span
                                                            class="chat-datetime">at July 06, 2014 18:06</span>
                                        <span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="chat-form">
                            <div class="input-group">
                                <input id="input-chat" type="text" placeholder="Type a message here..." class="form-control" />
                                <span
                                                    id="btn-chat" class="input-group-btn">
                                    <button type="button" class="btn btn-green">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop