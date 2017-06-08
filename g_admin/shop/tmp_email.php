<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";



	function sendEmail_tmp($flag,$oN){

		global $dbConn,$base_info;

		$order_info = get_orderinfo($oN);


		$base_infosite_name = "Germanium";
		$base_infosite_email = "info@germanium.net";


		$eol="\r\n";

		$boundary = "--------" . uniqid("part"); 
		$headers .= 'From: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol; 
		$headers .= 'Reply-To: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol; 
		$headers .= 'Return-Path: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol;    // these two to set reply address 
		$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
		$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 
        $headers .= "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-Type:text/html; charset=euc-kr\r\n"; 
		$headers .= "Content-Transfer-Encoding: 8bit\n\n";

		// order product
		$qry2 = "select * from chan_shop_orderproduct where orderNum='$oN' order by seq_no asc";
		$rst2 = mysql_query($qry2,$dbConn);

		while($row2 = mysql_fetch_array($rst2)){
				
			//$us_price = number_format($row2[p_price],2);

			$item_info = get_iteminfo($row2[item_code]);

			$item_sale = number_format($row2[item_sale],2);
			$real_total_price = number_format($row2[item_sale]*$row2[item_qty],2);


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

			//&nbsp;&nbsp;<span class='blue'>Credit:$$row2[item_credit]</span>
			$order_product .= "
			<tr bgcolor='#FFFFFF'>
				<td align=left>&nbsp;$item_info[model_no]&nbsp;<b>$item_info[item_title]</b></td>
				<td align=center>$$item_sale</td>
				<td align=center>$row2[item_qty]</td>
				<td align=center><b>$$real_total_price</b></td>
			</tr>";		
		}

		$order_info[ship_first_name] = mb_convert_encoding($order_info[ship_first_name], 'HTML-ENTITIES', 'UTF-8'); 
		$order_info[ship_last_name] = mb_convert_encoding($order_info[ship_last_name], 'HTML-ENTITIES', 'UTF-8'); 


		switch($flag)
		{
			case "1":
				$mail_title = "$base_infosite_name Email Notification";

						$mailStr .= "
						<table width=600 border=0 cellpadding=0 cellspacing=1 bgcolor='#cccccc'>
							<tr> 
								<td align=center class=title bgcolor=#FFFFFF> 
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td>
<span style='font-size:12pt;color:#ff6600'>Hello $order_info[ship_first_name] $order_info[ship_last_name],</span><br>
Thank you for shopping with us. We'd like to let you know that Germanium inc has received your order, and is preparing it for shipment. If you would like to view the status of your order, please visit Your Orders on $base_info[site_homepage] .

										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>

									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td class='d8 pink' align=left><b>Order Confirmation</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF>
											  <tr> 
												<td width=30% height=27 bgcolor=#f3f3f3 class=d8>&nbsp;&nbsp;&nbsp;&nbsp;Order #</td>
												<td width=70% height=27 align=left>&nbsp;<a href=$base_info[site_homepage]/tracking.php target=_blank><b>$oN</b></a></td>
											  </tr>
											  <tr> 
												<td height=1 colspan=3 bgcolor=#eeeeee></td>
											  </tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td bgcolor=#FFFFFF align=left><b>Your order will be sent to: </b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f4f4f4'>
												<tr bgcolor='#FFFFFF'>
													<td width=30% bgcolor=#f3f3f3 align=left>&nbsp;Name</td>
													<td width=70% align=left>&nbsp;$order_info[ship_first_name] $order_info[ship_last_name]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td bgcolor=#f3f3f3 align=left>&nbsp;Address</td>
													<td align=left>&nbsp;$order_info[ship_address1] $order_info[ship_address2]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td bgcolor=#f3f3f3 align=left>&nbsp;City / State</td>
													<td align=left>&nbsp;$order_info[ship_city] $order_info[ship_state]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td align=left bgcolor=#f3f3f3>&nbsp;Zip code</td>
													<td align=left>&nbsp;$order_info[ship_zipcode]</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=1 bgcolor='#f4f4f4'>	
										<tr> 
										  <td colspan=2  align=left><b>Order Details</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=2 bgcolor=#e0e0e0></td>
									  </tr>
									  <tr>
										<td height=28 colspan=2 bgcolor=#FFFFFF>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f3f3f3'>
												<tr bgcolor='#FFFFFF'>
													<td width=50% align=center>Item</td>
													<td width=20% align=center>Unit Price</td>
													<td width=10% align=center>Qty</td>
													<td width=20% align=center>Amount</td>
												</tr>
												$order_product
											</table>
										</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td width=70% align=right >Sub total : </td>
										<td width=30% align=right>$$order_info[order_price]&nbsp;&nbsp;</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td align=right >Tax : </td>
										<td align=right>$$order_info[tax]&nbsp;&nbsp;</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td align=right >Shipping : </td>
										<td align=right>$$order_info[shipping]&nbsp;&nbsp;</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td align=right  height=28><b>Total amount : </td>
										<td align=right>$$order_info[last_price]</b>&nbsp;&nbsp;</td>
									  </tr>
									</table>
								</td>
							</tr>
						</table>
						";




				$send = $order_info[bill_email];
				break;
			
			case "2":
				$mail_title = "$base_infosite_name Email Notification - Order Update";

				$mailStr .= "Order # : $oN.<br>";
				$mailStr .= "Customer Name : $order_memberinfo[bill_first_name] $order_memberinfo[bill_last_name]<br>";
				$mailStr .= "Date Ordered : $order_info[order_date].<br>";
				$mailStr .= " <br>";
				$mailStr .= "Hi, thank you for shopping with $base_infosite_name. Your package has been delivered to UPS.<br>";
				$mailStr .= "Please use your order id to track your package on our information page here. $base_info[site_homepage]/member/tracking.php<br>";
				$mailStr .= " <br>";
				$mailStr .= "Your order has been updated to the following status.<br>";
				$mailStr .= "New status: Shipped<br>";
				$mailStr .= "Tracking number : $order_info[tracking]<br>";
				$mailStr .= " <br>";
				$mailStr .= $order_info[feedback]."<br>";
				$mailStr .= "Please reply to this email if you have any questions.<br><br>";
				$mailStr .= "Thank you for shopping with us and hope to see you soon.";

				$send = $order_info[bill_email];
				break;

			case "4":
				$mail_title = "$base_infosite_name Email Notification - Order Cancellation";

				$mailStr .= "Order # : $oN.<br>";
				$mailStr .= "Customer Name : $order_memberinfo[bill_first_name] $order_memberinfo[bill_last_name]<br>";
				$mailStr .= "Date Ordered : $order_info[order_date].<br>";
				$mailStr .= " <br>";
				$mailStr .= "Your order has been canceled. <br>";
				$mailStr .= "We did not charge you for this order.";
				$mailStr .= " <br>";
				$mailStr .= "Your order has been updated to the following status.<br>";
				$mailStr .= "New status: CANCELLED<br>";
				$mailStr .= " <br>";
				$mailStr .= $order_info[feedback]."<br>";
				$mailStr .= "Please reply to this email if you have any questions.";

				$send = $order_info[bill_email];
				break;

			case "3":
				$mail_title = "$base_infosite_name Email Notification - Order Changed";

						$mailStr .= "
						<table width=600 border=0 cellpadding=0 cellspacing=1 bgcolor='#cccccc'>
							<tr> 
								<td align=center class=title bgcolor=#FFFFFF> 
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td class='d8 pink' align=left><b>Order Confirm</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF>
											  <tr> 
												<td width=142 height=27 bgcolor=#f3f3f3 class=d8>&nbsp;&nbsp;&nbsp;&nbsp;Order No.</td>
												<td width=12 height=27></td>
												<td width=410 height=27 align=left>&nbsp;<a href=$base_info[site_homepage]/member/tracking.php target=_blank><b>$oN</b></a></td>
											  </tr>
											  <tr> 
												<td height=1 colspan=3 bgcolor=#eeeeee></td>
											  </tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td bgcolor=#FFFFFF align=left><b>Billing & Shipping Information</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f4f4f4'>
												<tr bgcolor='#FFFFFF'>
													<td width=50% colspan=2 align=left>&nbsp;Billing </td>
													<td width=50% colspan=2 align=left>&nbsp;Shipping </td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Name</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_first_name] $order_memberinfo[bill_last_name]</td>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Name</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_first_name] $order_memberinfo[ship_last_name]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Address</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_address1] $order_memberinfo[bill_address2]</td>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Address</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_address1] $order_memberinfo[ship_address2]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;City / State</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_city] $order_memberinfo[bill_state]</td>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;City / State</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_city] $order_memberinfo[ship_state]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Zip code</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_zipcode]</td>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;Zip code</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_zipcode]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;Phone</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_phone]</td>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;Phone</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_phone]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;E-mail</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_email]</td>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;E-mail</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_email]</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=1 bgcolor='#f4f4f4'>	
										<tr> 
										  <td class='d8 pink' align=left><b>Order Items</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
									  <tr>
										<td height=28 bgcolor=#FFFFFF>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f3f3f3'>
												<tr bgcolor='#FFFFFF'>
													<td width=30% align=center>Item</td>
													<td width=30% align=center>Colors</td>
													<td width=15% align=center>Unit Price</td>
													<td width=10% align=center>Qty</td>
													<td width=15% align=center>Amount</td>
												</tr>
												$order_product
											</table>
										</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF>Sub total : $$order_info[order_price]&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF>Tax : $$order_info[tax]&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF>Shipping : $$order_info[shipping]&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF height=28><b>Total amount : $$order_info[last_price]</b>&nbsp;&nbsp;</td>
									  </tr>
									</table>
								</td>
							</tr>
						</table>
						";




				$send = $order_info[bill_email];
				break;
		}

		$send = "chanyong.lee@gmail.com";

		$mail_result = mail($send, $mail_title, $mailStr, $headers);

		/*
		$sendAdmin = "buy@domainshop.com";
		$sendAdmin2 = "info@germanium.net";

		$mail_title2 = "[Alert] ".$mail_title;
		$mail_result2 = mail($sendAdmin, $mail_title2, $mailStr, $headers);
		$mail_result3 = mail($sendAdmin2, $mail_title2, $mailStr, $headers);
		*/


		return $mail_result;
	}



?>

<?
		$oN = $_GET['oN'];

		$order_info = get_orderinfo($oN);
		
		$order_info[ship_first_name] = "david lee";

		$dbraddr1 = iconv( "UTF-8", "EUC-KR", $order_info[ship_first_name]);
		$dbraddr2 = $order_info[ship_first_name];
		$dbraddr3 = mb_convert_encoding($order_info[ship_first_name], 'HTML-ENTITIES', 'UTF-8'); 


		echo $dbraddr1;
		echo "<hr>";
		echo $dbraddr2;
		echo "<hr>";
		echo $dbraddr3;
		$mail_flag = "1";
		$mail_result = sendEmail_tmp($mail_flag,$oN);
?>