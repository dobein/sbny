<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	$accessCode = "3";
	$accessCode_sub = "3-1";

	if(!eregi("$accessCode", $admin_access_level[0]))
	{
		Misc::jvAlert("Deny access! code1","history.go(-1)");
		exit;
	}

	if(eregi("$accessCode_sub", $admin_access_level[1]))
	{
		Misc::jvAlert("Deny access! code2","history.go(-1)");
		exit;
	}

	$tableName = "chan_shop_orderinfo";

	if($mode == "save")
	{
		
		// 적립금 마이너스 시키기
		if($save_use == "YES")
		{
			$p_qry1 = "update chan_shop_member set save_money = save_money - $save_price where member_id = '$user_id'";
			//$p_rst1 = mysql_query($p_qry1,$dbConn);
		}

		// 적립금 적립시키기
		if($credit_save == "YES")
		{
			$p_qry2 = "update chan_shop_member set save_money = save_money + $credit_save_price where member_id = '$user_id'";
			$p_rst2 = mysql_query($p_qry2,$dbConn);
		}

		if($credit_delete == "YES")
		{
			$p_qry3 ="update $tableName set credit_info = '' where orderNum = '$orderNum'";
			$p_rst3 = mysql_query($p_qry3);
		}

		$order_info = serialize(array(
									bill_first_name => "$bill_first_name", 
									bill_last_name => "$bill_last_name", 
									bill_email => "$bill_email", 
									bill_address1 => "$bill_address1", 
									bill_address2 => "$bill_address2", 
									bill_city => "$bill_city", 
									bill_state => "$bill_state",
									bill_zipcode => "$bill_zipcode",
									bill_phone => "$bill_phone",
									bill_cellphone => "$bill_cellphone",
									ship_first_name => "$ship_first_name", 
									ship_last_name => "$ship_last_name", 
									ship_email => "$ship_email", 
									ship_address1 => "$ship_address1", 
									ship_address2 => "$ship_address2", 
									ship_city => "$ship_city", 
									ship_state => "$ship_state",
									ship_zipcode => "$ship_zipcode",
									ship_phone => "$ship_phone",
									ship_cellphone => "$ship_cellphone"));

		/**
		* tracking company
		*/
		$tracking = $tracking_company."@".$tracking;

		$qry4 = "update $tableName set order_info = '$order_info', order_status='$order_status', feedback = '$feedback', tracking = '$tracking' where orderNum = '$orderNum'";
		$rst4 = mysql_query($qry4,$dbConn);

		
		if($send_tracking == "YES")
		{
			//$mail_flag = "2";

			//$mail_result = sendEmail($mail_flag,$orderNum);
		}

		if($order_status == "3")
		{
			$mail_flag = "2";
			$mail_result = sendEmail($mail_flag,$orderNum);
		}
		else if($order_status == "4")
		{
			$mail_flag = "4";
			$mail_result = sendEmail($mail_flag,$orderNum);
		}

		if($invoice_print == "YES")
		{
			echo "<script> window.open(\"print_order.php?orderNum=$orderNum\",\"order\",\"width=700,height=500,scrollbars=1\"); </script>";
		}

		if($rst4)
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
	else if($mode == "inventory_save")
	{
		$opt1_inventory_arr = "";
		$opt1_content_arr = "";

		for($i=0; $i<count($size); $i++)
		{
			$opt1_content_arr .= $color[$i]."NaN".$size[$i]."SnS";
			$opt1_inventory_arr .= $size_inventory[$i]."NaN";


			//echo $item_code[$i]."-";
			//echo $size[$i]."-";
			//echo $size_inventory[$i]."-";
			//echo "<br>";
		}

		$u_qry1 = "update chan_shop_product set 	opt1_content_arr = '$opt1_content_arr', opt1_inventory_arr = '$opt1_inventory_arr' where item_code = '$item_code'";
		$u_rst1 = mysql_query($u_qry1);

		//Misc::jvAlert("Completed!.","location.replace('order_list.php?area=$area')");
		echo "<meta http-equiv='refresh' content='0; url=./order_list.php?area=$area'>";
		exit;

	}
	else if($mode == "order_adjust")
	{

		// 재고빼기
		for($i=0; $i<count($seqNo); $i++)
		{
			$opt_value = explode(",",$item_option[$i]);

			$color = trim($opt_value[0]);
			$size = trim($opt_value[1]);
		
			$item_info = get_iteminfo($item_code[$i]);

			// 재고상황 보여주기
			$item_size = explode("SnS",$item_info[opt1_content_arr]);

			//echo $item_info[opt1_inventory_arr];
			//echo "<hr>";
			$new_stock = "";

			for($d=0; $d<count($item_size)-1; $d++)
			{
				$item_color = $item_size[$i];
				$item_detailcolor = explode("NaN",$item_size[$d]);

				$opt1_file = explode("NaN",$item_info[opt1_file_name]);

				$opt1_inventory = explode("NaN",$item_info[opt1_inventory_arr]);

				$opt1_extraprice = explode("NaN",$item_info[opt1_extraprice_arr]);


				$stockArray = explode("NaN",$item_info[opt1_inventory_arr]);

				if($item_detailcolor[0] == $color)
				{
					//echo "$d 배열번 - ";

					if(empty($item_detailcolor[1]))
					{
						//echo "사이즈는 배열없음";

						for($s=0; $s<count($stockArray)-1; $s++)
						{
							if($s == $d)
							{
								$stockQty = $stockArray[$s]-$item_qty[$i];

								$new_stock .= $stockQty."NaN";
							}
							else
							{
								$new_stock .= $stockArray[$s]."NaN";
							}

						}

					}
					else
					{

						for($s=0; $s<count($stockArray)-1; $s++)
						{

							$sizeArray = explode(",",$item_detailcolor[1]);
							$sizeStockArray = explode(",",$opt1_inventory[$s]);

							for($k=0; $k<count($sizeArray); $k++)
							{
								if($size == $sizeArray[$k])
								{
									//echo "$k 배열번 사이즈";

									$stockQty = $stockArray[$k]-$item_qty[$i];

									$new_size .= "$stockQty,";

								}
								else
								{
									$new_size .= "$sizeStockArray[$k],";
								}

							}

							$new_size = substr($new_size, 0, -1); 

							if($s == $d)
							{
								$new_stock .= $new_size."NaN";
							}
							else
							{
								$new_stock .= $stockArray[$s]."NaN";
							}

							unset($new_size);

							
						}


					}

					//echo " 결과 : $item_code[$i] - $new_stock<br>";

					$u_qry1 = "update chan_shop_product set opt1_inventory_arr = '$new_stock' where item_code = '$item_code[$i]'";
					$u_rst1 = mysql_query($u_qry1);
				}


			}

		}


		for($i=0; $i<count($seqNo); $i++)
		{
			$qry1 = "update chan_shop_orderproduct set item_sale = '$item_sale[$i]', item_status = '$item_status[$i]', item_qty = '$item_qty[$i]' where seq_no = '$seqNo[$i]'";
			$rst1 = mysql_query($qry1);
		}

		$qry2 = "update chan_shop_orderinfo set shipping = '$shipping', tax = '$tax', pin_price = '$pin_price', discount_amt = '$discount_amt', order_price = '$order_price', last_price = '$last_price' where orderNum = '$orderNum'";
		$rst2 = mysql_query($qry2);


		$mail_flag = "3";

		if($order_adjust_email == "YES")
		{
			$mail_result = sendEmail($mail_flag,$orderNum);
		}

		//Misc::jvAlert("Completed!.","location.replace('order_list.php?area=$area')");
		echo "<meta http-equiv='refresh' content='0; url=./order_view.php?area=3-1&seqNo=$seqNo&orderNum=$orderNum'>";
		exit;

	}
	else if($mode == "order_save")
	{

		// 먼저 현재 오더를 order_his 에 넣고... 

		$qry4 = "select * from chan_shop_orderproduct where orderNum = '$orderNum'";
		$rst4 = mysql_query($qry4,$dbConn);

		while($row4 = mysql_fetch_assoc($rst4)){
			
			// 상품 정보 넣기
			$qry5 = "insert into chan_shop_orderproduct_his (orderNum,
																			item_code,
																			item_title,
																			item_option,
																			item_qty,
																			item_regular,
																			item_sale,
																			item_credit,
																			item_last,
																			item_status) values ('$row4[orderNum]',
																										'$row4[item_code]',
																										'$row4[item_title]',
																										'$row4[item_option]',
																										'$row4[item_qty]',
																										'$row4[item_regular]',
																										'$row4[item_sale]',
																										'$row4[item_credit]',
																										'$row4[item_last]',
																										'$row4[item_status]')";

			$rst5 = mysql_query($qry5,$dbConn);

		}

		// 체크된 오더 Status 바꾸기
		for($i=0; $i<count($seqNo); $i++)
		{
			//echo $seqNo[$i]."<br>";
			//$qry6 = "update chan_shop_orderproduct set where seq_no = '$seqNo[$i]'";
			$qry6 = "update chan_shop_orderproduct  set item_status = '$item_status[$i]' where seq_no = '$seqNo[$i]'";
			$rst6 = mysql_query($qry6,$dbConn);
		}


		// 제품 체크해서 status가 변경되면, balance 구하기
		$c_qry8 = "select item_last,item_qty from chan_shop_orderproduct where orderNum = '$orderNum' && item_status = '2'";
		$c_rst8 = mysql_query($c_qry8,$dbConn);

		$sub_order_price8 = 0;

		while($c_row8 = mysql_fetch_assoc($c_rst8)){

			$middle_sum8 = round_to_penny($c_row8[item_last]*$c_row8[item_qty]);

			$sub_order_price8 = $sub_order_price8 + $middle_sum8;
		}
	
		$balance_amount = $sub_order_price8;


		// 제품 체크해서 status가 변경되면, cancel된 금액 구하기
		$c_qry9 = "select item_last,item_qty from chan_shop_orderproduct where orderNum = '$orderNum' && item_status = '3'";
		$c_rst9 = mysql_query($c_qry9,$dbConn);

		$sub_order_price9 = 0;

		while($c_row9 = mysql_fetch_assoc($c_rst9)){

			$middle_sum9 = round_to_penny($c_row9[item_last]*$c_row9[item_qty]);

			$sub_order_price9 = $sub_order_price9 + $middle_sum9;
		}
	
		$cancel_amount = $sub_order_price9;


		// 다시 제품 체크해서 최종 order 가격 테이블 업데이트 하기

		$c_qry7 = "select item_last,item_qty from chan_shop_orderproduct where orderNum = '$orderNum'";
		$c_rst7 = mysql_query($c_qry7,$dbConn);

		$sub_order_price = 0;

		while($c_row7 = mysql_fetch_assoc($c_rst7)){

			$middle_sum = round_to_penny($c_row7[item_last]*$c_row7[item_qty]);

			$sub_order_price = $sub_order_price + $middle_sum;
		}
	
		$order_price = $sub_order_price;


		$new_order_price = $order_price - $cancel_amount;

		// 최종 오더값 다시 메기기
		$last_total_price = round_to_penny($shipping + $tax + $order_price - $save_price - $pin_price - $cancel_amount);


		$qry8 = "update chan_shop_orderinfo set order_price = '$new_order_price', last_price = '$last_total_price', balance = '$balance_amount' where orderNum = '$orderNum'";
		$rst8 = mysql_query($qry8,$dbConn);

		if($rst5 && $rst6 && $rst8)
		{
			Misc::jvAlert("Completed!.","location.replace('order_view.php?area=$area&orderNum=$orderNum')");
			exit;
		}
		else
		{
			Misc::jvAlert("Error! code 302","history.go(-1)");
			exit;
		}
	}
	else if($mode == "sendmail")
	{
			$eol="\r\n";

			$headers .= 'From: '.$base_info[site_name].' <'.$smail_email.'>'.$eol; 
			$headers .= 'Reply-To: '.$base_info[site_name].' <'.$smail_email.'>'.$eol; 
			$headers .= 'Return-Path: '.$base_info[site_name].' <'.$smail_email.'>'.$eol;    // these two to set reply address 
			$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
			$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 

			$mail_result = mail($mail_email, $mail_title, $mail_content, $headers);

			if($mail_result)
			{
				Misc::jvAlert("Completed!.","location.replace('order_list.php?area=$area')");
				//echo "<meta http-equiv='refresh' content='0; url=./order_list.php?area=$area'>";
				exit;
			}
			else
			{
				Misc::jvAlert("Fail!","history.go(-1)");
				exit;
			}
	}


	$qry1 = "select * from $tableName where orderNum='$orderNum'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

	$tracking_info = explode("@",$row1[tracking]);


	// 주문자 정보
	$order_info = unserialize($row1[order_info]);

	/**
	* @ 주문 상태 1:주문중 2: 주문완료 3:배송준비중 4:배송완료 5:오더완료 6:오더취소 7:환불/반품 
	* @ Step0 : Your order ing...
	* @ Step1 : Your order has been successfully submitted. Your credit/debit card has not yet been charged.
	* @ Step2 : Your credit/debit card has been successfully charged. Your order contents will soon be packaged and sealed.
	* @ Step3 : Your order has shipped.
	* @ Step4 : Your order is cancelled. Void orders are null and cannot be re-processed. If you need to re-order as a result, please do so on our website. If you have any questions or concerns, please contact us for help.
	*/

	// 신용카드 정보
	$credit_info = unserialize($row1[credit_info]);


	// 적립해줄 총 Credit 구하기
	$credit_save_price = getcreditsave($orderNum);


	if($row1[pin_price]>0)
	{
		$pin_price = $row1[pin_price];
	}
	else
	{
		$pin_price = $row1[last_price]-($row1[order_price]+$row1[shipping]+$row1[tax]);
	}

	include _BASE_DIR . "/admin/inc_top.php";
