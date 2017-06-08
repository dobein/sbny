<?
	include "./include/inc_base.php";


	$c_code1 = $domainCategory[c_code1];
	$c_code2 = '2';

	$_GET['c_code3'] = mysql_real_escape_string(htmlentities($_GET['c_code3']));

	if(empty($_GET['c_code3']))
	{
		$pre_qry1 = "select * from chan_shop_category where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 <> '0' order by pos asc limit 1,1";

		$pre_rst1 = mysql_query($pre_qry1);
		$pre_row1 = mysql_fetch_assoc($pre_rst1);

		$c_code3 = $pre_row1['c_code3'];
	}
	else
	{
		$c_code3 = $_GET['c_code3'];
	}



	// 상품설명
	$qry1 = "select * from chan_shop_category where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 = '$c_code3'";

	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);

	$page_title = Category_name($c_code1,$c_code2,$c_code3);


	include "./include/inc_top.php";
?>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; <a href=<?= _WEB_BASE_DIR ?>/>Home</a>  >  <b><?= Category_name($c_code1,$c_code2,'0') ?></b></td>
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
								<tr>
									<td width=25% valign=top height=450 >
										<table width=95% border=0 cellpadding=0 cellspacing=5 bgcolor=#FFFFFF>
											<?= printGermaniumcategory(); ?>
										</table>
									</td>
									<td width=75% valign=top bgcolor=#FFFFFF style="padding-top:10px">
									<!-- 메인 메뉴 -->
									<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" style="table-layout:fixed">
										<tr>
											<td bgcolor=#f9f9f9 height=35 style="padding-left:10px"><h3><?= $page_title ?></h3></td>
										</tr>
										<tr>
											<td valign=top style="white-break:normal;word-break:break-word;">
												<br>
												<?= stripslashes($row1[content]); ?>
											</td>
										</tr>
									</table>

									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
			<br><br>


<?
	include "./include/inc_bottom.php";
?>