<?
	include "./include/inc_base.php";

	if($_POST['mode'] == "alldelete")
	{
		if($user_info[user_id])
		{
			$qry1 = "delete from chan_shop_cart where user_id = '$user_info[user_id]'";
		}
		else
		{
			$qry1 = "delete from chan_shop_cart where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
		}

		$rst1 = mysql_query($qry1,$dbConn);
	}
	else if($_GET['mode'] == "del")
	{
		$no = $_GET['no'];

		if($_SESSION['member_id'])
		{
			$qry1 = "delete from chan_shop_cart where user_id = '".$_SESSION['member_id']."' && seq_no = '$no'";
		}
		else
		{
			$qry1 = "delete from chan_shop_cart where user_id = '".$_COOKIE['TEMP_SHOPID']."' && seq_no = '$no'";
		}

		$rst1 = mysql_query($qry1,$dbConn);
	}
	elseif($_POST['mode'] == "update")
	{
		$seqNo = $_POST['seqNo'];
		$item_qty = $_POST['item_qty'];

		for($k=0; $k<count($seqNo); $k++)
		{
			//echo $seqNo[$k]."&nbsp;$item_qty[$k]<br>";
		
			$u_qry1 = "update chan_shop_cart set item_qty = '$item_qty[$k]' where seq_no = '$seqNo[$k]'";
			$u_rst1 = mysql_query($u_qry1,$dbConn);

		}

	}
	/**
	* @ ¼îÇÎÄ«Æ® »Ñ¸®±â
	*/
	function printCart(){
	
		global $dbConn,$ip_address,$_COOKIE,$_SESSION,$base_info,$user_info,$itemCode,$total_amt_value,$back_qty;

		if($_SESSION['member_id'])
		{
			$qry1 = "select * from chan_shop_cart where user_id = '".$_SESSION['member_id']."' order by seq_no asc";
		}
		else
		{
			$qry1 = "select * from chan_shop_cart where user_id = '".$_COOKIE['TEMP_SHOPID']."' order by seq_no asc";
		}
		//print_r($qry1);

		$rst1 = mysql_query($qry1,$dbConn);

		$amount = 0;
		$total_qty = 0;

		$img_url = _WEB_BASE_DIR;

		$real_total_price = 0;

		$num1 = 0;

		$total_amt_value = 0;

		$back_qty = 0;

		while($row1 = mysql_fetch_assoc($rst1)){

			$item_info = get_iteminfo($row1[item_code]);




			$userfile1 = "<img src='"._WEB_BASE_DIR."/upload/thum_".$item_info[userfile1]."' width=50>";


			$item_info[item_title] = strip_tags($item_info[item_title]);

			if($item_info[item_price2]>0 && ($item_info[item_price2]<$item_info[item_price1]))
			{
				$cart_price = $item_info[item_price2];
			}
			else
			{
				$cart_price = $item_info[item_price1];
			}

			$real_total_price = number_format($cart_price*$row1[item_qty],2);

			$data .= "
          <tr>
            <td class=\"image\"><a href=\"#\">$userfile1</a></td>
            <td  class=\"name\"><a href=\"#\">$item_info[item_title]</a></td>
            <td class=\"model\">$item_info[model_no]</td>
            <td class=\"quantity\"><input type=\"text\" size=\"1\" value=\"$row1[item_qty]\" class=\"col-lg-3 col-md-3 col-xs-6 col-sm-3\"></td>
			<td class=\"price\">$".number_format($cart_price,2)."</td>
            <td class=\"total\">$$real_total_price</td>
            <td class=\"total\"><a href=cart.php?mode=del&no=$row1[seq_no] onfocus=blur()><i class=\"tooltip-test font24 icon-remove-circle\" data-original-title=\"Remove\"> </i></a></td>
		  </tr>
			";

			$total_amt_value = $total_amt_value + ($cart_price*$row1[item_qty]);

			$num1++;
			
			unset($size_value);
			unset($file_value);
			unset($now_file_value);

		}

		if($num1 == "0")
		{
			$data = "<tr><td align=\"center\" height=50 colspan=7>Nothing Found</td></tr>";
		}


		return $data;
	}


	//$sub_total_qry = "select (item_qty* from chan_shop_cart where user_id = '".$_SESSION['member_id']."' order by seq_no asc";
	

	$cart_data = printCart();

	$discountValue = discountReturn($total_amt_value);

	$total_amt = $total_amt_value-$discountValue[discount_amt];

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
        <li class="active">Cart</li>
      </ul>       
      <h1 class="heading1"><span class="maintext"> <i class="icon-shopping-cart"></i> Shopping Cart</span></h1>
      <!-- Cart-->
      <div class="cart-info">
        <table class="table table-striped table-bordered">
          <tr>
            <th class="image">Image</th>
            <th class="name">Product Name</th>
            <th class="model">Model</th>
            <th class="quantity">Qty</th>
            <th class="price">Unit Price</th>
            <th class="total">Total</th>
            <th class="total">Action</th>           
          </tr>
		  <?= $cart_data; ?>
        </table>
      </div>
	  <form action=checkout.php method=post>
      <div class="cartoptionbox">

          <h4 class="heading4"> Enter your promotion code.</h4>
          <fieldset>
            <div class="control-group">
              <label  class="control-label">Promotion Code</label>
              <div class="controls">
                <input type=text name=promotion_code  class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3 cartcountry">
              </div>
            </div>
          </fieldset>
      </div>
      <div class="container">
      <div class="pull-right">
          <div class="">
            <table class="table table-striped table-bordered ">
              <tr>
                <td><span class="extra bold">Sub-Total :</span></td>
                <td><span class="bold">$<?= number_format($total_amt_value,2) ?></span></td>
              </tr>
              <tr>
                <td><span class="extra bold">Discount (<?= $discountValue[discount_rate] ?>%) :</span></td>
                <td><span class="bold">$<?= number_format($discountValue[discount_amt],2) ?></span></td>
              </tr>
              <tr>
                <td><span class="extra bold totalamout">Total :</span></td>
                <td><span class="bold totalamout">$<?= number_format($total_amt,2) ?></span></td>
              </tr>
            </table>
            <input type="submit" value="CheckOut" class="btn btn-orange pull-right mb10">
            <input type="button" value="Continue Shopping" class="btn btn-orange pull-right mr10">
          </div>
        </div>
        </div>
		</form>
    </div>
  </section>
</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>