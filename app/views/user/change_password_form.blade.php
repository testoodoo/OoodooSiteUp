<div class="form-group">
    <label class="col-lg-2 control-label">New Password</label>
    <div class="col-lg-6">
        {{ Form::password('password',['class' => 'form-control required','id'=>'new_password','placeholder'=>'New Password']) }}
  </div>
</div>

<div class="form-group">
    <label class="col-lg-2 control-label">Confirm Password</label>
    <div class="col-lg-6">
    {{ Form::password('password_confirmation',['class' => 'form-control required','placeholder'=>'Confirm New Password']) }}
  </div>
</div>

<div class="form-group">
  <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-success">Save</button>
      <button type="button" class="btn btn-default">Cancel</button>
  </div>
</div>

