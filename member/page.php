<?
	include "../include/inc_base.php";

	$tableName = "chan_shop_page";


	include _BASE_DIR ."/include/inc_top.php";


	$item_code = mysql_real_escape_string(htmlentities($_GET['item_code']));

	// ��ǰ����
	$qry1 = "select * from $tableName where item_code = '$item_code'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);

?>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <span class="b"><?= $row1[item_name] ?></span></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="30"></td>
				</tr>
				<tr>
					<td>
      <table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height=350 valign=top><?= stripslashes($row1[item_description]) ?></td>
        </tr>
      </table>
		<br><br>	  </td>
	 </tr>
</table>


<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>