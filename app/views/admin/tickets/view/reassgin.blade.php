<div class="header blue">
    <h3>RE ASSIGN TO</h3>
</div>
@if(count($ticket->assigned_status())!=0)
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th>Updated At</th>
                <th>assigned to</th>
                <th>assigned by</th>
                <th>remarks</th>
            </tr>
            @foreach($ticket->assigned_status() as $history)
                <tr>
                    <td>{{$history->updated_at}}</td>
                    <td>
                        @if(!is_null($history->assigned($history->assigned_to)))
                            {{ $history->assigned($history->assigned_to)->name }} #{{$history->assigned($history->assigned_to)->employee_identity}}
                        @else
                            Not Available
                        @endif
                    </td>
                    <td>
                        @if(!is_null($history->assigned($history->assigned_by)))
                            {{ $history->assigned($history->assigned_by)->name }} #{{$history->assigned($history->assigned_by)->employee_identity}}
                        @else
                            Not Available
                        @endif
                    </td>
                    <td>{{$history->remarks}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
{{ Form::open( array( 'route' => array('admin.tickets.send_tickets'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
    {{ Form::hidden('ticket_no',$ticket->ticket_no) }}
    {{ Form::hidden('ticket_id',$ticket->id) }}
    <div class="form-group">
        <label class="control-label col-sm-3 blue bolder">
             Assign Employee
        </label>
        <div class="col-xs-12 col-sm-9">
            <select  name="employee_id" class="select2 employee_id"
                     data-placeholder="Sales Employee" required>
                <option value=""></option>
                @foreach($employees as $employee)
                    <option value="{{$employee->employee_identity}}">
                       {{$employee->name}} ({{$employee->employee_identity}})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('mobile','Customer phone no', array('class' => 'col-sm-3 control-label no-padding-right blue bolder'))}}
        <div class="col-sm-9">
            {{ Form::text('phone',$ticket->mobile, array('class' => 'col-xs-10 col-sm-5 required digits')) }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">
            <span class="blue bolder">Remark</span>
        </label>
        <div class="col-xs-10 col-sm-8">
                <textarea rows="3" class="form-control" name="remarks"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 center">
            <div class="form-group">
                <input class="btn btn-minier btn-primary" type="submit" value="Save">
            </div>
        </div>
    </div>
{{ Form::close() }}
@include('admin.partials.js_validation');