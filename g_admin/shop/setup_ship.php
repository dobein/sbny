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
		$wholesale_id = $_SESSION['member_id'];

		$shipping_company = $_POST['shipping_company'];

		$qry1 = "insert into $tableName values ('','$shipping_company','$wholesale_id')";
		$rst1 = mysql_query($qry1,$dbConn);

		Misc::jvAlert("Completed!","location.replace('setup_ship.php?area=$area')");
		exit;
	}

	/**
	* 활성화 시키기
	*/
	if($_POST['mode'] == "change")
	{
		$division = $_REQUEST['division'];
		$no = $_REQUEST['no'];

		$qry1 = "update chan_shop_shipping_option set activate = '$division' where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);
	}
	else if($_POST['mode'] == "del")
	{
		$no = $_REQUEST['no'];

		$qry1 = "delete from chan_shop_shipping where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);

		// 하위 카테고리 지우기
		$qry2 = "delete from chan_shop_shipping_option where parent_no = '$no'";
		$rst2 = mysql_query($qry2,$dbConn);

		Misc::jvAlert("Completed!","location.replace('setup_ship.php?area=$area')");
		exit;

	}

	function printShipping(){

		global $dbConn,$tableName,$area,$_SESSION;

		$wholesale_id = $_SESSION['member_id'];

		$qry1 = "select * from $tableName where wholesale_id = '$wholesale_id' order by seq_no asc";
		$rst1 = mysql_query($qry1,$dbConn);

		$num1 = 0;
		while($row1 = mysql_fetch_assoc($rst1)){
			
			// 추가 옵션 가져오기
			$qry2 = "select * from chan_shop_shipping_option where parent_no ='$row1[seq_no]'";
			$rst2 = mysql_query($qry2,$dbConn);
			while($row2 = mysql_fetch_assoc($rst2)){

			if($row2[activate] == "YES")
			{
				$active_msg = "<a href=\"javascript:change_active('$row2[seq_no]','NO','$area')\">Active</a>";
			}
			else
			{
				$active_msg = "<a href=\"javascript:change_active('$row2[seq_no]','YES','$area')\"><font style=\"color:red\">Inactive</font></a>";
			}

				$option2 .= "<tr bgcolor=#ffffff><td width=30% height=25>&nbsp;$row2[ship_title]</td><td width=20% height=25 align=center>$row2[ship_weight_min] ~ $row2[ship_weight_max] LB</td><td width=20% align=center>&nbsp;$$row2[ship_price]</td><td width=20% align=center>$active_msg</td><td width=10% align=center><a href=setup_ship_option_modify.php?no=$row1[seq_no]&seqNo=$row2[seq_no]>Modify</a></td></tr><tr><td colspan=5 height=1 bgcolor=#cccccc></td></tr>";

			}

			echo "
			<tr bgcolor='#FFFFFF'>
				<td width=20% height=100 align=center ><b>$row1[name]</b></td>
				<td width=60% valign=top>
					<table width=100% border=0 cellpadding=0 cellspacing=0>
						<tr bgcolor=#F4F4F4>
							<td >
								<table width=100% border=0 cellpadding=0 cellspacing=0>
									$option2
								</table>
							</td>

					</table>
				</td>
				<td width=10% align=center><a href=setup_ship_option.php?no=$row1[seq_no]&area=$area>Option Add</a></td>
				<td width=10% align=center><a href=\"javascript:category_del('$row1[seq_no]','$area')\">Delete</a></td>
			</tr>";

			$num1++;
			unset($option2);

		}

		if($num1 == "0")
		{
			echo "<tr bgcolor=#FFFFFF><td height=35 colspan=4 align=center>Empty</td></tr>";
		}

	}

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>
	function change_active(no,mode,area){
		
		if(mode == 'Active')
		{
			answer = confirm("Active?");

			if(answer == true)
			{
				location.replace('setup_ship.php?mode=change&division=' + mode + '&no=' + no + '&area=' + area);
				exit;
			}
			else return;
		}
		else
		{
			answer = confirm("Unactive?");

			if(answer == true)
			{
				location.replace('setup_ship.php?mode=change&division=' + mode + '&no=' + no + '&area=' + area);
				exit;
			}
			else return;
		}
	}

	function category_del(no,area){
		answer = confirm("Delete?");

		if(answer == true)
		{
			location.replace('setup_ship.php?mode=del&no=' + no + '&area=' + area);
			exit;
		}
		else return;
	}
</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Shipping Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
	<tr bgcolor='#FFFFFF'>
		<td colspan=4 align=left height=25 bgcolor=#eee8aa>&nbsp;&nbsp;<b>Shipping Setup</b></td>
	</tr>
	<? printShipping(); ?>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<script>
	function chk(tf){
		if(!tf.shipping_company.value)
			{
			alert('Enter your shipping company!');
			tf.shipping_company.focus();
			return false;
			}
		return true;
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=area value="<?= $area ?>">
	<tr bgcolor=#eee8aa height=30>
		<td colspan=2>&nbsp;&nbsp;<b>Shipping Company</b></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Name</td>
		<td>&nbsp;&nbsp;<input type=text name=shipping_company size=30></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="   Add company   "></td>
	</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>