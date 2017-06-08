<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_orderinfo";

	if($_POST['mode'] == "save")
	{
		// 기본 사이트 정보 가져오기

		$site_base_info = getinfo_site_admin($_POST['domain']);



		$orderNum = $_POST['orderNum'];

		$bill_first_name = addslashes($_POST['bill_first_name']);
		$bill_last_name = addslashes($_POST['bill_last_name']);
		$bill_email = $_POST['bill_email'];
		$bill_country = $_POST['bill_country'];
		$bill_address1 = addslashes($_POST['bill_address1']);
		$bill_address2 = addslashes($_POST['bill_address2']);
		$bill_city = addslashes($_POST['bill_city']);
		$bill_state = $_POST['bill_state'];
		$bill_zipcode = $_POST['bill_zipcode'];
		$bill_phone = $_POST['bill_phone'];
		$bill_cellphone = $_POST['bill_cellphone'];
		$ship_cellphone = $_POST['ship_cellphone'];
		$ship_first_name = addslashes($_POST['ship_first_name']);
		$ship_last_name = addslashes($_POST['ship_last_name']);
		$ship_email = $_POST['ship_email'];
		$ship_country = $_POST['ship_country'];
		$ship_address1 = addslashes($_POST['ship_address1']);
		$ship_address2 = addslashes($_POST['ship_address2']);
		$ship_city = addslashes($_POST['ship_city']);
		$ship_state = $_POST['ship_state'];
		$ship_zipcode = $_POST['ship_zipcode'];
		$ship_phone = $_POST['ship_phone'];
		$ship_cellphone = $_POST['ship_cellphone'];

		$email_msg = addslashes($_POST['email_msg']);


		$pay_status = $_POST['pay_status'];
		$tracking = $_POST['tracking'];
		$order_status = $_POST['order_status'];
		$feedback = addslashes($_POST['feedback']);



		/**
		* tracking company
		*/

		$qry4 = "update $tableName set pay_status = '$pay_status', 
														bill_first_name = '$bill_first_name',
														bill_last_name = '$bill_last_name',
														bill_email = '$bill_email',
														bill_country = '$bill_country',
														bill_address1 = '$bill_address1',
														bill_address2 = '$bill_address2',
														bill_city = '$bill_city',
														bill_state = '$bill_state',
														bill_zipcode = '$bill_zipcode',
														bill_cellphone = '$bill_cellphone',
														ship_cellphone = '$ship_cellphone',
														ship_first_name = '$ship_first_name',
														ship_last_name = '$ship_last_name',
														ship_country = '$ship_country',
														ship_address1 = '$ship_address1',
														ship_address2 = '$ship_address2',
														ship_city = '$ship_city',
														ship_state = '$ship_state',
														ship_zipcode = '$ship_zipcode',
														order_status='$order_status', 
														feedback = '$feedback', 
														tracking = '$tracking' where orderNum = '$orderNum'";
		$rst4 = mysql_query($qry4,$dbConn);


		/*
		if($_POST['order_status'] == "3")
		{
			$mail_flag = "2";
			$mail_result = sendEmail($mail_flag,$orderNum);
		}
		else if($_POST['order_status'] == "4")
		{
			$mail_flag = "4";
			$mail_result = sendEmail($mail_flag,$orderNum);
		}
		*/

		if($_POST['invoice_print'] == "YES")
		{
			echo "<script> window.open(\"print_order.php?orderNum=$orderNum\",\"order\",\"width=700,height=500,scrollbars=1\"); </script>";
		}


		// order status 가 3이면 메일 보내기
		if($_POST['send_email'] == "YES")
		{
			/**
			* @ 메일보내기
			*/
			$eol="\r\n";

			// 보내는 사람 정보
			$mail_from_name = "Germanium";
			$mail_from_email = "info@germanium.net";

			// 메일 헤더
			$headers .= 'From: '.$mail_from_name.' <'.$mail_from_email.'>'.$eol; 
			$headers .= 'Reply-To: '.$mail_from_name.' <'.$mail_from_email.'>'.$eol; 
			$headers .= 'Return-Path: '.$mail_from_name.' <'.$mail_from_email.'>'.$eol;    // these two to set reply address 
			$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
			$headers .= "Content-Type: TEXT/PLAIN; iso-8859-1".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 


			// 메일 제목
			$mail_title = "[".$mail_from_name."] $orderNum - Your order has been shipped.";

			// 사용자 메일
			$mail_result = mail($bill_email, $mail_title, $email_msg, $headers);

			// 관리자 메일
			$admin_mail_title = "[".$mail_from_name."] $orderNum - Your order has been shipped.";
			$admin_mail_result = mail($mail_from_email, $admin_mail_title, $email_msg, $headers);

			// DB 저장
			$e_qry1 = "insert into chan_shop_orderemail values ('$orderNum','$email_msg',now(),'')";
			$e_rst1 = mysql_query($e_qry1);
		}



		if($rst4)
		{
			$area = $_POST['area'];

			//Misc::jvAlert("Completed!.","location.replace('order_list.php?area=$area')");
			echo "<meta http-equiv='refresh' content='0; url=./order_list.php?area=$area'>";
			exit;
		}
		else
		{
			Misc::jvAlert("Fail!","history.go(-1)");
			exit;
		}
	}
	else if($_POST['mode'] == "del")
	{
		$orderNum = $_POST['orderNum'];
		$area = $_POST['area'];

		// orderNum
		$qry1 = "delete from chan_shop_orderinfo where orderNum = '$orderNum'";
		$rst1 = mysql_query($qry1);

		$qry2 = "delete from chan_shop_orderproduct where orderNum = '$orderNum'";
		$rst2 = mysql_query($qry2);


		if($rst1 && $rst2)
		{
			//Misc::jvAlert("Completed!.","location.replace('order_list.php?area=$area')");
			echo "<meta http-equiv='refresh' content='0; url=./order_list.php?area=$area'>";
			exit;
		}
		else
		{
			Misc::jvAlert("Fail!","history.go(-1)");
			exit;
		}

	}

	$orderNum = $_GET['orderNum'];

	$qry1 = "select * from $tableName where orderNum='$orderNum'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

	$tracking_info = explode("@",$row1[tracking]);


	$site_base_info = getinfo_site_admin($row1['domain']);



	// 과거 이메일 기록가져오기
	$old_qry1 = "select * from chan_shop_orderemail where orderNum = '$orderNum' order by seq_no desc limit 1";
	$old_rst1 = mysql_query($old_qry1);
	$old_row1 = mysql_fetch_assoc($old_rst1);
	$old_num1 = mysql_num_rows($old_rst1);

	
	if($old_num1>0)
	{
		$email_msg = $old_row1[content];
	}
	else
	{
		$today = date("F d, Y");

	$email_msg = "Dear ".$row1[bill_first_name]." ".$row1[bill_last_name]."\r\nThank you for your order for one bottle of 10gram organic germanium powder and your order has shipped on , $today via USPS Express Mail Service.\r\nShipping Address:\r\n$row1[ship_address1] $row1[ship_address2] $row1[ship_city], $row1[ship_state] $row1[ship_zipcode]\r\n\r\nYour tracking number is  $row1[tracking]\r\n\r\nPlease click the link below and check your shipping status from there.\r\nhttp://www.usps.com/shipping/trackandconfirm.htm?from=global&page=0035trackandconfirm\r\n\r\nAlso, you can check your order status on our website as well, $site_base_info[site_homepage]\r\r\nWe hope you would be happy with our germanium and look forward to serving you again.\r\r\nGermanium Inc Staff.";

	}


	// 이 사람의 오더 갯수 세기
	$s_qry1 = "select count(*) from chan_shop_orderinfo where user_id = '$row1[user_id]' && order_status = '3'";
	$s_rst1 = mysql_query($s_qry1,$dbConn);
	$s_num1 = @mysql_result($s_rst1,0,0);
	
	if($s_num1 == 0)
		{
		$s_count = "[첫번째 주문]";
		}
	else
		{
		$s_count = "[총 $s_num1 번째 주문]";
		}
				


	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>

	function print_invoice(orderNum){
		
		window.open("print_order.php?orderNum=" + orderNum,"invoice","width=700,height=500,scrollbars=1");

	}
