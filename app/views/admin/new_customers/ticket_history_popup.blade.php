@include('admin.partials.css_assets')
@include('admin.partials.js_assets')
<div class="col-sm-12">
    <div class="row">
        <div class="col-xs-12">
            <div class="header blue">
                <h3>Ticket Info</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Ticket No.</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Raised By</th>
                        <th>View</th>       
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $ticket->ticket_no }}</td>
                        <td>{{ $ticket->requirement }}</td>
                        <td>{{ $ticket->getOwnStatus->name }}</td>
                        <td>{{ $ticket->assigned_to }}</td>
                         <td><button type="button" class="btn btn-minier btn-primary" onclick="tickets()" >
                         view
                        </button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="header blue">
                <h3>Ticket Status</h3>
            </div>
            <div class="row">
                {{ Form::open( array('route' => array('status.store'),
                     'method' => 'POST','class' => 'ticket-status-validate-form','class' => 'form-horizontal validate-form')  ) }}
                    {{ Form::hidden('object_type','ticket') }}
                    {{ Form::hidden('object_id',$ticket->id) }}
                    {{ Form::hidden('owner_type',Auth::employee()->get()->employee_identity) }}
                    {{ Form::hidden('owner_id',Auth::employee()->get()->id) }}
                    <div class="form-group col-sm-5">
                        <label>Message reason for updation</label>
                            {{Form::textarea('message','',array('class'=>'form-control','rows' => "5",'cols' => "10",'required'))}}
                    </div>
                    <div class="form-group col-sm-5">
                        <label>Status updation</label>
                            <select name="status_id" required>
                                <option value="">Select Status updation</option>
                                @foreach($ticket_status_list as $list)
                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-xs-7">
                        <div class="form-group center">
                            <input class="btn btn-info center" type="submit" value="Update Status">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Message</th>
                <th>Updated By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticket->status_history() as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->status->name }}</td>
                    <td>{{ $status->message }}</td>
                    <td>{{ $status->updated_at }}</td>
                    </tr>
            @endforeach

        </tbody>
    </table>
</div>