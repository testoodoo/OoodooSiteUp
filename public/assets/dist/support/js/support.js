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
    var complaint_type = $('.complaint_type').val();
    var assign_to = $('#emp_subs').val();
    var body = $('.textarea').val();
    var thread_id = $('#threadId').val();

 	$.ajax(
 	{
 		url : '/replyMessage',
 		type :'get',
 		data : {body : body, thread_id : thread_id, assign_to : assign_to, complaint_type : complaint_type },
 		success: function(data) {
 			if(data["mail"] == "false") {
 				alert('fail');
 			}else{
                $('#chatBox').append('<li class="out"><img src="/assets/dist/support/images/avatar/assign.png" class="avatar img-responsive" /><div class="message" style="background-color: #F3E5AB;"><span class="chat-arrow"></span><a href="#" class="chat-name">'+data.from+'</a>&nbsp; at<span title="'+data.time+'" data-livestamp="'+data.time+'"></span><span class="chat-body">'+data.from+' assigned the complaint to '+data.assign_to+'</span></div><br><li class="out"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" /><div class="message" style="background-color: #E3E4FA;><span class="chat-arrow"></span><a href="#" class="chat-name">'+data.from+'</a>&nbsp; at<span title="'+data.time+'" data-livestamp="'+data.time+'"></span><span class="chat-body">'+data.body+'</span></div><br>');
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
                if(data.label == 'note'){
                    $('#chatBox').append('<li class="out"><img src="/assets/dist/support/images/avatar/note.jpg" class="avatar img-responsive" /><div class="message"><span class="chat-arrow"></span><a href="#" class="chat-name">'+data.from+'</a>&nbsp; at<span title="'+data.time+'" data-livestamp="'+data.time+'"></span><span class="chat-body">'+data.body+'</span></div><br>');
                }else{
                   $('#chatBox').append('<li class="out"><img src="/assets/dist/support/images/avatar/49.jpg" class="avatar img-responsive" /><div class="message"><span class="chat-arrow"></span><a href="#" class="chat-name">'+data.from+'</a>&nbsp; at<span title="'+data.time+'" data-livestamp="'+data.time+'"></span><span class="chat-body">'+data.body+'</span></div><br>');
                }
 				$('#noteContent').hide();
 				$('#replyHide').show();
 			}
	 	}
 	});
 });

    $('input[type=radio][name=connection_type]').change(function(){
        $('#new_conn, #exist_conn').toggle('slow');        
    });


    $('#input-chat').on('input',function(){ 
        var query = $('#input-chat').val();   
        var oTable = jQuery('#myTable').dataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bSearchable": true,
        "pageLength": 6,
        "ajax": '/userDetails?query='+query+'',
        "type":'get',
        "aoColumns": [{"sType":"string"}],
        "columnDefs": [
            {
                "targets": [ 3 ],
                "visible": false,
            }
        ]        

        });
    });
     $("#myTable tbody").on('click','tr',function(){
        var table = $('#myTable').DataTable();
        var rowData = table.row( this ).data();
        window.location.href = 'userDet/'+rowData[3]+'';

    });

/*  function mailUp(){
    $.ajax({
        url : '/mailSupportio',
        type : 'GET'
    });
  }

mailUp();

        setInterval( function () {
                mailUp()
                    }, 1000 );*/

    function Refersh(){
        $.ajax({
            url : '/navbar',
            type : 'GET',
            success : function(data){
                $('.active_session').text(data['active_session']);
                $('#new_ticket').text(data['new_ticket']);
                $('#total_ticket').text(data['total_ticket']);
                var network=data['server_1'] + data['server_0'];
                $('.network_status').text(data['server_0']+'/'+network);
                $(".network_area").empty();
                $.each(data['network'], function(i,j){
                    $('.network_area').append('<li><a href="#"><i class="fa fa-tasks fa-fw mrs"></i>'+j['location']+'</a></li>');
                });
                if(data['exo_call']==0){
                   $('.call_status').text('CALL STATUS DOWN');
                   $('.exo_call').text('DOWN');  
                }else{
                   $('.call_status').text('CALL STATUS UP');
                   $('.exo_call').text('UP');  
                }
            }
        });
    }

    Refersh();
    
        setInterval( function () {
                Refersh()
                    }, 15000 );

     function log(p) {
            var account_id =+p;
                $.ajax({
                    url : '/log',
                    type : 'GET',
                    data : {account_id :account_id},
                    dataType:'json',
                    success : function(data) {
                        if (data["found"] == "false") {
                                    alert('Logs Not available');
                                }else{
                        $('#logTable tbody').remove();
                         var trHTML = '';
                        $.each(data, function (i, item) {
                            trHTML += '<tr><td>' + item.created + '</td><td>' + item.username  + '</td><td>' + item.mac + '</td><td>'+ item.ap_mac + '</td><td>'+ item.message + '</td></tr>';
                        });
                    $('#logTable').append(trHTML);
                    }
                }
                });
    }

    function ticketPop(t) {
        window.open("<?php public_path() ?>/ticket_popup/"+t, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }

                        

});


