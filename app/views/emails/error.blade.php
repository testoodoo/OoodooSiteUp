<h1>{{ $code }} error in site...</h1><br>

<h2> Request Path : /{{ Request::path() }} </h2><br>

<hr>

<h1>Exception</h1><br>

<table>
	<thead>
		<tr>
			<th>Key</th>
			<th>Value</th>	
		</tr>
	</thead>
	<tbody>
		@foreach ($_SERVER as $key => $value)
			<tr>
				<td>{{ $key }}</td>		
				<td> {{$value}} </td>
			</tr>
		@endforeach
	</tbody>
	
</table>
<br>

<hr>

<h2> Inputs </h2> <br>

<?php var_dump(Input::all()); ?>

<hr>

<h2> User Info</h2> <br>

@if (!Auth::user()->guest())
	<p>Account ID : <b>{{ Auth::user()->get()->account_id }}</b></p>
	<?php var_dump(Auth::user()->get()); ?>
@else
	<h4> User Not Logged in </h4>
@endif

<h2> Exception Log </h2><br>

<p>{{ $exception }}</p>