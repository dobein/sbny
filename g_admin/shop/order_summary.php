<?
	// �⺻ ���� ���ϸ���
	include "../../include/inc_base.php";
	
	/**
	* ���ٱ��� ����
	**/
	include "../../include/inc_admin_session.php";



	include _BASE_DIR . "/g_admin/inc_top.php";

	function totalSaleswoship($division){
		
		global $dbConn,$tableName;

		$today = date("Y-m");
		$today2 = date("Y-m-d");

		// ���� ����

		if($division == "1")
		{
			$date_qry1 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('3','4') && date_format(order_date,'%Y-%m')='$today'";
		}
		else
		{
			$date_qry1 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('3','4') && date_format(order_date,'%Y-%m-%d')='$today2'";
		}

		//print_r($date_qry1);
		$date_rst1= mysql_query($date_qry1,$dbConn);
		$today_sum = @mysql_result($date_rst1,0,0);

		if(empty($today_sum)) { $today_sum = 0; }
		return $today_sum;
	}

	function totalSalesMonth($month){
		
		global $dbConn,$tableName;

		$today = $month;

		// ���� ����


		$date_qry1 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('3') && date_format(order_date,'%Y-%m')='$today'";


		//print_r($date_qry1);
		$date_rst1= mysql_query($date_qry1,$dbConn);
		$today_sum = @mysql_result($date_rst1,0,0);

		if(empty($today_sum)) { $today_sum = 0; }
		return $today_sum;
	}


	// �� ȸ���� ���ϱ�
	$m_qry1 = "select count(*) from chan_shop_member";
	$m_rst1 = mysql_query($m_qry1,$dbConn);
	$m_row1 = @mysql_result($m_rst1,0,0);

	// ���� ȸ����
	$start_date = date("Y-m-d 00:00:00",time());
	$stop_date = date("Y-m-d 23:59:59",time());

	$m_qry2 = "select count(*) from chan_shop_member where wdate between '$start_date' AND '$stop_date'";
	$m_rst2 = mysql_query($m_qry2,$dbConn);
	$m_row2 = @mysql_result($m_rst2,0,0);

	// �� �����
	$s_qry1 = "select sum(last_price) from chan_shop_orderinfo where orderNum<>''";
	$s_rst1 = mysql_query($s_qry1,$dbConn);
	$s_sum = @mysql_result($s_rst1,0,0);

	$s_qry2 = "select count(*) from chan_shop_orderinfo where orderNum<>''";
	$s_rst2 = mysql_query($s_qry2,$dbConn);
	$s_num2 = @mysql_result($s_rst2,0,0);


	// �� ����
	$s_qry6 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('4')";
	$s_rst6 = mysql_query($s_qry6,$dbConn);
	$s_sum6 = @mysql_result($s_rst6,0,0);

	$s_qry7 = "select count(*) from chan_shop_orderinfo where where order_status in ('4')";
	$s_rst7 = mysql_query($s_qry7,$dbConn);
	$s_num7 = @mysql_result($s_rst7,0,0);


	$s_qry3 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('3','4')";
	$s_rst3 = mysql_query($s_qry3,$dbConn);
	$s_sum3 = @mysql_result($s_rst3,0,0);

	$s_qry4 = "select count(*) from chan_shop_orderinfo where order_status in ('3','4')";
	$s_rst4 = mysql_query($s_qry4,$dbConn);
	$s_num4 = @mysql_result($s_rst4,0,0);

	// ���� �α��� ��
	$login_qry1 = "select count(*) from chan_shop_member_log where login_date between '$start_date' AND '$stop_date'";
	$login_rst1 = mysql_query($login_qry1,$dbConn);
	$login_num1 = @mysql_result($login_rst1,0,0);

	$login_qry2 = "select count(*) from chan_shop_member_log";
	$login_rst2 = mysql_query($login_qry2,$dbConn);
	$login_num2 = @mysql_result($login_rst2,0,0);


	if(empty($year)){
		
		$year = date("Y");

	}

?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Sales Summary</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td valign=top>
			<table width=99% border=0 cellspacing=1 cellpadding=0 bgcolor=#f9f9f9>
				<tr>
					<td height=28 colspan=2>&nbsp;<img src=../img/downboxed.gif align=absmiddle>&nbsp;<font color=#000000><b>Sales Summary</b></font></td>
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
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=25>&nbsp;&nbsp;&nbsp;<font size=3><a href=<?= $_SERVER['PHP_SELF'] ?>?year=2012>2012</a> / <a href=<?= $_SERVER['PHP_SELF'] ?>?year=2013>2013</a> / <a href=<?= $_SERVER['PHP_SELF'] ?>?year=2014>2014</a> / <a href=<?= $_SERVER['PHP_SELF'] ?>?year=2015>2015</a></font></td>
	</tr>
	<tr>
		<td valign=top>
			<table width=99% border=0 cellspacing=1 cellpadding=0 bgcolor=#f9f9f9>
				
				<? for($i=1; $i<=12; $i++): ?>
				<?
					if(strlen($i) == "1")
					{
						$i = "0".$i;
					}

					$month = $i;
					$sale_month = $year."-".$month;

					$date_qry1 = "select sum(last_price) from chan_shop_orderinfo where order_status in ('3') && date_format(order_date,'%Y')='$year'";
					$date_rst1 = mysql_query($date_qry1);
					$date_amt = @mysql_result($date_rst1,0,0);

					$s_amt1 = totalSalesMonth($sale_month);

					// �Ǹűݾ� %���
					$MAX_barsize = 300;
					$allocate_rate = @round(($s_amt1/$date_amt)*100); 		//��ǥ��
					$bar_width = @round(($s_amt1/$date_amt)*$MAX_barsize); 	// �̹��� ������



				?>
				<tr>
					<td width=10% height=28 align=center><font color=#000000><b><?= $year ?> - <?= $i ?></b></font></td>
					<td width=10% bgcolor=#FFFFFF align=right>&nbsp;<b>$<?= $s_amt1 ?></b>&nbsp;</td>
					<td width=80% bgcolor=#FFFFFF>&nbsp;<img src=../img/graph04.gif width=<?= $bar_width ?> height=10>&nbsp;( <?= $allocate_rate ?> %) </td>
				</tr>
				<? endfor; ?>
				

				</tr>

			</table>
		</td>
</tr>
</table>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>