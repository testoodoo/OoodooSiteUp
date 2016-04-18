$(document).ready(function() {
	$(".jumper").on("click", function( e ) {

        e.preventDefault();

        $("body, html").animate({ 
            scrollTop: $( $(this).attr('href') ).offset().top 
        }, 600);

    });

	$('#replyContent').hide();
	$("#cancelMessage, #replyMessage").click(function() {
		$('#replyHide, #replyContent').toggle();
	});

	$('#noteContent').hide();
	$("#cancelNote, #replyNote").click(function() {
		$('#replyHide, #noteContent').toggle();
	});	

 $('#reply').click(function() {
 	var body = $('.textarea').val();
 	var thread_id = $('#threadId').val();
 	$.ajax(
 	{
 		url : '/replyMessage',
 		type :'post',
 		data : {body : body, thread_id : thread_id},
 		success: function(data) {
 			if(data["mail"] == "false") {
 				alert('fail');
 			}else{
 				$('#chatBox').append('<li class="out"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" /><div class="message"><span class="chat-arrow"></span><a href="#" class="chat-name">'+data.from+'</a>&nbsp; at<span title="'+data.time+'" data-livestamp="'+data.time+'"></span><span class="chat-body">'+data.body+'</span></div>');
 				$('#replyContent').hide();
 				$('#replyHide').show();
 			}
	 	}
 	});
 });

  $('#note').click(function() {
 	var note = $('.notetext').val();
 	var thread_id = $('#threadId').val();
 	$.ajax(
 	{
 		url : '/addNote',
 		type :'post',
 		data : {note : note, thread_id : thread_id},
 		success: function(data) {
 			if(data["mail"] == "false") {
 				alert('fail');
 			}else{
 				$('#chatBox').append('<li class="out"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" /><div class="message"><span class="chat-arrow"></span><a href="#" class="chat-name">'+data.from+'</a>&nbsp; at<span title="'+data.time+'" data-livestamp="'+data.time+'"></span><span class="chat-body">'+data.body+'</span></div>');
 				$('#noteContent').hide();
 				$('#replyHide').show();
 			}
	 	}
 	});
 });



});