</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=20>&nbsp;&nbsp;>> Order View Manager <a href=tmp_email.php?oN=<?= $orderNum ?>>.</a></td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<tr bgcolor='#eee8aa'>
	<td height=35>&nbsp;<b>Order infomation</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td>
	<table width=100% align=center border=0 cellspacing=1 bgcolor='#CCCCCC'>
	<form action=<?= $_SERVER['PHP_SELF'] ?> method=post name=order>
	<input type=hidden name=mode value="save">
	<input type=hidden name=orderNum value="<?= $orderNum ?>">
	<input type=hidden name=area value="<?= $area ?>">
	<input type=hidden name=user_id value="<?= $row1[user_id] ?>">
	<input type=hidden name=invoice value="<?= $row1[invoice] ?>">
	<input type=hidden name=domain value="<?= $row1[domain] ?>">
	<input type=hidden name=seqNo value="<?= $_GET['seqNo'] ?>">
		<tr bgcolor='#FFFFFF'>
			<td  height=35 bgcolor='#F9F9F9'>&nbsp;Domain</td>
			<td colspan=3>&nbsp;<b><font color=red><?= $row1[domain] ?></font></b></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td height=35 bgcolor='#F9F9F9'>&nbsp;Order Count</td>
			<td colspan=3>&nbsp;<?= $s_count ?></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=20 bgcolor='#F9F9F9'>&nbsp;Order date</td>
			<td width=30% >&nbsp;<b><?= $row1[order_date] ?></b></td>
			<td bgcolor='#F9F9F9'>&nbsp;<b>User ID</b></td>
			<td >&nbsp;<b><?= $row1[user_id] ?></b></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=30 bgcolor='#F9F9F9'>&nbsp;Order number</td>
			<td width=30%>&nbsp;<b><?= $row1[orderNum] ?></b></td>
			<td width=20% bgcolor='#F9F9F9'>&nbsp;Invoice</td>
			<td width=30%>&nbsp;<b><?= $row1[invoice] ?></b>&nbsp;&nbsp;<a href="javascript:print_invoice('<?= $row1[orderNum] ?>')"><u>Print Invoice</u></a></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=30 bgcolor='#F9F9F9'>&nbsp;Amount</td>
			<td width=80% colspan=3>&nbsp;<b>$<?= number_format($row1[last_price],2); ?></b>&nbsp;&nbsp;&nbsp;(Order Price : $<?= number_format($row1[order_price],2); ?>&nbsp;Ship : $<?= number_format($row1[shipping],2); ?>)</td>
		</tr>

		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Pay method</td>
			<td colspan=3>&nbsp;<b><?= $row1[pay_method] ?></b></td>
		</tr>
		<!-- <tr bgcolor='#FFFFFF'>
			<td width=20% height=28 bgcolor='#F9F9F9'>&nbsp;Discount</td>
			<td width=80% colspan=3>&nbsp;<font color=red><b>-$<?= number_format($discount_amt,2); ?></b></font> ( <?= $row1[discount_rate] ?> )</td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=28 bgcolor='#F9F9F9'>&nbsp;Promotion</td>
			<td width=80% colspan=3>&nbsp;<font color=red><b>-$<?= number_format($pin_price,2); ?></b></font> ( <?= $row1[pin_number] ?> )</td>
		</tr> -->
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Pay Status</td>
			<td colspan=3>&nbsp;<select name=pay_status>
			<option value="1" <? if($row1[pay_status] == "1") echo "selected"; ?>>Pending
			<option value="2" <? if($row1[pay_status] == "2") echo "selected"; ?>>Completed
			</select></td>
		</tr>
		<!-- <tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Shipping</td>
			<td colspan=3>&nbsp;<?= $row1[shipping_title] ?> | $<?= number_format($row1[shipping],2); ?></td>
		</tr> -->
		<!-- <tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Credit Save</td>
			<td colspan=3>&nbsp;$<input type=text name=credit_save_price value="<?= $credit_save_price ?>" size=3 class="input"> <input type=checkbox name=credit_save value="YES" checked> Credit Save</td>
		</tr> -->
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor='#F9F9F9'>&nbsp;Shipping Memo<br>(for admin)</td>
			<td colspan=3><textarea name=feedback cols=100 rows=5 class="input"><?= stripslashes($row1[feedback]); ?></textarea></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor='#F9F9F9'>&nbsp;Customer Comments</td>
			<td colspan=3>&nbsp;<font color=red><?= stripslashes($row1[comment]); ?></font></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor='#F9F9F9'>&nbsp;E-mail Msg</td>
			<td colspan=3><textarea name=email_msg cols=90 rows=10 class="input"><?= $email_msg ?></textarea></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Tracking</td>
			<td colspan=3>&nbsp;<input type=text name=tracking size=30 value="<?= $row1[tracking] ?>" class="input">&nbsp;&nbsp;&nbsp;<select name=order_status style="background-color:#ffcc00;color:red;font-weight:bold">
			<option value="1" <? if($row1[order_status] == "1") echo "selected"; ?>>Pending
			<option value="2" <? if($row1[order_status] == "2") echo "selected"; ?>>Processing
			<option value="3" <? if($row1[order_status] == "3") echo "selected"; ?>>Shipped
			<option value="4" <? if($row1[order_status] == "4") echo "selected"; ?>>Canceled
			<!-- <option value="5" <? if($row1[order_status] == "5") echo "selected"; ?>>STEP-5 : BackOrder
			<option value="6" <? if($row1[order_status] == "6") echo "selected"; ?>>STEP-6 : Problem processing -->
			</select>&nbsp;&nbsp;&nbsp;<!-- <input type=checkbox name=send_tracking value="YES" > Send update email  --></td>
		</tr>
		<tr bgcolor='#cccccc'>
			<td width=20% height=20>&nbsp;</td>
			<td width=30% >&nbsp;Billing info</td>
			<td width=50% colspan=2>&nbsp;Shipping info</td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Name(en)</td>
			<td >&nbsp;<input name="bill_first_name" type="text" class="input" size="20" value="<?= $row1[bill_first_name] ?>">&nbsp;<input name="bill_last_name" type="text" class="input" size="20" value="<?= $row1[bill_last_name] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_first_name" type="text" class="input" size="20" value="<?= $row1[ship_first_name] ?>">&nbsp;<input name="ship_last_name" type="text" class="input" size="20" value="<?= $row1[ship_last_name] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Country</td>
			<td >&nbsp;<select name="bill_country" class="input"><?= printCountryList($row1[bill_country]); ?></select></td>
			<td colspan=2>&nbsp;<select name="ship_country" class="input"><?= printCountryList($row1[ship_country]); ?></select></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Address 1</td>
			<td >&nbsp;<input name="bill_address1" type="text" size=40 class="input" value="<?= $row1[bill_address1] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_address1" type="text" size=40 class="input" value="<?= $row1[ship_address1] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20>&nbsp;Address 2</td>
			<td >&nbsp;<input name="bill_address2" type="text" size=40 class="input" value="<?= $row1[bill_address2] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_address2" type="text" size=40 class="input" value="<?= $row1[ship_address2] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;City</td>
			<td >&nbsp;<input name="bill_city" type="text" class="input" value="<?= $row1[bill_city] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_city" type="text" class="input" value="<?= $row1[ship_city] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;State</td>
			<td >&nbsp;<input name="bill_state" type="text" class="input" value="<?= $row1[bill_state] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_state" type="text" class="input" value="<?= $row1[ship_state] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Zipcode</td>
			<td >&nbsp;<input name="bill_zipcode" type="text" class="input" value="<?= $row1[bill_zipcode] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_zipcode" type="text" class="input" value="<?= $row1[ship_zipcode] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Cell Phone</td>
			<td >&nbsp;<input name="bill_cellphone" type="text" class="input" value="<?= $row1[bill_cellphone] ?>"></td>
			<td colspan=2><input name="ship_cellphone" type="text" class="input" value="<?= $row1[ship_cellphone] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;E-mail</td>
			<td >&nbsp;<input name="bill_email" type="text" size=40 class="input" value="<?= $row1[bill_email] ?>"></td>
			<td colspan=2></td>
		</tr>
	</table>
	</td>
