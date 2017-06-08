<?
	include "../include/inc_base.php";

	$tableName = "chan_shop_member";



	include _BASE_DIR ."/include/inc_top.php";
?>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <b>REGISTER</b></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="30"></td>
				</tr>
				<tr>
					<td>


      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height=50 align=center>Congratulations <?= $_SESSION['member_first_name'] ?>, your account has been created.</td>
		</tr>
		<tr>
			<td height=50 align=center> <?= $base_info[site_homepage] ?> account E-mail is <b><?= $_SESSION['member_id'] ?></b>.</td>
		</tr>
      </table>



					</td>
				</tr>
			</table>
			<br><br><br>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>