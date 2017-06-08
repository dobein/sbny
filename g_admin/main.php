<?
	// 기본 설정 파일모음
	include "../include/inc_base.php";
	
	/**
	* 접근권한 설정
	**/
	include "../include/inc_admin_session.php";



	include _BASE_DIR . "/g_admin/inc_top.php";

	#$table_id=employee;

	// 게시판 기본파일
	#include _BASE_DIR ."/include/inc_board_employee.php";
	
	//$table_id = "employee";





	function printOrderhistory(){
		
		global $dbConn;

		if($_SESSION["admin_member_seqNo"] && $_SESSION["admin_member_id"]  != "admin")
		{
			$member_qry = "&& wholesaler = '".$_SESSION["member_seqNo"]."'";
		}


		$qry1 = "select * from chan_shop_orderinfo where orderNum<>'' $member_qry order by seq_no desc limit 10";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$order_info = unserialize($row1[order_info]);


			$order_date = explode(" ",$row1[order_date]);
			$order_price = number_format($row1[order_price],2);
			$last_price = number_format($row1[last_price],2);
			$shipping_title = Misc::cutLongString($row1[shipping_title],36,true);

			echo "<tr bgcolor=#FFFFFF>
			<td width=15% align=center height=22><a href=./shop/order_view.php?seqNo=$row1[seq_no]&orderNum=$row1[orderNum]>$order_date[0]</a></td>
			<td width=15% align=center><a href=./shop/order_view.php?seqNo=$row1[seq_no]&orderNum=$row1[orderNum]><b>$row1[orderNum]</b></a></td>
			<td width=20% align=center>$row1[bill_first_name] $row1[bill_last_name]</td>
			<td width=20% align=center><font color=red>$row1[pay_method]</font>&nbsp;&nbsp;<font color=blue>$$last_price</font></td>
			<td width=30%>$shipping_title</td>
			</tr>
			";

		}

	}

	function totalSaleswoship($division){
		
		global $dbConn,$tableName;

		$today = date("Y-m");
		$today2 = date("Y-m-d");

		// 오늘 쿼리

		if($division == "1")
		{
			$date_qry1 = "select sum(order_price) from chan_shop_orderinfo where order_status in ('3','4') && date_format(order_date,'%Y-%m')='$today'";
		}
		else
		{
			$date_qry1 = "select sum(order_price) from chan_shop_orderinfo where order_status in ('3','4') && date_format(order_date,'%Y-%m-%d')='$today2'";
		}

		//print_r($date_qry1);
		$date_rst1= mysql_query($date_qry1,$dbConn);
		$today_sum = @mysql_result($date_rst1,0,0);

		if(empty($today_sum)) { $today_sum = 0; }
		return $today_sum;
	}


	function printLoginhistory(){

		global $dbConn;

		$qry1 = "select * from chan_shop_member_log where status = 'fail' order by seq_no desc limit 10";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			echo "<tr>
			<td width=20% align=center height=22>$row1[member_id]</td>
			<td width=20% align=center>$row1[password]</td>
			<td width=60% align=left>&nbsp;$row1[login_date]</td>
			</tr>
			<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
			";

		}
	}

	function printMemberList(){

		global $dbConn;

		$qry1 = "select * from chan_shop_member order by seq_no desc limit 3";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$date =explode(" ",$row1[wdate]);

			echo "<tr bgcolor=#ffffff>
			<td width=30% align=center height=22>$row1[member_id]</td>
			<td width=30% align=center>$row1[last_name]</td>
			<td width=40% align=left>&nbsp;&nbsp;$date[0]</td>
			</tr>
			";

		}
	}

	// 총 회원수 구하기
	$m_qry1 = "select count(*) from chan_shop_member";
	$m_rst1 = mysql_query($m_qry1,$dbConn);
	$m_row1 = @mysql_result($m_rst1,0,0);

	// 오늘 회원수
	$start_date = date("Y-m-d 00:00:00",time());
	$stop_date = date("Y-m-d 23:59:59",time());

	$m_qry2 = "select count(*) from chan_shop_member where wdate between '$start_date' AND '$stop_date'";
	$m_rst2 = mysql_query($m_qry2,$dbConn);
	$m_row2 = @mysql_result($m_rst2,0,0);


		if($_SESSION["member_seqNo"] && $_SESSION["member_id"]  != "admin")
		{
			$member_qry = "&& wholesaler = '".$_SESSION["member_seqNo"]."'";
		}



	// 총 매출액
	$s_qry1 = "select sum(last_price) from chan_shop_orderinfo where orderNum<>'' $member_qry";
	$s_rst1 = mysql_query($s_qry1,$dbConn);
	$s_sum = @mysql_result($s_rst1,0,0);

	$s_qry2 = "select count(*) from chan_shop_orderinfo where orderNum<>'' $member_qry";
	$s_rst2 = mysql_query($s_qry2,$dbConn);
	$s_num2 = @mysql_result($s_rst2,0,0);


	// 총 리턴
	$s_qry6 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('4') $member_qry";
	$s_rst6 = mysql_query($s_qry6,$dbConn);
	$s_sum6 = @mysql_result($s_rst6,0,0);

	$s_qry7 = "select count(*) from chan_shop_orderinfo where where order_status in ('4') $member_qry";
	$s_rst7 = mysql_query($s_qry7,$dbConn);
	$s_num7 = @mysql_result($s_rst7,0,0);


	$s_qry3 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('3','4') $member_qry";
	$s_rst3 = mysql_query($s_qry3,$dbConn);
	$s_sum3 = @mysql_result($s_rst3,0,0);

	$s_qry4 = "select count(*) from chan_shop_orderinfo where order_status in ('3','4') $member_qry";
	$s_rst4 = mysql_query($s_qry4,$dbConn);
	$s_num4 = @mysql_result($s_rst4,0,0);

	// 오늘 로그인 수
	$login_qry1 = "select count(*) from chan_shop_member_log where login_date between '$start_date' AND '$stop_date'";
	$login_rst1 = mysql_query($login_qry1,$dbConn);
	$login_num1 = @mysql_result($login_rst1,0,0);

	$login_qry2 = "select count(*) from chan_shop_member_log";
	$login_rst2 = mysql_query($login_qry2,$dbConn);
	$login_num2 = @mysql_result($login_rst2,0,0);
