<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="shortcut icon" href="/assets/dist/user/img/oodoo_logo.png" type="image/png">
		
		<title>OODOO</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		@include('user._partials.css_assets')

		<style type="text/css">
			.error {
				color:red;
			}
		</style>		
	</head>
	
	<body>
		@include('user._partials.header')
		@include('user._partials.navbar')
		<section id="main-content">
			<section class="wrapper">				
				@include('user._partials.flash')
				@yield('main')
			</section>
		</section>
	</body>

   {{ HTML::script('/assets/dist/user/js/common-scripts.js') }}



<script type="text/javascript">
	$(document).ready(function() {
       	$("#owl-demo").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
			autoPlay:true

       	});
    });

      	//custom select box

    $(function(){
       	$('select.styled').customSelect();
    });

	function popitup(url) {
		newwindow=window.open(url,'name','height=650,width=750');
		if (window.focus) {newwindow.focus()}
		return false;
	}


	</script>
</html>
