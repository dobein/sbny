<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_discount";

	if($_GET['mode'] == "del")
	{
		$no = $_GET['no'];

		$qry1 = "delete from $tableName where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);


		Misc::jvAlert("Completed!","location.replace('setup_discount.php?area=$area')");
		exit;

	}

	if($_POST['mode'] == "save")
	{
		$amount = $_POST['amount'];
		$discount_rate = $_POST['discount_rate'];

		$qry1 = "insert into $tableName values ('','$amount','$discount_rate')";
		$rst1 = mysql_query($qry1,$dbConn);

		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('setup_discount.php?area=$area')");
			exit;
		}
	}

	function printStatetax(){
		
		global $dbConn,$tableName,$area;

		$qry1 = "select * from $tableName order by amount asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$tax = number_format($row1[tax],2);

			echo "
			<tr bgcolor='#FFFFFF'>
				<td width=200 height=25 align=center height=30>$row1[amount]</td>
				<td>&nbsp;$row1[discount_rate] %</td>
				<td align=center><a href=\"javascript:category_del('$row1[seq_no]','$area')\">D</a></td>
			</tr>";

		}

	}

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>
	function category_del(no,area){
		answer = confirm("Delete?");

		if(answer == true)
		{
			location.replace('setup_discount.php?mode=del&no=' + no + '&area=' + area);
			exit;
		}
		else return;
	}
</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Discount Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
	<tr bgcolor='#FFFFFF'>
		<td colspan=3 align=left height=25 bgcolor=#eee8aa>&nbsp;&nbsp;<b>Discount setup</b></td>
	</tr>
<script>
	function chk(tf){
		if(!tf.special_tax.value)
		{
			alert('Discount 퍼센티지를 넣어주세요!');
			tf.special_tax.focus();
			return false;
		}
	return true;
	}

</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> name=regi method=post Enctype="multipart/form-data" onSubmit="return chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=area value="<?= $area ?>">
	<tr bgcolor='#FFFFFF'>
		<td width=20% height=25 align=center height=30><font color=blue>Amount</font></td>
		<td width=60%>&nbsp;<b>Discount Rate</b></td>
		<td width=20% align=center>Func</td>
	</tr>
	<? printStatetax(); ?>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Amount</td>
		<td>&nbsp;&nbsp;&nbsp;<input type=text name=amount size=6>&nbsp;&nbsp;&nbsp;&nbsp;( EX. 100 )</td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Discount Rate</td>
		<td>&nbsp;&nbsp;&nbsp;<input type=text name=discount_rate size=6>&nbsp;%&nbsp;&nbsp;&nbsp;( EX. 10 )</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="Add Discount"></td>
	</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>