</tr>

<tr bgcolor='#FFFFFF'>
	<td align=center height=50><input type=checkbox name=send_email value="YES"> If you want to send email, then check it.<br>
	<input type=submit value="   Order Submit   " class="input"></td>
</tr></form>
<tr bgcolor='#eee8aa'>
	<td height=35>&nbsp;<b>Order item list</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td>
	<script>
		function adjust_form(){
		
			adjust_calc();

			last_amt = document.order_adjust.last_price.value;

			if(confirm("Total amount is : $" + last_amt + " ? \r\nQuantity will be change.") == true)
			{
				return true;
			}
			else return false;
		}

	</script>
	<form name=order_adjust action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return adjust_form()">
	<input type=hidden name=mode value="order_adjust">
	<input type=hidden name=orderNum value="<?= $orderNum ?>">
	<input type=hidden name=seqNo value="<?= $_GET['seqNo'] ?>">
	<input type=hidden name=area value="<?= $_GET['area'] ?>">
	<table width=100% align=center border=0 cellspacing=1 >
		<tr bgcolor='#cccccc'>
			<td width=10% align=center>Image</td>
			<td width=60% align=center>Name</td>
			<td width=10% align=center>Unit Price</td>
			<td width=10% align=center>Qty</td>
			<td width=10% align=center>Amount</td>
			
		</tr>
		<?
		$qry2 = "select * from chan_shop_orderproduct where orderNum='$orderNum' order by seq_no asc";
		$rst2 = mysql_query($qry2,$dbConn);

		$sub_amt = 0;
		$sub_qty = 0;

		while($row2 = mysql_fetch_array($rst2)){
				
			//$us_price = number_format($row2[p_price],2);
			$img_url = _WEB_BASE_DIR;
			$item_info = get_iteminfo($row2[item_code]);


					// thum 이미지
				$thum_img = explode("NaN",$item_info[userfile1]);
				$file_image = "<img src=\"../../img/".$thum_img[0]."\" border=0 style='border-color=#CCCCCC' width=40>";


			$real_total_price = number_format($row2[item_sale]*$row2[item_qty],2);


			echo "
			<tr >
				<td align=center >$file_image</td>
				<td align=left>&nbsp;(<b>$item_info[model_no]</b>) $row2[item_title]&nbsp;&nbsp;<font color=blue>$row2[item_option] $opt_msg</font></td>
				<td align=center>$<input type=text name=item_sale[] size=6 value=\"$row2[item_sale]\"></td>
				<td align=center><input type=text name=item_qty[] size=4 value=\"$row2[item_qty]\"></td>
				<td align=center>$<input type=text name=sub_total[] size=6 value=\"$real_total_price\">&nbsp;</td>
			</tr>";

			unset($valueCnt);
			unset($valueInventory);
			unset($adjust_num);
			unset($inventory);
			unset($color_result);
			unset($size_result);
			unset($inventory_result);

			$sub_amt = $sub_amt + $real_price;
			$sub_qty = $sub_qty + $row2[item_qty];

			unset($select1);
			unset($select2);
			unset($select3);
			unset($select4);
		}
		?>

	</table>
	</form>
	</td>
