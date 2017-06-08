<?
	include "./include/inc_base.php";


	if (!$_SESSION['member_id'])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/shopping/checkout.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?Mode=buy&goUrl=$URL");
	}


	$ip_address = explode(".",$REMOTE_ADDR);


	if(!$_SESSION['temp_orderNum'])
	{
			// 세션이 없으면 다시 만듬..

			$_SESSION['temp_orderNum'] = makeRandKey();


			/**
			* Pay Status : Waiting
			*/
			$pay_status = "PENDING";

			/**
			* Order Status : Configurating
			*/
			$order_status = "PENDING";


			$qry1 = "insert into chan_shop_orderinfo (user_id,
																			temp_order,
																			order_status) values ('".$_SESSION['member_id']."',
																												'".$_SESSION['temp_orderNum']."',
																												'".$order_status."')";
			//print_r($qry1);
			$rst1 = mysql_query($qry1);

			if($rst1)
			{
						$cart_qry1 = "select * from chan_shop_cart where user_id = '".$_SESSION['member_id']."' order by seq_no asc";
						$cart_rst1 = mysql_query($cart_qry1);

						$total_weight = 0;

						while($cart_row1 = mysql_fetch_assoc($cart_rst1))
						{
								// 주문 상품테이블에 INSERT

								/**
								* ITEM STATUS : READY
								*/
								$item_status = "";

								$item_info = get_iteminfo($cart_row1[item_code]);

								if($item_info[item_price2]>0 && ($item_info[item_price2]<$item_info[item_price1]))
								{
									$cart_price = $item_info[item_price2];
								}
								else
								{
									$cart_price = $item_info[item_price1];
								}

								$item_last = $cart_price*$cart_row1[item_qty];



								// 상품 정보 넣기
								$qry3 = "insert into chan_shop_orderproduct (temp_order,
																								item_code,
																								item_title,
																								item_option,
																								opt1_msg,
																								add_price,
																								item_qty,
																								item_sale,
																								item_last,
																								item_weight) values ('".$_SESSION['temp_orderNum']."',
																															'$cart_row1[item_code]',
																															'$item_info[item_title]',
																															'$cart_row1[item_option]',
																															'$cart_row1[opt1_msg]',
																															'$cart_row1[add_price]',
																															'$cart_row1[item_qty]',
																															'$cart_price',
																															'$item_last',
																															'$item_info[item_weight]')";

								//print_r($qry3);

								$rst3 = mysql_query($qry3);

						}
			}
			// 상품정보 넣기
	}



	include _BASE_DIR ."/include/inc_top.php";