?>
<script>
	function adjust_calc(){
		tf = document.order_adjust;
		

		sub_amt = 0;

			if(document.forms["order_adjust"]["item_qty[]"].length)
			{
				
				num = document.order_adjust.elements['item_qty[]'].length;

				item_amt = 0;
				

				for(i=0; i< num; i++)
				{
					if(document.forms["order_adjust"]["item_qty[]"][""+i+""].value == '')
					{
						alert('주문 수량을 입력하세요!');
						document.forms["order_adjust"]["item_qty[]"][""+i+""].focus();
						return false;
					}

					
					if(document.forms["order_adjust"]["item_status[]"][""+i+""].value == '4')
					{
						item_amt = parseFloat(document.forms["order_adjust"]["item_qty[]"][""+i+""].value) * parseFloat(document.forms["order_adjust"]["item_sale[]"][""+i+""].value);
					}
					else
					{
						item_amt = '0';
					}
					

					document.forms["order_adjust"]["sub_total[]"][""+i+""].value = item_amt;

					sub_amt =  parseFloat(sub_amt) + parseFloat(item_amt);

				}
				
				document.forms["order_adjust"]["order_price"].value = sub_amt;

			}
			else
			{
					if(document.forms["order_adjust"]["item_qty[]"].value == '')
					{
						alert('주문 수량을 입력하세요!');
						document.forms["order_adjust"]["item_qty[]"].focus();
						return false;
					}
		
					if(document.forms["order_adjust"]["item_status[]"].value == '4')
					{
						item_amt = parseFloat(document.forms["order_adjust"]["item_qty[]"].value) * parseFloat(document.forms["order_adjust"]["item_sale[]"].value);
					}
					else
					{
						item_amt = '0';
					}

					document.forms["order_adjust"]["sub_total[]"].value = item_amt;

					sub_amt =  parseFloat(sub_amt) + parseFloat(item_amt);

					document.forms["order_adjust"]["order_price"].value = sub_amt;
			}


		if(tf.shipping.value == '')
		{
			tf.shipping.value = '0';
		}
		
		/*
		if(tf.tax.value == '')
		{
			tf.tax.value = '0';
		}
		*/

		if(tf.discount_amt.value == '')
		{
			tf.discount_amt.value = '0';
		}
		if(tf.save_price.value == '')
		{
			tf.save_price.value = '0';
		}

		tf.last_price.value = parseFloat(sub_amt) + parseFloat(tf.shipping.value) - parseFloat(tf.discount_amt.value) - parseFloat(tf.save_price.value);
	}
	function print_invoice(orderNum){
		
		window.open("print_order.php?orderNum=" + orderNum,"invoice","width=700,height=500,scrollbars=1");

	}
