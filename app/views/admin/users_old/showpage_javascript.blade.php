    <script type="text/javascript">
                $(document).ready(function(){
          
            $('button.raise_ticket').click(function(){
                $(".show_form").slideToggle("high");
            });
            });
    </script>
    <script type="text/javascript">
    function ticket(t) {
        window.open("<?php public_path() ?>/admin/users-old/ticket-popup/"+t, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }
    function bill(x) {

        window.open("<?php public_path() ?>/admin/users-old/bill-popup/"+x, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }
    function datausage(y) {
        window.open("<?php public_path() ?>/admin/users-old/datausage-popup/"+y, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }
    function payment(z) {
        window.open("<?php public_path() ?>/admin/users-old/payment-popup/"+z, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }
  
    function cust_password_acc_id() {
        window.open("<?php public_path() ?>/admin/users-old/showpassword/{{$user->account_id}}", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=800, height=400");
    }

     function Logs(p) {
            var account_id =+p;
                $.ajax({
                    url : '/admin/users-old/log_ajax',
                    type : 'GET',
                    data : {account_id :account_id},
                    dataType:'json',
                    success : function(data) {
                        if (data["found"] == "false") {
                                    alert('Logs Not available');
                                }else{
                        $('#records_table tbody').remove();
                         var trHTML = '';
                        $.each(data, function (i, item) {
                            trHTML += '<tr><td>' + item.created + '</td><td>' + item.username  + '</td><td>' + item.mac + '</td><td>'+ item.ap_mac + '</td><td>'+ item.message + '</td></tr>';
                        });
                    $('#records_table').append(trHTML);
                    }
                }
                });
    }

    </script>
    <script type="text/javascript">
          jQuery(document).ready(function() {
            var oTable = jQuery('#bills').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/admin/bills/user_bill?account_id={{$user->account_id}}',
                       "type":'get',

                        "createdRow": function ( row, data, index ) {
                    if(data[12] == "paid"){
                            $('td:eq(12)', row).html('<span style="color:green">Paid</span>');
                    }else if(data[12] == "not_paid"){
                            $('td:eq(12)', row).html('<span style="color:red">Not Paid</span>');
                    }else if(data[12] == "partially_paid"){
                            $('td:eq(12)', row).html('<span style="color:orange">Partially Paid</span>');
                    }
                },

                   });

             var oTable = jQuery('#payments').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/admin/payments/payment_user?account_id={{$user->account_id}}',
                       "type":'get',
                   });

              var oTable = jQuery('#usages').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/admin/usages/usage_user?account_id={{$user->account_id}}',
                       "type":'get',
                        "createdRow": function ( row, data, index ) {
                        var total_gb=data[8]/1000000000;
                        var gb=total_gb.toFixed(2);
                        $('td:eq(8)', row).html(gb);
                },
                   });

              var oTable = jQuery('#session').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/admin/session/session_history?account_id={{$user->account_id}}',
                       "type":'get',
                   });

              var oTable = jQuery('#active_session').dataTable({
                processing: true,
                serverSide: true,
                       "ajax": '/admin/users-old/active_session_ajax?account_id={{$user->account_id}}',
                       "type":'get',
                   });

              var oTable = jQuery('#ticket').dataTable({
                processing: true,
                serverSide: true,
                "pageLength": 3,
                       "ajax": '/admin/users-old/ticket_ajax?account_id={{$user->account_id}}',
                       "type":'get',
                   });


            });
    </script>