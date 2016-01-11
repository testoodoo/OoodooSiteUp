<div style="margin:0;padding:0">
<table style="font-size:13px" align="center" bgcolor="#f2f2f2" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
  <td colspan="3" height="10"></td>
</tr>
<tr>
  <td width="10%"></td>
  <td width="80%"><table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="580">
      <tbody><tr>
        <td colspan="3" bgcolor="#dddddd" height="1"></td>
      </tr>
      <tr>
        <td bgcolor="#dddddd" width="1"></td>
        <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
              <td width="20"></td>
              <td><div>
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                      <td colspan="2" height="20"></td>
                    </tr>
                    <tr>
                      <td valign="middle" width="50%"><a><img class="CToWUd" src="http://www.oodoo.co.in/img/email/logo_text_50x200.png" alt=""></a></td>
                    </tr>
            <td></td>
                    <tr>
                      <td colspan="2" style="color:#666666;font-size:1em;line-height:22px;font-family:Arial,Helvetica,sans-serif">Dear <span class="il">{{ $payer_name }},</span></a></td>
                    </tr>
                    <tr>
                      <td height="16"></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="color:#666666;font-size:1em;line-height:22px;font-family:Arial,Helvetica,sans-serif">Thank you for paying {{ $user->first_name }}'s OODOO Fiber Bill. Your Payment has been successfully processed</td>
                    </tr>
                                        <tr>
                      <td colspan="2" height="28"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody><tr>
                            <td></td>
                            <td colspan="6" bgcolor="#ececec" height="1"></td>
                          </tr>
                          <tr>
                            <td style="color:#666666;font-size:1em;line-height:22px;font-family:Arial,Helvetica,sans-serif" height="31" valign="middle">Account ID: <strong style="color:#000000;font-weight:normal"> {{ $user->account_id }}</strong></td>
                            <td bgcolor="#ececec" width="1"></td>
                            <td bgcolor="" width="7"></td>
                            <td style="color:#666666;font-size:1em;line-height:22px;font-family:Arial,Helvetica,sans-serif" width="107">Transaction Amount:</td>
                            <td style="color:#000;font-size:1em;line-height:22px;font-family:Arial,Helvetica,sans-serif" align="right">
                                Rs&nbsp;
                                    <?php $transaction_amount = $transaction->amount + ($transaction->amount * 0.02) ?>
                                    {{ $transaction_amount }}
                                </td>
                            <td width="7"></td>
                            <td bgcolor="#ececec" width="1"></td>
                          </tr>
                          <tr>
                            <td colspan="7" bgcolor="#e9e9e9" height="1"></td>
                          </tr>
                          <tr>
                            <td style="color:#666666;font-size:1em;line-height:22px;font-family:Arial,Helvetica,sans-serif" height="31" valign="middle">Transaction ID: <strong style="color:#000000;font-weight:normal">{{$transaction->transaction_code}}</strong></td>
                          </tr>

                        </tbody></table></td>
                    </tr>
                    <tr>
                      <td colspan="2" height="29"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tbody><tr>
                            <td bgcolor="#28bbf2" height="36" width="10"></td>
                            <td style="color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-weight:bold;font-size:1em;line-height:14px" bgcolor="#28bbf2" valign="middle">Payment&nbsp;Summary</td>
                            <td style="color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-weight:bold;font-size:12px;line-height:14px" align="right" bgcolor="#28bbf2" valign="middle">Amount</td>
                            <td bgcolor="#28bbf2" width="10"></td>
                          </tr>
                        </tbody></table></td>
                    </tr>
                    <tr>
                      <td colspan="2" height="1"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                      <tbody><tr>
                              <td height="36" width="10"></td>
                              <td style="color:#666666;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:14px" valign="middle">Bill Amount</td>
                              <td style="color:#666666;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:14px" align="right" valign="middle">Rs {{$bill->total_charges}} /-</td>
                              <td width="10"></td>
                            </tr>
                            <tr>
                              <td colspan="4" bgcolor="#e6e6e6" height="1"></td>
                            </tr>
                                                                                    <tr>
                              <td height="36" width="10"></td>
                              <td style="color:#666666;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:14px" valign="middle"><span style="float:left">DISCOUNT&nbsp;</span><img class="CToWUd" src="http://www.oodoo.co.in/img/email/saving_img.gif" alt=""></td>
                              <td style="color:#666666;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:14px" align="right" valign="middle">Rs {{ $bill->discount }} /-</td>
                              <td width="10"></td>
                            </tr>
                            <tr>
                              <td colspan="4" bgcolor="#e6e6e6" height="1"></td>
                            </tr>
                                                                                    
                          <tr>
                            <td colspan="4" bgcolor="#e6e6e6" height="1"></td>
                          </tr>
                          <tr>
                            <td height="36" width="10"></td>
                            <td style="color:#000000;font-weight:bold;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:14px" valign="middle">Amount Paid</td>
                            <td style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:1em;font-weight:bold;line-height:14px" align="right" valign="middle">Rs {{$transaction->amount}} /-</td>
                            <td width="10"></td>
                          </tr>
                          <tr>
                            <td height="36" width="10"></td>
                            <td style="color:#000000;font-weight:bold;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:14px" valign="middle">Balance Amount</td>
                            <td style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:1em;font-weight:bold;line-height:14px" align="right" valign="middle">
                              Rs {{$bill->total_charges - $bill->amount_paid}} /-
                            </td>
                            <td width="10"></td>
                          </tr>
                          <tr>
                            <td colspan="4" bgcolor="#e6e6e6" height="1"></td>
                          </tr>
                        </tbody></table></td>
                    </tr>

                                        <tr>
                      <td colspan="2" height="23"></td>
                    </tr>
                                         <tr>
                      <td style="color:#666666;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:20px" colspan="2">Your Account will be credited with the amount paid within 24 Hours. To view details of the payment,</td>
                    </tr>
                                        
                                        <tr>
                      <td colspan="2" height="23"></td>
                    </tr>
                                         <tr>
                      <td colspan="2" align="center"><a style="background:#009fe3;width:185px;min-height:42px;display:inline-block;color:#fff;font-size:15px;line-height:42px;font-family:Arial,Helvetica,sans-serif;text-align:center;text-decoration:none" href="http://accounts.oodoo.co.in" target="_blank">Login&nbsp;Here</a></td>
                    </tr>
                    <tr>
                      <td colspan="2" height="23"></td>
                    </tr>
                                        <tr>
                      <td style="color:#666666;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:20px" colspan="2">For any queries please reach out to us at <a style="color:#28bbf2;text-decoration:none">mail@oodoo.co.in</a> or +91 8940808080</td>
                    </tr>
                    <tr>
                      <td colspan="2" height="17"></td>
                    </tr>
                    <tr>
                      <td style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:20px" colspan="2"><strong>Best Regards,</strong><br>
                        Team OODOO Fiber</td>
                    </tr>
                    <tr>
                      <td colspan="2" height="20"></td>
                    </tr>
                  </tbody></table>
                </div></td>
              <td width="20"></td>
            </tr>
          </tbody></table></td>
        <td bgcolor="#dddddd" width="1"></td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#dddddd" height="1"></td>
      </tr>
    </tbody></table></td>
  <td width="10%"></td>
</tr>
<tr>
<td><img class="CToWUd" src="" height="1" width="1"></td></tr></tbody></table></div>