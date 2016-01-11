 <div class="row show_map" style="display:none;">
    <div class="col-xs-12">
        <div class="widget-box widget-color-blue2">
            <div class="widget-header">
                <h4 class="widget-title lighter smaller">Assign Roles</h4>
            </div>
            <div class="widget-body">
                {{ Form::open( array( 'route' => array('admin.employees.assign_roles'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
                <div class="page-header">
                        <h1>
                            Assign
                        </h1>
                </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                                <span class="blue bolder">SELECT ROLES</span>
                        </label>
                        <div class="col-sm-6">
                            <select name="role" class="select2 employee"
                                             data-placeholder="Sales Employee">
                                <option value="">Select Role</option>
                                @foreach($roles as $key)
                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-top" for="duallist"> SELECT EMPLOYEES</label>
                        <div class="col-sm-8">
                            <select multiple="multiple" size="10" name="roles[]" id="duallist">
                            @foreach($employees as $employee)
                                    <option value="{{$employee->employee_identity}}" >{{$employee->name}}</option>
                            @endforeach
                            </select>

                            <div class="hr hr-16 hr-dotted"></div>
                        </div>
                    </div>
                <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
                        </div>
                    </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@include('admin.partials.js_validation');
