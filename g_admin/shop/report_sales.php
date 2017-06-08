<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$today = date("Y-m-d");

	if(empty($_GET['year'])){
		$year = date("Y");
	}
	else
	{
		$year = $_GET['year'];
	}

	if(empty($_GET['month'])){
		$month = date("m");
	}
	else
	{
		$month = $_GET['month'];
	}

	$day = date("d");

	$end_day = date("t", mktime(0, 0, 0, $month, $day, $year));

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Sales Report</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<script>
	function go_view(str,value){
		
		if(str == '1')
		{
			m = document.sales.month.value;
			location.replace('report_sales.php?year=' + value + '&month=' + m);
		}
		else
		{

			y = document.sales.year.value;
			location.replace('report_sales.php?year=' + y + '&month=' + value);
		}
	}

</script>
<form name=sales>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td align=left height=35>&nbsp;
							  Year : <select name=year onChange="go_view('1',this.value)">
							  <?

							  for($k=2013; $k<$year+20; $k++):

							  if($k == $year)
							  {
								  $selected1 = "selected";
							  }
							  else
							  {
								  $selected1 = "";
							  }
							  ?>
							  <option value="<?= $k ?>" <?= $selected1 ?>><?= $k ?>
							  <?
							  endfor;
							  ?>
							  </select>&nbsp;&nbsp;
							  Month : <select name=month onChange="go_view('2',this.value)">
							  <option value="01" <? if($month == "01") echo "selected"; ?>>01
							  <option value="02" <? if($month == "02") echo "selected"; ?>>02
							  <option value="03" <? if($month == "03") echo "selected"; ?>>03
							  <option value="04" <? if($month == "04") echo "selected"; ?>>04
							  <option value="05" <? if($month == "05") echo "selected"; ?>>05
							  <option value="06" <? if($month == "06") echo "selected"; ?>>06
							  <option value="07" <? if($month == "07") echo "selected"; ?>>07
							  <option value="08" <? if($month == "08") echo "selected"; ?>>08
							  <option value="09" <? if($month == "09") echo "selected"; ?>>09
							  <option value="10" <? if($month == "10") echo "selected"; ?>>10
							  <option value="11" <? if($month == "11") echo "selected"; ?>>11
							  <option value="12" <? if($month == "12") echo "selected"; ?>>12
							  </select>&nbsp;&nbsp;</td>
	</tr>
</table>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
		  <tr bgcolor="#F4F4F4">
			<td width=20% align="center" height=25><span class="style2">Date</span></td>
			<td width=20% align="center" height=25><span class="style2">-</span></td>
			<td width=30% align="center" ><span class="style2">Orders</span></td>
			<td width=30% align="center" ><span class="style2">Sales Amount</span></td>
		  </tr>
		  <?
		  for($i=1; $i<=$end_day; $i++):

			if(strlen($i) == 1)
			{
				$s_day = "0".$i;
			}
			else
			{
				$s_day = $i;
			}

			$s_date = date("D", mktime(0, 0, 0, $month, $s_day, $year));

			$calendar_date = $year."-".$month."-".$s_day;

			if($calendar_date == $today)
			{
				$bgcolor = "#cccccc";
			}
			else
			{
				$bgcolor = "#ffffff";
			}


			$sale_month = $year."-".$month;

			$date_qry1 = "select sum(last_price),count(*) as cnt from chan_shop_orderinfo where order_status in ('3') && date_format(order_date,'%Y-%m-%d')='$calendar_date'";
			$date_rst1 = mysql_query($date_qry1);
			$date_amt = @mysql_result($date_rst1,0,0);
			$cnt_amt = @mysql_result($date_rst1,0,1);

		  ?>
		  <tr bgcolor=<?= $bgcolor ?>>
			<td height=25 align=center><?= $calendar_date ?></td>
			<td align=center><?= $s_date ?></td>
			<td align=center><b><?= $cnt_amt ?></b></td>
			<td align=center><b>$<?= number_format($date_amt,2) ?></b></td>
		  </tr>
		  <?
		  endfor;

			$calendar_m = $year."-".$month;

			$date_qry2 = "select sum(last_price),count(*) as cnt from chan_shop_orderinfo where order_status in ('3') && date_format(order_date,'%Y-%m')='$calendar_m'";
			$date_rst2 = mysql_query($date_qry2);
			$cntSum = @mysql_result($date_rst2,0,1);
			$amtSum = @mysql_result($date_rst2,0,0);
		  ?>
		  <tr bgcolor="#F4F4F4">
			<td width=20% align="center" height=35><span class="style2"></span></td>
			<td width=20% align="center" ><span class="style2"></span></td>
			<td width=30% align="center" ><span class="style2"><b><?= $cntSum ?></b></span></td>
			<td width=30% align="center" ><span class="style2"><b>$<?= NUMBER_FORMAT($amtSum,2); ?></b></span></td>
		  </tr>
		</table>	
		</form>
		<br><br><br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>