</tr>
<!-- <tr bgcolor='#eee8aa'>
	<td height=35>&nbsp;<b>Send E-mail</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td>
		<table width=100% align=center cellpadding=0 cellspacing=1 bgcolor=#dcdcdc>
	<form action=<?= $_SERVER['PHP_SELF'] ?> method=post name=email>
	<input type=hidden name=mode value="sendmail">
	<input type=hidden name=orderNum value="<?= $orderNum ?>">
	<input type=hidden name=area value="<?= $area ?>">
			<tr>
				<td width=15% height=25 bgcolor=#FFFFFF>&nbsp;From Name</td>
				<td width=35% bgcolor=#FFFFFF>&nbsp;<input type=text name=smail_name value="<?= $base_info[site_name] ?>" size=30></td>
				<td width=15% bgcolor=#FFFFFF>&nbsp;From Email</td>
				<td width=35% bgcolor=#FFFFFF>&nbsp;<input type=text name=smail_email value="<?= $base_info[site_email] ?>" size=30></td>
			</tr>
			<tr>
				<td width=15% height=25 bgcolor=#FFFFFF>&nbsp;To Name</td>
				<td width=35% bgcolor=#FFFFFF>&nbsp;<input type=text name=mail_name value="<?= $order_info[bill_first_name] ?>&nbsp;<?= $order_info[bill_last_name] ?>" size=30></td>
				<td width=15% bgcolor=#FFFFFF>&nbsp;To Email</td>
				<td width=35% bgcolor=#FFFFFF>&nbsp;<input type=text name=mail_email value="<?= $order_info[bill_email] ?>" size=30></td>
			</tr>
			<tr>
				<td width=15% height=25 bgcolor=#FFFFFF>&nbsp;Title</td>
				<td width=85% bgcolor=#FFFFFF colspan=3>&nbsp;<input type=text name=mail_title size=70 value="<?= $base_info[site_name] ?> Email Notification"></td>
			</tr>
			<tr>
				<td bgcolor=#FFFFFF>&nbsp;Content</td>
				<td colspan=3 valign=top bgcolor=#FFFFFF><textarea name=mail_content cols=80 rows=10 wrap></textarea></td>
			</tr>
			<tr bgcolor=#FFFFFF>
				<td colspan=4 align=center height=80><input type=submit value=" Send E-mail " class="input"></td>
			</tr></form>
		</table>
	</td>
</tr> -->
</table>
<br>
<br>
<br>
<br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>