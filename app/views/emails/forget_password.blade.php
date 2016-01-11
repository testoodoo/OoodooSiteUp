<table style="background:#fff;border:0;border-left:1px solid #ccc;border-right:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="670">
<tbody>
<tr>
<td> <a href="" style="border:none;color:#0084b4;text-decoration:none" target="_blank"><span></span></a>
<table style="background:#f2f2f2;table-layout:fixed" border="0" cellpadding="0" cellspacing="0" width="670">
<tbody>
<tr>
<td style="width:19px;height:77px"> &nbsp; </td>
<td rowspan="2" style="background:#fff;line-height:100%" height="77" valign="top" width="54">
<a href="http://www.oodoo.co.in" style="border:none;color:#0084b4;text-decoration:none" target="_blank">
<img class="CToWUd" src="http://oodoo.co.in/img/email/logo_small.png" style="border:0;line-height:100%;border:0" height="77" width="54"></a>
</td>
<td width="9"> &nbsp; </td>
<td height="77" width="10"> &nbsp; </td>
<td style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333" height="77" width="458">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="font-size:14px;font-weight:bold;color:#000"> 
	<span dir="ltr">{{ $user->first_name}} {{ $user->first_name}},</span> 
</td>
</tr>
<tr>
<td style="font-size:14px;color:#666"> Forgot your OODOO password? </td>
</tr>
</tbody>
</table> </td>
<td height="77" width="10"> &nbsp; </td>
<td style="width:85px"></td>
</tr>
<tr>
<td style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif">&nbsp;</td>
<td style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif">&nbsp;</td>
<td colspan="4" style="background:#fff;border-top:1px solid #ddd;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif" height="17">&nbsp;</td>
</tr>
</tbody>
</table> </td>
<td rowspan="3"></td>
</tr>
<tr>
<td style="background:#fff">  
<table style="background:#fff;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif" align="center" border="0" cellpadding="0" cellspacing="0" width="520">
<tbody>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="padding:10px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333;padding-bottom:0;font-size:15px;line-height:20px"> We received a request to reset the password for your account, <a style="direction:ltr;border:none;color:#0084b4;text-decoration:none" target="_blank">
	{{ $user->account_id}}
	</a>. 
</td>
</tr>
<tr>
<td style="padding:10px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333;padding-bottom:0;font-size:15px;line-height:20px"> If you made this request, click the button below. If you didn't make this request, you can ignore this email. </td>
</tr>
<tr>
<td height="10"></td>
</tr>
<tr>
<td style="padding:10px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<table style="white-space:nowrap;background-color:#33a9e5;border-radius:5px;border:1px solid #2288cc;padding:5px 0 5px 0;text-align:center;height:28px" background="http://oodoo.co.in/img/email/button_bg.png" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="color:#ffffff;font-size:13px;font-weight:bold;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;white-space:nowrap;padding-left:30px;padding-right:30px" align="center"><span>
	<a href="{{ Request::root() }}/users/reset-password-request?token={{$token}}" style="border:none;color:#0084b4;text-decoration:none;color:#ffffff;font-size:13px;font-weight:bold;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif" target="_blank">Reset your password</a></span></td>
</tr>
</tbody>
</table> </td>
</tr>
</tbody>
</table> </td>
</tr>
<tr>
<td style="padding:10px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333;padding-bottom:0;font-size:15px;line-height:20px"> Or use this link to reset your password:<br> <a href="{{ Request::root() }}/users/reset-password-request?token={{$token}}" style="border:none;color:#0084b4;text-decoration:none" target="_blank">
	{{ Request::root() }}/users/reset-password-request?token={{$token}}
</a> </td>
</tr>
<tr>
<td style="padding:10px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#333;padding-bottom:0;font-size:15px;line-height:20px"> If you're getting a lot of password reset emails you didn't request, you can change your <a href="http://accounts.oodoo.co.in" style="border:none;color:#0084b4;text-decoration:none" target="_blank">account settings</a> to require personal information to reset your password. </td>
</tr>
<tr>
</tr>
<tr>
<td height="25"></td>
</tr>
</tbody>
</table> </td>
</tr>
</tbody>
</table> </td>
</tr>
<tr>
<td>
<table style="background-color:#eee;background-image:url('http://oodoo.co.in/img/email/shadow-bottom.jpg');background-repeat:repeat-x;border-top-color:#ddd;border-top-style:solid;border-top-width:1px" bgcolor="#eeeeee" border="0" cellpadding="0" cellspacing="0" width="670">
<tbody>
<tr>
<td colspan="4" height="16"></td>
</tr>
<tr>
<td style="width:85px"></td>
<td style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:12px;line-height:17px;color:#777">
<div>
Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email related to your use of OODOO Fiber.
</div>
<div>
<a style="border:none;color:#0084b4;text-decoration:none;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;text-decoration:none;font-size:11px;line-height:17px;color:#999999">OODOO Communications. #15, Govindaswamy Street, Sholinganallur <span style="white-space:nowrap">Chennai - 600119 </span></a>
</div> </td>
<td style="width:85px"></td>
</tr>
<tr>
<td colspan="3" height="25"></td>
</tr>
</tbody>
</table> </td>
</tr>
</tbody>
</table>
