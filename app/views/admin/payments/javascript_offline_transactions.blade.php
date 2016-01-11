<script type="text/javascript">
    $(document).ready(function(){

        $('div.new_customers').hide();
        $('div.exit_customers').show();
        $('div.card_payment').hide();
        $('div.multi_bill_new').hide();
        $('div.multi_bill').hide();


       $('select.select_transaction_type').change(function(){
            if ($(this).val() == "cheque") {
                $('div.cheque_fields').show();
                $('div.card_payment').hide();
            } else if($(this).val() == "cash"){
                $('div.card_payment').hide();
                $('div.cheque_fields').hide();
                }else{
                    $('div.card_payment').show();
                    $('div.cheque_fields').hide();
            }
        });

        //part_payment 
        $('select.bill_type').change(function(){
            if ($(this).val() == "multi_bill") {
                $('div.multi_bill').show();
                $('div.single_bill').hide();
                $('div.new_customers').hide();
            } else if($(this).val() == "single_bill"){
                $('div.new_customers').hide();
                $('div.multi_bill').hide();
                $('div.single_bill').show();
                }else{
                $('div.multi_bill').hide();
                $('div.single_bill').show();
                $('div.new_customers').show();
            }
        });

        $('select.select_transaction_type').change(function(){
            if ($(this).val() == "cash") {
                $('div.multi_bill').hide();
                $('div.single_bill').show(); 
            } 
        });

        $('select.bill_type').change(function(){
            if (($(this).val() == "single_bill")&&($('select.select_payment_type').val()=="exiting_customers"))  {
                $('div.new_customers').hide();
            }
        });
         $('select.bill_type').change(function(){
            if (($(this).val() == "single_bill")&&($('select.select_payment_type').val()=="new_customers"))  {
                $('div.new_customers').show();
            }
        });
         $('select.bill_type').change(function(){
            if (($(this).val() == "single_bill")&&($('select.select_payment_type').val()=="device_details"))  {
                $('div.new_customers').show();
            }
        });



       //payment for new customers and exiting customers
       $('select.select_payment_type').change(function(){
            if ($(this).val() == "exiting_customers" || $(this).val() == "planchange_topup" ) {
                $('div.exit_customers').show();
                 $('div.new_customers').hide();
                 $('div.multi_bill').hide();
            } else {
                $('div.new_customers').show();
                 $('div.exit_customers').hide();
                 $('div.multi_bill').hide();
            }
        });

        
         $('div.form_payment_transaction_id').hide();

              //add form by using javascript
            $("#add").click(function (e) {
                $(".form_multi_transaction_id").append('<div class="form-group body"><div class="col-sm-2"></div>Transaction id&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="transaction_id[] class="form-horizontal">&nbsp;&nbsp;&nbsp;<span  class="btn btn-sm btn-primary delete">Delete</span></div>');
            });

            $("body").on("click", ".delete", function (e) {
                    $(this).parent("div").remove();
            });
            $("#addition").click(function (e) {
                $(".form_multi_bill").append('<div class="form-group body"><div class="col-xs-3 col-sm-3 control-label no-padding-right">Account id</div>&nbsp;&nbsp;&nbsp;<input type="text" name="account_ids[] value="" onchange="billfetch()" class="acc_id">&nbsp;&nbsp;&nbsp;Bill No&nbsp;&nbsp;&nbsp;<input type="text" name="bill_nos[] value="" class="bil_no">&nbsp;&nbsp;&nbsp;Amount&nbsp;&nbsp;&nbsp;<input type="text" name="amounts[] value="" class="amt">&nbsp;&nbsp;&nbsp;<span  class="btn btn-sm btn-primary delete">Delete</span></div>');
            });

            $("#addition_new").click(function (e) {
                $(".form_multi_bill_new").append('<div class="form-group body"><div class="col-xs-3 col-sm-3 control-label no-padding-right">CRF NO</div>&nbsp;&nbsp;&nbsp;<input type="text" name="account_ids_new[] value=""><input type="hidden" name="bill_new_cust[]" value="300300"> <input type="hidden" name="bill_new_dev[]" value="400400">&nbsp;&nbsp;&nbsp;Amount&nbsp;&nbsp;&nbsp;<input type="text" name="amounts_new[] value="">&nbsp;&nbsp;&nbsp;<span  class="btn btn-sm btn-primary delete">Delete</span></div>');
            });
                               
                                                                                                                                                                                                                                                                                                    
            $("body").on("click", ".delete", function (e) {
                $(this).parent("div").remove();
            });

       $('select.bill_type').change(function(){
            if($(this).val() =="multi_bill"){
                $('.select_transaction_type').empty();
                $('.select_transaction_type').append(new Option("Select Transaction Type",""));
                $('.select_transaction_type').append(new Option("Card","card"));
                $('.select_transaction_type').append(new Option("Cheque","cheque"));
            }else{
                $('.select_transaction_type').empty();
                $('.select_transaction_type').append(new Option("Select Transaction Type",""));
                $('.select_transaction_type').append(new Option("Cash","cash"));
                $('.select_transaction_type').append(new Option("Card","card"));
                $('.select_transaction_type').append(new Option("Cheque","cheque"));
            }
         });

         $('select.bill_type').change(function(){
            if($(this).val() =="new_cust_multi_bill"){
                $('.select_transaction_type').empty();
                $('.select_transaction_type').append(new Option("Select Transaction Type",""));
                $('.select_transaction_type').append(new Option("Card","card"));
                $('.select_transaction_type').append(new Option("Cheque","cheque"));
                $('div.multi_bill_new').show();
                $('div.new_customers').hide();
                $('div.single_bill').hide();
            }else{
              $('div.multi_bill_new').hide();   
            }
         });

        $('select.select_payment_type').change(function(){
            if ($(this).val() == "new_customers") {
                $('.bill_type').empty();
                $('.bill_type').append(new Option("Select Bill Type",""));
                $('.bill_type').append(new Option("Single bill","single_bill"));
                $('.bill_type').append(new Option("New Cust Multi bill","new_cust_multi_bill"));
            }else{
                $('.bill_type').empty();
                $('.bill_type').append(new Option("Select Bill Type",""));
                $('.bill_type').append(new Option("Single bill","single_bill"));
                $('.bill_type').append(new Option("Multi bill","multi_bill"));
            }
        });

        $('select.select_payment_type').change(function(){
            if ($(this).val() == "device_details") {
                $('.device_bill').val(400400);
                $('.bill_type').empty();
                $('.bill_type').append(new Option("Select Bill Type",""));
                $('.bill_type').append(new Option("Single bill","single_bill"));
                $('.bill_type').append(new Option("New Cust Multi bill","new_cust_multi_bill"));
                $('.select_transaction_type').empty();
                $('.select_transaction_type').append(new Option("Select Transaction Type",""));
                $('.select_transaction_type').append(new Option("Cash","cash"));
                $('.select_transaction_type').append(new Option("Card","card"));
                $('.select_transaction_type').append(new Option("Cheque","cheque"));
            }
        });



    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    //checked for payment date
    $('.sr').attr('readonly',true);
    $('.sr').attr('placeholder',"Don't Enter payment date");

        $('#s').change(function(){
            if($('#s:checked').length){
                $('.sr').attr('readonly',false);
                $('.sr').attr('placeholder',"Enter payment date");

            }else{
                $('.sr').attr('readonly',true);
                $('.sr').attr('placeholder',"Don't Enter payment date");
            }
        });

            

    });


    
