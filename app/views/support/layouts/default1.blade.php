<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>OoDoO Support</title>
	</head>
	<body>
		@include('support.partials.css_assets1')
		@include('support.layouts.sidebar1')
		@include('support.layouts.navbar1')
		<section class="page-container">
			@yield('main')
		</section>
		@include('support.partials.js_assets1')
	</body>
</html>