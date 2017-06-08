<?
	include "../include/inc_base.php";

	if (!$_SESSION['member_id'])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/member/myinfo.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?Mode=buy&goUrl=$URL");
	}



	$tableName = "chan_shop_member";


	if($_POST['mode'] == "save")
	{
		$user_id = mysql_real_escape_string(htmlentities($_POST['user_id']));
		$old_password = mysql_real_escape_string(htmlentities($_POST['old_password']));
		$name_first = $_POST['name_first'];
		$name_last = $_POST['name_last'];
		$tax_id = mysql_real_escape_string(htmlentities($_POST['tax_id']));
		$company = $_POST['company'];
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipcode = mysql_real_escape_string(htmlentities($_POST['zipcode']));
		$country = mysql_real_escape_string(htmlentities($_POST['country']));
		$phone_flag = mysql_real_escape_string(htmlentities($_POST['phone_flag']));
		$cell_phone1 = mysql_real_escape_string(htmlentities($_POST['cell_phone1']));
		$cell_phone2 = mysql_real_escape_string(htmlentities($_POST['cell_phone2']));
		$cell_phone3 = mysql_real_escape_string(htmlentities($_POST['cell_phone3']));

		$phone1 = mysql_real_escape_string(htmlentities($_POST['phone1']));
		$phone2 = mysql_real_escape_string(htmlentities($_POST['phone2']));
		$phone3 = mysql_real_escape_string(htmlentities($_POST['phone3']));

		$corp_phone = mysql_real_escape_string(htmlentities($_POST['corp_phone']));
		$mail_flag = mysql_real_escape_string(htmlentities($_POST['mail_flag']));

		$cell_phone = $cell_phone1."-".$cell_phone2."-".$cell_phone3;
		$phone = $phone1."-".$phone2."-".$phone3;

		$old_password = md5($old_password);

		$qry2 = "update $tableName set member_password = '$old_password', first_name = '$name_first', last_name = '$name_last', gender = '$gender', company = '$company', address1 = '$address1', address2 = '$address2', city = '$city', state = '$state', country = '$country', zipcode = '$zipcode', cell_phone = '$cell_phone', home_phone = '$phone' where member_id = '".$_SESSION['member_id']."'";
		//print_r($qry2);
		$rst2 = mysql_query($qry2,$dbConn);


		Misc::jvAlert("Completed!","location.replace('myinfo.php')");
		exit;

	}

	include _BASE_DIR ."/include/inc_top.php";

	$m_qry1 = "select * from $tableName where domain = '$domain' && member_id = '".$_SESSION['member_id']."'";
	$m_rst1 = mysql_query($m_qry1,$dbConn);
	$m_row1 = mysql_fetch_assoc($m_rst1);

	$phone = explode("-",$m_row1[home_phone]);
	$cell_phone = explode("-",$m_row1[cell_phone]);

?>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <span class="b">MY INFORMATION</span></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td>

	<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post name=join>
<input type=hidden name=mode value="save">
<input type=hidden name=action value="<?= $action ?>">
<input type=hidden name=member_id value="<?= $user_info[user_id] ?>">
	  <tr>
		<td colspan=4 height=35 align=left>&nbsp;&nbsp;Please enter the following information, and keep a record of it. </td>
	  </tr>
	 <tr>
		<td valign=top colspan=4>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Personal Information</td>
				</tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;First Name</td>
					<td align='left' width=75%> &nbsp;<input type=text name=name_first size=25 value="<?= $m_row1[first_name] ?>" class="input" ></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Last Name</td>
					<td align='left' width=75%> &nbsp;<input type=text name=name_last size=25 class="input" value="<?= $m_row1[last_name] ?>"></td>
				 </tr>
			</table>
			<br>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Login Information</td>
				</tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;E-mail</td>
					<td align='left' width=75%> &nbsp;<b><?= $_SESSION['member_id']; ?></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;New Password</td>
					<td align='left' width=75%> &nbsp;<input type=password name=old_password size=20 class="input" value=""></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Newsletter</td>
					<td align='left' width=75%> &nbsp;<input type=radio name=mail_flag value="YES" class="input" <? if($m_row1[mail_flag] == "YES") echo "checked"; ?>> YES &nbsp;&nbsp;
	<input type=radio name=mail_flag value="NO" class="input" <? if($m_row1[mail_flag] == "NO") echo "checked"; ?>> NO</td>
				 </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign=top colspan=4>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Address Information</td>
				</tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Telephone</td>
					<td align='left' width=75%> &nbsp;<input type=text name=cell_phone1 size=3 class="input" value="<?= $cell_phone[0] ?>">&nbsp;-&nbsp;<input type=text name=cell_phone2 size=3 class="input" value="<?= $cell_phone[1] ?>">&nbsp;-&nbsp;<input type=text name=cell_phone3 size=3 class="input" value="<?= $cell_phone[2] ?>"></td>
				 </tr>
				 <!-- <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Company Phone</td>
					<td align='left' width=75%> &nbsp;<input type=text name=phone1 size=3 class="input" value="<?= $phone[0] ?>">&nbsp;-&nbsp;<input type=text name=phone2 size=3 class="input" value="<?= $phone[1] ?>">&nbsp;-&nbsp;<input type=text name=phone3 size=3 class="input" value="<?= $phone[2] ?>"></td>
				 </tr> -->
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Street Address</td>
					<td align='left' width=75%> &nbsp;<input type=text name=address1 size=35 class="input" value="<?= $m_row1[address1] ?>"></td>
				 </tr>
					 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Address2</td>
					<td align='left' width=75%> &nbsp;<input type=text name=address2 size=35 class="input" value="<?= $m_row1[address2] ?>"></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;City</td>
					<td align='left' width=75%> &nbsp;<input type=text name=city size=20 class="input" value="<?= $m_row1[city] ?>"></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;State</td>
					<td align='left' width=75%> &nbsp;<input type=text name=state size=20 class="input" value="<?= $m_row1[state] ?>"></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Country</td>
					<td align='left' width=75%> &nbsp;<select name="country" class="input"><?= printCountryList( $m_row1[country]); ?></select></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Zipcode</td>
					<td align='left' width=75%> &nbsp;<input type=text name=zipcode size=10 class="input" value="<?= $m_row1[zipcode] ?>"></td>
				 </tr>
			</table>
		</td>
	</tr>
	 <tr>
		<td colspan=4 height=50 align=center><input type=submit value="&nbsp;&nbsp;&nbsp;SUBMIT&nbsp;&nbsp;&nbsp;" class="summit_btn"></td>
	 </tr></form>
	</table>
	<br>
	<br>
			</TD>
		</TR>
	</TABLE>
<!-- BODY END -->
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>