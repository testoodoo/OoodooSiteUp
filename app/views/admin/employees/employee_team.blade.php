@extends('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/admin/index">Home</a>
        </li>
        <li class="active">
            <a href="/admin/employees/team">Team</a>
        </li>
    </ul>
</div>
<div class="page-header">
    <h1>
        Employees Team
    <a href="/admin/employees/team_create" class="pull-right"><button class="btn btn-primary">Add New</button></a>
    </h1>
</div>
<div class="col-sm-12">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <tbody>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Vehicles</td>
            <td>Members</td>
            <td>Tickets</td>
            <td>Edit</td>
        </tr>
        @foreach($team as $t)
          <tr>
              <td>{{$t->id}}</td>
              <td>{{$t->team}}</td>
              <td class="center">{{$t->vehicles}}</td>
              <td>@foreach($t->employees($t->members) as $name)
                    {{$name}}</br>
                   @endforeach
            </td>
            <td class="center">
                @foreach($t->ticket($t->members) as $id)
                    @if($no=DB::table('tickets')->where('id',$id)->first())
                     &nbsp;<span onclick="ticket({{$id}})" class="btn btn-light btn-xs"><span class="grey">
                    {{$no->ticket_no}}
                    </span></span>
                    @else
                    @endif
                @endforeach
            </td>
            <td>
                <a type="button" class="btn btn-minier btn-primary" href="/admin/employees/team_edit/{{$t->id}}" >
                    Edit
                </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
</div>
<script type="text/javascript">
 function ticket(t) {
        window.open("<?php public_path() ?>/admin/users-old/ticket-popup/"+t, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }

function addcolumn(){
        var y=$('.count').val();
        i=+y+1;
        $(".update_meter"+t).append('<div class="form-group col-sm-12"><div class="col-sm-2" ><select name="used_type[]" class="form-control used_type'+t+i+'" onchange="UsedType('+t+','+i+')"><option value="">Select Usage Type</option><option value="new_customers">New customers</option><option value="exist_customers">Exist customers</option><option value="damage">damage</option><option value="left_over">left over</option></select></div><div class="col-sm-2"><input type="text" name="crf_no[]"  placeholder="CRF NO" class="form-control crf_no'+t+i+'" readonly="true"/></div><div class="col-sm-2"><input type="text" name="account_id[]"  placeholder="Account id" class="form-control account_id'+t+i+'" readonly="true"/></div><div class="col-sm-1"><input type="text" name="id[]"  placeholder="ID" class="form-control id'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="drum_no[]"  placeholder="Drum No" class="form-control drum_no'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="from_meter[]" placeholder="From Meter" class="form-control from_meter'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="to_meter[]" placeholder="To Meter" class="form-control to_meter'+t+i+'" onchange="TotalMeterCalc('+t+','+(i+1)+')" /></div><div class="col-sm-1"><input type="text" name="total_meter[]" placeholder="Total Meter" class="form-control t_meter'+t+i+'" readonly="true"/></div><span class="btn btn-minier btn-primary delete">DELETE</span></div></div>');
    }
</script>

@stop