<div class="header blue">
    <h3> Add Otdr Details</h3>
</div>
@if(count($ticket->otdr_det())!=0)
<table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th>Location A & Area A</th>
                <th>Location B & Area B</th>
                <th>distance</th>
            </tr>
            @foreach($ticket->otdr_det() as $history)
                <tr>
                    <td>{{$history->location_a}}-{{$history->area_a}}</td>
                    <td>{{$history->location_b}}-{{$history->area_b}}</td>
                    <td>{{$history->distance}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
{{ Form::open(array('route' => 'admin.network.otdr_post', 'method' => 'POST', 'class' => 'form-horizontal otdr-validate-form ')) }}
    {{ Form::hidden('incident_id[]',$ticket->id) }}
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
    <div class="form-group">
        <label class="col-sm-3 control-label">Location A</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="location_a" placeholder="Location A" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Select Area A</label>
        <div class="col-xs-12 col-sm-9">
            <select  name="area_a" class="select2 required"
                     data-placeholder="Select Area" required>
                        <option value=""></option>
                    @foreach($areas as $area)
                        <option value="{{$area->name}}">{{$area->name}}</option>
                    @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Location B</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="location_b" placeholder="Location B" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Select Area B</label>
        <div class="col-xs-12 col-sm-9">
            <select  name="area_b" class="select2 required"
                     data-placeholder="Select Area" required>
                        <option value=""></option>
                     @foreach($areas as $area)
                        <option value="{{$area->name}}">{{$area->name}}</option>
                    @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Distance</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" name="distance" placeholder="Distance" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 center">
            <div class="form-group">
                <input class="btn btn-info" type="submit" value="Save">
            </div>
        </div>
    </div>
{{ Form::close(); }}

