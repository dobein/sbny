<?
	include "./include/inc_base.php";

	/**
	* @ 회원정보 가져오기
	*/
	if($_SESSION['temp_orderNum'])
	{
		$client_info = getinfo_dbMember($_SESSION['user_id']);




		$temp_order_info = get_orderinfo_temp($_SESSION['temp_orderNum']);

		$total_weight = get_total_weight($_SESSION['temp_orderNum']);


	}

	if($temp_order_info['ship_country'] == "US")
	{
		// fedex excel rate
		//$fedexRate = fedexExcel_Domestic_Process($_SESSION['temp_orderNum'],$total_weight,".");


		// fedex process
		$fedexRate = fedexProcess($_SESSION['temp_orderNum'],$total_weight,".");

	}
	else
	{
		// fedex excel rate
		//$fedexRate = fedexExcelProcess($_SESSION['temp_orderNum'],$total_weight,".");


		$fedexRate = fedexProcess($_SESSION['temp_orderNum'],$total_weight,".");

	}


	// usps process
	//$usps_data = uspsProcess($_SESSION['temp_orderNum'],$total_weight);


?>
<table width=100% border=0 cellpadding=0 cellspacing=0>
<?= $fedexRate ?>

<? if(empty($fedexRate)): ?>
<tr><td colspan=2><label><input type=radio name=shipping_method id="optionsRadios99" value="9@FEDEX_GROUND_TMP@0" <? if($temp_order_info[shipping_method] == "FEDEX_GROUND_TMP") echo "checked"; ?>>&nbsp;<font color=red>FEDEX Temporary - <?= $temp_order_info['ship_country'] ?></font></label></td></tr>
<tr><td colspan=2>Currently FeDex/USPS can't calculate accurate shipping rate to this destination.<br>
Response : Due to shipping policy of certain countries/destination.<br><br>
* Shipping rate will be calculated manually and it will be confirmed then order <br> will be processed. We absolutely cancel and refund the order if shipping rate <br>does not meet for customer.<br><br>
</td>
</tr>
<? endif; ?>

</table>