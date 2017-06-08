<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	$tableName = "chan_shop_member";

	if($_POST['mode'] == "save")
	{
		$seq_no = $_POST['seq_no'];

		if($_POST['func'] == "modify")
		{
			$domain = $_POST['domain'];

			$member_password = md5($_POST['member_password']);

			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$email = $_POST['email'];
			$level = $_POST['level'];
			$gender = $_POST['gender'];
			$birthday = $_POST['birthday'];
			$address1 = $_POST['address1'];
			$address2 = $_POST['address2'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$zipcode = $_POST['zipcode'];
			$country = $_POST['country'];
			$cell_phone = $_POST['cell_phone'];
			$home_phone = $_POST['home_phone'];
			$corp_phone = $_POST['corp_phone'];
			$memo = addslashes($_POST['memo']);
			$admin_memo = addslashes($_POST['admin_memo']);
			$mail_flag = $_POST['mail_flag'];

			if($_POST['member_password'])
			{
			$qry2 = "update $tableName set domain = '$domain', member_password = '$member_password', first_name = '$first_name', last_name = '$last_name', email = '$email', level = '$level', gender = '$gender', birthday = '$birthday', address1 = '$address1', address2 = '$address2', city = '$city', state = '$state', zipcode = '$zipcode', country = '$country', cell_phone = '$cell_phone', home_phone = '$home_phone', corp_phone = '$corp_phone', memo = '$memo' , admin_memo = '$admin_memo', mail_flag = '$mail_flag' where seq_no = '$seq_no'";
			}
			else
			{
			$qry2 = "update $tableName set domain = '$domain', first_name = '$first_name', last_name = '$last_name', email = '$email', level = '$level', gender = '$gender', birthday = '$birthday', address1 = '$address1', address2 = '$address2', city = '$city', state = '$state', zipcode = '$zipcode', country = '$country', cell_phone = '$cell_phone', home_phone = '$home_phone', corp_phone = '$corp_phone', memo = '$memo' , admin_memo = '$admin_memo', mail_flag = '$mail_flag' where seq_no = '$seq_no'";
			}

		}
		else
		{
			$qry2 = "delete from $tableName where seq_no = '$seq_no'";

			// order history 기록 지우기
			//$o_qry1 = "delete from chan_shop_orderinfo where user_id = '$member_id'";
			//$o_rst1 = mysql_query($o_qry1,$dbConn);

		}

		$rst2 = mysql_query($qry2,$dbConn);

		if($rst2)
		{
			Misc::jvAlert("Completed!","location.replace('member_list.php')");
			exit;
		}
	}

	$seq_no = $_GET['seq_no'];

	$qry1 = "select * from $tableName where seq_no = '$seq_no'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);


	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Member Manager (<?= $_SESSION['member_id'] ?>)</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post>
<input type=hidden name=mode value="save">
<input type=hidden name=seq_no value="<?= $seq_no ?>">

<tr bgcolor='#eee8aa'>
	<td colspan=4 height=35>&nbsp;<b>Member View</b></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center>Domain</td>
	<td width=* colspan=3 bgcolor=#FFFFFF>&nbsp;<select name=domain><option value="">Choose your domain<? printDomainList($row1[domain]); ?></select></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>ID</td>
	<td width=*  bgcolor=#FFFFFF>&nbsp;<b><?= $row1[member_id] ?></b></td>
	<td width=15% align=center>New Password</td>
	<td width=* bgcolor=#FFFFFF>&nbsp;<input type=text name=member_password value="" size=30 class="input"></td>
</tr> 
<tr bgcolor=#f4f4f4>
	<td width=15% align=center>First Name</td>
	<td width=355 bgcolor=#FFFFFF>&nbsp;<input type=text name=first_name value="<?= $row1[first_name] ?>" size=30 class="input"></td>
	<td width=15% align=center height=28>Last Name</td>
	<td width=35% bgcolor=#FFFFFF>&nbsp;<input type=text name=last_name value="<?= $row1[last_name] ?>" size=30 class="input"></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center>Level</td>
	<td width=* colspan=3 bgcolor=#FFFFFF>&nbsp;<select name=level>
	<option value="10" <? if($row1[level] == "10") echo "selected"; ?>>Pendding
	<option value="9" <? if($row1[level] == "9") echo "selected"; ?>>Approved
	</select></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center>E-mail</td>
	<td width=* colspan=3 bgcolor=#FFFFFF>&nbsp;<input type=text name=email value="<?= $row1[email] ?>" size=50 class="input"></td>
</tr>
<tr bgcolor=#f4f4f4>
<td  align="center" width=15%>Company</td>
<td  colspan=3 bgcolor=#FFFFFF> &nbsp;<input type=text name=birthday size=25 class="input" value="<?= $row1[birthday] ?>"></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center>Tax ID</td>
	<td width=* colspan=3 bgcolor=#FFFFFF>&nbsp;<input type=text name=gender value="<?= $row1[gender] ?>" size=50 class="input"></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Address</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<input type=text name=address1 value="<?= $row1[address1] ?>" size=30 class="input">&nbsp;<input type=text name=address2 value="<?= $row1[address2] ?>" size=30 class="input"></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>City</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<input type=text name=city value="<?= $row1[city] ?>" size=16 class="input">&nbsp;State : <input type=text name=state value="<?= $row1[state] ?>" size=2 class="input">
	&nbsp;Zip : <input type=text name=zipcode value="<?= $row1[zipcode] ?>" size=5 class="input">
	&nbsp;Country : <select name="country" class="input"><?= printCountryList($row1[country]); ?></select> <?= $row1[country] ?></td>
</tr>

<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Fax</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<input name="home_phone" type="text" class="input" size=16 value="<?= $row1[home_phone] ?>" ></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Telephone</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<input name="cell_phone" type="text" class="input" size=16 value="<?= $row1[cell_phone] ?>" ></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Memo</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<textarea name="memo" cols=70 rows=5><?= stripslashes($row1[memo]); ?></textarea></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Admin Memo</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<textarea name="admin_memo" cols=70 rows=5><?= stripslashes($row1[admin_memo]); ?></textarea></td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Newletter</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<input type=radio name=mail_flag value="YES" class="input" <? if($row1[mail_flag] == "YES") echo "checked"; ?>> YES &nbsp;&nbsp;
	<input type=radio name=mail_flag value="NO" class="input" <? if($row1[mail_flag] == "NO") echo "checked"; ?>> NO</td>
</tr>
<tr bgcolor=#f4f4f4>
	<td width=15% align=center height=28>Func</td>
	<td width=* bgcolor=#FFFFFF colspan=3>&nbsp;<input type=radio name=func value="modify" checked> Modify <input type=radio name=func value="delete"> Delete</td>
</tr>
<tr bgcolor=#FFFFFF>
	<td colspan=4 align=center height=35><input type=submit value="    Modify   " class="input"></td>
</tr></form>
</table>
<br>
<br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>