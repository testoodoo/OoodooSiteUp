<div class="header blue">
    <h3>ETA Details</h3>
</div>
@if(count($ticket->incident_status())!=0)
<span class="blue bolder bar"></span>
<div class="progress progress-striped pos-rel">
    <div class="progress-bar progress-bar-success" style="width: 25%;"></div>
</div>
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th>updated_at</th>
                <th>Up Time</th>
                <th>Up hour</th>
                <th>assigned to</th>
                <th>assigned by</th>
                <th>remarks</th>
            </tr>
            @foreach($ticket->incident_status() as $history)
                <tr>
                    <td>{{$history->updated_at}}</td>
                    <td>{{$history->up_time}}</td>
                    <td>{{$history->hour}}</td>
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
    {{ Form::hidden('up_time',$ticket->incident()->up_time, array('class' => 'col-xs-10 col-sm-5 up_time')) }}
    {{ Form::hidden('down_time',$ticket->incident()->created_at, array('class' => 'col-xs-10 col-sm-5 down_time')) }}
@endif
{{ Form::open( array( 'route' => array('admin.network.incident_update'), 'method' => 'POST','class' => 'form-horizontal eta-validate-form', 'role' => 'form')  ) }}
    {{ Form::hidden('ticket_no',$ticket->ticket_no) }}
    {{ Form::hidden('incident_id[]',$ticket->id) }}
    <div class="form-group">
        <div class="form-group">
        <label class="col-sm-3 control-label">Map Incidents</label>
            <div class="col-xs-12 col-sm-9">
                <select  name="incident_id[]" class="select2 required"
                         data-placeholder="Map Incidents" multiple>
                            <option value=""></option>
                         @foreach($incident as $inc)
                            <option value="{{$inc->id}}">{{$inc->name}} ({{$inc->location}}) </option>
                        @endforeach
                </select>
            </div>
        </div>
        <label class="control-label col-sm-3 blue bolder">
             Assign Employee
        </label>
        <div class="col-xs-12 col-sm-9">
            <select  name="assigned_to" class="select2 employee_id"
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
        <label class="col-sm-3 control-label blue bolder">Enter Hour</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="hour" placeholder="Enter Estimate Hour Only" required/>
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="col-sm-3 control-label blue bolder">Process End Date</label>
        <div class="col-sm-5">
            <input type="text" class="form-control datepicker" name="date" maxlength="10"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label blue bolder">Process End Time</label>
        <div class="col-sm-5 bootstrap-timepicker">
            <input id="timepicker1" type="text" name="time" class="form-control">
        </div>
    </div> -->
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right">
            <span class="blue bolder">Remark</span>
        </label>
        <div class="col-xs-10 col-sm-8">
                <textarea rows="3" class="form-control" name="remarks" required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 center">
            <div class="form-group">
                <input class="btn btn-info" type="submit" value="Save">
            </div>
        </div>
    </div>
{{ Form::close() }}
<script type="text/javascript">
function ReportProgress(starttime,downtime)
{
    var i=starttime.split(" ");
    var date=i[0].split("-");
    var time=i[1].split(":");
    var a = new Date(); // Now
    var b = new Date(date[0],date[1]-1,date[1]-3,time[0],time[1],time[2]);
    var second= Math.round((a-b)/1000);
    var minute= Math.round((second)/60);
    var hour= Math.round((hour)/60);

    var idw=downtime.split(" ");
    var datedw=idw[0].split("-");
    var timedw=idw[1].split(":");
    var adw = new Date(date[0],date[1]-1,date[1]-3,time[0],time[1],time[2]);
    var bdw = new Date(datedw[0],datedw[1]-1,datedw[1]-3,timedw[0],timedw[1],timedw[2]);
    var seconddw= Math.round((adw-bdw)/1000);
    var minutedw= Math.round((seconddw)/60);
    var hourdw= Math.round((minutedw)/60);
    var per=Math.round((minute/minutedw)*100);
    if(minutedw){
        $('.progress-bar-success').width(per+'px');
        $('.bar').text(minute+' MINITES REMAINING'+' OUT OF '+minutedw);
    }else{
       $('.progress-bar-success').width('0px');
        $('.bar').text('ETA Time Expired'); 
    }
}

setInterval(function() {
    var starttime=$('.up_time').val();
    var downtime=$('.down_time').val();
  ReportProgress(starttime,downtime);
},5000);

</script>
<script type="text/javascript">
     $('#timepicker1').timepicker({
                    minuteStep: 1,
                    showSeconds: true,
                    showMeridian: false,
                    disableFocus: true
                }).on('focus', function() {
                    $('#timepicker1').timepicker('showWidget');
                }).next().on(ace.click_event, function(){
                    $(this).prev().focus();
                });
</script>
<script type="text/javascript">
    
$(document).ready(function() {

    $('.validate-form').validate();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });

});

</script>
