<?
	include "./include/inc_base.php";


		if(!isset($_SESSION['member_id']))
		{
			echo "session error!";
			exit;
		}


		// $ip_address
		$ip_address = $_SERVER['REMOTE_ADDR'];


		if(isset($_SESSION['user_id']))
		{
			$cart_qry1 = "user_id = '".$_SESSION['member_id']."'";
			$user_temp_id = $_SESSION['member_id'];


		}

		if($_POST['flag'] == "cart")
		{


							$value = explode("^",$_POST['r_data']);

							$product_id = $value[0];
							$qty = $value[1];

							$item_info = get_iteminfo($product_id);
					
							
							$qry2 = "select sum(item_qty) from chan_shop_cart where user_id = '".$_SESSION['member_id']."' && item_code = '$product_id'";
							$rst2 = mysql_query($qry2);

							// 이 상품 담은 갯수
							$num2 = mysql_result($rst2,0,0);

							if($qty>0)
							{
								$order_qty = $qty;
							}
							else
							{
								$order_qty = "1";
							}

							// 이번까지 담은 총갯수
							$total_cart_sum = $num2+$order_qty;


							if($item_info[item_price2]>0 && ($item_info[item_price2]<$item_info[item_price1]))
							{
								$cart_price = $item_info[item_price2];
							}
							else
							{
								$cart_price = $item_info[item_price1];
							}


							if($num2>0)
							{
									$qry1 = "update chan_shop_cart set item_qty=item_qty+$order_qty, item_sale = '$cart_price' where user_id = '".$_SESSION['member_id']."' && item_code = '$product_id'";
							}
							else
							{
									$qry1 = "insert into chan_shop_cart (item_code,
																				item_name,
																				item_option,
																				item_qty,
																				item_sale,
																				user_id,
																				wdate,
																				ip) values ('$product_id',
																								'$item_info[item_title]',
																								'$item_info[color]',
																								'$qty',
																								'$cart_price',
																								'".$_SESSION['member_id']."',
																								now(),
																								'$ip_address')";
							}

							$rst1 = mysql_query($qry1,$dbConn);

							if($rst1)
							{
								$qry2 = "select sum(item_sale*item_qty),count(*) as cnt from chan_shop_cart where user_id = '".$_SESSION['member_id']."'";
								$rst2 = mysql_query($qry2);

								$total_amt = @mysql_result($rst2,0,0);
								$total_cnt = @mysql_result($rst2,0,1);

								$cart_message = "ok^".$item_info[item_title]."^".$total_amt."^".$total_cnt;
							}
							else
							{
								$cart_message = "fail";
							}
									


			echo $cart_message;

		}
		else if($_POST['flag'] == "wish")
		{
							$item_info = get_iteminfo($option_arr[1]);
					
							
							$qry2 = "select * from chan_shop_wish where site_domain = '$site_domain' && user_id = '$user_temp_id' && product_id = '$option_arr[1]'";
							$rst2 = mysql_query($qry2);
							$num2 = mysql_num_rows($rst2);


							$order_qty = $option_arr[2];




							if($num2 == "0")
							{
									$qry1 = "insert into chan_shop_wish (site_domain,
																				product_id,
																				item_title,
																				item_option,
																				order_qty,
																				item_regular,
																				item_sale,
																				user_id,
																				wdate,
																				ip) values ('$site_domain',
																								'$option_arr[1]',
																								'$item_info[item_title]',
																								'$opt_value',
																								'$order_qty',
																								'$item_info[regular_price]',
																								'$item_info[sale_price]',
																								'".$_SESSION['member_id']."',
																								now(),
																								'$ip_address')";
							}
							else
							{
								$qry1 = "update chan_shop_wish set order_qty=order_qty+$order_qty where site_domain = '$site_domain' && user_id = '$user_temp_id' && product_id = '$option_arr[1]'";
							}

							//print_r($qry1);
							//echo "<br>";
							$rst1 = mysql_query($qry1,$dbConn);

		}



?>