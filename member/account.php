<?
	include "../include/inc_base.php";

	if (!$HTTP_COOKIE_VARS[MEMLOGIN_INFO])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/member/account.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?goUrl=$URL");
	}


	$tableName = "chan_shop_member";


	if($mode == "save")
	{
		$cell_phone = $cell_phone1."-".$cell_phone2."-".$cell_phone3;
		$phone = $phone1."-".$phone2."-".$phone3;

		$qry2 = "update $tableName set member_password = '$old_password', first_name = '$name_first', last_name = '$name_last', gender = '$gender', birthday = '$birthday', address1 = '$address1', address2 = '$address2', city = '$city', state = '$state', zipcode = '$zipcode', cell_phone = '$cell_phone', home_phone = '$phone' where member_id = '$member_id'";
		$rst2 = mysql_query($qry2,$dbConn);

		Misc::jvAlert("Completed!","location.replace('/member/account.php')");
		exit;

	}

	include _BASE_DIR ."/include/inc_top.php";

	$m_qry1 = "select * from $tableName where member_id = '$user_info[user_id]'";
	$m_rst1 = mysql_query($m_qry1,$dbConn);
	$m_row1 = mysql_fetch_assoc($m_rst1);

	$phone = explode("-",$m_row1[home_phone]);
	$cell_phone = explode("-",$m_row1[cell_phone]);

?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign=top>
						<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height=50 align=left>&nbsp;&nbsp;&nbsp;<b><a href=tracking.php>My Account</a></b></td>
							</tr>
							<tr><td height=1 bgcolor=#f4f4f4></td></tr>
						</table>
						<br>
						<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td >
									<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td><span style="font-size:12pt;font-weight:bold;color:#000000">WELCOME <?= $user_dbinfo[first_name] ?> <?= $user_dbinfo[last_name] ?></span></td>
										</tr>
										<tr>
											<td height=40>&nbsp;</td>
										</tr>
										<tr>
											<td height=30 BGCOLOR=#F4F4F4><span style="font-size:9pt;font-weight:bold;color:#000000">CONTACT INFORMATION &nbsp;&nbsp;&nbsp;<a href=myinfo.php><u>EDIT</u></a></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[first_name] ?> <?= $user_dbinfo[last_name] ?></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[member_id] ?></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[birthday] ?></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[address1] ?> <?= $user_dbinfo[address2] ?></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[city] ?></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[state] ?></span></td>
										</tr>
										<tr>
											<td height=24>&nbsp;<span style="font-size:8pt;color:#000000"><?= $user_dbinfo[zipcode] ?></span></td>
										</tr>
									</table>
									<br>
									<br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
<!-- BODY END -->
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>