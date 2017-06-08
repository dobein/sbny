<?
	include "../include/inc_base.php";

	if($_POST['login_mode2'] == "save")
	{
		$goUrl=mysql_real_escape_string(htmlentities($_POST['goUrl'])); 


		$userid2=mysql_real_escape_string(htmlentities($_POST['userid2'])); 
		$password2=mysql_real_escape_string(htmlentities($_POST['password2'])); 


		$remember_id = $_POST['remember_id'];
		$remember_pw = $_POST['remember_pw'];

		if(Member_login($userid2,$password2,'MEMBER',$remember_id,$remember_pw))
		{
			if(!$goUrl)
				{
					$goUrl_1 = "../index.php";
				}
			else
				{
					$goUrl_1 = "$goUrl";
				}

			// 로그인이 완료되면 현재 아이피를 이 아이디로 다 업데이트 한다
			$login_qry1 = "update chan_shop_cart set user_id = '$userid2' where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
			$login_rst1 = mysql_query($login_qry1,$dbConn);

			$t_qry2 = "update chan_shop_today set user_id = '$userid2' where user_id = '$myip'";
			$t_rst2 = mysql_query($t_qry2);


			echo "<meta http-equiv='refresh' content='0; url=$goUrl_1'>";
			exit;
		}
		else
		{
			Misc::jvAlert("Check your Login info!","history.go(-1)");
			exit;
		}

	}


	include _BASE_DIR ."/include/inc_top.php";
?>




			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <b>SIGN IN</b></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td height=450 valign=top>
	<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=50% valign=top>
					<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						<td valign=top align=left>&nbsp;&nbsp;<b><?= $btn_login_title ?></b><br/>
							<table width=95% align=center border="0" cellspacing="0" cellpadding="0">
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
									
									window.open("lost_id.php","lost","width=500,height=300,scrollbars=1,left=400,top=150");

								}
							</script>
							<form name=sub_login3 action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return login_chk2(this)" autocomplete=off>
							<input type=hidden name=login_mode2 value="save">
							<input type=hidden name=goUrl value="<?= $goUrl ?>">
							<tr><td colspan=2 height=50 align=left><?= $btn_login_message ?></td></tr>
							<tr> 
							  <td width="80" class='d8 gray' height=28 align=left><?= $btn_join_email ?></td>                              <td width="200"><input name="userid2" type="text" size="28" class=input value="<?= $_COOKIE['PALACE_ID'] ?>"></td>
							</tr>
							<tr><td colspan=2></td></tr>
							<tr> 
							  <td class='d8 gray' height=28 align=left><?= $btn_join_passwd ?></td>
							  <td ><input name="password2" type="password" size="18" class=input value="<?= $_COOKIE['PALACE_PW'] ?>">&nbsp;&nbsp;<input type=submit value="   <?= $btn_login ?>   "  class="summit_btn"></td>
							</tr>
							<tr><td colspan=2></td></tr>
							</form>
						  </table>
						  <br>
						  <table width=98% align=center border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height=24 align=left><?= $btn_login_lostid ?></td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td width=50% valign=top>
				<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign=top align=left><b><?= $btn_login_register_title ?></b><br/><br>
						<table width=98% align=center border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align=left>
					  -  <?= $btn_login_register_message ?><br/>
					  <br>
				Register now to take advantage : <br>
				+ Check your order status with the "Track My Order" link <br>
				+ Retain your cart information <br>
				+ Save your shipping / billing information <br>
				+ Subscribe to our email lists  <br>
								</td>
							</tr>

						</table>

						</td>
					 </tr>
					</table>
			</td>
		</tr>
		<tr>
			<td colspan=2>
			<br><br><br>
					<table width="380"  border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						<td valign=top align=left>&nbsp;&nbsp;<b>Guest Purchase</b><br/>
							<script>
								function login_chk3(tf){
									if(!tf.guest_email.value)
									{
										alert('Enter your Email!');
										tf.guest_email.focus();
										return false;
									}

								return true;
								}
							</script>
							<form name=sub_login4 action=/member/guest_purchase.php method=post onSubmit="return login_chk3(this)" autocomplete=off>
							<input type=hidden name=mode value="guest_purchase">
							<table width=95% align=center border="0" cellspacing="0" cellpadding="0">
							<tr><td colspan=2 height=50 align=left>Enter your email address</td></tr>
							<tr>                           
							  <td ><input name="guest_email" type="text" size="28" class=input value=""> <input type=submit value="   <?= $btn_login ?>   "  class="summit_btn"></td>
							</tr>
						  </table>
						  </form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<br>
	</td>
</tr>
</table>
<script>
	document.sub_login3.userid2.focus();
</script>





<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>