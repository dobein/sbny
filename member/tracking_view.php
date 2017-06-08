<?
	include "../include/inc_base.php";

	if (!$HTTP_COOKIE_VARS[MEMLOGIN_INFO])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/member/tracking.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?goUrl=$URL");
	}

	include _BASE_DIR ."/include/inc_top.php";

	$tableName = "chan_shop_orderinfo";

	$orderNum = $_GET['orderNum'];

	$row1 = get_orderinfo($orderNum);

	if($row1[user_id] != $user_info[user_id])
	{
		Misc::jvAlert("Access deny!","history.go(-1)");
		exit;
	}

	// 주문자 정보
	$order_info = unserialize($row1[order_info]);

	$tracking_info = explode("@",$row1[tracking]);

	switch($row1[order_status]){

		case "1":
			$status_msg = "Pending";
			break;
		case "2":
			$status_msg = "Processing";
			break;
		case "3":
			$status_msg = "Shipped";
			break;
		case "4":
			$status_msg = "Canceled";
			$tracking = "";
			break;
		case "5":
			$status_msg = "Back Order";
			$bgcolor = "black";
			break;
		case "6":
			$status_msg = "Processing";
			$bgcolor = "red";
			break;
		default:
			$status_msg = "Check";
	}

?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<!-- <tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <span class="b">ACCOUNT</span></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr> -->
				<tr>
					<td height="50"></td>
				</tr>
				<tr>
					<td valign=top>
						<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign=top>

      <table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height=50 align=left>&nbsp;&nbsp;&nbsp;<b><a href=tracking.php>My Order History</a></b></td>
		</tr>
		<tr><td height=1 bgcolor=#f4f4f4></td></tr>
		<tr>
			<td height=28>- Click on an order number to see the details of your order, or to track your order. </td>
		</tr>
		<tr>
			<td></td>
		</tr>
<tr bgcolor='#FFFFFF'>
	<td>
	<table width=100% align=center border=0 cellspacing=0 bgcolor='#CCCCCC'>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=28 bgcolor=#F9F9F9>&nbsp;<b>Order num</b></td>
			<td width=30%>&nbsp;<b><?= $row1[orderNum] ?></b></td>
			<td width=20% bgcolor=#F9F9F9>&nbsp;Order date</td>
			<td width=30%>&nbsp;<?= $row1[order_date] ?></td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor=#F9F9F9>&nbsp;Amount</td>
			<td colspan=3>&nbsp;<b>$<?= number_format($row1[last_price],2); ?></b>&nbsp;&nbsp;&nbsp;(Price : $<?= number_format($row1[order_price],2); ?>&nbsp;Ship : $<?= number_format($row1[shipping],2); ?>&nbsp;Tax : $<?= number_format($row1[tax],2); ?>)</td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>

		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Shipping</td>
			<td colspan=3>&nbsp;<?= $row1[shipping_title] ?> | $<?= number_format($row1[shipping],2); ?></td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Discount</td>
			<td colspan=3>&nbsp;<font color=red>-$<?= number_format($row1[discount_amt],2); ?></font></td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Pay method</td>
			<td colspan=3>&nbsp;<?= $row1[pay_method] ?></td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor=#F9F9F9>&nbsp;Order Status</td>
			<td colspan=3>&nbsp;<?= $status_msg ?></td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor=#F9F9F9>&nbsp;Tracking</td>
			<td colspan=3>&nbsp;<a href=http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=<?= $tracking_info[1] ?> target=_blank><u><?= $tracking_info[1] ?></u></a></td>
		</tr>
		<tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
	</table>
	</td>
</tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=0>
<tr>
	<td class='d8 pink'>&nbsp;<b>Delivery infomation</b></td>
