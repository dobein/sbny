<?
	include "../include/inc_base.php";

	if($mode == "save")
	{
		$subject = "[Referral] $name";



		// 관리자
		$to = "info@moshita.com";
		//$to = "chanyong.lee@gmail.com";

				$message = "
				<html>
				<head>
				  <title>Moshita</title>
				</head>
				<body>
				<table width=600 border=0 cellpadding=0 cellspacing=1 bgcolor=#cccccc>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Company Name</td>
						<td width=200>&nbsp;$name</td>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Contact Name</td>
						<td width=200>&nbsp;$c_name</td>
					</tr>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Street</td>
						<td width=200>&nbsp;$address</td>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;City</td>
						<td width=200>&nbsp;$city</td>
					</tr>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;State</td>
						<td width=200>&nbsp;$state</td>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Zip</td>
						<td width=200>&nbsp;$zip</td>
					</tr>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Phone</td>
						<td width=200>&nbsp;$phone</td>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Fax</td>
						<td width=200>&nbsp;$fax</td>
					</tr>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Referral Company</td>
						<td width=200>&nbsp;$r_name</td>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Referral Contact</td>
						<td width=200>&nbsp;$r_cname</td>
					</tr>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Referral Phone</td>
						<td width=500 colspan=3>&nbsp;$r_phone</td>
					</tr>
					<tr bgcolor=#FFFFFF>
						<td width=100 height=25 bgcolor=#f9f9f9>&nbsp;Content</td>
						<td width=500 colspan=3>&nbsp;$content</td>
					</tr>
				</table>
				";


		// HTML 메일을 보내려면, Content-type 헤더를 설정해야 합니다.
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// 추가 헤더
		$headers .= 'From: '.$name.' <'.$email.'>' . "\r\n";
		$headers .= 'To: moshita <orders@moshita.com>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

		// 메일 보내기
		$result = mail($to, $subject, $message, $headers);


		if($result)
			{
				Misc::jvAlert("Your message has been sent. thank you!.","location.replace('../index.php')");
				exit;		
			}
	}

	include _BASE_DIR ."/include/inc_top.php";
?>
<br>
<table width="95%" align=center border="0" cellspacing="0" cellpadding="0" style='border-top: dotted #000000 1px; border-bottom: dotted #000000 1px;'>
  <tr bgcolor='#d2cab3'> 
	<td height=23 colspan=3>&nbsp;&nbsp;<b>REFERRAL</b></td>
  </tr>
</table>
<br>

      <table width="90%" align=center border="0" cellspacing="0" cellpadding="0">
	<script>
		function chk(tf){
			if(!tf.name.value)
			{
				alert("Enter your company name!");
				tf.name.focus();
				return false;
			}
			if(!tf.email.value && !tf.phone.value)
			{
				alert("Enter your email address or phone number!");
				tf.email.focus();
				return false;
			}

		return true;
		}
	</script>
	<form action=<?= $PHP_SELF ?> method=post onSubmit="return chk(this)">
	<input type=hidden name=mode value="save">
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
<font color=red><b>Receive a $100 Bonus for each of your Referrals.</b></font> <br>
That's right! <br><b>Tiger Fashion, Inc.</b> will give you <font color=red><b>$100 towards</b></font> any merchandise of your choice for <font color=red><b>FREE</b></font> for just referring someone. <br><br>

If you know a business owner who would like to carry our beautiful collections in their store, please fill out the form below and give the retailer's information. That's it. Or You can also call us at <font color=red><b>212.244.1175.</b></font><br><br>

When your referral places their first order, you can redeem your $100 on any item in our collections. <br><br>
			</td>
		</tr>
        <tr bgcolor=#FFFFFF> 
          <td height=35 colspan=2><img src="../images/pilcrow.png" align=absmiddle>&nbsp;&nbsp;<b>Contact US by Email</b></td>
        </tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Your Company Name : </td>
			<td width=75%><INPUT class=input size=22 name=name></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Contact Name : </td>
			<td width=75%><INPUT class=input size=22 name=c_name></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Street address : </td>
			<td width=75%><INPUT class=input size=42 name=address></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;City : </td>
			<td width=75%><INPUT class=input size=30 name=city></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;State : </td>
			<td width=75%><INPUT class=input size=16 name=state></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Zip : </td>
			<td width=75%><INPUT class=input size=5 name=zip></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>

		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;E-mail : </td>
			<td width=75%><INPUT class=input size=42 name=email></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Telephone Number : </td>
			<td width=75%><INPUT class=input size=22 name=phone></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Fax Number : </td>
			<td width=75%><INPUT class=input size=22 name=fax></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Referral Company name: : </td>
			<td width=75%><INPUT class=input size=22 name=r_name></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Referral Contact Name: </td>
			<td width=75%><INPUT class=input size=22 name=r_cname></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Referral Telephone No.: </td>
			<td width=75%><INPUT class=input size=22 name=r_phone></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Subject : </td>
			<td width=75%><INPUT class=input size=50 name=subject></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=140>&nbsp;&nbsp;Comment : </td>
			<td width=75%><textarea name=content cols="60" rows=7 class="input"></textarea></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr>
			<td colspan=2 height=30 align=center><input type=submit value="SUBMIT" class="input" style="background-color:#d2cab3;color:#FFFFFF"></td>
		</tr></form>
      </table>
	  <br>
	  <table width="90%" align=center border="0" cellspacing="0" cellpadding="0">
	  <tr><td>
	  (To be eligible to receive the $100 Bonus, you must be our wholesale customer. Your REFERRAL must be a legitimate <br>buyer for a women's retail store and order minimum of $600)
	  </td></tr>
	  </table>
	  <br>

	  
<?
	// 왼쪽 include
	include _BASE_DIR ."/include/inc_bottom.php";
?>