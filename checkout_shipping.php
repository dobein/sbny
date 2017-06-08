<?
	include "./include/inc_base.php";


	if (!$_SESSION['member_id'])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/shopping/checkout.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?Mode=buy&goUrl=$URL");
	}



	if($_SESSION['temp_orderNum'])
	{
		$client_info = getinfo_dbMember($_SESSION['user_id']);


		$ship_address_info = getinfo_shipaddress($client_info[user_id]);


		$temp_order_info = get_orderinfo_temp($_SESSION['temp_orderNum']);

		$total_weight = get_total_weight($_SESSION['temp_orderNum']);

		if($temp_order_info['used_promotion_code'])
		{
			$promotion_code = check_gift($temp_order_info['used_promotion_code']);
		
			//$promotion_code['pin_type']
		}
	}

	if($temp_order_info['ship_country'] == "US")
	{
		// fedex excel rate
		$fedexRate = fedexExcel_Domestic_Process($_SESSION['temp_orderNum'],$total_weight,".");

		if(empty($fedexRate))
		{
			// fedex process
			$fedexRate = fedexProcess($_SESSION['temp_orderNum'],$total_weight,".");
		}
	}
	else
	{
		// fedex excel rate
		$fedexRate = fedexExcelProcess($_SESSION['temp_orderNum'],$total_weight,".");

		if(empty($fedexRate))
		{
			$fedexRate = fedexProcess($_SESSION['temp_orderNum'],$total_weight,".");
		}
	}


	// usps process
	$usps_data = uspsProcess($_SESSION['temp_orderNum'],$total_weight);



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
        <h2 class="heading1"><span class="maintext">Checkout</span></h2>


		<form name="shippmethod_info" id="signupForm" class="form-horizontal form-custom">
		<input type=hidden name=mode value="save">
        <div class="checkoutsteptitle">Shipping Method </div>
        <div class="checkoutstep">
          <div class="row">
				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td><b>Shipping Address</b></td>
					</tr>
					<tr>
						<td><?= $temp_order_info['ship_address1'] ?> <?= $temp_order_info['ship_address2'] ?> <?= $temp_order_info['ship_city'] ?> <?= $temp_order_info['ship_state'] ?> <?= $temp_order_info['ship_zipcode'] ?> <?= $temp_order_info['ship_country'] ?></td>
					</tr>
				</table>
				<br>
				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width=50%><b>Shipping Methods (please choose one)<b></td>
					<td width=30%><b><font color=green>Estimated Date of Arrival *</font></b></td>
					<td width=20%></td>
				</tr>
				<?= $fedexRate ?>
				<?= $usps_data ?>
				<? if(empty($fedexRate) && empty($usps_data)): ?>
				<tr><td colspan=3><label><input type=radio name=shipping_method id="optionsRadios99" value="9@FEDEX_GROUND_TMP@0" <? if($temp_order_info[shipping_method] == "FEDEX_GROUND_TMP") echo "checked"; ?>>&nbsp;<font color=red>FEDEX Temporary - <?= $temp_order_info['ship_country'] ?></font></label></td></tr>
				<tr><td colspan=3>Currently FeDex/USPS can't calculate accurate shipping rate to this destination.<br>
				Response : Due to shipping policy of certain countries/destination.<br><br>
				* Shipping rate will be calculated manually and it will be confirmed then order <br> will be processed. We absolutely cancel and refund the order if shipping rate <br>does not meet for customer.<br><br>
				</td>
				</tr>
				<? endif; ?>
				<? if($temp_order_info['ship_country'] == "US" && ($temp_order_info['ship_state'] != "PR" && $temp_order_info['ship_state'] != "HI" && $temp_order_info['ship_state'] != "VI" && $temp_order_info['ship_state'] != "MP" && $temp_order_info['ship_state'] != "AS" && $temp_order_info['ship_state'] != "GU" && $temp_order_info['ship_state'] != "AK")): ?>
					<? if($cartReturn_array['cart_amt']>$base_info['ship_free_price']): ?>
					<tr><td><label><input type=radio name=shipping_method id="optionsRadios99" value="9@FEDEX_FREE@0" <? if($temp_order_info[shipping_method] == "FEDEX_FREE") echo "checked"; ?>>&nbsp;FEDEX GROUND</label></td><td>&nbsp;</td><td>Free</td></tr>	
					<? endif; ?>
				<? endif; ?>
				<? if($_SESSION['member_id'] == "paiamanager@yahoo.com"): ?>
				<tr><td><label><input type=radio name=shipping_method id="optionsRadios99" value="89@USPS_FREE@0" <? if($temp_order_info[shipping_method] == "USPS_FREE") echo "checked"; ?>>&nbsp;USPS Priority Mail</label></td><td>&nbsp;</td><td>Free</td></tr>
				<? endif; ?>
				<? if($promotion_code['pin_type'] == "FREESHIP"): ?>
				<tr><td><label><input type=radio name=shipping_method id="optionsRadios99" value="9@FEDEX_FREE@0" <? if($temp_order_info[shipping_method] == "FEDEX_FREE@0") echo "checked"; ?>>&nbsp;FEDEX GROUND</label></td><td>&nbsp;</td><td>Free</td></tr>
				<? endif; ?>
				</table>
				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
				  <tr>
					<td  colspan="2">If there's any special instruction please leave a note.</td>
				  </tr>
				  <tr>
					<td colspan="2"><textarea name=customer_comment cols=40 rows=3><?= stripslashes($temp_order_info[customer_comment]); ?></textarea></td>
				  <tr>
				</table>
          </div>
           </div>
        <div class="checkoutsteptitle">	Promotion Code </div>
        <div class="checkoutstep">
          <div class="row">

				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td><b>Promotion Code</b></td>
					</tr>
				</table>
				<br>
				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
				  <tr>
					<td >Enter your coupon code.<br><input name="promotion_code"  type="text" class="txt" style="width:120px" value="<?= $temp_order_info['used_promotion_code'] ?>"> <input type=button value=" APPLY " id="promotion_update" class="btn btn-primary btn-sm" style="cursor:pointer"></td>
				  </tr>
				  <tr>
					<td ><span id="promotion_result"></span></td>
				  </tr>
				 </table>
				<br>
				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td><b>Store Credit</b></td>
					</tr>
				</table>
				<br>
				<table width=95% align=center border=0 cellpadding=0 cellspacing=0>
				  <tr>
					<td >My storecredit : $<?= $mySC_amount ?><br>$<input type=text name=storecredit_amt size=4 value="<?= $temp_order_info['used_storecredit'] ?>" class="txt" style="width:60px" onClick="this.value=''">  <input type=button value=" USE IT " id="storecredit_update"  style="background-color:#104DE3;" class="btn btn-primary btn-sm" style="cursor:pointer"></td>
				  </tr>
				  <tr>
					<td ><span id="storecredit_result"></span></td>
				  </tr>
				 </table>

            
          </div>
		  <input type=button value=" Continue " id="shipmethod_update" class="btn btn-orange pull-right" style="cursor:pointer">
		  checkout_info_update.php 로 바로 전송하기 </div>

			</form>
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