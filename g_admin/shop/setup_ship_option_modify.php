<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";


	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	$tableName = "chan_shop_shipping";

	if($_POST['mode'] == "save")
	{
		$ship_title = $_POST['ship_title'];
		$ship_weight_min = $_POST['ship_weight_min'];
		$ship_weight_max = $_POST['ship_weight_max'];
		$ship_price = $_POST['ship_price'];
		$ship_price = $_POST['ship_price'];

		if($_POST['flag'] == "1")
		{
			$qry1 = "update chan_shop_shipping_option set  ship_title = '$ship_title', ship_weight_min = '$ship_weight_min', ship_weight_max = '$ship_weight_max', ship_price = '$ship_price' where seq_no = '$seqNo'";
		}
		else
		{
			$qry1 = "delete from chan_shop_shipping_option where seq_no = '$seqNo'";
		}
		
		$rst1 = mysql_query($qry1,$dbConn);

		Misc::jvAlert("Completed!","location.replace('setup_ship.php?area=$area')");
		exit;
	}


	$no = $_GET['no'];
	$seqNo = $_GET['seqNo'];

	$qry1 = "select * from $tableName where seq_no = '$no'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);

	$qry2 = "select * from chan_shop_shipping_option where seq_no = '$seqNo'";
	$rst2 = mysql_query($qry2,$dbConn);
	$row2 = mysql_fetch_assoc($rst2);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Shipping Option Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<script>
	function chk(tf){
		if(!tf.shipping_company.value)
			{
			alert('배송 회사명을 넣어주세요!');
			tf.shipping_company.focus();
			return false;
			}
		return true;
	}
</script>
<form action=<?= $PHP_SELF ?> method=post onSubmit="return chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=seqNo value="<?= $seqNo ?>">
<input type=hidden name=area value="<?= $area ?>">
	<tr bgcolor=#eee8aa height=30>
		<td colspan=2>&nbsp;&nbsp;<b>Company (<?= $row1[name]; ?>) Option Add</b></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Name</td>
		<td>&nbsp;&nbsp;<?= $row1[name]; ?></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Opt Title</td>
		<td>&nbsp;&nbsp;<input type=text name=ship_title size=40 value="<?= $row2[ship_title] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Weight</td>
		<td>&nbsp;&nbsp;<input type=text name=ship_weight_min size=4 value="<?= $row2[ship_weight_min] ?>"> ~ <input type=text name=ship_weight_max size=4 value="<?= $row2[ship_weight_max] ?>"> lbs</td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Price</td>
		<td>&nbsp;&nbsp;<input type=text name=ship_price size=4 value="<?= $row2[ship_price] ?>"> USD</td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Action</td>
		<td>&nbsp;&nbsp;<input type=radio name=flag value="1" checked> Modify <input type=radio name=flag value="2" > Delete </td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="   Option Modify   "></td>
	</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>