</script>
<script type="text/javascript">
        function billfetch(){
    
            if($('.acc_id').val()){
               var account_id = $('.acc_id').val();
            }else{
                var account_id = $('.acct_id').val();
            }
               
                $.ajax({
                    url : 'fetchBillNo',
                    type : 'POST',
                    data : {account_id :account_id},
                   success : function(data) {
                            if (data["found"] == "false") {
                                alert('Account Id not Found');
                            } else {
                                $('.acc_id').val(data['account_id']);
                                $('.amt').val(data['amount']);
                                $('.bil_no').val(data['bill_no']);
                                var amount=data['amount'];
                                var subtotal=$('.total_amount').val()
                                var totalamount= +subtotal+ +amount;
                                $('.total_amount').val(totalamount)
                                
                                $('.amt').removeClass();
                                $('.bil_no').removeClass();
                                $('.acc_id').removeClass();

                                }
                        }
                })
            }

    function payment(){
             $('div.form_payment_cash').hide();
             $('div.form_payment_transaction_id').show();
        }
    function transaction(){
             $('div.form_payment_cash').show();
             $('div.form_payment_transaction_id').hide();
        }
    function paymentDate(){
             
        }

    function check(){
                $('form').submit(function() {
                $(this).find("button[type='submit']").prop('disabled',true);
                    });
            }

</script>