?>
<div id="maincontainer">
  <section id="product">
    <div class="container">
    <!--  breadcrumb -->  
      <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Checkout</li>
      </ul>
      <div class="row">        
        <!-- Account Login-->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
						<script>
							var sameAddress_flag = 1;

							function sameAddress(){

								if(sameAddress_flag == '1')
								{
									tf = document.shipping_info;

									tf.ship_first_name.value = tf.bill_first_name.value;
									tf.ship_last_name.value = tf.bill_last_name.value;

									tf.ship_address1.value = tf.bill_address1.value;
									tf.ship_address2.value = tf.bill_address2.value;
									tf.ship_city.value = tf.bill_city.value;

									if(tf.bill_country.value == 'US')
									{
										ship_state_area.innerHTML = '<select name="ship_state"  id="ship_state" ><?= printState($temp_order_info[ship_state]); ?></select>';
									}
									else
									{
										ship_state_area.innerHTML = '<input type=text name="ship_state"  id="ship_state" value="<?= $temp_order_info[ship_state] ?>">';
									}


									tf.ship_state.value = tf.bill_state.value;
									tf.ship_zipcode.value = tf.bill_zipcode.value;
									tf.ship_country.value = tf.bill_country.value;

									sameAddress_flag = 2;
								}
								else
								{
									tf = document.shipping_info;

									tf.ship_first_name.value = '';
									tf.ship_last_name.value = '';

									tf.ship_address1.value = '';
									tf.ship_address2.value = '';
									tf.ship_city.value = '';
									tf.ship_state.value = '';
									tf.ship_zipcode.value = '';
									tf.ship_country.value = '';

									sameAddress_flag = 1;

								}

							}

							function choose_country(flag,country)
							{
								if(flag == '1')
								{
									if(country == 'US')
									{
										bill_state_area.innerHTML = '<select name="bill_state"  id="bill_state" ><?= printState($temp_order_info[bill_state]); ?></select>';
									}
									else
									{
										bill_state_area.innerHTML = '<input type=text name="bill_state" id="bill_state" class=" border-color" value="<?= $temp_order_info[bill_state] ?>">';
									}
								}
								else
								{
									if(country == 'US')
									{
										ship_state_area.innerHTML = '<select name="ship_state"  id="ship_state" ><?= printState($temp_order_info[ship_state]); ?></select>';
									}
									else
									{
										ship_state_area.innerHTML = '<input type=text name="ship_state"  id="ship_state" class=" border-color" value="<?= $temp_order_info[ship_state] ?>">';
									}
								}
							}
						</script>
						<link rel="stylesheet" href="/css/checkout_style.css">
						<!-- Payment Method -->
						<div class="payment-method">
							<!-- Panel Gropup -->
							<div class="panel-group" id="accordion">

								<!-- Panel Default -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="check-title">
											<a data-toggle="collapse" id="checkut1_title" class="active" data-parent="#accordion" >
											<span class="number">1</span>Billing & Shipping Information</a>
										</h4>
										<div align="right"><a href="javascript:checkout_update('first')">edit</a></div>
									</div>
									<div id="checkut1" class="panel-collapse collapse in">
										<div class="panel-body">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<form name="shipping_info">
													<div class="form">
														<div class="card-control">
														<span style="font-size:11pt;font-weight:bold;color:#000;">Billing Information</span>
															<ul>
																<li>
																	<div class="field fix">
																		<div class="input-box">
																			<label class="label" for="first">First Name <em>*</em></label>
																			<input type="text" name=bill_first_name class=" border-color" id="first">
																		</div>
																		<div class="input-box">
																			<label class="label" for="last">Last Name<em>*</em></label>
																			<input type="text" name=bill_last_name class=" border-color" id="last">
																		</div>
	
																	</div>
																</li>
																<li>
																	<div class="field fix">
																		<div class="input-box">
																			<label class="label" for="Country">Country<em>*</em></label>
																			<div class="i-box">
																				<select  id="bill_Country" name="bill_country" onChange="javascript:choose_country('1',this.value)">
																					<?= printCountryList($temp_order_info['bill_country']); ?>
																				</select>
																			</div>
																		</div>	
								
																	</div>									
																</li>
																<li>
																	<div class="field fix">

																		<div class="input-box">
																			<label class="label" for="Zip">Zip/Postal Code <em>*</em></label>
																			<input type="text" name=bill_zipcode class=" border-color" id="Zip">
																		</div>
																		<div class="input-box">
																			<label class="label" for="City">City <em>*</em></label>
																			<input type="text" name=bill_city class=" border-color" id="City">
																		</div>				
																		<div class="input-box">
																			<label class="label" for="State">State/Province<em>*</em></label>
																			<div class="i-box">
																				<span id="bill_state_area">
																				<select  id="bill_state" name=bill_state>
																					<?= printState($temp_order_info['bill_state']); ?>
																				</select>
																				</span>
																			</div>
																		</div>
																	</div>									
																</li>
																<li>
																	<div class="field fix">
																		<div class="input-box inhun">
																			<label class="label" for="addr">Address <em>*</em></label>
																			<input type="text" name=bill_address1 style="width:70%" class=" border-color" id="addr"/>
																			<input type="text" name=bill_address2 style="width:70%" class=" border-color"/>
																		</div>							
																	</div>	
																</li>

																<li>
																	<div class="field fix">
																		<div class="input-box">
																			<label class="label" for="Telephone">Telephone <em>*</em></label>
																			<input type="text" name=bill_phone class=" border-color" id="Telephone">
																		</div>									
																		<div class="input-box">
																			<label class="label" for="email">Email Address <em>*</em></label>
																			<input type="email" name=bill_email class=" border-color" id="email"/>
																		</div>			
																	</div>
																</li>
																<li>
																	<input type=checkbox name=useDefaultAddress id="useDefaultAddress" value="YES" onClick="sameAddress()"> Check here if Shipping Address is same as Billing Address.
																</li>
															</ul>
															<br>
														<span style="font-size:11pt;font-weight:bold;color:#000;">Shipping Information</span>
															<ul>
																<li>
																	<div class="field fix">
																		<div class="input-box">
																			<label class="label" for="first">First Name <em>*</em></label>
																			<input type="text" name=ship_first_name class=" border-color" id="first">
																		</div>
																		<div class="input-box">
																			<label class="label" for="last">Last Name<em>*</em></label>
																			<input type="text" name=ship_last_name class=" border-color" id="last">
																		</div>
	
																	</div>
																</li>
																<li>
																	<div class="field fix">
																		<div class="input-box">
																			<label class="label" for="Country">Country<em>*</em></label>
																			<div class="i-box">
																				<select  id="ship_Country" name="ship_country" onChange="javascript:choose_country('2',this.value)">
																					<?= printCountryList($temp_order_info['bill_country']); ?>
																				</select>
																			</div>
																		</div>	
								
																	</div>									
																</li>
																<li>
																	<div class="field fix">

																		<div class="input-box">
																			<label class="label" for="Zip">Zip/Postal Code <em>*</em></label>
																			<input type="text" name=ship_zipcode class=" border-color" id="Zip">
																		</div>
																		<div class="input-box">
																			<label class="label" for="City">City <em>*</em></label>
																			<input type="text" name=ship_city class=" border-color" id="City">
																		</div>				
																		<div class="input-box">
																			<label class="label" for="State">State/Province<em>*</em></label>
																			<div class="i-box">
																				<span id="ship_state_area">
																				<select  id="ship_state" name=ship_state>
																					<?= printState($temp_order_info['bill_state']); ?>
																				</select>
																				</span>
																			</div>
																		</div>
																	</div>									
																</li>
																<li>
																	<div class="field fix">
																		<div class="input-box inhun">
																			<label class="label" for="addr">Address <em>*</em></label>
																			<input type="text" name=ship_address1 style="width:70%" class=" border-color" id="addr"/>
																			<input type="text" name=ship_address2 style="width:70%" class=" border-color"/>
																		</div>							
																	</div>	
																</li>
															</ul>
														</div>
														<div class="button-check">									
															<div class="">									
																<span class="left-btn"><a href=""><i class="fa fa-long-arrow-up"></i>Back</a></span><button type="button" onClick="javascript:checkout_update('billing')" class="btn right-btn custom-button">Continue</button>
															</div>										
														</div>
													</div>
												</form>
											</div>									
										</div>
									</div>
								</div><!-- End Panel Default -->
								<!-- Panel Default -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="check-title">
											<a data-toggle="collapse" id="checkut2_title" data-parent="#accordion">
											<span class="number">2</span>Shipping Method</a>
										</h4>
										<div align="right"><a href="javascript:checkout_update('billing')">edit</a></div>
									</div>
									<div id="checkut2" class="panel-collapse collapse">
										<div class="panel-body">
											<form name="shippmethod_info">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div class="flatrate">
													<div id="shipRate_toggle_contents">
													</div>
													<br>
													Customer Memo : <br>
													<textarea name=customer_comment style="width:80%;height:100px"></textarea>
												</div>								
												<div class="button-check">									
													<div class="">									
														<span class="left-btn"><a href=""><i class="fa fa-long-arrow-up"></i>Back</a></span><button type="button" onClick="javascript:checkout_update('shipmethod')" class="btn right-btn custom-button">Continue</button>
													</div>										
												</div>											
											</div>
											</form>
										</div>
									</div>
								</div><!-- End Panel Default -->
								<!-- Panel Default -->
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="check-title">
											<a data-toggle="collapse" id="checkut3_title" data-parent="#accordion" >
											<span class="number">3</span>Payment Information</a>
										</h4>
									</div>
									<div id="checkut3" class="panel-collapse collapse">
										<div class="panel-body">
											<script>
												function pay_chk(){

													tf = document.payment;

													if(!tf.card_number.value == '')
													{
															toastr.options = {
															  "closeButton": false,
															  "debug": false,
															  "positionClass": "toast-top-right",
															  "onclick": null,
															  "showDuration": "300",
															  "hideDuration": "1000",
															  "timeOut": "5000",
															  "extendedTimeOut": "1000",
															  "showEasing": "swing",
															  "hideEasing": "linear",
															  "showMethod": "fadeIn",
															  "hideMethod": "fadeOut"
															}
															
															toastr.error('Enter your Card Number!');

															return false;

													}

													return true;
												}
											</script>
											<form name=payment method=post action=checkout_process.php onSubmit="return pay_chk()">
											<input type=hidden name=mode value="save">
											<input type=hidden name=payment_method value="CREDITCARD">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div class="flatrate">
													<div class="credit_form">
													</div>
												</div>								
												<div class="button-check">					
													<div class="">							
														<span class="left-btn"><a href=""><i class="fa fa-long-arrow-up"></i>Back</a></span><button type="submit" class="btn right-btn custom-button">PLACE ORDER</button>
													</div>										
												</div>											
											</div>
											</form>
										</div>
									</div>
								</div><!-- End Panel Default -->	
												
							</div>
							<!-- End Panel Gropup -->
						</div>
						<!-- End Payment Method -->		

		</div>        
        <!-- Sidebar Start-->
        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3">
          <aside>
            <div class="sidewidt">
              <h2 class="heading2"><span><i class="icon-list-ol"></i> Checkout Steps</span></h2>
              <ul class="nav nav-list categories">
                <li>
                  <a class="active" href="#">Billing & Shipping Details</a>
                </li>
                <li>
                  <a href="#">Delivery Method</a>
                </li>                
                <li>
                  <a href="#"> Payment Method</a>
                </li>
              </ul>
            </div>
          </aside>
        </div>
        <!-- Sidebar End-->
      </div>
    </div>
  </section>
</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>