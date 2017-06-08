<?
	// 기본 설정 파일모음
	include "../include/inc_base.php";

	$tableName = "chan_shop_orderinfo";

	$qry1 = "select * from $tableName where orderNum='$orderNum'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

	$wholesaler_info = getInfoWholesaler($row1[wholesaler]);

	// 주문자 정보
	$order_info = unserialize($row1[order_info]);

	// 신용카드 정보
	$credit_info = unserialize($row1[credit_info]);

	$replace_credit = substr($credit_info[card_number],0,12);
	$credit_new_number = str_replace($replace_credit,"********",$credit_info[card_number]);

	$tracking_info = explode("@",$row1[tracking]);
?>
<html>
<TITLE>INVOICE</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style>
input.line,TEXTAREA.line
{font-size:9pt; font-family:century gothic; color:#5A5A5A; border:1px solid #CCCCCC;}
TD,SELECT,input,option,form,TEXTAREA,center,pre,blockquote {font-family:century gothic; font-size:9pt;}

.dot_table {border-right: dotted #CCCCCC 1px; border-left: dotted #CCCCCC 1px; border-top: dotted #CCCCCC 1px; border-bottom: dotted #CCCCCC 1px;}

</style>
<SCRIPT LANGUAGE='JavaScript'> 
<!-- 
function ThisWindowsPrint() { 
    with ( factory.printing ){ 
        header = ''; 
        footer = ''; 
        portrait = true; // true 세로출력 , false 가로출력 
        leftMargin = 0; 
        rightMargin = 0; 
        topMargin = 0; 
        bottomMargin = 0; 
        Print(false, window) // 첫번째 인자 : 대화상자표시여부 , 두번째인자 : 출력될 프레임 
    } 
} 
//--> 
</SCRIPT> 
<body onload="javascript:ThisWindowsPrint();">
<Object id='factory' viewastext style='display:none' classid='clsid:1663ed61-23eb-11d2-b92f-008048fdd814' codebase='../smsx.cab#Version=6,2,433,14'> 
</Object> 
<br>
<table width=98% align=center border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td width=60% valign=top>
			<table width=100% align=center border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td height=35><span style="font-size:18pt;font-weight:bold;line-height:30px"><?= $wholesaler_info[company] ?></span></td>
				</tr>
				<tr>
					<td><?= $wholesaler_info[address1] ?> <?= $wholesaler_info[address2] ?></td>
				</tr>
				<tr>
					<td><?= $wholesaler_info[city] ?>,  <?= $wholesaler_info[state] ?> <?= $wholesaler_info[zipcode] ?></td>
				</tr>
				<tr>
					<td>T) <?= $wholesaler_info[cell_phone] ?></td>
				</tr>
			</table>
		</td>
		<td width=40% valign=top>
			<table width=100% align=center border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td align=right height=35><span style="font-size:18pt;font-weight:bold;line-height:30px">Invoice</span>&nbsp;&nbsp;</td>
				</tr>
			</table>
			<table width=100% align=right border="1" bordercolor="#000000" style="border-collapse: collapse;" cellspacing=0 cellpadding=0>
				<tr>
					<td width=30% align=center>Date</td>
					<td width=30% align=center>Order #</td>
					<td width=40% align=center>Invoice #</td>
				</tr>
				<tr>
					<td width=30% align=center><?= date("Y-m-d"); ?></td>
					<td width=30% align=center><?= $row1[orderNum] ?></td>
					<td width=40% align=center><?= $row1[invoice] ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<table width=98% align=center border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td width=50% valign=top>
			<table width=90% align=left border="1" bordercolor="#000000" style="border-collapse: collapse;" cellspacing=0 cellpadding=0>
			<tr bgcolor='#FFFFFF'>
				<td height=25 height=35 style="padding-left:5px">Bill To</td>
			</tr>
			<tr>
				<td valign=top style="padding-left:5px"><?= $order_info[bill_first_name] ?> <?= $order_info[bill_last_name] ?><br>
				<?= $order_info[bill_address1] ?> <?= $order_info[bill_address2] ?><br>
				<?= $order_info[bill_city] ?>, <?= $order_info[bill_state] ?> <?= $order_info[bill_zipcode] ?><br>
				<?= $order_info[bill_cellphone] ?></td>
			</tr>
			</table>
		</td>
		<td width=50% valign=top>
			<table width=90% align=right border="1" bordercolor="#000000" style="border-collapse: collapse;" cellspacing=0 cellpadding=0>
			<tr bgcolor='#FFFFFF'>
				<td height=25 height=35 style="padding-left:5px">&nbsp;Ship To</td>
			</tr>
			<tr>
				<td valign=top style="padding-left:5px"><?= $order_info[ship_first_name] ?> <?= $order_info[ship_last_name] ?><br>
				<?= $order_info[ship_address1] ?> <?= $order_info[ship_address2] ?><br>
				<?= $order_info[ship_city] ?>, <?= $order_info[ship_state] ?> <?= $order_info[ship_zipcode] ?><br>
				<?= $order_info[ship_cellphone] ?></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<table width=98% align=center style="border-top: 1px solid #5b5b5b;border-left: 1px solid #5b5b5b;border-right: 1px solid #5b5b5b;border-bottom: 1px solid #5b5b5b;" cellspacing=0 cellpadding=0>
	<tr>
		<td width=5% align=center style="border-right: 1px solid #5b5b5b;border-bottom: 1px solid #5b5b5b;">Qty</td>
		<td width=20% align=center style="border-right: 1px solid #5b5b5b;border-bottom: 1px solid #5b5b5b;">Item</td>
		<td width=57% align=center style="border-right: 1px solid #5b5b5b;border-bottom: 1px solid #5b5b5b;">Description</td>
		<td width=8% align=center style="border-right: 1px solid #5b5b5b;border-bottom: 1px solid #5b5b5b;">Rate</td>
		<td width=10% align=center style="border-bottom: 1px solid #5b5b5b;">Amount</td>
	</tr>
<?
$qry2 = "select * from chan_shop_orderproduct where orderNum='$orderNum' order by seq_no asc";
$rst2 = mysql_query($qry2,$dbConn);
$num2 = mysql_num_rows($rst2);

$sub_sum = "0";

$remain_row = 47-$num2;


while($row2 = mysql_fetch_array($rst2)){
		
	//$us_price = number_format($row2[p_price],2);
	$img_url = _WEB_BASE_DIR;

	$item_info = get_iteminfo($row2[item_code]);



	if($row2[item_status] == "1")
	{
		$select_msg = "Checking";
		$ship_qty = "0";
	}
	else if($row2[item_status] == "2")
	{
		$select_msg = "BackOrder";
		$ship_qty = "0";
	}
	else if($row2[item_status] == "3")
	{
		$select_msg = "Out of Stock";
		$ship_qty = "0";
	}
	else if($row2[item_status] == "4")
	{
		$select_msg = "Ship";
		$ship_qty = $row2[item_qty];
	}

	$real_price = number_format($row2[item_last] * $row2[item_qty],2);


	echo "
		<tr>
			<td align=right style=\"border-right: 1px solid #5b5b5b;\">$ship_qty&nbsp;</td>
			<td align=left style=\"border-right: 1px solid #5b5b5b;\">&nbsp;$item_info[model_no]</td>
			<td align=left style=\"border-right: 1px solid #5b5b5b;\">&nbsp;$row2[item_title]&nbsp;$row2[item_option]</td>
			<td align=right style=\"border-right: 1px solid #5b5b5b;\">$row2[item_last]&nbsp;</td>
			<td align=right >$real_price&nbsp;</td>
		</tr>";
	
	$sub_sum = $sub_sum + $row2[item_last];

}

for($k=0; $k<$remain_row; $k++)
{
	echo "
		<tr>
			<td align=right style=\"border-right: 1px solid #5b5b5b;\">&nbsp;</td>
			<td align=left style=\"border-right: 1px solid #5b5b5b;\">&nbsp;</td>
			<td align=left style=\"border-right: 1px solid #5b5b5b;\">&nbsp;</td>
			<td align=right style=\"border-right: 1px solid #5b5b5b;\">&nbsp;</td>
			<td align=right >&nbsp;</td>
		</tr>";
}

$sub_total = round_to_penny($sub_sum);
?>
</table>
<br>
<table width=98% align=center border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td width=70% valign=top>
			<table width=98% align=left style="border-top: 1px solid #5b5b5b;border-left: 1px solid #5b5b5b;border-right: 1px solid #5b5b5b;border-bottom: 1px solid #5b5b5b;" cellspacing=0 cellpadding=0>
				<tr>
					<td height=25>&nbsp;Thanks for shopping with us</td>
				</tr>
				<tr>
					<td height=25>&nbsp;** Return Policy</td>
				</tr>
				<tr>
					<td height=25>&nbsp;* All damages and shortages must be reported within 7 days.</td>
				</tr>
				<tr>
					<td height=25>&nbsp;* Returns will not be accepted without Return Authorization Number</td>
				</tr>
			</table>
		</td>
		<td width=30% valign=top>
				<table width=98% align=right border="1" bordercolor="#000000" style="border-collapse: collapse;" cellspacing=0 cellpadding=0>
				<tr bgcolor='#FFFFFF'>
					<td width=50% height=25 align=right>Sub Total : &nbsp;</td>
					<td width=50% align=right>$<?= number_format($row1[order_price],2); ?>&nbsp;</td>
				</tr>
				<tr bgcolor='#FFFFFF'>
					<td height=25  align=right>Shipping : &nbsp;</td>
					<td align=right>$<?= number_format($row1[shipping],2); ?>&nbsp;</td>
				</tr>
				<tr bgcolor='#FFFFFF'>
					<td height=25  align=right>Discount : &nbsp;</td>
					<td align=right>$<?= number_format($row1[discount_amt],2); ?>&nbsp;</td>
				</tr>
				<tr bgcolor='#FFFFFF'>
					<td height=25  align=right>Total : &nbsp;</td>
					<td align=right>$<?= number_format($row1[last_price],2); ?>&nbsp;</td>
				</tr>
				</table>	
		</td>
	</tr>
</table>
<br>
</body>
</html>