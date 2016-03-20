$(document).ready(function() {
	$(".jumper").on("click", function( e ) {

        e.preventDefault();

        $("body, html").animate({ 
            scrollTop: $( $(this).attr('href') ).offset().top 
        }, 600);

    });

	$('#replyContent').hide();
	$("#replyMessage").click(function() {
		$('#replyHide, #replyContent').toggle();
	});
});


