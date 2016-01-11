<html>
	<link media="all" type="text/css" rel="stylesheet" href="/assets/dist/user/css/payment-process.css">
	<header class="clearfix norm-hd">
	    <table class="header-table" cellspacing="0" border="0">
	        <tbody>
	        <tr>
	            <td class="mer-logo-wrap hd-logo">
                    <img src="/assets/dist/user/img/oodoo_logo.png" alt="merchant-logo">
	            </td>
	            <td class="payz-logo-wrap hd-logo">
                    <h1 style="float:right;">OODOO&nbsp;<i style="color:red">FIBER</i></h1>
	            </td>
	        </tr>
	        </tbody>
	    </table>
	</header>
	<head>
		{{ HTML::script('/assets/dist/user/js/jquery.js') }}
			<script type="text/javascript">
				$(document).ready(function() {
					$("#payuform").submit();
				});
			</script>

	</head>
<body>
	<form id="payuform" method="post" action="{{$gateway_url}}" style="display:none">
		<input name="key" type="hidden" value="{{ $key }}" />
		<input name="txnid" type="hidden" value="{{ $txnid }}" />
		<input name="amount" type="hidden" value="{{ $amount }}" />
		<input name="productinfo" type="hidden" value="{{ $productinfo }}" />
		<input name="firstname" type="hidden" value="{{ $firstname }}" />
		<input name="email" type="hidden" value="{{ $email }}" />
		<input name="phone" type="hidden" value="{{ $phone }}" />
		<input name="surl" type="hidden" value="{{ $s_url }}" />
		<input name="furl" type="hidden" value="{{ $f_url }}" />
		<input name="hash" type="hidden" value="{{ $hash_str }}" />
		<input type="hidden" name="service_provider" value="{{$service_provider}}"/>
		<input name="udf1" type="hidden" value="{{$udf1}}" />
		<input name="udf2" type="hidden" value="{{$udf2}}" />
		<input name="udf3" type="hidden" value="{{$udf3}}" />
		<input name="udf4" type="hidden" value="{{$udf4}}" />
		<input name="udf5" type="hidden" value="{{$udf5}}" />
		<input name="udf6" type="hidden" value="{{$udf6}}" />
		<input name="udf7" type="hidden" value="{{$udf7}}" />
		<input name="udf8" type="hidden" value="{{$udf8}}" />
		<input name="udf9" type="hidden" value="{{$udf9}}" />
		<input name="udf10" type="hidden" value="{{$udf10}}" />
	</form>
	<div class="wrap" id="detect-iframe">
	    <style>
		    .clr {
		        overflow: hidden;
		    }
		    .mer-logo-wrap {
		        text-align: left;
		        padding-left: 35px;
		    }
		    .header-table {
		        width: 100%;
		    }
		    .header-table td {
		        vertical-align: middle;
		        width: 49.9%;
		    }
		    .mer-logo-wrap > img {
		        max-height: 75px;
		    }
		    .payz-logo-wrap {
		        text-align: right;
		        padding-right: 35px;
		    }
		    .norm-hd {
		        padding: 15px 0;
		        position: relative;
		        z-index: 1000;
		        border-bottom: 1px solid #e5e5e5;
		    }
		</style>

    
    <section class="main-info info">

            Redirecting you to secure payment gateway...<br>
        <p style="color:red"> Please do not refresh the page </p>
        <div class="progress progress-striped active">
            <div class="bar" style="width: 100%;"></div>
        </div>
        <div id="delay-message" style="font-size: 14px; color: red; margin-top: 1em;"></div>
    </section>
    
    
</body></html>
