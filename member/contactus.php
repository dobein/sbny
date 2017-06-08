<?
	include "../include/inc_base.php";

	if($mode == "save")
	{
		$subject = "[Contact Us] $name";

		// message
		$message = "Name : $name\r\nPhone Number : $phone\rEmail : $email\r\nFax Number : $fax\r\ntitle : $subject\r\ncontent : $content\r\n";

		// To send HTML mail, the Content-type header must be set

		// °ü¸®ÀÚ
		$to = "chanyong.lee@gmail.com";


		$eol="\r\n";

		$headers .= "From: $name <$email>".$eol; 
		$headers .= "Reply-To: $name <$email>".$eol; 
		$headers .= "Return-Path: $name <$email>".$eol;    // these two to set reply address 
		$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
		$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 

		// Mail it
		$result = mail($to, $subject, $message, $headers);

		if($result)
			{
				Misc::jvAlert("Your message has been sent. thank you!.","location.replace('../index.php')");
				exit;		
			}
	}

	include _BASE_DIR ."/include/inc_top.php";
?>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <span class="b">CONTACT US</span></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="30"></td>
				</tr>
				<tr>
					<td>
	<table width="100%" align=center border=0 cellpadding=0 cellspacing=0 >
		<tr>
			<td height=35 align=left class="title_font" bgcolor=#f4f4f4>&nbsp;&nbsp;<b>Contact Us</b></td>
		</tr>
	</table>
	<br>
      <table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height=27>&nbsp;&nbsp;Tel. 1-516-367-7072</td>
		</tr>
		<tr>
			<td height=27>&nbsp;&nbsp;Email. info@germanium.net</td>
		</tr>
	</table>
	<br>
	  <table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
	<script>
		function chk(tf){
			if(!tf.name.value)
			{
				alert("Enter your name!");
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
        <tr bgcolor=#FFFFFF> 
          <td height=35 colspan=2>&nbsp;&nbsp;<b>Contact US by Email</b></td>
        </tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Name : </td>
			<td width=75%><INPUT class=input size=22 name=name></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;E-mail : </td>
			<td width=75%><INPUT class=input size=42 name=email></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Phone Number : </td>
			<td width=75%><INPUT class=input size=22 name=phone></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Fax Number : </td>
			<td width=75%><INPUT class=input size=22 name=fax></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Subject : </td>
			<td width=75%><INPUT class=input size=50 name=subject></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr bgcolor=#FFFFFF>
			<td width=25% height=28>&nbsp;&nbsp;Comment : </td>
			<td width=75%><textarea name=content cols="60" rows=7 class="input"></textarea></td>
		</tr>
		<tr><td colspan=2 height=1 bgcolor=#cccccc></td></tr>
		<tr>
			<td colspan=2 height=35 align=center><input type=submit value="   SUBMIT   " class="summit_btn" ></td>
		</tr></form>
      </table>


	  <BR>
	  <br>	  
		</td>
	 </tr>
</table>
	  
<?
	// ¿ÞÂÊ include
	include _BASE_DIR ."/include/inc_bottom.php";
?>