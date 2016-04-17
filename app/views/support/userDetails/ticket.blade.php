    <div class="col-lg-12" style="">
        <div class="panel panel-grey">
            <div class="panel-heading">Complaint</div>
            <div class="panel-body pan">
                <form action="/ticket/store" method="post">
                    <div class="form-body pal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">
                                                                    Name</label>
                                    <div class="input-icon right">
                                        <i class="fa fa-user"></i>
                                        <input name="account_id" type="hidden" value="{{$user->account_id}}">
                                        <input id="inputName" name="name" type="text" placeholder="" class="form-control" value="{{$user->first_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPhone" class="control-label">
                                                                    Phone</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-phone"></i>
                                            <input id="inputPhone" name="mobile" type="text" placeholder="Phone" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputEmail" class="control-label">
                                                                    E-mail</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-envelope"></i>
                                            <input id="inputEmail" name="email" type="text" placeholder="" class="form-control" value="{{$user->email}}">
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputSubject" class="control-label">
                                                                Address</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-tag"></i>
                                            <input id="inputSubject" name="address" type="text" placeholder="" class="form-control" value="{{$user->address1}}, {{$user->address2}}, {{$user->address3}}">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label">Ticket Type</label>
                                    <select class="form-control" name="ticket_type_id">
		                                <option value="">Select Ticket Type</option>
		                                @foreach($user->ticket_type() as $ticket_type )
		                                	<option value="{{$ticket_type->id}}">{{$ticket_type->name}}</option>
		                                @endforeach
	                                </select>
                                    </div>
                                </div>

                                </div>

                                <div class="form-group">
                                    <label for="inputMessage" name="requirment" class="control-label">
                                                        Requirement</label>
                                    <textarea rows="5" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputMessage" class="control-label">
                                                        Message</label>
                                    <textarea rows="5" class="form-control"></textarea>
                                </div>
                                    <div class="form-group mbn">
                                        <div class="checkbox">
                                            <label>
                                                <div class="icheckbox_minimal-grey" style="position: relative;">
                                                    <input tabindex="5" type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
                                                        <ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                    </div>&nbsp; An email will be sent to the customer with Message content
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions text-right pal">
                                        <button type="submit" class="btn btn-primary">
                                                        Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
