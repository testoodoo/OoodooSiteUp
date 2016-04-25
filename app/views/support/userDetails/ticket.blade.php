    <div class="col-lg-12" id="newTickets" style="display:non;">
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
                                        <input id="inputName" name="name" type="text" placeholder="" class="form-control" value="{{$user->first_name}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputPhone" class="control-label">
                                                                    Phone</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-phone"></i>
                                            <input id="inputPhone" name="mobile" pattern="([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})" id="mobisle" placeholder="Phone" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputEmail" class="control-label">
                                                                    E-mail</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-envelope"></i>
                                            <input id="inputEmail" name="email" type="email" placeholder="" class="form-control" value="{{$user->email}}" required>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputSubject" class="control-label">
                                                                Address</label>
                                        <div class="input-icon right">
                                            <i class="fa fa-tag"></i>
                                            <input id="inputSubject" name="address" type="text" placeholder="" class="form-control" value="{{$user->address1}}, {{$user->address2}}, {{$user->address3}}" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="control-label">Ticket Type</label>
                                    <select class="form-control" name="ticket_type_id" required>
		                                <option value="">Select Ticket Type</option>
		                                @foreach($user->ticket_type() as $ticket_type )
		                                	<option value="{{$ticket_type->id}}">{{$ticket_type->name}}</option>
		                                @endforeach
	                                </select>
                                    </div>
                                </div>                                
                                    <div class="form-group">
                                    <label class="control-label">Assign To: </label>
                                    <select class="form-control" name="employee_id" required>
                                        <option value="">Select Employee</option>
                                        @foreach($user->employee_identity() as $employee )
                                                <option value="{{$employee->employee_identity}}">
                                                   {{$employee->name}} ({{$employee->employee_identity}})
                                                </option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>                                   
                                </div>

                                <div class="col-md-6">

                                <div class="form-group">
                                    <label for="inputMessage" class="control-label">
                                                        Requirement</label>
                                    <textarea rows="5"  name="requirement" class="form-control" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="inputMessage" class="control-label">
                                                        Message</label>
                                    <textarea rows="5" name="message" class="form-control" required></textarea>
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
                                    <div class="text-right pal">
                                        <button class="btn btn-primary submitBtn">
                                                        Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
<script type="text/javascript">
$(document).ready(function() {
    $('#newTicket').on('click', function(event) {
        var account_id = $("input[name=account_id]").val();
        $.ajax(
        {
            url : '/ticketCheck',
            type :'get',
            data : {account_id : account_id},
            success: function(data) {
                if(data['ticket']==true){
                    $('#failMessage').show();
                    
                }else{
                    $('#newTickets').show();
                }
            }
        });
    });
});    

</script> 