?>

<br>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td >
			<table width=99% border=0 cellspacing=1 cellpadding=0 bgcolor=#f9f9f9>
				<tr>
					<td height=28 colspan=2>&nbsp;<img src=../images/handle.png align=absmiddle>&nbsp;<font color=#000000><b>Sales Summary</b></font></td>
				</tr>
				<tr><td height=1 bgcolor=#cccccc colspan=2></td></tr>
				<tr bgcolor=#FFFFFF>
					<td width=25% height=28>&nbsp;&nbsp;<b>Total</b> Sales</td>
					<td width=75%>&nbsp;<b><font color=red>$<?= number_format($s_sum) ?></font></b> / <?= $s_num2 ?> </td>
				</tr>
				<tr bgcolor=#FFFFFF>
					<td width=25% height=28>&nbsp;&nbsp;<b><?= date("Y-m"); ?></b> Sales</td>
					<td width=75%>&nbsp;<b><font color=blue>$<?= totalSaleswoship('1'); ?></font></b></td>
				</tr>
				<tr bgcolor=#FFFFFF>
					<td width=25% height=28>&nbsp;&nbsp;<b><?= date("d  D"); ?></b> Sales</td>
					<td width=75%>&nbsp;<b><font color=blue>$<?= totalSaleswoship('2'); ?> </td>
				</tr>
				<tr bgcolor=#FFFFFF>
					<td width=25% height=28>&nbsp;&nbsp;Cancel</td>
					<td width=75%>&nbsp;<b><font color=red>$<?= number_format($s_sum6) ?></font></b> / <?= $s_num7 ?> </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<table width=100% border=0 cellspacing=1 cellpadding=0 bgcolor=#f9f9f9>
	<tr>
		<td height=28>&nbsp;<img src=../images/handle.png align=absmiddle>&nbsp;<font color=#000000><b>Order List</b></font></td>
	</tr>
	<tr><td height=1 bgcolor=#cccccc></td></tr>
</table>
<table width=100% border=0 cellspacing=1 cellpadding=0 bgcolor=#f9f9f9>
<tr bgcolor=#DFDF00>
	<td width=15% align=center height=22>Date</td>
	<td width=15% align=center>Order #</td>
	<td width=20% align=center>Name</td>
	<td width=20% align=center>Amount</td>
	<td width=30% align=center>Shipping</td>
</tr>
<? printOrderhistory(); ?>
</table>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>