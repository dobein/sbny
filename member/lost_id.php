<?
	include "../include/inc_base.php";

	if($_POST['mode'] == "save")
	{
		$email = $_POST['email'];

		$qry1 = "select * from chan_shop_member where domain = '$domain' && member_id = '$email'";

		$rst1 = mysql_query($qry1,$dbConn);
		$num1 = mysql_num_rows($rst1);



		if($num1>0)
		{
			$base_info[admin_email] = $base_info[site_email];

			$row1 = mysql_fetch_assoc($rst1);

			$eol="\r\n";

			$headers .= 'From: '.$base_info[site_name].' <'.$base_info[admin_email].'>'.$eol; 
			$headers .= 'Reply-To: '.$base_info[site_name].' <'.$base_info[admin_email].'>'.$eol; 
			$headers .= 'Return-Path: '.$base_info[site_name].' <'.$base_info[admin_email].'>'.$eol;    // these two to set reply address 
			$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
			$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 


			$mailStr .= "Dear $row1[first_name] $row1[last_name].\r\n";
			$mailStr .= "Thank you for your inquiry. Here's your id & password \r\n";


			/**
			* Temp order number ¸¸µé±â
			*/
			$keychars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$length = 7;

			// RANDOM KEY GENERATOR
			$randkey = "";
			$max=strlen($keychars)-1;
			for ($i=0;$i<=$length;$i++) {
			  $randkey .= substr($keychars, rand(0, $max), 1);
			}


			$userPass = $randkey;

			$new_password = md5($userPass);


			$n_qry1 = "update chan_shop_member set member_password = '$new_password' where member_id = '$email'";
			$n_rst1 = mysql_query($n_qry1);



			$mailStr .= "Your login ID : $row1[member_id] \r\n";
			$mailStr .= "Your temporary Password : $userPass \r\n";

			$mailStr .= "For any other questions/inquiries, please visit us or send us an e-mail via our customer service request form under the FAQ Section"."\r\n";
			$mailStr .= "Thank you very much for your business!"."\r\n";
			$mailStr .= "$base_info[site_name]";

			$mail_title = "Your ID & Password at $base_info[site_name]";

			$mail_result = mail($row1[member_id], $mail_title, $mailStr, $headers);

			$msg = "Your ID & Password has been sent to your email.";
		}
		else
		{
			$msg = "The email address you entered cannot be found in our records.";
		}
	}

?>
<html>
<head>
<title>Request Your Password</title>
<link href="<?= _WEB_BASE_DIR ?>/css/style.css" rel="stylesheet" type="text/css" />
<body bgcolor=#ffffff>
<table width=100% height=100% align=center border="0" cellspacing="0" cellpadding="0" bgcolor=#ffffff>
  <tr> 
    <td style='padding:30px;' valign=top>&nbsp;<b>To receive your login id & password via email, <br>&nbsp;please enter your email address.</b><br/><div style='padding:10px'>
	<table width=100% border="0" cellspacing="0" cellpadding="0" bgcolor=#ffffff>
		<script>
			function login_chk2(tf){
				if(!tf.userid2.value)
				{
					alert('Enter your ID!');
					tf.userid2.focus();
					return false;
				}

			return true;
			}

			function looking_id(){
				
				window.open("lost_id.php","lost","width=500,height=400,scrollbars=1,left=400,top=150");

			}
		</script>
		<form name=sub_login action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return login_chk2(this)" autocomplete=off>
		<input type=hidden name=mode value="save">
							<? if($msg): ?>
							<tr><td colspan=2 height=1 bgcolor=#dcdcdc></td></tr>
							<tr> 
                              <td height=35 colspan=2 align=center><?= $msg ?></td>
                            </tr>
							<? endif; ?>

							<tr><td colspan=2 height=1 bgcolor=#dcdcdc></td></tr>
							<tr> 
                              <td width="30%" height=35>Email</td>                              <td width="70%"><input name="email" type="text" size="32" class=input></td>
                            </tr>

							<tr>
                              <td colspan=2 align=center><input type=submit value="   <?= $btn_search ?>   "  class="summit_btn"></td>
                            </tr>
        </form>
      </table>
	  </td>
	</tr>
</table>
</body>
</html>