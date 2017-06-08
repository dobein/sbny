<?
	include "./include/inc_base.php";

	/**
	* @ 회원정보 가져오기
	*/
	if($_SESSION['temp_orderNum'])
	{
		$client_info = getinfo_dbMember($_SESSION['user_id']);


		$temp_order_info = get_orderinfo_temp($_SESSION['temp_orderNum']);


		$pre_qry1 = "select (item_sale*item_qty) as sum from chan_shop_orderproduct where temp_order = '".$_SESSION['temp_orderNum']."'";
		$pre_rst1 = mysql_query($pre_qry1);
		$sub_total = @mysql_result($pre_rst1,0,0);


		$discount_rate = discountAmt($cartReturn_array['cart_amt']);
		
		if($discount_rate[discount_rate])
		{
			$calc_discount = ($cartReturn_array['cart_amt']*$discount_rate[discount_rate])/100;

			$discount_amt = floor($calc_discount*100)/100;

			if(empty($discount_amt))
			{
				$discount_amt = 0;
			}
		}
		else
		{
			$discount_amt = 0;
		}




		$last_amount_sum = $sub_total + $temp_order_info[shipping] - $temp_order_info[used_promotion_discount] - $discount_amt - $temp_order_info[used_storecredit];
	}

/*
require_once 'authorize_dpm/anet_php_sdk/AuthorizeNet.php'; // The SDK


$relay_response_url = _DOMAIN."/relay_response.php";
$api_login_id = '----';
$transaction_key = '57xV3XS----';
$amount = $last_amount_sum;
$time = time();
$fp_sequence = $_SESSION['temp_orderNum'];

echo AuthorizeNetDPM::getCreditCardForm($amount, $fp_sequence,$relay_response_url,$api_login_id, $transaction_key);
*/
?>
<table width=100% border=0 style="color:#000">
	<tr>
		<td width=30% height=35>Total Amount</td>
		<td width=70%><div class="col-xs-6">$<?= $last_amount_sum ?></div></td>
	</tr>
	<tr>
		<td height=35>Card Number</td>
		<td><div class="col-xs-6"><input type="text" name=card_number class="form-control" ></div></td>
	</tr>
	<tr>
		<td height=35>Expire Date</td>
		<td><div class="col-xs-2">Year <input type="text" name=expire_year class="form-control" placeholder="yy"></div> <div class="col-xs-2">Month <input type="text" name=expire_month class="form-control" placeholder="mm"></div></td>
	</tr>
	<tr>
		<td height=35>Cvv4</td>
		<td><div class="col-xs-3"><input type="text" name=cvv_num class="form-control" ></div></td>
	</tr>
</table>