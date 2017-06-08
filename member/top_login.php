<?
	include "../include/inc_base.php";

	if($login_mode2 == "save")
	{

		if(Member_login($userid2,$password2,'MEMBER'))
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
			$login_qry1 = "update chan_shop_cart set user_id = '$userid2' where ip = '$REMOTE_ADDR'";
			$login_rst1 = mysql_query($login_qry1,$dbConn);

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

            <table width="720" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> 
                                                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td valign="top"> 
                        <table width="720" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="top" class='black title' height=23 colspan=3>
                  Login</a>
          </td>
		  </tr>
              <tr> 
                <td height="1" bgcolor="#eeeeee" colspan=3><img height=1 class=hidden></td>
              </tr>
  <tr> 
    <td style='padding:30px;' width=280 class='d8 pink' valign=top><b>User Login</b><br/><div style='padding:10px'><table width=280 border="0" cellspacing="0" cellpadding="0">
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
		<form name=sub_login action=<?= $PHP_SELF ?> method=post onSubmit="return login_chk2(this)" autocomplete=off>
		<input type=hidden name=login_mode2 value="save">
		<input type=hidden name=goUrl value="<?= $goUrl ?>">
							<tr><td colspan=2 height=50>If you're already registered with beautyofnewyork.com, <br>please sign in using your login id and your password.</td></tr>
							<tr>
								<td height=1 bgcolor=#f4f4f4 colspan=2></td>
							</tr>
                            <tr> 
                              <td width="80" class='d8 gray' height=28>User ID</td>                              <td width="200"><input name="userid2" type="text" size="18" class=input></td>
                            </tr>
							<tr><td colspan=2><img height=6 class=hidden></td></tr>
                            <tr> 
                              <td class='d8 gray' height=28>Passwd</td>
                              <td ><input name="password2" type="password" size="18" class=input></td>
							</tr>
							<tr><td colspan=2><img height=6 class=hidden></td></tr>
							<tr>
                              <td colspan=2 align=center><input name="login" type="image" src="<?= _WEB_BASE_DIR ?>/img/btn_login.gif" width="107" height="28"></td>
                            </tr>
        </form>
      </table>
	  <br>
	  <table width=240 border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height=1 bgcolor=#f4f4f4></td>
		</tr>
		<tr>
			<td height=24>Did you forget your password? <a href="javascript:looking_id()">click here</a></td>
		</tr>
		</table>
	  </td>
	  <td width=1 bgcolor=#eeeeee></td>
	  <td width=349 style='padding:30px;' class='d8' valign=top><b>Register</b><br/>- I am a new customer.&nbsp;&nbsp;<a href=join.php><u>Create a New Account.</u></a><br/>
	  <br>
Register now to take advantage : <br>
+ Check your order status with the "Track My Order" link <br>
+ Retain your cart information <br>
+ Save your shipping / billing information <br>
+ Subscribe to our email lists  <br>
<br><br><br>
<? if($Mode == "buy"): ?><b><a href="guest_purchase.php"><u>Guest Purchase</u></a></b><? endif; ?>
<br>

</td>
  </tr>
      <tr> 
    <td align="center" colspan=3>&nbsp;</td>
  </tr>
</table>
                      </td>
                    </tr>
                  </table>
<script>
	document.sub_login.userid2.focus();
</script>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>