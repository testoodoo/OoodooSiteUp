<div class="form-group">
    <label class="col-lg-2 control-label">About Me</label>
    <div class="col-lg-10">
        <!-- <textarea name="" id="" class="form-control" cols="30" rows="10"></textarea> -->
        {{ Form::textarea('about_me',$user->about_me, array('class' => 'required form-control')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">First Name</label>
    <div class="col-lg-6">
        {{ Form::text('first_name',$user->first_name, array('class' => 'required form-control')) }}
  </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Last Name</label>
    <div class="col-lg-6">
        {{ Form::text('last_name',$user->last_name, array('class' => 'required form-control')) }}
    </div>
</div>
<div class="form-group">
  <label class="col-lg-2 control-label">Country</label>
  <div class="col-lg-6">
      {{ Form::text('country',$user->country, array('class' => 'required form-control')) }}
  </div>
</div>
<div class="form-group">
  <label class="col-lg-2 control-label">Birthday</label>
  <div class="col-lg-6">
      {{ Form::text('dob',$user->dob, array('class' => 'required form-control')) }}
  </div>
</div>
<div class="form-group">
  <label class="col-lg-2 control-label">Occupation</label>
  <div class="col-lg-6">
      {{ Form::text('occupation',$user->occupation, array('class' => 'required form-control')) }}
  </div>
</div>
<div class="form-group">
  <label class="col-lg-2 control-label">Email</label>
  <div class="col-lg-6">
      {{ Form::text('email',$user->email, array('class' => 'required form-control')) }}
  </div>
</div>
<div class="form-group">
  <label class="col-lg-2 control-label">Mobile</label>
  <div class="col-lg-6">
      {{ Form::text('mobile',$user->mobile, array('class' => 'required form-control')) }}
  </div>
</div>
<div class="form-group">
  <label class="col-lg-2 control-label">Website URL</label>
  <div class="col-lg-6">
      {{ Form::text('website_url',$user->website_url, array('class' => 'form-control')) }}
  </div>
</div>

<div class="form-group">
  <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-success">Save</button>
      <button type="button" class="btn btn-default">Cancel</button>
  </div>
</div>