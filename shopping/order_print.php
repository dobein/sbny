<?
	include "../include/inc_base.php";

	if (!$_SESSION['member_id'])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/index.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?goUrl=$URL");
	}

	$orderNum = $_GET['orderNum'];

	$order_info = get_orderinfo($orderNum);


?>
<html>
<head>
<title>PRINT</title>

<style>
body {margin:0px;background:#FFF repeat-y fixed left top}
TD,SELECT,input,DIV,option,form,TEXTAREA,center,pre,blockquote {font-size:8pt; font-family:Arial; color:#333;line-height:16px;}

img {border:0;}

A:link    {color:#333;text-decoration:none;font-family:Arial;}
A:visited {color:#333;text-decoration:none;font-family:Arial;}
A:active  {color:#333;text-decoration:none;font-family:Arial;}
A:hover  {color:#666;text-decoration:underline;font-family:Arial;}

.menu A:link    {color:#fff;text-decoration:none;font-family:Arial;}
.menu A:visited {color:#fff;text-decoration:none;font-family:Arial;}
.menu A:active  {color:#fff;text-decoration:none;font-family:Arial;}
.menu A:hover  {color:#ff9900;text-decoration:none;font-family:Arial;}

.hidden {visibility:hidden;}

img.absmiddle { vertical-align:middle }

.png24 {tmp:expression(setPng24(this));} 

.menu2 A:link    {color:#333;text-decoration:none;}
.menu2 A:visited {color:#333;text-decoration:none;}
.menu2 A:active  {color:#333;text-decoration:none;}
.menu2 A:hover  {color:#ff9900;text-decoration:none;}

.menu, .menu2, .menu3 {font-size:10px;font-family:Arial;}

.menu3 A:link    {color:#333;text-decoration:none;}
.menu3 A:visited {color:#333;text-decoration:none;}
.menu3 A:active  {color:#333;text-decoration:none;}
.menu3 A:hover  {color:#000;text-decoration:underline;}

.product {border:solid 1px #e9e9e9;}

.orange {color:#ff9900;}

.blueblack {color:#000080}
.grayblue {color:#483d8b}
.white {color:#ffffff;}
.black {color:#000000;}
.pink {color:#FF52A0;}
.gray {color:#999999;}
.lgray {color:#c0c0c0;}
.title {font:12pt Arial;font-weight:bold;}
.blue {color:#00868B;}

.10px {font-size:10px;}
.14px {font-size:10px;}

</style>
<body onload="window.print();">
<!-- BODY START -->

            <table width="98%" align=center border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> 
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td valign="top" class='black title' height=23 colspan=3>
                  Order Print
          </td>
		  </tr>
              <tr> 
                <td height="1" bgcolor="#eeeeee" colspan=3><img height=1 class=hidden></td>
              </tr>
		</table>          
				</td>
                    </tr>
					<tr>
						<td height=24></td>
					</tr>
					<tr> 
					  <td align="right">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
								<td height="15" align="center" class="title"> 
									<table width="95%" border="0" cellpadding="0" cellspacing="0">	
										<tr> 
										  <td class='d8 pink'><b>Order Confirm</b></td>
										</tr>
									  <tr> 
										<td height="1" colspan="3" bgcolor="#e0e0e0"></td>
									  </tr>
										<tr> 
										  <td>
											<table width="100%" border="0" cellpadding="0" cellspacing="0">
											  <tr> 
												<td width="142" height="27" bgcolor="#f3f3f3" class=d8>&nbsp;&nbsp;&nbsp;&nbsp;Order Number</td>
												<td width="12" height="27"></td>
													  <td width="410" height="27">&nbsp;<b><?= $orderNum ?></b></td>
											  </tr>
											  <tr> 
												<td height="1" colspan="3" bgcolor="#eeeeee"></td>
											  </tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width="95%" border="0" cellpadding="0" cellspacing="0">	
										<tr> 
										  <td class='d8 pink'><b>Billing & Shipping Information</b></td>
										</tr>
									  <tr> 
										<td height="1" colspan="3" bgcolor="#e0e0e0"></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f4f4f4'>
												<tr bgcolor='#FFFFFF'>
													<td width=50% colspan=2>&nbsp;Billing info</td>
													<td width=50% colspan=2>&nbsp;Shipping info</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Name</td>
													<td width=35%>&nbsp;<?= $order_info[bill_first_name] ?> <?= $order_info[bill_last_name] ?></td>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Name</td>
													<td width=35%>&nbsp;<?= $order_info[ship_first_name] ?> <?= $order_info[ship_last_name] ?></td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Address</td>
													<td width=35%>&nbsp;<?= $order_info[bill_address1] ?> <?= $order_info[bill_address2] ?></td>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Address</td>
													<td width=35%>&nbsp;<?= $order_info[ship_address1] ?> <?= $order_info[ship_address2] ?></td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3>&nbsp;City / State</td>
													<td width=35%>&nbsp;<?= $order_info[bill_city] ?> <?= $order_info[bill_state] ?></td>
													<td width=15% bgcolor=#f3f3f3>&nbsp;City / State</td>
													<td width=35%>&nbsp;<?= $order_info[ship_city] ?> <?= $order_info[ship_state] ?></td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Zipcode</td>
													<td width=35%>&nbsp;<?= $order_info[bill_zipcode] ?></td>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Zipcode</td>
													<td width=35%>&nbsp;<?= $order_info[ship_zipcode] ?></td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3>&nbsp;Phone</td>
													<td width=35%>&nbsp;<?= $order_info[bill_cellphone] ?></td>
													<td width=15% bgcolor=#f3f3f3>&nbsp;</td>
													<td width=35%>&nbsp;</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3>&nbsp;E-mail</td>
													<td width=35%>&nbsp;<?= $order_info[bill_email] ?></td>
													<td width=15% bgcolor=#f3f3f3>&nbsp;</td>
													<td width=35%>&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width="95%" border="0" cellpadding="0" cellspacing="0">	
										<tr> 
										  <td class='d8 pink'><b>Order Items</b></td>
										</tr>
									  <tr> 
										<td height="1" colspan="3" bgcolor="#e0e0e0"></td>
									  </tr>
									  <tr>
										<td height=28>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f3f3f3'>
												<tr bgcolor='#FFFFFF'>
													<td width=20% align=left>&nbsp;Model#</td>
													<td width=30% align=left>&nbsp;Name</td>
													<td width=30% align=left>&nbsp;Option</td>
													<td width=10% align=center>Qty</td>
													<td width=10% align=center>Price</td>
												</tr>
												<?
												$qry2 = "select * from chan_shop_orderproduct where orderNum='$orderNum' order by seq_no asc";
												$rst2 = mysql_query($qry2,$dbConn);

												
												while($row2 = mysql_fetch_array($rst2)){
														
													//$us_price = number_format($row2[p_price],2);

													$item_info = get_iteminfo($row2[item_code]);

													$row2[item_sale] = number_format($row2[item_sale],2);
													$real_total_price = number_format($row2[item_sale]*$row2[item_qty],2);

													echo "
													<tr bgcolor='#FFFFFF'>
														<td align=left height=28>&nbsp;$item_info[model_no]</td>
														<td align=left height=28>&nbsp;$item_info[item_title]</td>
														<td align=left>&nbsp;<span class='blue'>$row2[item_option]</span></td>
														<td align=center>$row2[item_qty]</td>
														<td align=center><FONT class='pink t10'><b>$$real_total_price</b></FONT></td>
													</tr>";
												}
												?>
											</table>
										</td>
									  </tr>
									  <tr>
										<td align=right>Sub total : $<?= number_format($order_info[order_price],2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right>Shipping : $<?= number_format($order_info[shipping],2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right height=28><b>Total amount : $<?= number_format($order_info[last_price],2); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
									  </tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				  </tr>
				  <tr> 
					<td align="right"><table width="564" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="36" align="center" valign="bottom"><br></td>
						</tr>
					  </table></td>
				  </tr>
				</table>
			</td>
		</tr>
	</table>
<!-- BODY END -->

