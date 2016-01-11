@include('admin.partials.css_assets')
@include('admin.partials.js_assets')
<div class="page-header">
      <h1>USER ID AND PASSWORD</h1>
</div>
<div class="alert alert-info">
	<button class="close" data-dismiss="alert">
		<i class="ace-icon fa fa-times"></i>
	</button>
	@if(count($user)!=0)
		User id&nbsp;&nbsp;{{ $user->account_id}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password&nbsp;&nbsp; {{ $user->password}}
	@else
		<h4>User ID and Password Not Found</h4>
	@endif
</div>
