@extends ('support.layouts.default')
@section('main')
<div class="page-content">
    <div id="tab-general">
        <div class="row mbl">
            <div class="col-lg-12">
                <div class="col-md-12">
                    <div id="area-chart-spline" style="width: 100%; height: 300px; display: none; padding: 0px; position: relative;">
                        <canvas class="flot-base" width="1176" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1176px; height: 300px;"></canvas>
                        <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                            <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 10px;">Jan</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 203px;">Feb</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 395px;">Mar</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 588px;">Apr</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 781px;">May</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 973px;">Jun</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 299px; left: 1166px;">Jul</div>
                            </div>
                            <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 290px; left: 1px;">0</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 250px; left: 1px;">25</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 210px; left: 1px;">50</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 170px; left: 1px;">75</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 130px; left: 1px;">100</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 90px; left: 1px;">125</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 50px; left: 1px;">150</div>
                                <div class="flot-tick-label tickLabel" style="position: absolute; top: 10px; left: 1px;">175</div>
                            </div>
                        </div>
                        <canvas class="flot-overlay" width="1176" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1176px; height: 300px;"></canvas>
                        <div class="legend">
                            <div style="position: absolute; width: 0px; height: 0px; top: 15px; right: 15px; opacity: 0.85; background-color: rgb(255, 255, 255);"></div>
                            <table style="position:absolute;top:15px;right:15px;;font-size:smaller;color:#545454">
                                <tbody>
                                    <tr>
                                        <td class="legendColorBox">
                                            <div style="border:1px solid #ccc;padding:1px">
                                                <div style="width:4px;height:0;border:5px solid #66b0ea;overflow:hidden"></div>
                                            </div>
                                        </td>
                                        <td class="legendLabel">Upload</td>
                                    </tr>
                                    <tr>
                                        <td class="legendColorBox">
                                            <div style="border:1px solid #ccc;padding:1px">
                                                <div style="width:4px;height:0;border:5px solid #3f516b;overflow:hidden"></div>
                                            </div>
                                        </td>
                                        <td class="legendLabel">Download</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Profile: {{$user->first_name}}</h2>
                        <div class="row mtl">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-center mbl">
                                        <img src="assets/dist/support/images/photo5.png" class="img-responsive">
                                        </div>
                                        <div class="text-center mbl">
                                            <a href="#" class="btn btn-green">
                                                <i class="fa fa-upload"></i>&nbsp;
                                        Upload
                                            </a>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <td>User Name</td>
                                                <td>{{$user->first_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{$user->email}}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{$user->address1}}&nbsp;{{$user->address2}}&nbsp;{{$user->address3}}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <span class="label label-success">Active</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User Rating</td>
                                                <td>
                                                    <i class="fa fa-star text-yellow fa-fw"></i>
                                                    <i class="fa fa-star text-yellow fa-fw"></i>
                                                    <i class="fa fa-star text-yellow fa-fw"></i>
                                                    <i class="fa fa-star text-yellow fa-fw"></i>
                                                    <i class="fa fa-star text-yellow fa-fw"></i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>DOB</td>
                                                <td>{{$user->dob}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-content">
                                            <ul class="list-inline item-details">
                                                <li>
                                                    <a href="http://themifycloud.com">Admin templates</a>
                                                </li>
                                                <li>
                                                    <a href="http://themescloud.org">Bootstrap themes</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab-edit" data-toggle="tab">Edit Profile</a>
                                        </li>
                                        <li>
                                            <a href="#tab-messages" data-toggle="tab">Messages</a>
                                        </li>
                                    </ul>
                                    <div id="generalTabContent" class="tab-content">
                                        <div id="tab-edit" class="tab-pane fade in active">
                                            <form action="#" class="form-horizontal">
                                                <h3>Account Setting</h3>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Email</label>
                                                    <div class="col-sm-9 controls">
                                                        <div class="row">
                                                            <div class="col-xs-9">
                                                                <input type="email" placeholder="email@yourcompany.com" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Username</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9">
                                                                    <input type="text" placeholder="username" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Password</label>
                                                            <div class="col-sm-9 controls">
                                                                <div class="row">
                                                                    <div class="col-xs-4">
                                                                        <input type="password" placeholder="password" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label">Confirm Password</label>
                                                                <div class="col-sm-9 controls">
                                                                    <div class="row">
                                                                        <div class="col-xs-4">
                                                                            <input type="password" placeholder="password" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                    <h3>Profile Setting</h3>
                                                                    <div class="form-group">
                                                                        <label class="col-sm-3 control-label">First Name</label>
                                                                        <div class="col-sm-9 controls">
                                                                            <div class="row">
                                                                                <div class="col-xs-9">
                                                                                    <input type="text" placeholder="first name" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-3 control-label">Last Name</label>
                                                                            <div class="col-sm-9 controls">
                                                                                <div class="row">
                                                                                    <div class="col-xs-9">
                                                                                        <input type="text" placeholder="last name" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">Gender</label>
                                                                                <div class="col-sm-9 controls">
                                                                                    <div class="row">
                                                                                        <div class="col-xs-9">
                                                                                            <div class="radio">
                                                                                                <label class="radio-inline">
                                                                                                    <div class="iradio_minimal-grey checked" style="position: relative;">
                                                                                                        <input type="radio" value="0" name="gender" checked="checked" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                            <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                        </div>&nbsp;
                                                                Male
                                                                                                    </label>
                                                                                                    <label class="radio-inline">
                                                                                                        <div class="iradio_minimal-grey" style="position: relative;">
                                                                                                            <input type="radio" value="1" name="gender" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                            </div>&nbsp;
                                                                Female
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="col-sm-3 control-label">Birthday</label>
                                                                                        <div class="col-sm-9 controls">
                                                                                            <div class="row">
                                                                                                <div class="col-xs-4">
                                                                                                    <input id="datepicker-normal" type="text" class="form-control">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-3 control-label">Marital Status</label>
                                                                                            <div class="col-sm-9 controls">
                                                                                                <div class="row">
                                                                                                    <div class="col-xs-4">
                                                                                                        <select class="form-control">
                                                                                                            <option>Single</option>
                                                                                                            <option>Married</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-3 control-label">Position</label>
                                                                                            <div class="col-sm-9 controls">
                                                                                                <div class="row">
                                                                                                    <div class="col-xs-4">
                                                                                                        <select class="form-control">
                                                                                                            <option>CEO</option>
                                                                                                            <option>Director</option>
                                                                                                            <option>Manager</option>
                                                                                                            <option>Staff</option>
                                                                                                            <option>Office Boy</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-sm-3 control-label">About</label>
                                                                                            <div class="col-sm-9 controls">
                                                                                                <div class="row">
                                                                                                    <div class="col-xs-9">
                                                                                                        <textarea rows="3" class="form-control"></textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr>
                                                                                            <h3>Contact Setting</h3>
                                                                                            <div class="form-group">
                                                                                                <label class="col-sm-3 control-label">Mobile Phone</label>
                                                                                                <div class="col-sm-9 controls">
                                                                                                    <div class="row">
                                                                                                        <div class="col-xs-9">
                                                                                                            <input type="text" placeholder="mobile phone" class="form-control">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <label class="col-sm-3 control-label">Website</label>
                                                                                                    <div class="col-sm-9 controls">
                                                                                                        <div class="row">
                                                                                                            <div class="col-xs-9">
                                                                                                                <input type="text" placeholder="website" class="form-control">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label class="col-sm-3 control-label">Facebook</label>
                                                                                                        <div class="col-sm-9 controls">
                                                                                                            <div class="row">
                                                                                                                <div class="col-xs-9">
                                                                                                                    <input type="text" placeholder="facebook" class="form-control">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label class="col-sm-3 control-label">Twitter</label>
                                                                                                            <div class="col-sm-9 controls">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-xs-9">
                                                                                                                        <input type="text" placeholder="twitter" class="form-control">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <hr>
                                                                                                                <button type="submit" class="btn btn-blue btn-block">Finish</button>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                        <div id="tab-messages" class="tab-pane fade in">
                                                                                                            <div class="row mbl">
                                                                                                                <div class="col-lg-6">
                                                                                                                    <span style="margin-left: 15px"></span>
                                                                                                                    <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                        <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                            <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                        </div>
                                                                                                                        <a href="#" class="btn btn-success btn-sm mlm mrm">
                                                                                                                            <i class="fa fa-send-o"></i>&nbsp;
                                                Write Mail
                                                                                                                        </a>
                                                                                                                        <a href="#" class="btn btn-white btn-sm">
                                                                                                                            <i class="fa fa-trash-o"></i>&nbsp;
                                                Delete
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                    <div class="col-lg-6">
                                                                                                                        <div class="input-group">
                                                                                                                            <input type="text" class="form-control">
                                                                                                                                <span class="input-group-btn">
                                                                                                                                    <button type="button" class="btn btn-white">Search</button>
                                                                                                                                </span>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="list-group">
                                                                                                                        <a href="#" class="list-group-item">
                                                                                                                            <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                    <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                </div>
                                                                                                                                <span class="fa fa-star text-yellow mrm mlm"></span>
                                                                                                                                <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                                                                                                                <span class="badge">12:10 AM</span>
                                                                                                                                <span class="pull-right mrl">
                                                                                                                                    <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                </span>
                                                                                                                            </a>
                                                                                                                            <a href="#" class="list-group-item">
                                                                                                                                <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                    <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                        <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                    </div>
                                                                                                                                    <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                    <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                    <span>Sed ut perspiciatis unde</span>&nbsp;
                                            - &nbsp;
                                                                                                                                    <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span>
                                                                                                                                    <span class="badge">12:10 AM</span>
                                                                                                                                    <span class="pull-right mrl">
                                                                                                                                        <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                    </span>
                                                                                                                                </a>
                                                                                                                                <a href="#" class="list-group-item">
                                                                                                                                    <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                        <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                            <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                        </div>
                                                                                                                                        <span class="fa fa-star text-yellow mrm mlm"></span>
                                                                                                                                        <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                        <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                        <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span>
                                                                                                                                        <span class="badge">12:10 AM</span>
                                                                                                                                        <span class="pull-right mrl">
                                                                                                                                            <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                        </span>
                                                                                                                                    </a>
                                                                                                                                    <a href="#" class="list-group-item">
                                                                                                                                        <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                            <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                            </div>
                                                                                                                                            <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                            <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                            <span>Sed ut perspiciatis unde</span>&nbsp;
                                            - &nbsp;
                                                                                                                                            <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                                                                                                                            <span class="badge">12:10 AM</span>
                                                                                                                                            <span class="pull-right mrl">
                                                                                                                                                <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                            </span>
                                                                                                                                        </a>
                                                                                                                                        <a href="#" class="list-group-item">
                                                                                                                                            <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                    <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                </div>
                                                                                                                                                <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                                <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span>
                                                                                                                                                <span class="badge">12:10 AM</span>
                                                                                                                                                <span class="pull-right mrl">
                                                                                                                                                    <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                </span>
                                                                                                                                            </a>
                                                                                                                                            <a href="#" class="list-group-item">
                                                                                                                                                <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                    <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                        <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                    </div>
                                                                                                                                                    <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                    <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                    <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                                    <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span>
                                                                                                                                                    <span class="badge">12:10 AM</span>
                                                                                                                                                    <span class="pull-right mrl">
                                                                                                                                                        <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                    </span>
                                                                                                                                                </a>
                                                                                                                                                <a href="#" class="list-group-item">
                                                                                                                                                    <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                        <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                            <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                        </div>
                                                                                                                                                        <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                        <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                        <span>Sed ut perspiciatis unde</span>&nbsp;
                                            - &nbsp;
                                                                                                                                                        <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                                                                                                                                        <span class="badge">12:10 AM</span>
                                                                                                                                                        <span class="pull-right mrl">
                                                                                                                                                            <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                        </span>
                                                                                                                                                    </a>
                                                                                                                                                    <a href="#" class="list-group-item">
                                                                                                                                                        <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                            <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                                <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                            </div>
                                                                                                                                                            <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                            <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                            <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                                            <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span>
                                                                                                                                                            <span class="badge">12:10 AM</span>
                                                                                                                                                            <span class="pull-right mrl">
                                                                                                                                                                <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                            </span>
                                                                                                                                                        </a>
                                                                                                                                                        <a href="#" class="list-group-item">
                                                                                                                                                            <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                                <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                                    <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                                </div>
                                                                                                                                                                <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                                <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                                <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                                                <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span>
                                                                                                                                                                <span class="badge">12:10 AM</span>
                                                                                                                                                                <span class="pull-right mrl">
                                                                                                                                                                    <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                                </span>
                                                                                                                                                            </a>
                                                                                                                                                            <a href="#" class="list-group-item">
                                                                                                                                                                <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                                    <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                                        <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                                    </div>
                                                                                                                                                                    <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                                    <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                                    <span>Sed ut perspiciatis unde</span>&nbsp;
                                            - &nbsp;
                                                                                                                                                                    <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                                                                                                                                                    <span class="badge">12:10 AM</span>
                                                                                                                                                                    <span class="pull-right mrl">
                                                                                                                                                                        <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                                    </span>
                                                                                                                                                                </a>
                                                                                                                                                                <a href="#" class="list-group-item">
                                                                                                                                                                    <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                                        <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                                            <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                                        </div>
                                                                                                                                                                        <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                                        <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                                        <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                                                        <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</span>
                                                                                                                                                                        <span class="badge">12:10 AM</span>
                                                                                                                                                                        <span class="pull-right mrl">
                                                                                                                                                                            <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                                        </span>
                                                                                                                                                                    </a>
                                                                                                                                                                    <a href="#" class="list-group-item">
                                                                                                                                                                        <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                                                                                                            <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                                                                                                                                                <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                                                                                                                                            </div>
                                                                                                                                                                            <span class="fa fa-star-o mrm mlm"></span>
                                                                                                                                                                            <span style="min-width: 120px; display: inline-block;" class="name">Bhaumik Patel</span>
                                                                                                                                                                            <span>Sed ut perspiciatis unde</span>&nbsp; - &nbsp;
                                                                                                                                                                            <span style="font-size: 11px;" class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</span>
                                                                                                                                                                            <span class="badge">12:10 AM</span>
                                                                                                                                                                            <span class="pull-right mrl">
                                                                                                                                                                                <span class="glyphicon glyphicon-paperclip"></span>
                                                                                                                                                                            </span>
                                                                                                                                                                        </a>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
@stop