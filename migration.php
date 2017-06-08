<?
$db_host = "db521582901.db.1and1.com";
$db_user = "dbo521582901";
$db_passwd = "puchonA12!";
$db_name = "db521582901";


$dbConn = mysql_connect($db_host,$db_user,$db_passwd);
mysql_select_db($db_name);

	$pre_qry1 = "select * from chan_shop_orderproduct_old";
	$pre_rst1 = mysql_query($pre_qry1);

	while($pre_row1 = mysql_fetch_assoc($pre_rst1)){
	
		
		$domain = "germanium.net";
		


		$qry1 = "insert into chan_shop_orderproduct (orderNum,
																		item_code,
																		item_title,
																		item_qty,
																		item_regular,
																		item_sale,
																		item_last) values ('$pre_row1[orderNum]',
																										'$pre_row1[item_code]',
																										'$pre_row1[item_title]',
																										'$pre_row1[item_qty]',
																										'$pre_row1[item_regular]',
																										'$pre_row1[item_sale]',
																										'$pre_row1[item_last]')";
			print_r($qry1);
			echo "<br>";
			$rst1 = mysql_query($qry1);

	}

	$pre_qry1 = "select * from chan_shop_orderinfo_old";
	$pre_rst1 = mysql_query($pre_qry1);

	while($pre_row1 = mysql_fetch_assoc($pre_rst1)){
	
		
		$domain = "germanium.net";
		
		// 주문자 정보
		$order_info = unserialize($pre_row1[order_info]);


		$qry1 = "insert into chan_shop_orderinfo (domain,
																	user_id,
																	orderInt,
																	orderNum,
																	invoiceInt,
																	invoice,
																	credit_info,
																	order_price,
																	shipping_title,
																	shipping,
																	tax,
																	last_price,
																	pay_method,
																	pay_status,
																	order_status,
																	order_date,
																	tracking,
																	feedback,
																	payment_id,
																	bill_email,
																	bill_cellphone,
																	bill_first_name,
																	bill_last_name,
																	bill_country,
																	bill_address1,
																	bill_address2,
																	bill_city,
																	bill_state,
																	bill_zipcode,
																	ship_first_name,
																	ship_last_name,
																	ship_country,
																	ship_address1,
																	ship_address2,
																	ship_city,
																	ship_state,
																	ship_zipcode) values ('$domain',
																										'$pre_row1[user_id]',
																										'$pre_row1[orderInt]',
																										'$pre_row1[orderNum]',
																										'$pre_row1[invoiceInt]',
																										'$pre_row1[invoice]',
																										'$pre_row1[credit_info]',
																										'$pre_row1[order_price]',
																										'$pre_row1[shipping_title]',
																										'$pre_row1[shipping]',
																										'$pre_row1[tax]',
																										'$pre_row1[last_price]',
																										'$pre_row1[pay_method]',
																										'$pre_row1[pay_status]',
																										'$pre_row1[order_status]',
																										'$pre_row1[order_date]',
																										'$pre_row1[tracking]',
																										'$pre_row1[feedback]',
																										'$pre_row1[credit_info]',
																										'$order_info[bill_email]',
																										'$order_info[bill_phone]',
																										'$order_info[bill_first_name]',
																										'$order_info[bill_last_name]',
																										'$order_info[bill_country]',
																										'$order_info[bill_address1]',
																										'$order_info[bill_address2]',
																										'$order_info[bill_city]',
																										'$order_info[bill_state]',
																										'$order_info[bill_zipcode]',
																										'$order_info[ship_first_name]',
																										'$order_info[ship_last_name]',
																										'$order_info[ship_country]',
																										'$order_info[ship_address1]',
																										'$order_info[ship_address2]',
																										'$order_info[ship_city]',
																										'$order_info[ship_state]',
																										'$order_info[ship_zipcode]')";
			print_r($qry1);
			echo "<br>";
			$rst1 = mysql_query($qry1);

	}



	$pre_qry1 = "select * from chan_shop_member_old";
	$pre_rst1 = mysql_query($pre_qry1);

	while($pre_row1 = mysql_fetch_assoc($pre_rst1)){

		$domain = "germanium.net";


		$qry1 = "insert into chan_shop_member (domain, 
																	member_id, 
																	member_password,
																	level,
																	first_name,
																	last_name,
																	address1,
																	address2,
																	city,
																	state,
																	zipcode,
																	country,
																	cell_phone,
																	mail_flag,
																	wdate) values ('$domain',
																							'$pre_row1[member_id]',
																							'".md5($pre_row1[member_password])."',
																							'$pre_row1[level]',
																							'$pre_row1[first_name]',
																							'$pre_row1[last_name]',
																							'$pre_row1[address1]',
																							'$pre_row1[address2]',
																							'$pre_row1[city]',
																							'$pre_row1[state]',
																							'$pre_row1[zipcode]',
																							'$pre_row1[country]',
																							'$pre_row1[cell_phone]',
																							'$pre_row1[mail_flag]',
																							'$pre_row1[wdate]')";

		$rst1 = mysql_query($qry1);

	}




?>