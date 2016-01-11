<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keyword" content="OODOO Fiber, pay OODOO Fiber, Pay BIll, payment, Bill Payment">

    <title>Pay Bill | OODOO Fiber</title>

    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/bootstrap-reset.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/font-awesome.css">

    <!-- <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/jquery.easy-pie-chart.css">
 -->

    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/owl.carousel.css">

    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/slidebars.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/owl.carousel.css">

    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/style.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/style-responsive.css">



    
    <script src="/assets/dist/user/js/jquery.js"></script>
    <script src="/assets/dist/user/js/bootstrap.min.js"></script>

    <script src="/assets/dist/user/js/jquery.validate.min.js"></script>

    <script src="/assets/dist/user/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/assets/dist/user/js/jquery.scrollTo.min.js"></script>
    <script src="/assets/dist/user/js/jquery.nicescroll.js"></script>
    <script src="/assets/dist/user/js/jquery.sparkline.js"></script>
    <!-- <script src="/assets/dist/user/js/jquery.easy-pie-chart.js"></script>
 -->
    
    <!-- <script src="/assets/dist/user/js/easy-pie-chart.js"></script>
 -->
    <script src="/assets/dist/user/js/count.js"></script>
    <script src="/assets/dist/user/js/oodoo.js"></script>


        <style type="text/css">
            .error {
                color:red;
            }
        </style>
		
	  <script type="text/javascript">
		var hash = '';
		function submitPaymentForm() {
		  if(hash == '') {
			return;
		  }
		  var PaymentForm = document.forms.PaymentForm;
		  PaymentForm.submit();
		}
		</script>
		<script type="text/javascript">
		function CalcPGchargees() {
		billamt = $('#udf2').val();
		pgcharges = billamt * 0.02;
		amount = (billamt*1) + (pgcharges*1);
		$('#udf3').val(pgcharges);
		$('#amount').val(amount);
		}
		</script>
  
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->


  </head>

  <body onload="submitPaymentForm()" background="/assets/dist/user/img/">

  <section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
          <!--logo start-->
          <a href="index.php" class="logo" >OODOO&nbsp;<span>Fiber</span></a>
          <!--logo end-->

      </header>
      <!--header end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->

            <div class="panel-body" style="width: 525px;">
                @if( $errors->has() || Session::has('failure') )
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>
                        <i class="icon-remove red"></i>
                        @foreach ($errors->all() as $message) 
                            <span>{{$message}}</span><br/>
                        @endforeach
                        {{Session::get('failure')}}
                    </div>
                @endif
                @if( Session::has('success') )
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>
                        <i class="icon-ok green"></i>
                        {{Session::get('success')}}
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <section class="panel">
                        <header class="panel-heading">
                            <h4> Pay OODOO Fiber Bill </h4>
                        </header>
                        <div class="panel-body">
							{{ Form::open( array( 'route' => array('users.payments.anonymousConfirmPayment'), 'method' => 'POST','class' => 'anonymous-pay-form validate-form')  ) }}
                                <input type="hidden" name="bill_no">
                                <input type="hidden" name="gateway_amount" id="gateway_amount">
                                <div class="form-group">
                                    <label for="udf1">Account ID</label>
                                    <input type="text" class="form-control" name="account_id" value="" placeholder="Enter your OODOO Account ID" required>
                                    <label for="account_id" class="error account_id_error" style="display:none;"></label>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Bill Amount</label>
                                    <input type="text" class="form-control" name="payable_amount" value="" placeholder="Enter Bill Amount" required onchange="CalcPGchargees()" class="payable_amount">
                                </div>
								<div class="form-group">
                                    <label for="amount">Total Amount <br>(Payment Gateway Charges 1%)</label>
                                    <input type="text" class="form-control total_payment" name="amount" value="" required readonly placeholder="Additional of Payment Gateway Charges 1%">
                                </div>
                                <div class="form-group">
                                    <label for="firstname">Name</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="" placeholder="Enter Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" value="" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label for="MobileNo">Mobile No</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="" maxlength="10" minlength="10" placeholder="Enter Mobile Number" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" required value="yes" name="tac" id="tac"> Agree to <a href="tac.html">Terms and Conditions</a>
                                        </label>
                                </div>
								<button type="submit" class="btn btn-info">Submit</button>
							{{Form::close();}}
                          </div>
                          </section>
                      </section>
                    </div>
                </div>
				  <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              <?php echo date("Y"); ?> &copy; OODOO Fiber.
              <a href="#" class="go-top">
                  <i class="fa fa-angle-double-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/assets/dist/user/js/owl.carousel.js"></script>
    <script src="/assets/dist/user/js/jquery.customSelect.min.js"></script>
    <script src="/assets/dist/user/js/respond.min.js"></script>
    <script src="/assets/dist/user/js/slidebars.min.js"></script>
    <script src="/assets/dist/user/js/common-scripts.js"></script>
    <script src="/assets/dist/user/js/sparkline-chart.js"></script>

  <!--script for this page-->

    <script type="text/javascript">
        $(document).ready(function(){

            $('input[name="account_id"]').on('keyup keypress blur change', function() {
                var account_id = $('input[name="account_id"]').val();
                $.ajax({
                    url : '/payments/anonymous-get-bill-no',
                    type :'GET',
                    data : {account_id : account_id},
                    success : function(data) {
                        if (data["status"] == "success") {
                            if( 0 < parseInt(data["payable_amount"])) {
                                $('input[name="bill_no"]').val(data["bill_no"]);  
                                /*$('input[name="firstname"]').val(data["firstname"]);  
                                $('input[name="email"]').val(data["email"]);  
                                $('input[name="phone"]').val(data["phone"]);  */
                                $('input[name="payable_amount"]').val(parseInt(data["payable_amount"]));

                                var payable_amount = $('input[name="payable_amount"]').val();
                                var gateway_amount = parseInt(payable_amount * 0.01);
                                var total_amount = parseInt(payable_amount *1) + parseInt(gateway_amount * 1);
                                $('.total_payment').val(total_amount);
                                $('#gateway_amount').val(gateway_amount);
                            }else{
                                $('label.account_id_error').html('NO BALANCE.YOUR BILL YET TO BE GENERATED.').show();
                            }
                            
                            //$('form.anonymous-pay-form').submit();
                        } else if(data["status"] == "failure"){
                            $('label.account_id_error').html(data['status']).show();
                        }else{
                            $('input[name="bill_no"]').val("");
                            $('input[name="bill_no"]').val("");  
                            $('input[name="firstname"]').val("");  
                            $('input[name="email"]').val("");  
                            $('input[name="phone"]').val("");  
                            $('input[name="payable_amount"]').val("");  
                            $('.total_payment').val("");
                             //alert("Bill Not Available for this Account ID")
                            //return false;
                        }
                        
                    }

                });                
            });

            $('button[type="submit"]','form.anonymous-pay-form').click(function(){
                var bill_no = $('input[name="bill_no"]').val();
                if (bill_no.length == 0){
                    $('label.account_id_error').html('Either Account ID is not valid or Bill is not available').show();
                    return false;
                }
            });

            $('.error').css('color','red');

            $('input[name="payable_amount"]').keyup(function(){
                var payable_amount = $(this).val();
                if ( (payable_amount.length != 0) &&(!isNaN(payable_amount))){
                    var gateway_amount = parseInt(payable_amount * 0.01);
                    var total_amount = parseInt(payable_amount *1) + parseInt(gateway_amount);
                    $('.total_payment').val(total_amount);
                    $('#gateway_amount').val(gateway_amount);    
                }
            });
        });
    </script>
  

  </body>
</html>
