<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>OODOO</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		@include('user._partials.css_assets')
		
	</head>

	<body>
		@yield('main')
	</body>

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

	</script>
</html>