<div class="header blue">
    <h3>RE ASSIGN TO</h3>
</div>
@if(count($ticket->assigned_status())!=0)
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th>Updated At</th>
                <th>Team</th>
                <th>assigned to</th>
                <th>assigned by</th>
                <th>remarks</th>
            </tr>
            @foreach($ticket->assigned_status() as $history)
                <tr>
                    <td>{{$history->updated_at}}</td>
                    @if($history->team_type)
                        <td>{{$history->team_type}}</td>
                    @else
                        <td>Not Found</td>
                    @endif
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
{{ Form::open( array( 'url' => 'ticket/send', 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
    {{ Form::hidden('ticket_no',$ticket->ticket_no) }}
    {{ Form::hidden('ticket_id',$ticket->id) }}
    {{ Form::hidden('complete','1', array('class' => 'complete')) }}
    @if(Auth::employee()->get()->role_id!=11)
        <div class="form-group">
            <label class="control-label col-sm-3 blue bolder">
                 Assign status
            </label>
            <div class="col-xs-12 col-sm-9">
                    <span class="compt btn btn-minier btn-purple" onclick="Incomplete(1)" value="1">Complete</span>
                    <span class="compo btn btn-minier btn-pink" onclick="Incomplete(0)" value="0">Incomplete</span>
            </div>
        </div>
        <div class="form-group team_det">
            <label class="control-label col-sm-3 blue bolder">
                 Re Assign Team
            </label>
            <div class="col-xs-12 col-sm-9">
            @foreach($team_list as $team)
                    <input name="team" type="radio"  value="{{$team->name}}" />{{$team->name}}
            @endforeach
            </div>
        </div>
    @endif
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
                <button class="btn btn-minier btn-primary" onclick="check()" type="submit" value="Save">Save</button>
            </div>
        </div>
    </div>
{{ Form::close() }}
<script type="text/javascript">
    function Incomplete(x){

        if (x==1) {
             $('.team_det').hide();
             $('.complete').val(1);
            $('.compt').removeClass('btn-purple');
            $('.compt').addClass('btn-success');
            $('.compo').addClass('btn-pink');
        }else{
            $('.team_det').show();
            $('.complete').val(0);
            $('.compo').removeClass('btn-pink');
             $('.compo').addClass('btn-success');
             $('.compt').addClass('btn-purple');
        }
    }
    
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.team_det').hide();
    });

    $('.select2').css('width','200px').select2({allowClear:true})

    $('#select2-multiple-style .btn').on('click', function(e){
        var target = $(this).find('input[type=radio]');
        var which = parseInt(target.val());
        if(which == 2) $('.select2').addClass('tag-input-style');
         else $('.select2').removeClass('tag-input-style');
    });
                
</script>
<script type="text/javascript">
    function check(){
                $('form').submit(function() {
                $(this).find("button[type='submit']").prop('disabled',true);
                    });
            }
</script>