</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=20>&nbsp;&nbsp;>> Order View Manager</td>
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
	<script>
		function go_cim(){
			
			document.order.action = 'cim_process.php';
			document.order.submit();
		}

	</script>
	<form action=<?= $PHP_SELF ?> method=post name=order>
	<input type=hidden name=mode value="save">
	<input type=hidden name=orderNum value="<?= $orderNum ?>">
	<input type=hidden name=area value="<?= $area ?>">
	<input type=hidden name=user_id value="<?= $row1[user_id] ?>">
	<input type=hidden name=invoice value="<?= $row1[invoice] ?>">
	<input type=hidden name=seqNo value="<?= $seqNo ?>">
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
			<td width=30% >&nbsp;<b>$<?= number_format($row1[last_price],2); ?></b>&nbsp;&nbsp;&nbsp;(Order Price : $<?= number_format($row1[order_price],2); ?>&nbsp;Ship : $<?= number_format($row1[shipping],2); ?>)</td>
			<td  bgcolor='#F9F9F9'>&nbsp;Pay method</td>
			<td >&nbsp;<b><?= $row1[pay_method] ?></b></td>
		</tr>
		<? if($row1[pay_method] == "CREDIT"): ?>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Cim Pay</td>
			<td colspan=3>&nbsp;<select name=c_id>
			<?= printCimInfo($row1[user_id]); ?>
			</select>&nbsp;&nbsp;Pay Amount : <input type=text name=pay_cim_amt size=6 value="<?= $row1[last_price] ?>"> <input type=button value="Pay by CIM" onClick="go_cim()"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Cim Result</td>
			<td colspan=3>&nbsp;<?= $row1[cim_info] ?></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Authorize Result</td>
			<td colspan=3>&nbsp;transId : <?= $credit_info[transId] ?></td>
		</tr>
		<? else: ?>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Pay method</td>
			<td colspan=3>&nbsp;<b><?= $row1[pay_method] ?></b></td>
		</tr>
		<? endif; ?>
		<!-- <tr bgcolor='#FFFFFF'>
			<td width=20% height=28 bgcolor='#F9F9F9'>&nbsp;Discount</td>
			<td width=80% colspan=3>&nbsp;<font color=red><b>-$<?= number_format($discount_amt,2); ?></b></font> ( <?= $row1[discount_rate] ?> )</td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=28 bgcolor='#F9F9F9'>&nbsp;Promotion</td>
			<td width=80% colspan=3>&nbsp;<font color=red><b>-$<?= number_format($pin_price,2); ?></b></font> ( <?= $row1[pin_number] ?> )</td>
		</tr> -->
		<!-- <tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Pay Status</td>
			<td colspan=3>&nbsp;<select name=pay_status>
			<option value="1" <? if($row1[pay_status] == "1") echo "selected"; ?>>Pending
			<option value="2" <? if($row1[pay_status] == "2") echo "selected"; ?>>Completed
			</select></td>
		</tr> -->
		<!-- <tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Shipping</td>
			<td colspan=3>&nbsp;<?= $row1[shipping_title] ?> | $<?= number_format($row1[shipping],2); ?></td>
		</tr> -->
		<!-- <tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Credit Save</td>
			<td colspan=3>&nbsp;$<input type=text name=credit_save_price value="<?= $credit_save_price ?>" size=3 class="input"> <input type=checkbox name=credit_save value="YES" checked> Credit Save</td>
		</tr> -->
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor='#F9F9F9'>&nbsp;E-mail (고객에게 첨부할 메세지)</td>
			<td colspan=3><textarea name=feedback cols=100 rows=5 class="input"><?= $row1[feedback] ?></textarea></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td height=28 bgcolor='#F9F9F9'>&nbsp;Customer Comments</td>
			<td colspan=3>&nbsp;<?= $row1[comment] ?></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=28 bgcolor='#F9F9F9'>&nbsp;Tracking</td>
			<td colspan=3>&nbsp;<select name=tracking_company>
			<?= get_shipping_select($tracking_info[0]); ?>
			</select>&nbsp;<input type=text name=tracking size=30 value="<?= $tracking_info[1] ?>" class="input">&nbsp;&nbsp;&nbsp;<select name=order_status style="background-color:#ffcc00;color:red;font-weight:bold">
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
			<td >&nbsp;<input name="bill_first_name" type="text" class="input" size="20" value="<?= $order_info[bill_first_name] ?>">&nbsp;<input name="bill_last_name" type="text" class="input" size="20" value="<?= $order_info[bill_last_name] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_first_name" type="text" class="input" size="20" value="<?= $order_info[ship_first_name] ?>">&nbsp;<input name="ship_last_name" type="text" class="input" size="20" value="<?= $order_info[ship_last_name] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Address 1</td>
			<td >&nbsp;<input name="bill_address1" type="text" size=40 class="input" value="<?= $order_info[bill_address1] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_address1" type="text" size=40 class="input" value="<?= $order_info[ship_address1] ?>"></td>
		</tr>
		<!-- <tr bgcolor='#FFFFFF'>
			<td  height=20>&nbsp;Address 2</td>
			<td >&nbsp;<input name="bill_address2" type="text" size=40 class="input" value="<?= $order_info[bill_address2] ?>"></td>
			<td >&nbsp;<input name="ship_address2" type="text" size=40 class="input" value="<?= $order_info[ship_address2] ?>"></td>
		</tr> -->
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;City</td>
			<td >&nbsp;<input name="bill_city" type="text" class="input" value="<?= $order_info[bill_city] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_city" type="text" class="input" value="<?= $order_info[ship_city] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;State</td>
			<td >&nbsp;<input name="bill_state" type="text" class="input" value="<?= $order_info[bill_state] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_state" type="text" class="input" value="<?= $order_info[ship_state] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Zipcode</td>
			<td >&nbsp;<input name="bill_zipcode" type="text" class="input" value="<?= $order_info[bill_zipcode] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_zipcode" type="text" class="input" value="<?= $order_info[ship_zipcode] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Phone</td>
			<td >&nbsp;<input name="bill_phone" type="text" class="input" value="<?= $order_info[bill_phone] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_phone" type="text" class="input" value="<?= $order_info[ship_phone] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;Cell Phone</td>
			<td >&nbsp;<input name="bill_cellphone" type="text" class="input" value="<?= $order_info[bill_cellphone] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_cellphone" type="text" class="input" value="<?= $order_info[ship_cellphone] ?>"></td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td  height=20 bgcolor='#F9F9F9'>&nbsp;E-mail</td>
			<td >&nbsp;<input name="bill_email" type="text" size=40 class="input" value="<?= $order_info[bill_email] ?>"></td>
			<td colspan=2>&nbsp;<input name="ship_email" type="text" size=40 class="input" value="<?= $order_info[ship_email] ?>"></td>
		</tr>
	</table>
	</td>
