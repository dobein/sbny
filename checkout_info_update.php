<?
	include "./include/inc_base.php";


		if(!isset($_SESSION['member_id']))
		{
			echo "session error!";
			exit;
		}


		// $ip_address
		$ip_address = $_SERVER['REMOTE_ADDR'];


		if($_POST['flag'] == "contact")
		{

						$c_first_name=mysql_real_escape_string(htmlentities($_POST['c_first_name'])); 
						$c_last_name=mysql_real_escape_string(htmlentities($_POST['c_last_name'])); 
						$c_email=mysql_real_escape_string(htmlentities($_POST['c_email'])); 
						$c_company=mysql_real_escape_string(htmlentities($_POST['c_company'])); 
						$c_phone=mysql_real_escape_string(htmlentities($_POST['c_phone'])); 

						$qry1 = "update chan_shop_orderinfo set c_first_name = '".addslashes(trim($c_first_name))."',
																					c_last_name = '".addslashes(trim($c_last_name))."',
																					c_email = '".addslashes(trim($c_email))."',
																					c_company = '".addslashes(trim($c_company))."',
																					c_cell_phone = '".$c_phone."' where orderNum = '".$_SESSION['temp_orderNum']."'";
						$rst1 = mysql_query($qry1);

						if($rst1)
						{
							echo "ok^$c_first_name^$c_last_name^$c_email^$c_company^$c_phone";
						}
						else
						{
							echo "fail";
						}

		}
		else if($_POST['flag'] == "ship_address")
		{
						$bill_email=mysql_real_escape_string(htmlentities($_POST['bill_email'])); 
						$bill_phone=mysql_real_escape_string(htmlentities($_POST['bill_phone'])); 

						$bill_first_name=mysql_real_escape_string(htmlentities($_POST['bill_first_name'])); 
						$bill_last_name=mysql_real_escape_string(htmlentities($_POST['bill_last_name'])); 

						$b_address=mysql_real_escape_string(htmlentities($_POST['bill_address1'])); 
						$b_address_2=mysql_real_escape_string(htmlentities($_POST['bill_address2'])); 
						$b_city=mysql_real_escape_string(htmlentities($_POST['bill_city'])); 
						$b_country=mysql_real_escape_string(htmlentities($_POST['bill_country'])); 
						$b_state=mysql_real_escape_string(htmlentities($_POST['bill_state'])); 
						$b_zipcode=mysql_real_escape_string(htmlentities($_POST['bill_zipcode'])); 

						$ship_first_name=mysql_real_escape_string(htmlentities($_POST['ship_first_name'])); 
						$ship_last_name=mysql_real_escape_string(htmlentities($_POST['ship_last_name'])); 

						$s_address=mysql_real_escape_string(htmlentities($_POST['ship_address1'])); 
						$s_address_2=mysql_real_escape_string(htmlentities($_POST['ship_address2'])); 
						$s_city=mysql_real_escape_string(htmlentities($_POST['ship_city'])); 
						$s_country=mysql_real_escape_string(htmlentities($_POST['ship_country'])); 
						$s_state=mysql_real_escape_string(htmlentities($_POST['ship_state'])); 
						$s_zipcode=mysql_real_escape_string(htmlentities($_POST['ship_zipcode'])); 


						$vowels = array("-", "=", " ");
						$s_zipcode = str_replace($vowels, "", $s_zipcode);


						$qry1 = "update chan_shop_orderinfo set bill_first_name = '".addslashes(trim($bill_first_name))."',
																					bill_last_name = '".addslashes(trim($bill_last_name))."',
																					bill_address1 = '".addslashes(trim($b_address))."',
																					bill_address2 = '".addslashes(trim($b_address_2))."',
																					bill_city = '".addslashes(trim($b_city))."',
																					bill_state = '".addslashes(trim($b_state))."',
																					bill_zipcode = '".$b_zipcode."',
																					bill_country = '".addslashes(trim($b_country))."', 
																					ship_first_name = '".addslashes(trim($ship_first_name))."',
																					ship_last_name = '".addslashes(trim($ship_last_name))."',
																					ship_address1 = '".addslashes(trim($s_address))."',
																					ship_address2 = '".addslashes(trim($s_address_2))."',
																					ship_city = '".addslashes(trim($s_city))."',
																					ship_state = '".addslashes(trim($s_state))."',
																					ship_zipcode = '".trim($s_zipcode)."',
																					ship_country = '".addslashes(trim($s_country))."',
																					bill_email = '".addslashes(trim($bill_email))."',
																					bill_cellphone = '".addslashes(trim($bill_phone))."' where temp_order = '".$_SESSION['temp_orderNum']."'";
						$rst1 = mysql_query($qry1);


						if($rst1)
						{
							echo "ok^$s_address^$s_address_2^$s_city^$s_state^$s_zipcode^$s_country";
						}
						else
						{
							echo "fail";
						}
		}
		else if($_POST['flag'] == "shipping_method")
		{
						$shipping_method=mysql_real_escape_string(htmlentities($_POST['ship_method'])); 
						$customer_comment=mysql_real_escape_string(htmlentities($_POST['customer_comment'])); 

						$shipping_array = explode("@",$shipping_method);


						$signiture_option = "NO";
						$ship_price = $shipping_array[2];


						$qry1 = "update chan_shop_orderinfo set 
																			shipping = '".$ship_price."', 
																			shipping_title = '".$shipping_array[1]."', 
																			comment = '".addslashes($customer_comment)."' 
																			where temp_order = '".$_SESSION['temp_orderNum']."'";
						$rst1 = mysql_query($qry1);

						if($rst1)
						{
							//echo "success";
							echo "ok^$shipping_array[1]^$ship_price^$signiture_option";
						}
						else
						{
							echo "fail";
						}
		}
		else if($_POST['flag'] == "promotion_update")
		{
						$promotion_code=mysql_real_escape_string(htmlentities($_POST['promotion_code'])); 

						$promotion_result = check_gift($promotion_code);


						$promotion_used_result = check_used_gift($promotion_code);

						if($promotion_result[valid_time] == "ONE" && $promotion_used_result>0)
						{
								$gift_msg = "This coupon is already used!";
								$return_status = "fail";
						}
						else
						{

									if(empty($promotion_result))
									{
										$gift_msg = "We could not find $promotion_code code.";
										$return_status = "fail";
									}
									else
									{
										// 이 핀이 적용된 카테고리를 가져온다.

										if($promotion_result['apply_category'])
										{
											$pre_qry2 = "select * from chan_shop_category where seq_no = '".$promotion_result['apply_category']."'";
											$pre_rst2 = mysql_query($pre_qry2);
											$pre_row2 = mysql_fetch_assoc($pre_rst2);
											
											// 이 제품의 카테고리
											$this_c_code1 = $pre_row2['c_code1'];
											$this_c_code2 = $pre_row2['c_code2'];
											$this_c_code3 = $pre_row2['c_code3'];

													// 각 쇼핑카트 상품들을 돌려서, 해당 상품이 이 카테고리에 있는지 검색.. 있으면 금액 가져옴

													$sub_total = 0;

													$pre_qry1 = "select * from chan_shop_cart where user_id = '".$_SESSION['user_id']."'";
													$pre_rst1 = mysql_query($pre_qry1);
													while($pre_row1 = mysql_fetch_assoc($pre_rst1)){
													
														// $pre_row1[[product_id]
														$pre_qry3 = "select * from chan_shop_c_product where product_id = '$pre_row1[product_id]' && p_code1 = '$this_c_code1' && p_code2 = '$this_c_code2' && p_code3 = '$this_c_code3'";
														$pre_rst3 = mysql_query($pre_qry3);
														$pre_num3 = mysql_num_rows($pre_rst3);

														if($pre_num3>0)
														{
															$cart_sub_amt = $pre_row1['order_qty']*$pre_row1['item_sale'];
														}
														else
														{
															$cart_sub_amt = 0;
														}

														$sub_total = $sub_total + $cart_sub_amt;

													}

										}
										else
										{
											$pre_qry1 = "select sum(order_qty*item_sale) from chan_shop_cart where user_id = '".$_SESSION['user_id']."'";
											$pre_rst1 = mysql_query($pre_qry1);
											$sub_total = @mysql_result($pre_rst1,0,0);
										}

										


										if($promotion_result[status] == "Ready")
										{
													if($promotion_result[pin_type] == "DISCOUNT")
													{
														$promotion_discount_amt = $promotion_result[pin_price];
														$promotion_discount_msg = "$$promotion_result[pin_price]";
													}
													else if($promotion_result[pin_type] == "PERCENT")
													{
														// 총 주문금액(세일상품제외한 금액)

														$percentSubtotal = ($sub_total * $promotion_result[pin_percent])/100;
														$percentSubtotal = sprintf("%.2f",($percentSubtotal*100)/100);

														$promotion_discount_amt = $percentSubtotal;
														$promotion_discount_msg = $promotion_result[pin_percent]."%";
													}
													else
													{
														// free shipping
														$promotion_discount_amt = 0;
														$promotion_discount_msg = "Your free shipping offer is applied.";
													}

													$gift_msg = "Very good!";

													$qry1 = "update chan_shop_orderinfo set used_promotion_discount = '".$promotion_discount_amt."', used_promotion_code = '".$promotion_code."' where orderNum = '".$_SESSION['temp_orderNum']."'";
													$rst1 = mysql_query($qry1);
													$return_status = "ok";


										}
										else if($promotion_result[status] == "Pending")
										{
													$gift_msg = "Sorry, your promotion code is pending!";
													$return_status = "fail";
										}
										else if($promotion_result[status] == "Done")
										{
													$gift_msg = "Sorry, You already used!";
													$return_status = "fail";
										}

										$today = time();

										if($today>$promotion_result[expire_date])
										{
											$gift_msg = "This coupon is expired!";
											$return_status = "fail";

											$qry1 = "update chan_shop_orderinfo set used_promotion_discount = '', used_promotion_code = '' where orderNum = '".$_SESSION['temp_orderNum']."'";
											$rst1 = mysql_query($qry1);
										}
										
										if($promotion_result[limit_money]>=$sub_total)
										{
											$gift_msg = "Minium amount is $$promotion_result[limit_money]. your order is $$sub_total";
											$return_status = "fail";

											$qry1 = "update chan_shop_orderinfo set used_promotion_discount = '', used_promotion_code = '' where orderNum = '".$_SESSION['temp_orderNum']."'";
											$rst1 = mysql_query($qry1);
										}

									}


						}


						if($return_status == "ok")
						{
							echo "ok@$promotion_code@$promotion_discount_amt@$promotion_discount_msg";
						}
						else
						{
							echo "fail@$gift_msg";
						}
		}


?>