</tr>
<tr> 
	<td height="1" bgcolor="#e0e0e0"></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td>
	<table width=100% align=center border=0 cellspacing=0 bgcolor='#CCCCCC'>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=22 align=center>&nbsp;</td>
			<td width=40% align=left>Billing information</td>
			<td width=40% align=left>Shipping information</td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Name(en)</td>
			<td >&nbsp;<?= $order_info[bill_first_name] ?>&nbsp;<?= $order_info[bill_last_name] ?></td>
			<td >&nbsp;<?= $order_info[ship_first_name] ?>&nbsp;<?= $order_info[ship_last_name] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Address 1</td>
			<td >&nbsp;<?= $order_info[bill_address1] ?></td>
			<td >&nbsp;<?= $order_info[ship_address1] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Address 2</td>
			<td >&nbsp;<?= $order_info[bill_address2] ?></td>
			<td >&nbsp;<?= $order_info[ship_address2] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;City</td>
			<td >&nbsp;<?= $order_info[bill_city] ?></td>
			<td >&nbsp;<?= $order_info[ship_city] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;State</td>
			<td >&nbsp;<?= $order_info[bill_state] ?></td>
			<td >&nbsp;<?= $order_info[ship_state] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Zipcode</td>
			<td >&nbsp;<?= $order_info[bill_zipcode] ?></td>
			<td >&nbsp;<?= $order_info[ship_zipcode] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;Phone</td>
			<td >&nbsp;<?= $order_info[bill_phone] ?></td>
			<td >&nbsp;<?= $order_info[ship_phone] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor=#F9F9F9>&nbsp;E-mail</td>
			<td >&nbsp;<?= $order_info[bill_email] ?></td>
			<td >&nbsp;<?= $order_info[ship_email] ?></td>
		</tr>
		<tr><td colspan=3 height=1 bgcolor=#F4F4F4></td></tr>
	</table>
	</td>
</tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=0>
<tr>
	<td class='d8 pink'>&nbsp;<b>Order Summary</b></td>
</tr>
<tr> 
	<td height="1" bgcolor="#e0e0e0"></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td>
	<table width=100% align=center border=0 cellspacing=0>
		<tr bgcolor='#F2F2F2'>
			<td width=10% align=center>Image</td>
			<td width=40% align=left>&nbsp;Item #</td>
			<td width=15% align=center>Unit Price</td>
			<td width=10% align=center>Qty</td>
			<td width=15% align=center>Amount</td>
		</tr>
		<?
		$qry2 = "select * from chan_shop_orderproduct where orderNum='$orderNum' order by seq_no asc";
		$rst2 = mysql_query($qry2,$dbConn);

		while($row2 = mysql_fetch_array($rst2)){
				
			//$us_price = number_format($row2[p_price],2);
			$img_url = _WEB_BASE_DIR;
			$item_info = get_iteminfo($row2[item_code]);

			$file_name = "thum_".get_firstpic($item_info[userfile1]);

			if($item_info[userfile1])
				{
					$file_image = "<img src=\"../../thum_upload/$file_name\" border=0 style='border-color=#CCCCCC' width=40>";
				}
			else
				{
					$file_image = "<font style='color:#CCCCCC'>No images</font>";
				}


			$real_total_price = number_format($row2[item_last]*$row2[item_qty],2);


			$row2[item_regular] = number_format($row2[item_regular],2);
			$row2[item_sale] = number_format($row2[item_sale],2);
			$row2[item_last] = number_format($row2[item_last],2);

			$brand_name = brand_name($item_info[brand]);

			switch($row2[item_status])
			{
				case "1":
					$item_status = "Checking";
					break;
				case "2":
					$item_status = "BackOrder";
					break;
				case "3":
					$item_status = "Out of Stock";
					break;
				case "4":
					$item_status = "Ready";
					break;
				default:
					$item_status = "-";
					break;
			}

			echo "
			<tr bgcolor='#FFFFFF'>
				<td align=center>$file_image</td>
				<td align=left height=25>&nbsp;<b>$item_info[model_no]</b>&nbsp;$row2[item_title]&nbsp;<b>$row2[item_option]</b></td>
				<td align=center>$$row2[item_last]</td>
				<td align=center>$row2[item_qty]</td>
				<td align=center><b>$$real_total_price</b></td>
			</tr>
			<tr><td colspan=5 height=1 bgcolor=#F4F4F4></td></tr>";
		}
		?>
	</table>
	</td>
</tr>
</table>

<p align=center><input type=button value=" Go Back " onClick="javascript:history.go(-1)" class="summit_btn"></p>
<br><br>



								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	  
<?
	// 왼쪽 include
	include _BASE_DIR ."/include/inc_bottom.php";
?>