</tr>

<tr bgcolor='#FFFFFF'>
	<td align=center height=50><input type=submit value="   Order Submit   " class="input"></td>
</tr></form>
<tr bgcolor='#eee8aa'>
	<td height=35>&nbsp;<b>Order item list</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td>
	<form name=order_adjust action=<?= $PHP_SELF ?> method=post >
	<input type=hidden name=mode value="order_adjust">
	<input type=hidden name=orderNum value="<?= $orderNum ?>">
	<input type=hidden name=seqNo value="<?= $seqNo ?>">
	<input type=hidden name=area value="<?= $area ?>">
	<table width=100% align=center border=0 cellspacing=1 bgcolor='#CCCCCC'>
		<tr bgcolor='#FFFFFF'>
			<td width=10% align=center>Image</td>
			<td width=35% align=center>Name</td>
			<td width=10% align=center>Unit Price</td>
			<td width=10% align=center>Qty</td>
			<td width=10% align=center>My Stock</td>
			<td width=15% align=center>Status.</td>
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


			if($row2[item_last] == $item_info[item_price1])
			{
				$sale_division = "";
				$notSale_amt = $notSale_amt + $row2[item_last];
			}
			else
			{
				$sale_division = "<font color=red>(Sale item)</font>";
			}


			$opt_array = explode(",",$row2[item_option]);
			$opt_array_color = explode(":",$opt_array[1]);

			$size_value = explode("/",$item_info[color]);		


			//echo $select_value;
			$file_value = explode("/",$item_info[file_name]);
			$now_file_value = $file_value[$select_value];

			if($now_file_value)
			{
				// thum 이미지
				//$thum_img = explode("NaN",$item_info[userfile1]);
				$file_image = "<img src=\"../../thum_upload/thum_".$now_file_value."\" border=0 style='border-color=#CCCCCC' width=40>";
			}
			else
			{
				// thum 이미지
				$thum_img = explode("NaN",$item_info[userfile1]);
				$file_image = "<img src=\"../../thum_upload/thum_".$thum_img[0]."\" border=0 style='border-color=#CCCCCC' width=40>";
			}


			

			//<td align=center height=50><input type=checkbox name=seqNo[] value=$row2[seq_no]></td>

			if($row2[item_status] == "2")
			{
				$bgColor = "#f0fff0";
			}
			else if($row2[item_status] == "3")
			{
				$bgColor = "#e6e6fa";
			}
			else
			{
				$bgColor = "#FFFFFF";
			}

			if($row2[item_status] == "1")
			{
				$select1 = "selected";
			}
			else if($row2[item_status] == "2")
			{
				$select2 = "selected";
			}
			else if($row2[item_status] == "3")
			{
				$select3 = "selected";
			}

			if($row2[opt1_msg])
			{
				$opt_msg = "&nbsp;<font color=green>$row2[opt1_msg] (+$$row2[item_opt1])</font>";
			}
			else
			{
				$opt_msg = "";
			}

			if($row2[gift_box] == "YES")
			{
				$gift_box = "<b>gift box</b>";

				$gift_box_price = "4.99";
				$real_total_price = number_format(($row2[item_last]+$gift_box_price)*$row2[item_qty],2);

				$real_price = ($row2[item_last]+$gift_box_price)*$row2[item_qty];
			}
			else
			{
				$gift_box = "";

				$real_total_price = number_format($row2[item_last]*$row2[item_qty],2);

				$real_price = $row2[item_last]*$row2[item_qty];
			}


			// 해당옵션가져오기
			$opt_arr = explode("SnS",$item_info[opt1_content_arr]);
			
			for($k=0; $k<count($opt_arr)-1; $k++)
			{
				$opt_value = explode("NaN",$opt_arr[$k]);

				$opt_inventory_value = explode("NaN",$item_info[opt1_inventory_arr]);

				if($opt_value[0] == $opt_array_color[1])
				{
					$color_result .= "<input type=text name=color[] value=\"$opt_value[0]\" size=10>";
					$size_result .= "<input type=text name=size[] value=\"$opt_value[1]\" size=10>";
					$inventory_result .= "<input type=text name=size_inventory[] value=\"$opt_inventory_value[$k]\" size=10>";
				}
				else
				{
					$color_result .= "<input type=text name=color[] value=\"$opt_value[0]\" size=10>";
					$size_result .= "<input type=text name=size[] value=\"$opt_value[1]\" size=10>";
					$inventory_result .= "<input type=text name=size_inventory[] value=\"$opt_inventory_value[$k]\" size=10>";
				}
				
			}

			if($row2[item_status] == "1")
			{
				$select1 = "selected";
				$real_total_price = $row2[item_last]*$row2[item_qty];
			}
			else if($row2[item_status] == "2")
			{
				$select2 = "selected";
				$real_total_price = "0";
			}
			else if($row2[item_status] == "3")
			{
				$select3 = "selected";
				$real_total_price = "0";
			}
			else if($row2[item_status] == "4")
			{
				$select4 = "selected";
				$real_total_price = $row2[item_last]*$row2[item_qty];
			}




			// 재고상황 보여주기
			$item_size = explode("SnS",$item_info[opt1_content_arr]);

			for($d=0; $d<count($item_size)-1; $d++)
			{
				$item_color = $item_size[$i];
				$item_detailcolor = explode("NaN",$item_size[$d]);

				$opt1_file = explode("NaN",$item_info[opt1_file_name]);

				$opt1_inventory = explode("NaN",$item_info[opt1_inventory_arr]);

				$opt1_extraprice = explode("NaN",$item_info[opt1_extraprice_arr]);


				$inventory .= "<tr><td><input type=text name=opt1_content_color[] value=\"$item_detailcolor[0]\" size=6 style=\"border:0px\">&nbsp;<input type=text name=opt1_content_size[] value=\"$item_detailcolor[1]\" size=6 style=\"border:0px\">&nbsp;<input type=hidden name=opt1_file_name[] size=30 value=\"$opt1_file[$d]\">&nbsp;<input type=text name=opt1_inventory_arr[] size=4 value=\"$opt1_inventory[$d]\" style=\"border:0px\"></td></tr>";
			}



			//<select name=item_status[]><option value=1 $select1>Ship<option value=2 $select2>Pendding<option value=3 $select3>Cancel</select>
			// <a href=product_modify.php?itemCode=$row2[item_code]&Category3=$item_info[p_code1]/$item_info[p_code2]/$item_info[p_code3] target=_blank>
			echo "
			<tr bgcolor='$bgColor'><input type=hidden name=seqNo[] value=$row2[seq_no]><input type=hidden name=item_code[] value=$row2[item_code]><input type=hidden name=item_option[] value=\"$row2[item_option]\">
				<td align=center >$file_image</td>
				<td align=left>&nbsp;(<b>$item_info[model_no]</b>) $row2[item_title]&nbsp;&nbsp;<font color=blue>$row2[item_option] $opt_msg</font></td>
				<td align=center>$<input type=text name=item_sale[] size=6 value=\"$row2[item_sale]\"></td>
				<td align=center><input type=text name=item_qty[] size=4 value=\"$row2[item_qty]\"></td>
				<td align=center>
				<table>
				$inventory
				</table>				
				</td>
				<td align=center><select name=item_status[]><option value=1 $select1>Checking
				<option value=2 $select2>BackOrder
				<option value=3 $select3>Out of Stock
				<option value=4 $select4>Ready</select>
				</td>
				<td align=center>$<input type=text name=sub_total[] size=6 value=\"$real_total_price\">&nbsp;</td>
			</tr>";

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
		<tr bgcolor='#FFFFFF'>
			<td height=30 align=left colspan=7>&nbsp;
			Order price : <input type=text name=order_price size=6 class="input" value="<?= round_to_penny($row1[order_price]); ?>">&nbsp;
			Shipping (<?= $row1[shipping_title] ?>) : <input type=text name=shipping size=6 class="input" value="<?= round_to_penny($row1[shipping]); ?>">&nbsp;
			<!-- Tax : <input type=text name=tax size=6 class="input" value="<?= round_to_penny($row1[tax]); ?>">&nbsp; -->
			Promotion : - <input type=text name=pin_price size=6 class="input" value="<?= round_to_penny($row1[pin_price]); ?>">&nbsp;
			Discount : - <input type=text name=discount_amt size=6 class="input" value="<?= round_to_penny($row1[discount_amt]); ?>">&nbsp;
			<b>Total amount</b> : <input type=text name=last_price size=10 class="input" value="<?= round_to_penny($row1[last_price]); ?>">
			&nbsp;&nbsp;<input type=button value="Calc" onClick="adjust_calc()">
			&nbsp;&nbsp;
			</td>
		</tr>
		<tr bgcolor='#FFFFFF'>
			<td height=30 colspan=7 align=right><input type=checkbox name=order_adjust_email value="YES"> E-mail send &nbsp;&nbsp;<input type=submit value="   Order Adjust   " class="input">&nbsp;&nbsp;
			</td>
		</tr>
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
	<form action=<?= $PHP_SELF ?> method=post name=email>
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
	include _BASE_DIR . "/admin/inc_bottom.php";
?>