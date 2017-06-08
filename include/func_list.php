<?
	function printIndexBottom($flag,$start,$stop){
		
		global $base_info;

		if($flag == 'sale')
		{
		$qry1 = "select * from chan_shop_product where print_option = 'YES' && item_price2<item_price1 && item_price2>0 order by seq_no desc limit $start,$stop";
		}
		else if($flag == 'new')
		{
		$qry1 = "select * from chan_shop_product where print_option = 'YES' order by seq_no desc limit $start,$stop";
		}
		else if($flag == 'most')
		{
		$qry1 = "select * from chan_shop_product where item_icon = 'HOT' && print_option = 'YES' order by seq_no desc limit $start,$stop";
		}

		$rst1 = mysql_query($qry1);

		while($row = mysql_fetch_assoc($rst1)){

				if($row[userfile1])
					{
						$userfile1 = _WEB_BASE_DIR."/productimages/".$row[userfile1];
					}
				else
					{
						$userfile1 = _WEB_BASE_DIR."/images/sample.jpg";
					}

				$item_url = str_replace(" ","+",$row[item_url]);
				$product_link = _WEB_BASE_DIR."/details/$item_url";

				switch($row[item_icon])
					{
						case "NEW":
							$add_icon = "<span class=\"sale-text new-sale\">NEW</span>";
							break;
						case "HOT":
							$add_icon = "<span class=\"sale-text\">HOT</span>";
							break;
						case "SALE":
							$add_icon = "<span class=\"sale-text\">SALE</span>";
							break;
					}

				if($row[item_price2]>0)
					{
						$price = "<span class=\"old-price\">$$row[item_price1]</span><span class=\"new-price\">$$row[item_price2]</span>";
						$jyp_price = "<span class=\"old-price\">￥".number_format($row[item_price1]*$base_info[currency])."</span><span class=\"new-price\">￥".number_format($row[item_price2]*$base_info[currency])."</span>";
					}
				else
					{
						$price = "<span class=\"new-price\">$$row[item_price1]</span>";
						$jyp_price = "<span class=\"new-price\">￥".number_format($row[item_price1]*$base_info[currency])."</span>";
					}


				$s_qry1 = "select sum(rate1+rate2+rate3), count(*) from chan_shop_product_rate where item_code = '$row[item_code]'";
				$s_rst1 = mysql_query($s_qry1);
				$s_sum1 = @mysql_result($s_rst1,0,0);
				$s_cnt1 = @mysql_result($s_rst1,0,1);

				$rate_ave = 5*($s_sum1/15*$s_cnt1);

				for($star=1; $star<6;$star++)
				{
					if($star>$rate_ave)
					{
						$star_icon .= "<i class=\"fa fa-star-o\"></i>&nbsp;";
					}
					else
					{
						$star_icon .= "<i class=\"fa fa-star\"></i>&nbsp;";
					}
				}

			$row[item_title] = SUBSTR($row[item_title],0,8);

			$content .= "
										<div class=\"single-new-product\">
											<div class=\"product-img\">
												<a href=\"$product_link\">
													<img class=\"primary-img\" src=\"$userfile1\" alt=\"\" >
													<img class=\"secondary-img\" src=\"$userfile1\" alt=\"\" >
												</a>
											</div>
											<div class=\"product-details\">
												<div class=\"product-name\">
													<h3><a href=\"$product_link\">$row[item_title]..</a></h3>
												</div>
												<div class=\"ratings no-rating\">
													<ul>
														$star_icon
													</ul>
												</div>
												<div class=\"price-box\">
													$price
												</div>
												<div class=\"price-box\">
													$jyp_price
												</div>
											</div>
										</div>";

			unset($star_icon);
		}

		return $content;
	}

	function Category_info($c_code1,$c_code2 = false,$c_code3 = false){


		if($c_code1 && $c_code2 && $c_code3)
		{
			$qry1 = "select * from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='$c_code3'";
			$rst1 = mysql_query($qry1);
			$row1 = mysql_fetch_assoc($rst1);
	
		}
		else if($c_code1 && $c_code2)
		{
			$qry1 = "select * from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='0'";
			$rst1 = mysql_query($qry1);
			$row1 = mysql_fetch_assoc($rst1);
	
		}
		else
		{
			$qry1 = "select * from chan_shop_category where c_code1='$c_code1' && c_code2='0' && c_code3='0'";
			$rst1 = mysql_query($qry1);
			$row1 = mysql_fetch_assoc($rst1);

		}

		//print_r($qry1);

		return $row1;

	}

	function getCategorybyName_seo($name1){
		
		$seo_link = str_replace("-"," ",$name1);

		$code1 = "&& url_link = '$seo_link'";



		$qry1 = "select * from chan_shop_category where activate = 'Active' $code1";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}

	function getProductbyName_seo($name1){
		
		$seo_link = str_replace("-"," ",$name1);

		$code1 = "&& item_url = '$seo_link'";



		$qry1 = "select * from chan_shop_product where print_option = 'YES' $code1";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}
	function chooseCategory($category = false){
		

		$qry1 = "select * from chan_shop_category where c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);
		while($row1 = mysql_fetch_assoc($rst1)){
			
			$first_category = "$row1[seq_no]/$row1[c_code1]/$row1[c_code2]/";

			if($category == $first_category)
			{
				$data .= "<option value=\"$first_category@$row1[name]\" selected style=\"font-weight:bold\">$row1[name]";
			}
			else
			{
				$data .= "<option value=\"$first_category@$row1[name]\" style=\"font-weight:bold\">$row1[name]";
			}

			$qry2 = "select * from chan_shop_category where c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
			$rst2 = mysql_query($qry2);
			while($row2 = mysql_fetch_assoc($rst2)){

				$second_category = "$row1[seq_no]/$row2[c_code1]/$row2[c_code2]/";
				
				if($category == $second_category)
				{
					$data .= "<option value=\"$second_category@$row1[name]/$row2[name]\" selected>└--- $row2[name]";
				}
				else
				{
					$data .= "<option value=\"$second_category@$row1[name]/$row2[name]\">└--- $row2[name]";
				}

				$qry3 = "select * from chan_shop_category where c_code1 = '$row2[c_code1]' && c_code2 = '$row2[c_code2]' && c_code3 <> '0' order by pos asc";
				$rst3 = mysql_query($qry3);
				while($row3 = mysql_fetch_assoc($rst3)){

					$third_category = "$row1[seq_no]/$row3[c_code1]/$row3[c_code2]/$row3[c_code3]";
					
					if($category == $third_category)
					{
						$data .= "<option value=\"$third_category@$row1[name]/$row2[name]/$row3[name]\" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└--- $row3[name]";
					}
					else
					{
						$data .= "<option value=\"$third_category@$row1[name]/$row2[name]/$row3[name]\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└--- $row3[name]";
					}

				}

			}


		}

		return $data;
	}

	function item_cnt($item_code){
	
		$o_qry1 = "select sum(StockCnt) from chan_shop_product_option where item_code = '".$item_code."'";
		$o_rst1 = mysql_query($o_qry1);
		
		$sum = @mysql_result($o_rst1,0,0);

		return $sum;
	}



	function chooseCategory_search($category = false){
		

		$qry1 = "select * from chan_shop_category where c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);
		while($row1 = mysql_fetch_assoc($rst1)){
			
			$first_category = "$row1[seq_no]";

			if($category == $first_category)
			{
				$data .= "<option value=\"$first_category\" selected style=\"font-weight:bold\">$row1[name]";
			}
			else
			{
				$data .= "<option value=\"$first_category\" style=\"font-weight:bold\">$row1[name]";
			}

			$qry2 = "select * from chan_shop_category where c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
			$rst2 = mysql_query($qry2);
			while($row2 = mysql_fetch_assoc($rst2)){

				$second_category = "$row2[seq_no]";
				
				if($category == $second_category)
				{
					$data .= "<option value=\"$second_category\" selected>└--- $row2[name]";
				}
				else
				{
					$data .= "<option value=\"$second_category\">└--- $row2[name]";
				}

				$qry3 = "select * from chan_shop_category where c_code1 = '$row2[c_code1]' && c_code2 = '$row2[c_code2]' && c_code3 <> '0' order by pos asc";
				$rst3 = mysql_query($qry3);
				while($row3 = mysql_fetch_assoc($rst3)){

					$third_category = "$row3[seq_no]";
					
					if($category == $third_category)
					{
						$data .= "<option value=\"$third_category\" selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└--- $row3[name]";
					}
					else
					{
						$data .= "<option value=\"$third_category\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└--- $row3[name]";
					}

				}

			}


		}

		return $data;
	}

	function getPageInfo($page_code){


		$qry1 = "select * from chan_shop_page where item_code = '$page_code'";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$row1 = mysql_fetch_Assoc($rst1);

		return $row1;
	}

	function min_chan_shop_c_product(){
		
		global $dbConn;

		$qry1 = "select min(pos) from chan_shop_c_product";
		$rst1 = mysql_query($qry1);
		$num1 = @mysql_result($rst1,0,0);

		return $num1;
	}


		function resize_image($destination, $departure, $size, $quality='150', $ratio='false'){ 

			if($size[2] == 1)    //-- GIF 
				$src = imageCreateFromGIF($departure); 
			elseif($size[2] == 2) //-- JPG 
				$src = imageCreateFromJPEG($departure); 
			else    //-- $size[2] == 3, PNG 
				$src = imageCreateFromPNG($departure); 

			$dst = imagecreatetruecolor($size['w'], $size['h']); 


			$dstX = 0; 
			$dstY = 0; 
			$dstW = $size['w']; 
			$dstH = $size['h']; 

			if($ratio != 'false' && $size['w']/$size['h'] <= $size[0]/$size[1]){ 
				$srcX = ceil(($size[0]-$size[1]*($size['w']/$size['h']))/2); 
				$srcY = 0; 
				$srcW = $size[1]*($size['w']/$size['h']); 
				$srcH = $size[1]; 
			}elseif($ratio != 'false'){ 
				$srcX = 0; 
				$srcY = ceil(($size[1]-$size[0]*($size['h']/$size['w']))/2); 
				$srcW = $size[0]; 
				$srcH = $size[0]*($size['h']/$size['w']); 
			}else{ 
				$srcX = 0; 
				$srcY = 0; 
				$srcW = $size[0]; 
				$srcH = $size[1]; 
			} 

			@imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH); 
			@imagejpeg($dst, $destination, $quality); 
			@imagedestroy($src); 
			@imagedestroy($dst); 

			return TRUE; 
		} 

		// $img : 원본이미지 
		// $m : 목표크기 pixel 
		// $ratio : 비율 강제설정 
		function _getimagesize($img, $m, $ratio='false'){ 

			$v = @getImageSize($img); 

			if($v === FALSE || $v[2] < 1 || $v[2] > 3) 
				return FALSE; 

			$m = intval($m); 

			if($m > $v[0] && $m > $v[1]) 
				return array_merge($v, array("w"=>$v[0], "h"=>$v[1])); 

			if($ratio != 'false'){ 
				$xy = explode(':',$ratio); 
				return array_merge($v, array("w"=>$m, "h"=>ceil($m*intval(trim($xy[1]))/intval(trim($xy[0]))))); 
			}elseif($v[0] > $v[1]){ 
				$t = $v[0]/$m; 
				$s = floor($v[1]/$t); 
				$m = ($m > 0) ? $m : 1; 
				$s = ($s > 0) ? $s : 1; 
				return array_merge($v, array("w"=>$m, "h"=>$s)); 
			} else { 
				$t = $v[1]/intval($m); 
				$s = floor($v[0]/$t); 
				$m = ($m > 0) ? $m : 1; 
				$s = ($s > 0) ? $s : 1; 
				return array_merge($v, array("w"=>$s, "h"=>$m)); 
			} 
		} 


	function pageInfo($item_code){
		
		global $dbConn,$user_info;

		$qry1 = "select * from chan_shop_page where item_code = '$item_code'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}


	function getInfoWholesaler($no){
		
		global $dbConn,$user_info;

		$qry1 = "select * from chan_shop_member where seq_no = '$no'";
		$rst1 = mysql_query($qry1);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}

	function SelectWholesaler($no){
		
		global $dbConn,$user_info;

		$qry1 = "select * from chan_shop_member where level = '9'";
		$rst1 = mysql_query($qry1);
		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($no == $row1[seq_no])
			{
				$content .= "<option value=\"$row1[seq_no]\" selected>$row1[company]";
			}
			else
			{
				$content .= "<option value=\"$row1[seq_no]\">$row1[company]";
			}
		}
	
		return $content;
	}

	function printTopCarts(){

		if($_SESSION['member_id'])
		{
			$qry1 = "select * from chan_shop_cart where user_id = '".$_SESSION['member_id']."' order by seq_no asc limit 5";
		}
		else
		{
			$qry1 = "select * from chan_shop_cart where user_id = '".$_SERVER['REMOTE_ADDR']."' order by seq_no asc limit 5";
		}

		$rst1 = mysql_query($qry1);
		while($row1 = mysql_fetch_assoc($rst1)){

			$item_info = get_iteminfo($row1[item_code]);


			$direct_link = _WEB_BASE_DIR;

			$userfile1 = "<img src='"._WEB_BASE_DIR."/productimages/thum_".$item_info[userfile1]."' width=50>";


			$item_info[item_title] = strip_tags($item_info[item_title]);


			$real_total_price = number_format($row1[item_sale]*$row1[item_qty],2);

			$content .= "
								<div class=\"product-items-cart\">
									<div class=\"cart-img\">
										<a href=\"#\">$userfile1</a>
									</div>
									<div class=\"cart-text-2\">
										<a class=\"btn-remove\" title=\"Remove This Item\" href=\"$direct_link/cart.php?mode=del&no=$row1[seq_no]\"><span class=\"pencil\"><i class=\"fa fa-pencil\"></i></span>
										<p class=\"product-name\"><a href=\"#\">$item_info[item_title]</a></p>
										<p><strong>$row1[item_qty]</strong> x<span class=\"price\">$$real_total_price</span> </p>
									</div>
								</div>";
		}

		return $content;

	}

	function makeRandKey(){

		/**
		* Temp order number 만들기
		*/
		$keychars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$length = 5;

		// RANDOM KEY GENERATOR
		$randkey = "";
		$max=strlen($keychars)-1;
		for ($i=0;$i<=$length;$i++) {
		  $randkey .= substr($keychars, rand(0, $max), 1);
		}

		// item code 만들기
		$temp_orderNum = $randkey.date("d").date("m").date("s").date("y")."K".date("h").date("i");
	
		return $temp_orderNum;
	}


	function printWon($price){

		global $base_info;

		$won_price = floor(($base_info[currency]*$price)/100)*100;

		$won_price = number_format($won_price);

		return $won_price;
	}

	function printDomainList($domain = false){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);

		$start = 1;
		while($row1 = mysql_fetch_assoc($rst1)){
			

			if($domain == $row1[name])
			{
				echo "<option value=\"$row1[name]\" selected>$row1[name]</a></li>";
			}
			else
			{
				echo "<option value=\"$row1[name]\">$row1[name]</a></li>";
			}


			$start++;
		}

	}



	function printTopmenu($code1){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 = '$code1' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);

		$start = 1;
		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($num1 == $start)
			{
				$add_value = "class=\"last\"";
			}
			else
			{
				$add_value = "";
			}

			echo "<li $add_value style=\"padding-left:10px\"><a href=\"/shopping/product_list.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]\">$row1[name]</a></li>";

			/*
			if($start == $num1)
			{
			echo "[\"$row1[name]\", \"/shopping/product_list.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]\"]";
			}
			else
			{
			echo "[\"$row1[name]\", \"/shopping/product_list.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]\"],";
			}
			*/

			$start++;
		}

	}

	function putTodayView($iid){
		
		global $dbConn,$user_info,$REMOTE_ADDR;

		$ip_address = $REMOTE_ADDR;

		if($user_info[user_id])
		{
			$cart_qry1 = "user_id = '$user_info[user_id]'";
			$user_temp_id = $user_info[user_id];
		}
		else
		{
			$cart_qry1 = "user_id = '$ip_address'";
			$user_temp_id = $ip_address;
		}

		// 검토해서 찾기
		$qry2 = "select * from chan_shop_today where item_code = '$iid' && $cart_qry1";
		$rst2 = mysql_query($qry2);
		$num2 = @mysql_num_rows($rst2);

		if($num2 == "0")
			{

			$qry1 = "insert into chan_shop_today (item_code,
														user_id,
														wdate,
														ip) values ('$iid',
																		'$user_temp_id',
																		now(),
																		'$ip_address')";
			$rst1 = mysql_query($qry1);
			
			}


	}

	function discountReturn($amt){
		
		if($amt>0 && $amt<100)
		{
			$discount_rate = "5";

			$discount_amt = ($amt*$discount_rate)/100;
		}
		else if($amt>=100 && $amt<1000)
		{
			$discount_rate = "10";

			$discount_amt = ($amt*$discount_rate)/100;
		}

		$data[discount_rate] = $discount_rate;
		$data[discount_amt] = $discount_amt;

		return $data;
	}

	function get_category_by_url($item_url){
		
		global $dbConn;

		$item_url = str_replace("-"," ",$item_url);
		$item_url = chop($item_url);

		$qry1 = "select * from chan_shop_category where url_link = '$item_url'";
		//PRINT_R($qry1);
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}
	function get_iteminfo_by_url($item_url){
		
		global $dbConn;

		$item_url = str_replace("-"," ",$item_url);
		$item_url = chop($item_url);

		$qry1 = "select * from chan_shop_product where item_url = '$item_url'";
		//PRINT_R($qry1);
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}

	function itemCode(){
		
		global $dbConn;

		$qry1 = "select max(item_num) from chan_shop_product";
		$rst1 = mysql_query($qry1);
		$row1 = mysql_result($rst1,0,0);

		if(!$row1)
		{
			$num = "1001";
		}
		else
		{
			$num = $row1 + 1;
		}

		return $num;
	}

	function printCountryList($country = false){
		
		global $dbConn;

		$qry1 = "select * from country order by name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if(empty($country)){
				
				$country = "US";
			}

			if($row1[iso] == $country)
			{
				echo "<option value=\"$row1[iso]\" selected>$row1[nicename]";
			}
			else
			{
				echo "<option value=\"$row1[iso]\">$row1[nicename]";
			}
		}

	}

	function check_gift($gift_number){
		
		global $dbConn,$site_domain;

		$qry1 = "select * from chan_shop_pin where site_domain = '$site_domain' && pin_number = '$gift_number' && (user_id = '".$_SESSION['user_id']."' || user_id = 'anyone' || group_id = '".$_SESSION['member_group']."') order by seq_no desc limit 1";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);
		
		return $row1;		
	}

	function check_used_gift($gift_number){

		global $dbConn,$site_domain;

		$qry1 = "select * from chan_shop_pin_history where site_domain = '$site_domain' && promotion_code = '$gift_number' && user_id = '".$_SESSION['user_id']."'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_num_rows($rst1);
		
		return $row1;	
	}


	function printState($state){
		
		global $dbConn;

		$qry1 = "select * from tbl_state order by state_name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[state_abbr] == $state)
			{
				echo "<option value=\"$row1[state_abbr]\" selected>$row1[state_name]";
			}
			else
			{
				echo "<option value=\"$row1[state_abbr]\">$row1[state_name]";
			}
		}

	}

	function printStylego($style){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_style order by name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[seq_no] == $style)
			{
				echo "<option value=\"$row1[seq_no]\" selected>$row1[name]";
			}
			else
			{
				echo "<option value=\"$row1[seq_no]\">$row1[name]";
			}
		}

	}

	function sendEmail($flag,$oN){

		global $dbConn,$base_info;

		$order_info = get_orderinfo($oN);


		$base_infosite_name = $base_info[site_name];
		$base_infosite_email = $base_info[site_email];

		$eol="\r\n";

		$boundary = "--------" . uniqid("part"); 
		$headers .= 'From: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol; 
		$headers .= 'Reply-To: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol; 
		$headers .= 'Return-Path: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol;    // these two to set reply address 
		$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
		$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 
        $headers .= "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-Type:text/html; charset=euc-kr\r\n"; 
		$headers .= "Content-Transfer-Encoding: 8bit\n\n";

		// order product
		$qry2 = "select * from chan_shop_orderproduct where orderNum='$oN' order by seq_no asc";
		$rst2 = mysql_query($qry2,$dbConn);

		while($row2 = mysql_fetch_array($rst2)){
				
			//$us_price = number_format($row2[p_price],2);

			$item_info = get_iteminfo($row2[item_code]);

			$item_sale = number_format($row2[item_sale],2);
			$real_total_price = number_format($row2[item_sale]*$row2[item_qty],2);


			switch($row2[item_status])
			{
				case "1":
					$item_status = "Checking";
					break;
				case "2":
					$item_status = "BackOrder";
					break;
				case "3":
					$item_status = "Out of Stock";
					break;
				case "4":
					$item_status = "Ready";
					break;
				default:
					$item_status = "-";
					break;
			}

			//&nbsp;&nbsp;<span class='blue'>Credit:$$row2[item_credit]</span>
			$order_product .= "
			<tr bgcolor='#FFFFFF'>
				<td align=left>&nbsp;$item_info[model_no]&nbsp;<b>$item_info[item_title]</b></td>
				<td align=center>$$item_sale</td>
				<td align=center>$row2[item_qty]</td>
				<td align=center><b>$$real_total_price</b></td>
			</tr>";		
		}

		$order_info[ship_first_name] = mb_convert_encoding($order_info[ship_first_name], 'HTML-ENTITIES', 'UTF-8'); 
		$order_info[ship_last_name] = mb_convert_encoding($order_info[ship_last_name], 'HTML-ENTITIES', 'UTF-8'); 

		switch($flag)
		{
			case "1":
				$mail_title = "$base_infosite_name Email Notification";

						$mailStr .= "
						<table width=600 border=0 cellpadding=0 cellspacing=1 bgcolor='#cccccc'>
							<tr> 
								<td align=center class=title bgcolor=#FFFFFF> 
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td>
<span style='font-size:12pt;color:#ff6600'>Hello $order_info[ship_first_name] $order_info[ship_last_name],</span><br>
Thank you for shopping with us. We'd like to let you know that $base_info[site_name] has received your order, and is preparing it for shipment. If you would like to view the status of your order, please visit Your Orders on $base_info[site_homepage] .

										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>

									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td class='d8 pink' align=left><b>Order Confirmation</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF>
											  <tr> 
												<td width=30% height=27 bgcolor=#f3f3f3 class=d8>&nbsp;&nbsp;&nbsp;&nbsp;Order #</td>
												<td width=70% height=27 align=left>&nbsp;<a href=$base_info[site_homepage]/tracking.php target=_blank><b>$oN</b></a></td>
											  </tr>
											  <tr> 
												<td height=1 colspan=3 bgcolor=#eeeeee></td>
											  </tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td bgcolor=#FFFFFF align=left><b>Your order will be sent to: </b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f4f4f4'>
												<tr bgcolor='#FFFFFF'>
													<td width=30% bgcolor=#f3f3f3 align=left>&nbsp;Name</td>
													<td width=70% align=left>&nbsp;$order_info[ship_first_name] $order_info[ship_last_name]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td bgcolor=#f3f3f3 align=left>&nbsp;Address</td>
													<td align=left>&nbsp;$order_info[ship_address1] $order_info[ship_address2]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td bgcolor=#f3f3f3 align=left>&nbsp;City / State</td>
													<td align=left>&nbsp;$order_info[ship_city] $order_info[ship_state]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td align=left bgcolor=#f3f3f3>&nbsp;Zip code</td>
													<td align=left>&nbsp;$order_info[ship_zipcode]</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=1 bgcolor='#f4f4f4'>	
										<tr> 
										  <td colspan=2  align=left><b>Order Details</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=2 bgcolor=#e0e0e0></td>
									  </tr>
									  <tr>
										<td height=28 colspan=2 bgcolor=#FFFFFF>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f3f3f3'>
												<tr bgcolor='#FFFFFF'>
													<td width=50% align=center>Item</td>
													<td width=20% align=center>Unit Price</td>
													<td width=10% align=center>Qty</td>
													<td width=20% align=center>Amount</td>
												</tr>
												$order_product
											</table>
										</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td width=70% align=right >Sub total : </td>
										<td width=30% align=right>$$order_info[order_price]&nbsp;&nbsp;</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td align=right >Tax : </td>
										<td align=right>$$order_info[tax]&nbsp;&nbsp;</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td align=right >Shipping : </td>
										<td align=right>$$order_info[shipping]&nbsp;&nbsp;</td>
									  </tr>
									  <tr bgcolor=#FFFFFF>
										<td align=right  height=28><b>Total amount : </td>
										<td align=right>$$order_info[last_price]</b>&nbsp;&nbsp;</td>
									  </tr>
									</table>
								</td>
							</tr>
						</table>
						";




				$send = $order_info[bill_email];
				break;
			
			case "2":
				$mail_title = "$base_infosite_name Email Notification - Order Update";

				$mailStr .= "Order # : $oN.<br>";
				$mailStr .= "Customer Name : $order_memberinfo[bill_first_name] $order_memberinfo[bill_last_name]<br>";
				$mailStr .= "Date Ordered : $order_info[order_date].<br>";
				$mailStr .= " <br>";
				$mailStr .= "Hi, thank you for shopping with $base_infosite_name. Your package has been delivered to UPS.<br>";
				$mailStr .= "Please use your order id to track your package on our information page here. $base_info[site_homepage]/member/tracking.php<br>";
				$mailStr .= " <br>";
				$mailStr .= "Your order has been updated to the following status.<br>";
				$mailStr .= "New status: Shipped<br>";
				$mailStr .= "Tracking number : $order_info[tracking]<br>";
				$mailStr .= " <br>";
				$mailStr .= $order_info[feedback]."<br>";
				$mailStr .= "Please reply to this email if you have any questions.<br><br>";
				$mailStr .= "Thank you for shopping with us and hope to see you soon.";

				$send = $order_info[bill_email];
				break;

			case "4":
				$mail_title = "$base_infosite_name Email Notification - Order Cancellation";

				$mailStr .= "Order # : $oN.<br>";
				$mailStr .= "Customer Name : $order_memberinfo[bill_first_name] $order_memberinfo[bill_last_name]<br>";
				$mailStr .= "Date Ordered : $order_info[order_date].<br>";
				$mailStr .= " <br>";
				$mailStr .= "Your order has been canceled. <br>";
				$mailStr .= "We did not charge you for this order.";
				$mailStr .= " <br>";
				$mailStr .= "Your order has been updated to the following status.<br>";
				$mailStr .= "New status: CANCELLED<br>";
				$mailStr .= " <br>";
				$mailStr .= $order_info[feedback]."<br>";
				$mailStr .= "Please reply to this email if you have any questions.";

				$send = $order_info[bill_email];
				break;

			case "3":
				$mail_title = "$base_infosite_name Email Notification - Order Changed";

						$mailStr .= "
						<table width=600 border=0 cellpadding=0 cellspacing=1 bgcolor='#cccccc'>
							<tr> 
								<td align=center class=title bgcolor=#FFFFFF> 
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td class='d8 pink' align=left><b>Order Confirm</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF>
											  <tr> 
												<td width=142 height=27 bgcolor=#f3f3f3 class=d8>&nbsp;&nbsp;&nbsp;&nbsp;Order No.</td>
												<td width=12 height=27></td>
												<td width=410 height=27 align=left>&nbsp;<a href=$base_info[site_homepage]/member/tracking.php target=_blank><b>$oN</b></a></td>
											  </tr>
											  <tr> 
												<td height=1 colspan=3 bgcolor=#eeeeee></td>
											  </tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=0>	
										<tr> 
										  <td bgcolor=#FFFFFF align=left><b>Billing & Shipping Information</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
										<tr> 
										  <td>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f4f4f4'>
												<tr bgcolor='#FFFFFF'>
													<td width=50% colspan=2 align=left>&nbsp;Billing </td>
													<td width=50% colspan=2 align=left>&nbsp;Shipping </td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Name</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_first_name] $order_memberinfo[bill_last_name]</td>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Name</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_first_name] $order_memberinfo[ship_last_name]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Address</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_address1] $order_memberinfo[bill_address2]</td>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Address</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_address1] $order_memberinfo[ship_address2]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;City / State</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_city] $order_memberinfo[bill_state]</td>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;City / State</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_city] $order_memberinfo[ship_state]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% bgcolor=#f3f3f3 align=left>&nbsp;Zip code</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_zipcode]</td>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;Zip code</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_zipcode]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;Phone</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_phone]</td>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;Phone</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_phone]</td>
												</tr>
												<tr bgcolor='#FFFFFF'>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;E-mail</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[bill_email]</td>
													<td width=15% align=left bgcolor=#f3f3f3>&nbsp;E-mail</td>
													<td width=35% align=left>&nbsp;$order_memberinfo[ship_email]</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td height=28>&nbsp;</td></tr>
									</table>
									<table width=95% border=0 cellpadding=0 cellspacing=1 bgcolor='#f4f4f4'>	
										<tr> 
										  <td class='d8 pink' align=left><b>Order Items</b></td>
										</tr>
									  <tr> 
										<td height=1 colspan=3 bgcolor=#e0e0e0></td>
									  </tr>
									  <tr>
										<td height=28 bgcolor=#FFFFFF>
											<table width=100% align=center border=0 cellspacing=1 bgcolor='#f3f3f3'>
												<tr bgcolor='#FFFFFF'>
													<td width=30% align=center>Item</td>
													<td width=30% align=center>Colors</td>
													<td width=15% align=center>Unit Price</td>
													<td width=10% align=center>Qty</td>
													<td width=15% align=center>Amount</td>
												</tr>
												$order_product
											</table>
										</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF>Sub total : $$order_info[order_price]&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF>Tax : $$order_info[tax]&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF>Shipping : $$order_info[shipping]&nbsp;&nbsp;</td>
									  </tr>
									  <tr>
										<td align=right bgcolor=#FFFFFF height=28><b>Total amount : $$order_info[last_price]</b>&nbsp;&nbsp;</td>
									  </tr>
									</table>
								</td>
							</tr>
						</table>
						";




				$send = $order_info[bill_email];
				break;
		}


		$mail_result = mail($send, $mail_title, $mailStr, $headers);


		return $mail_result;
	}

	function getcreditsave($oN){
		
		global $dbConn;

		$c_qry1 = "select item_credit,item_qty from chan_shop_orderproduct where orderNum = '$oN'";
		$c_rst1 = mysql_query($c_qry1,$dbConn);

		$sub_order_price = 0;

		while($c_row1 = mysql_fetch_assoc($c_rst1)){

			$middle_sum = round_to_penny($c_row1[item_credit]*$c_row1[item_qty]);

			$sub_order_price = $sub_order_price + $middle_sum;
		}
	
		$order_price = $sub_order_price;


		return $order_price;
	}

	function printGiftprice($price = false){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_pinprice order by price asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[price] == $price)
			{
				echo "<option value=$row1[price] selected>$$row1[price]";
			}
			else
			{
				echo "<option value=$row1[price]>$$row1[price]";
			}
		}
	}

	function check_gift2($gift_number){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_pin where pin_number = '$gift_number'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);
		
		$num1 = mysql_num_rows($rst1);

		$result1[count] = $num1;
		$result1[status] = $row1[status];
		$result1[used_date] = $row1[used_date];
		$result1[pin_price] = $row1[pin_price];
		$result1[pin_number] = $row1[pin_number];
		$result1[pin_percent] = $row1[pin_percent];
		$result1[pin_type] = $row1[pin_type];

		return $result1;
	}

	function round_to_penny($amount){
	   
	   $string = (string)($amount * 100);

	   $string_array = split("\.", $string);
	   
	   $int = (int)$string_array[0];
	   
	   $return = $int / 100;
	   
	   return $return;

	}

	// orderInt 값 구하기
	function get_orderInt(){
		
		global $dbConn;

		$qry1 = "select max(orderInt) from chan_shop_orderinfo";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$orderInt  = @mysql_result($rst1,0,0);

		if(empty($orderInt))
		{
			$orderInt = "10001";
		}
		else
		{
			$orderInt = $orderInt + 1;
		}

		$charCode = "A";
		
		$order[orderInt] = $orderInt;
		$order[orderCode] = $charCode.$orderInt;

		return $order;
	}

	// invoice 값 구하기
	function get_invoiceInt(){
		
		global $dbConn;

		$today = date("Y-m");

		//$qry1 = "select max(invoiceInt) from chan_shop_orderinfo where date_format(order_date,'%Y-%m') = '$today'; ";
		$qry1 = "select max(invoiceInt) from chan_shop_orderinfo";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$invoiceInt  = @mysql_result($rst1,0,0);

		if(empty($invoiceInt))
		{
			$invoiceInt = "1001";
		}
		else
		{
			$invoiceInt = $invoiceInt + 1;
		}

		$invoice[invoiceInt] = $invoiceInt;
		$invoice[invoiceCode] = date("ym").$invoiceInt;

		return $invoice;
	}


	function str_highlight($text, $needle, $options = null, $highlight = null) 
	{ 
		// Default highlighting 
		if ($highlight === null) { 
			$highlight = '<strong>\1</strong>'; 
		} 
	  
		// Select pattern to use 
		if ($options & STR_HIGHLIGHT_SIMPLE) { 
			$pattern = '#(%s)#'; 
			$sl_pattern = '#(%s)#'; 
		} else { 
			$pattern = '#(?!<.*?)(%s)(?![^<>]*?>)#'; 
			$sl_pattern = '#<a\s(?:.*?)>(%s)</a>#'; 
		} 
	  
		// Case sensitivity 
		if (!($options & STR_HIGHLIGHT_CASESENS)) { 
			$pattern .= 'i'; 
			$sl_pattern .= 'i'; 
		} 
	  
		$needle = (array) $needle; 
		foreach ($needle as $needle_s) { 
			$needle_s = preg_quote($needle_s); 
	  
			// Escape needle with optional whole word check 
			if ($options & STR_HIGHLIGHT_WHOLEWD) { 
				$needle_s = '\b' . $needle_s . '\b'; 
			} 
	  
			// Strip links 
			if ($options & STR_HIGHLIGHT_STRIPLINKS) { 
				$sl_regex = sprintf($sl_pattern, $needle_s); 
				$text = preg_replace($sl_regex, '\1', $text); 
			} 
	  
			$regex = sprintf($pattern, $needle_s); 
			$text = preg_replace($regex, $highlight, $text); 
		} 
	  
		return $text; 
	} 

	/**
	* sales tax 구하기
	*/
	function get_salestax($state){
	
		global $dbConn,$base_info;

		$pre_qry1 = "select * from chan_shop_statetax where state = '$state'";
		//print_r($pre_qry1);
		$pre_rst1 = mysql_query($pre_qry1,$dbConn);
		$pre_num1 = mysql_affected_rows();

		if($pre_num1>0)
		{
			$pre_row1 = mysql_fetch_assoc($pre_rst1);

			$result[state] = $pre_row1[state];
			$result[tax] = $pre_row1[tax];
		}
		else
		{			
			$result[state] = "Base sales tax";
			$result[tax] = $base_info[tax_base_sales];
		}

		return $result;
		
	}

	/**
	* shipping 가져오기
	*/
	function get_shipping_select($ship = false){
		
		global $dbConn;

		$qry1 = "SELECT * FROM chan_shop_shipping";
		$rst1 = mysql_query($qry1,$dbConn);

		$num1 = "0";

		while($row1 = mysql_fetch_assoc($rst1)){

			if($ship == $row1[seq_no])
			{
				$option2 .= "<option name=$row1[seq_no] selected>$row1[name]";
			}
			else
			{
				$option2 .= "<option name=$row1[seq_no]>$row1[name]";
			}
			


			$num1 ++;	
		}

		return $option2;
	}

	function get_shipping($weight,$country,$wholesale_id){
		
		global $dbConn;

		//$qry1 = "SELECT * FROM chan_shop_shipping as A left join chan_shop_shipping_option as B on A.seq_no = B.parent_no && A.wholesale_id = '$wholesale_id' && B.activate = 'YES' && B.ship_weight_min<='$weight' && B.ship_weight_max>='$weight'";
		
		$qry1 = "SELECT * FROM chan_shop_shipping as A, chan_shop_shipping_option as B where A.seq_no = B.parent_no && A.wholesale_id = '$wholesale_id' && B.activate = 'YES' && B.ship_weight_min<='$weight' && B.ship_weight_max>='$weight'";
		//PRINT_R($qry1);

		$rst1 = mysql_query($qry1,$dbConn);

		$num1 = "0";

		while($row1 = mysql_fetch_assoc($rst1)){

			
			if($country != "US")
			{
				$add_price = "0";
				$add_msg = "";

				$ship_price_msg = "$".number_format($row1[ship_price],2);
			}
			else
			{
				$add_price = "0";
				$add_msg = "";
				
				$ship_price_msg = "$".number_format($row1[ship_price],2);
			}

			

			$row1[ship_price] = round_to_penny($row1[ship_price]+$add_price);
			
			if($num1 == "0")
			{
				$checked_value = "checked";
			}
			else
			{
				$checked_value = "";
			}

			$opt_msg = "$row1[ship_price]@$row1[name]@$row1[ship_title]";

			$option2 .= "<tr align=left><td height=25 width=40%>&nbsp;<input type=radio name=ship_flag onClick=\"javascript:sum_ship('$row1[ship_price]')\" value=\"$opt_msg\" > $row1[name] $row1[ship_title]</td><td width=60% class='pink'>$ship_price_msg $add_msg</td></tr><tr><td colspan=2 height=1 bgcolor=#f9f9f9></td></tr>";

			echo $option2;
			unset($option2);

			$num1 ++;	
		}

		
	}

	/**
	* 상품 정보 가져오기
	*/
	function get_itemPricehistory($itemCode){
		
		global $dbConn,$user_dbinfo;

		$qry1 = "select * from chan_shop_price where item_code = '$itemCode' order by seq_no desc limit 1";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		$img_url = _WEB_BASE_DIR;


				$result[sale_msg] = "$".number_format($row1[item_price],2);

				// 원가
				$result[item_costco] = 	$row1[item_costco];

				// Regular 가격
				$result[item_price1] = $row1[item_price1];
				$result[item_price_msg] = "$".number_format($row1[item_price],2);

				// 세일가격
				$result[item_price2] = $row1[item_price2];
				$result[item_price2_msg] = "$".number_format($row1[item_price2],2);

				// 최종 판매가격
				$result[item_price3] = 	$row1[item_price3];
				$result[item_price3_msg] = "$".number_format($row1[item_price3],2);



		return $result;
	}

	/**
	* 상품 총 무게 가져오기
	*/
	function get_weight($orderNum){
		
		global $dbConn;

		$qry1 = "select sum(item_weight) from chan_shop_orderproduct where orderNum = '$orderNum'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = @mysql_result($rst1,0,0);

		return $row1;

	}

	function printItemPrice($itemCode){
		
		global $dbConn;
		
		$qry1 = "select item_price, item_sale from chan_shop_product where item_code = '$itemCode'";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = mysql_fetch_assoc($rst1);

		$item_price = get_itemprice($row1[item_price],$row1[item_sale]);
		
		return $item_price;
	}

	/**
	* TOP link 뿌려주기
	*/
	function printToplink($c_code1){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_addlink where c_code1 = '$c_code1' order by seq_no desc limit 5";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);

		echo "<table width=100% border=0 cellpadding=0 cellspacing=0>";
		echo "<tr><td height=20>&nbsp;</td></tr>";

		while($row1 = mysql_fetch_assoc($rst1)){
			
			echo "
                    <tr>
                      <td class=\"left_news\">&nbsp;&nbsp;<a href=$row1[url] target=_blank><span style='color:#FFFFFF'>::  $row1[name]</span></a></td>
                    </tr>	
			";

		}

		echo "</table>";
	}

	/**
	* TOP 공지사항 뿌려주기
	*/
	function printTopNotice(){
		
		global $dbConn,$choose_lang;

		$qry1 = "select * from chan_shop_board where area = '$choose_lang' && tablename = 'notice' order by seq_no desc limit 5";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$title = Misc::cutLongString($row1[title],16,true);

			$url = _WEB_BASE_DIR."/talk/view.php?board_mode=view&table_id=notice&directory=&no=$row1[seq_no]&start=0&Mode=&how=&S_content=";

			echo "
                    <tr>
                      <td class=\"left_news\"><a href=$url><span style='color:#FFFFFF'>$title</span></a></td>
                    </tr>	
			";

		}

	}


	function discountAmt($amt){

		global $dbConn;

		$qry1 = "select * from chan_shop_discount where amount<='$amt' order by amount desc limit 1";
		$rst1 = mysql_query($qry1);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}


	function printBanner($spot){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_banner where banner_spot = '$spot' && view_print = 'YES' order by seq_no asc";
		//PRINT_R($qry1);
		$rst1 = mysql_query($qry1);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			//$title = Misc::cutLongString($row1[title],16,true);

			//$url = _WEB_BASE_DIR."/talk/view.php?board_mode=view&table_id=notice&directory=&no=$row1[seq_no]&start=0&Mode=&how=&S_content=";

			$img_url = _WEB_BASE_DIR;

			if($row1[brand_url] == "http://")
			{
				echo "<div ><img src=$img_url/upload/$row1[userfile1] border=0></div>";
			}
			else
			{
				echo "<div><a href=$row1[brand_url] onFocus=\"this.blur();\"><img src=$img_url/upload/$row1[userfile1] border=0></a></div>";
			}
			

		}

	}

	function printBannerName($spot){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_banner where banner_spot = '$spot' && view_print = 'YES' order by seq_no asc";
		$rst1 = mysql_query($qry1);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			//$title = Misc::cutLongString($row1[title],16,true);

			//$url = _WEB_BASE_DIR."/talk/view.php?board_mode=view&table_id=notice&directory=&no=$row1[seq_no]&start=0&Mode=&how=&S_content=";

			$img_url = _WEB_BASE_DIR;


			echo "$row1[name]";


		}

	}


	function printTopNotice_index(){
		
		global $dbConn,$choose_lang;

		$qry1 = "select * from chan_shop_board where tablename = 'notice' && area = '$choose_lang' order by seq_no desc limit 5";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$title = Misc::cutLongString($row1[title],16,true);

			$url = _WEB_BASE_DIR."/talk/view.php?board_mode=view&table_id=notice&directory=&no=$row1[seq_no]&start=0&Mode=&how=&S_content=";

			echo "
                    <tr>
                      <td class=\"left_news\"><a href=$url>$title</a></td>
                    </tr>	
			";

		}

	}
	function printfashion_index(){
		
		global $dbConn,$choose_lang;

		$qry1 = "select * from chan_shop_board where tablename = 'qna' && area = '$choose_lang' order by seq_no desc limit 5";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$title = Misc::cutLongString($row1[title],16,true);

			$url = _WEB_BASE_DIR."/talk/view.php?board_mode=view&table_id=qna&directory=&no=$row1[seq_no]&start=0&Mode=&how=&S_content=";

			echo "
                    <tr>
                      <td class=\"left_news\"><a href=$url>$title</a></td>
                    </tr>	
			";

		}

	}

	/**
	* 게시판 메뉴 뿌려주기
	*/
	function printBoardmenu(){
		
		global $dbConn,$tableName,$choose_lang;

		$qry1 = "select * from chan_shop_boardmain where division = 'BASIC' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$num = 0;
		$img_url = _WEB_BASE_DIR;


		while($row1 = mysql_fetch_array($rst1)){

		if($choose_lang == "Japaness")
		{
			$board_name = $row1[board_name_jap];
		}
		else
		{
			$board_name = $row1[board_name];
		}

			echo "
				<tr> 
				  <td height=\"25\"><table width=\"140\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					  <tr> 
						<td width=\"15\"><img src=\"$img_url/img/shopping/left_menu_dot.gif\" width=\"11\" height=\"11\"></td>
						<td class=\"left_menu\"><a href=$img_url/talk/list.php?table_id=$row1[board_id]>$board_name</a></td>
					  </tr>
					</table></td>
				</tr>
				<tr> 
				  <td height=\"1\" background=\"$img_url/img/shopping/left_menu_dotline.gif\"></td>
				</tr>
			";
		$num++;
		}
	}

	/**
	* 카테고리별 탑배너 가져오기
	*/
	function get_categoryimg($p_code1,$p_code2 = false, $p_code3 = false){
		
		global $dbConn;

		if($p_code3)
		{
			$qry1 = "select * from chan_shop_category where c_code1 = '$p_code1' && c_code2 = '$p_code2' && c_code3 = '$p_code3'";
		}
		else if(($p_code2 != "0") && empty($p_code3))
		{
			$qry1 = "select * from chan_shop_category where c_code1 = '$p_code1' && c_code2 = '$p_code2' && c_code3 = '0'";
		}
		else
		{
			$qry1 = "select * from chan_shop_category where c_code1 = '$p_code1' && c_code2 = '0' && c_code3 = '0'";
		}

		//print_r($qry1);

		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		if($row1[userfile1])
		{
			if($row1[url_link])
			{
				$userfile1 = "<a href=$row1[url_link]><img src=\"../upload/$row1[userfile1]\" border=0></a>";
			}
			else
			{
				$userfile1 = "<img src=\"../upload/$row1[userfile1]\" >";
			}

		}
		else
		{
			$userfile1 = "<img src=\"../img/Korean/main/main_img.jpg\" width=672 height=180>";
		}

		return $userfile1;
	}

	/**
	* 상품 사진 가져오기
	*/
	function get_firstpic($images){
	
		$photo_arr = explode("NaN",$images);

		return $photo_arr[0];
	}

	function get_firstpic_array($images){
	
		$photo_arr = explode("NaN",$images);

		return $photo_arr;
	}

	/**
	* 쇼핑카트 지우기
	*/
	function delete_cart(){
		
		global $dbConn,$ip_address,$_SESSION;

		$qry1 = "delete from chan_shop_cart where user_id = '".$_SESSION['member_id']."'";

		$rst1 = mysql_query($qry1,$dbConn);

	}

	/**
	* 상품 정보 가져오기
	*/
	function get_iteminfo($itemCode){
		
		global $dbConn;

		$itemCode = chop($itemCode);

		$qry1 = "select * from chan_shop_product where item_code = '$itemCode'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}

	function get_itemcategory($itemCode){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_c_product where item_code = '$itemCode'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}

	/**
	* 등록된 Style 가져오기 펑션
	*/
	function printStyle($style = false){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_style order by name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[seq_no] == $style)
			{
				echo "<option value=$row1[seq_no] selected>$row1[name]";
			}
			else
			{
				echo "<option value=$row1[seq_no]>$row1[name]";
			}
		}

	}
	/**
	* 등록된 Size 가져오기 펑션
	*/
	function printSize($size = false){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_size order by seq_no asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[seq_no] == $size)
			{
				echo "<option value=$row1[seq_no] selected>$row1[name]";
			}
			else
			{
				echo "<option value=$row1[seq_no]>$row1[name]";
			}
		}

	}
	/**
	* 등록된 Size 가져오기 펑션
	*/
	function printSizevalue2($size){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_size where seq_no = '$size'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		$size_value = explode("/",$row1[name]);

		return $row1[name];

	}

	function printSizevalue($size){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_size where seq_no = '$size'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		$size_value = explode("/",$row1[name]);

		for($k = 0; $k<count($size_value); $k++)
		{
			echo "<option value=$size_value[$k]>$size_value[$k]";
		}

	}

	function optionSum($item_code){
	
		$qry1 = "select sum(StockCnt) from chan_shop_product_option where item_code = '$item_code'";
		$rst1 = mysql_query($qry1);
		$stock = @mysql_result($rst1,0,0);

		return $stock;
	}

	function option_info($seqNo){
	
		$qry1 = "select * from chan_shop_product_option where seq_no = '$seqNo'";
		$rst1 = mysql_query($qry1);
		$stock = mysql_fetch_assoc($rst1);

		return $stock;
	}

	function getOrderNumber(){
		
		global $dbConn;

		$qry1 = "select max(orderInt) from chan_shop_orderinfo";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$orderInt  = @mysql_result($rst1,0,0);

		if(empty($orderInt))
		{
			$orderInt = "104001";
		}
		else
		{
			$orderInt = $orderInt + 1;
		}

		/*
		$keychars = "1234567890";
		$length = 1;

		// RANDOM KEY GENERATOR
		$randkey = "";
		$max=strlen($keychars)-1;
		for ($i=0;$i<=$length;$i++) {
		  $randkey .= substr($keychars, rand(0, $max), 1);
		}

		$charCode = "A";
		
		$startDay = date('z');
		*/
		

		$order[orderInt] = $orderInt;
		$order[orderCode] = $orderInt."-".rand(0,9);

		return $order;

	}

	/**
	* 등록된 브랜드 가져오기 펑션
	*/
	function printBrand($brand = false){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_brand order by name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[seq_no] == $brand)
			{
				echo "<option value=$row1[seq_no] selected>$row1[name]";
			}
			else
			{
				echo "<option value=$row1[seq_no]>$row1[name]";
			}
		}

	}
	
	/**
	* 해당 카테고리에 등록된 브랜드만 가져오기
	*/
	function printBrandcategory($c_code1,$c_code2,$c_code3 = false,$brand = false){
	
		global $dbConn;

		if($c_code3)
		{
			$code3_qry = "&& A.p_code3 = '$c_code3'";
		}

		$qry1 = "select B.item_name,B.item_code,B.brand,C.name from chan_shop_c_product as A left join chan_shop_product as B on (A.item_code = B.item_code && A.p_code1 = '$c_code1' && A.p_code2 = '$c_code2' $code3_qry) left outer join chan_shop_brand as C on (B.brand = C.seq_no) group by B.brand order by C.name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($row1[name])
			{
				if($row1[brand] == $brand)
				{
					echo "<option value=$row1[brand] selected>$row1[name]";
				}
				else
				{
					echo "<option value=$row1[brand]>$row1[name]";
				}
			}
		}

	}


	function printBrandsort(){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_brand order by name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			echo "<option value=$row1[seq_no]>$row1[name]";

		}

	}
	
	function style_name($seqNo){
		
		global $dbConn;

		$qry1 = "select name from chan_shop_style where seq_no = '$seqNo'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = @mysql_result($rst1,0,0);

		if(!$row1)
		{
			$row1 = "No style";
		}
		return $row1;
	}
	function brand_name_img($seqNo){
		
		global $dbConn;

		$qry1 = "select name,userfile1 from chan_shop_brand where seq_no = '$seqNo'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = @mysql_result($rst1,0,0);
		$row2 = @mysql_result($rst1,0,1);

		if($row2)
		{
			$result = "<img src='../upload/$row2'>";
		}

		return $result;
	}

	function brand_name($seqNo){
		
		global $dbConn;

		$qry1 = "select name from chan_shop_brand where seq_no = '$seqNo'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = @mysql_result($rst1,0,0);

		if(!$row1)
		{
			$row1 = "No brand";
		}
		return $row1;
	}


	/**
	* @ 멤버 로그인 펑션
	*/
	function Member_login($user_id,$password,$division = false,$remember_id,$remember_pw){
		
		global $dbConn,$c_domain,$domain;

		$password=md5($password); 



		$qry1 = "select * from chan_shop_member where member_id = '$user_id' && member_password = '$password'";
		$cookie_name = "MEMLOGIN_INFO";

		$rst1 = mysql_query($qry1,$dbConn);



		if(mysql_affected_rows() <= "0")
			{
				//Misc::jvAlert("로그인에 실패했습니다.","history.go(-1)");
				//exit;
				$Result = 0;
			}
		else
			{
				$row1 = mysql_fetch_assoc($rst1);

				$_SESSION['member_id']=$row1[member_id];
				$_SESSION['member_first_name']=$row1[first_name];
				$_SESSION['member_last_name']=$row1[last_name];

				// session id 저장
				$_SESSION['session_id'] = session_id();



				// 로그인 정보가 있다면... 이 사람의 정보로 쿠키를 굽니다.
				$login_info = array(sitename => "ecommerce", user_id => "$user_id", user_pw => "$password", user_level => $row1[level]);
				$login_info = base64_encode(serialize($login_info));
				
				SetCookie($cookie_name,$login_info,0,"/",$c_domain);
				//SetCookie($cookie_name,$login_info,0,"/");

				if($remember_id == "YES")
				{
					$cookie_name_id = "PALACE_ID";
					SetCookie($cookie_name_id,$user_id,time()+36000000,"/");
				}
				else
				{
					$cookie_name_id = "PALACE_ID";
					SetCookie($cookie_name_id,'',0,"/");
				}

				if($remember_pw == "YES")
				{
					$cookie_name_id = "PALACE_PW";
					SetCookie($cookie_name_id,$password,time()+36000000,"/");
				}
				else
				{
					$cookie_name_id = "PALACE_PW";
					SetCookie($cookie_name_id,'',0,"/");
				}

				// 기존 카트 업데이트
				$cart_qry1 = "update chan_shop_cart set user_id = '$row1[member_id]' where user_id = '".$_SERVER['REMOTE_ADDR']."'";
				$cart_rst1 = mysql_query($cart_qry1);


				$Result = 1;
			}
		
		// 성공/실패 결과 리턴
		return $Result;
	}

	/**
	* @ 멤버 로그인 펑션
	*/
	function Member_adminlogin($user_id,$password,$division = false,$forever_check){
		
		global $dbConn;

		if($division == "ADMIN")
		{
			$qry1 = "select * from chan_shop_manager where member_id = '$user_id' && member_password = '$password'";
			$cookie_name = "LOGIN_INFOR";
		}
		else
		{
			$qry1 = "select * from chan_shop_member where member_id = '$user_id' && member_password = '$password'";
			$cookie_name = "MEMLOGIN_INFO";
		}
		$rst1 = mysql_query($qry1,$dbConn);


		if(mysql_affected_rows() <= "0")
			{
				//Misc::jvAlert("로그인에 실패했습니다.","history.go(-1)");
				//exit;
				$Result = 0;
			}
		else
			{
				$row1 = mysql_fetch_assoc($rst1);

				if($forever_check == "Yes")
						{
								$loginTime = "1999999999";
						}
				else
						{
								$loginTime = "0";
						}

				// 로그인 정보가 있다면... 이 사람의 정보로 쿠키를 굽니다.
				$login_info = array(sitename => "globalshop", user_id => "$user_id", user_pw => "$password", user_level => $row1[level]);
				$login_info = base64_encode(serialize($login_info));
				
				SetCookie($cookie_name,$login_info,$loginTime,"/");
				
				$Result = 1;
			}
		
		// 성공/실패 결과 리턴
		return $Result;
	}

	/**
	* @ 로그인 쿠키로 개인정보 뽑아오기
	*/
	function getinfo_Member($user_info){
		
		$user_info = unserialize(base64_decode($user_info));
		
		return $user_info;

	}

	/**
	* @ 로그인 쿠키로 개인정보 뽑아오기
	*/


	function getinfo_site_admin(){

		global $dbConn;

		$qry1 = "select * from chan_shop_base";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		//$user_info = unserialize($row1[info]);
		
		return $row1;
	}




	/**
	* @ 아이디로 개인정보 뽑아오기
	*/
	function getinfo_Member2($user_info){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_manager where member_id = '$user_info'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		$user_info = unserialize($row1[etc]);
	
		return $user_info;

	}

	function getinfo_level($user_info){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_manager where member_id = '$user_info'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;

	}

	/**
	* @ 아이디로 개인정보 뽑아오기
	*/
	function getinfo_dbMember($user_info){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_member where member_id = '$user_info'";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_fetch_assoc($rst1);
		
		return $row1;

	}

	/**
	* @ 관리자 쇼핑 카테고리 추가 / 수정 / 삭제하기
	* @ 일반적 3단계 카테고리 구조입니다.
	*/
	function admin_category_manager($mode){
		
		global $dbConn;

		$tableName = "chan_shop_category";

		if($mode == "add")
		{

		}
		else if($mode == "modify")
		{
		}
		else if($mode == "delete")
		{
		}

	}

	/**
	* @ 카테고리 이름 가져오기
	*/
	function Category_name($c_code1,$c_code2,$c_code3){

		global $dbConn,$choose_lang;

		if($c_code3 != "0")
		{
		$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='$c_code3'";
		}
		else if($c_code2 != "0")
		{
		$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='0'";
		}
		else
		{
		$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='0' && c_code3='0'";
		}

		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);


		//$row1[name] = $row1[name];
		$row1 = @mysql_result($rst1,0,0);		

		$name = "$row1";

		return $name;
	}

	/**
	* @ 카테고리 이름 가져오기
	*/
	function Category_name_member($flag,$c_code1,$c_code2,$c_code3){

		global $dbConn,$choose_lang;

		if($flag == "BIG")
		{
			$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='0' && c_code3='0'";
		}
		else if($flag == "MIDDLE")
		{
			$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='0'";
		}
		else if($flag == "SMALL")
		{
			$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='$c_code3'";
		}

		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);


		//$row1[name] = $row1[name];
		$row1 = @mysql_result($rst1,0,0);		

		$name = "$row1";

		return $name;
	}

	/**
	* @ 카테고리 이름 가져오기 (링크없음)
	*/
	function Category_name_nolink1($c_code1,$c_code2,$c_code3){

		global $dbConn;


		$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='0' && c_code3='0'";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);


		//$row1[name] = $row1[name];
		$row1 = @mysql_result($rst1,0,0);		


		$name = "$row1";

		return $name;
	}
	function Category_name_nolink2($c_code1,$c_code2,$c_code3){

		global $dbConn;


		$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='0'";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = @mysql_result($rst1,0,0);		

		if($c_code2 == "0" || $c_code3 == "0")
		{
			$row1 = "NULL";
		}

		$name = "$row1";

		return $name;
	}
	function Category_name_nolink3($c_code1,$c_code2,$c_code3){

		global $dbConn;


		$qry1 = "select name from chan_shop_category where c_code1='$c_code1' && c_code2='$c_code2' && c_code3='$c_code3'";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = @mysql_result($rst1,0,0);		

		if($c_code2 == "0" || $c_code3 == "0")
		{
			$row1 = "NULL";
		}

		$name = "$row1";

		return $name;
	}

	/**
	* @ MIDDLE 카테고리 가져오기
	*/
	function printMiddlecategory($p_code1 = false){

		global $dbConn;
      

		// DB에서 한페이지에 보여줄 갯수 구하기
		$board_col = 4;
		$board_row = 14;

		$limit = $board_row*$board_col;
		// 열 갯수 변수치환

		$cols = $board_col;
		// DB접근을 위한 START 값

		if(!$start)
			{
			$start=0;
			}

		$que = "select * from chan_shop_category where activate = 'Active' && c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' limit $start,$limit";
		//print_r($que);

		// 한 페이지당 뿌려줄 게시물 갯수를 정한다.
		$scale=$limit;

		// 한페이지에 보여줄 목록수를 정한다.
		$page_scale=10;

		// 페이지 갯수를 구한다.
		$page=floor($start/($scale*$page_scale));

		// DB QUERY
		$result=mysql_query($que);
		$result_rows=mysql_num_rows($result);

		// 한페이지의 총 게시물 갯수
		$total=mysql_affected_rows();

		// 전체 갯수 구하기
		$total_num_query = mysql_query("select count(*) from chan_shop_category where activate = 'Active' && c_code1 <> '0' && c_code2 = '0' && c_code3 = '0'");
		$total_num = mysql_result($total_num_query,0,0);

		$page_total = $total_num;

		// 전체의 마지막 페이지수 구하기 
		$last=floor($total_num/$scale);

        // 총 줄수
        $total_row = ceil($total/$board_col);

        // 총 페이지수
        $total_page = ceil($total/($board_col*$board_row));

		for($i=0; $i < $total;)
		{
		echo "<tr>";
		if($total < $cols)
			{ 		
			$cols = $total;
			}
				echo "<td width=25%><table border=0 width=100%><tr>";

					if($cols<4)
					{
						$cols = 4;
					}

                 	for($j=0; $j < $cols; $j++,$i++)
						{     
                     	  	$obj = mysql_fetch_array($result);
			
							if($obj[seq_no])
							{
								// 제목 자르기
								//$category_name = Misc::cutLongString($obj[name],10,true);

								// 총 등록 상품 수
								$total_item_count = countProduct($obj[c_code1],$obj[c_code2],$obj[c_code3]);


								// 링크걸기
								$link_url = "/shopping/product_list.php?p_code1=$obj[c_code1]&p_code2=$obj[c_code2]&p_code3=$obj[c_code3]";
								
								echo "<td align=left width=25% style=\"padding-left:10px\">";

								echo  "
								<a href=$link_url><span style=\"font-size:8pt;color:#808080\">$obj[name]</a>
								";
							}

							else
							{
								echo "<td align=left width=25%>";

								echo "";
							}
							echo "</td>";
			  				}

				echo "</tr></table></td>";
		}


	}




	function subStyle($chooseValue){

		global $dbConn,$p_code1,$p_code2;
      

		$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 = '$chooseValue' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);

		$img_url = _WEB_BASE_DIR;

		
		$menu_num = 1;
		

		while($row1 = mysql_fetch_assoc($rst1)){
		
				// 제목 자르기
				//$category_name = Misc::cutLongString($row1[name],10,true);


				$menu_link = "$img_url/shopping/product_list.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]";


				

					//<IMG SRC=$img_url/img/arr_o.gif align=absmiddle>&nbsp;
					//$menu .= "<a href=$link_url>$row1[name]</a><br>";
					if($p_code1 == $row1[c_code1] && $p_code2 == $row1[c_code2])
					{
					$menu .= "<tr>
					  <td height=\"20\">&nbsp;<a href=$menu_link><font color=#FF80C0><b>$row1[name]</b></font></a></td>
					</tr>";
					}
					else
					{
					$menu .= "<tr>
					  <td height=\"20\">&nbsp;<a href=$menu_link><b>$row1[name]</b></a></td>
					</tr>";
					}



				$menu_num++;
				unset($sub_category);
				

		}


		echo $menu;


	}

	/**
	* @ MIDDLE 카테고리 가져오기 subStyle
	*/
	function subCategory($p_code1,$p_code2 = false){

		global $dbConn;
      

		$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 = '$p_code1' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);

		$img_url = _WEB_BASE_DIR;

		$menu_num = 1;
		
		$menu = "";

		while($row1 = mysql_fetch_assoc($rst1)){
		
				// 제목 자르기
				//$category_name = Misc::cutLongString($row1[name],10,true);

				$menu_sidenum = "td".$p_code1.$menu_num;
				$menu_lay = "divSmall".$p_code1.$menu_num;

				$menu_value = $p_code1.$menu_num;


				// 이 상품의 c_code2 값으로 하위 상품 가져오기
				if($p_code2 == $row1[c_code2])
				{
					$qry2 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$p_code1' && c_code2 = '$p_code2' && c_code3 <> '0' order by pos asc";
					//print_r($qry2);
					//$menu_link = "$img_url/shopping/product_first.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]";

					$rst2 = mysql_query($qry2,$dbConn);

					$num2 = 0;

					while($row2 = mysql_fetch_assoc($rst2)){
						

						$sub_category .= "
							<tr><td height=20 style='padding-left:20px'><a href='$img_url/shopping/product_list.php?p_code1=$row2[c_code1]&p_code2=$row2[c_code2]&p_code3=$row2[c_code3]' >$row2[name]</a></td></tr>
								";

						$num2++;

					}
				}

				$seo_url = str_replace(" ","+",$row1[url_link]);

				$menu .= "<li><a href=$seo_url>$row1[name]</a><li>";


				$menu_num++;
				unset($sub_category);
				

		}

		echo $menu;


	}

	function printMainCategory(){


		global $dbConn;
      

		$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1);

		$img_url = _WEB_BASE_DIR;

		$menu_num = 1;
		
		$menu = "";

		while($row1 = mysql_fetch_assoc($rst1)){
		

				$seo_url = str_replace(" ","+",$row1[url_link]);

				$menu .= "<li><a href="._WEB_BASE_DIR."/shop/$seo_url>$row1[name]</a><li>";


				$menu_num++;
				unset($sub_category);
				

		}

		echo $menu;

	}

	/**
	* @ SMALL 카테고리 가져오기
	*/
	function printSmallcategory($p_code1,$p_code2 = false){

		global $dbConn;
      

		// DB에서 한페이지에 보여줄 갯수 구하기
		$board_col = 5;
		$board_row = 5;

		$limit = $board_row*$board_col;
		// 열 갯수 변수치환

		$cols = $board_col;
		// DB접근을 위한 START 값

		if(!$start)
			{
			$start=0;
			}

		/*
		if($p_code2)
		{
			$code2_qry = "&& c_code2 = '$p_code2' && c_code3 = '0'";
		}
		*/

		$que = "select * from chan_shop_category where activate = 'Active' && c_code1 = '$p_code1' && c_code2 <> '0' && c_code3 = '0' limit $start,$limit";
		//print_r($que);

		// 한 페이지당 뿌려줄 게시물 갯수를 정한다.
		$scale=$limit;

		// 한페이지에 보여줄 목록수를 정한다.
		$page_scale=10;

		// 페이지 갯수를 구한다.
		$page=floor($start/($scale*$page_scale));

		// DB QUERY
		$result=mysql_query($que);
		$result_rows=mysql_num_rows($result);

		// 한페이지의 총 게시물 갯수
		$total=mysql_affected_rows();

		// 전체 갯수 구하기
		$total_num_query = mysql_query("select count(*) from chan_shop_category where activate = 'Active' && c_code1 = '$p_code1' && c_code2 <> '0' && c_code3 = '0'");
		$total_num = mysql_result($total_num_query,0,0);

		$page_total = $total_num;

		// 전체의 마지막 페이지수 구하기 
		$last=floor($total_num/$scale);

        // 총 줄수
        $total_row = ceil($total/$board_col);

        // 총 페이지수
        $total_page = ceil($total/($board_col*$board_row));

		for($i=0; $i < $total;)
		{
		echo "<tr>";
		if($total < $cols)
			{ 		
			$cols = $total;
			}
				echo "<td><table border=0 width=100%><tr>";

					if($cols<5)
					{
						$cols = 5;
					}

                 	for($j=0; $j < $cols; $j++,$i++)
						{     
                     	  	$obj = mysql_fetch_array($result);
			
							if($obj[seq_no])
							{
								// 제목 자르기
								$category_name = Misc::cutLongString($obj[name],10,true);

								// 총 등록 상품 수
								$total_item_count = countProduct($obj[c_code1],$obj[c_code2],$obj[c_code3]);


								// 링크걸기
								$link_url = "product_list.php?p_code1=$obj[c_code1]&p_code2=$obj[c_code2]&p_code3=$obj[c_code3]";
								
								echo "<td align=left width=20%>";

								echo  "
								<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"F1ECE6\">
								<tr> 
								  <td height=\"28\" align=\"left\" bgcolor=\"#FFFFFF\" class='t10 letter1px bottom'>&nbsp;&nbsp;<img src=\"../img/arrow_1.gif\" width=3 height=5>&nbsp;<a href=$link_url onfocus=blur()>&nbsp;$category_name ($total_item_count)</a></td>
								</tr>
								</table>
								";
							}

							else
							{
								echo "<td align=left width=20%>";

								echo "
								<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"F1ECE6\">
								<tr> 
								  <td height=\"28\" align=\"center\" bgcolor=\"#FFFFFF\">&nbsp;</td>
								</tr>
								</table>
								";
							}
							echo "</td>";
			  				}

				echo "</tr></table></td>";
		}


	}


	/**
	* @ 카테고리 가져오기
	*/
	function printLeftCategoryNew($p_code1 = false){

		global $dbConn,$choose_lang;

		$qry1 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$p_code1' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);

		$menu_num = 1;
		$img_url = _WEB_BASE_DIR;

		while($row1 = mysql_fetch_assoc($rst1)){


			echo "<td width=\"125\" height=\"25\" style=\"padding-left:13px\" class='sub_menu2'><a href=\"$img_url/shopping/product_list.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]\">$row1[name]</a></td>";

				
			$menu_num++;
			unset($sub_category);
			unset($sub_num);
		}


		return $row1;
	}

	function printLeftCategory_tmp($p_code1 = false, $p_code2 = false){

		global $dbConn;

		$qry1 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);

		$menu_num = 1;
		$img_url = _WEB_BASE_DIR;

		while($row1 = mysql_fetch_assoc($rst1)){

			$qry2 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
			$rst2 = mysql_query($qry2,$dbConn);

			$num = 1;
			while($row2 = mysql_fetch_assoc($rst2)){			
				
				$link = "$img_url/shopping/product_list.php?p_code1=$row2[c_code1]&p_code2=$row2[c_code2]";

				$sub_category .= "<li style=\"background-color:#FFFFFF\" ><a href=$link>$row2[name]</a></li>";

				$num++;
			}


			$sub_num = "sub".$menu_num;




			if($num>1)
			{

				if($row1[c_code1] == $p_code1)
				{
					$view_opt = "";
				}
				else
				{
					//$view_opt = "";
					$view_opt = "style=\"display:none\"";
				}

			echo "<li><a  title=\"$row1[name]\" onclick=\"SwitchMenu('$sub_num');\">$row1[name]</a></li>";

			echo "<li class=\"submenu\" id=\"$sub_num\" $view_opt><ul>$sub_category</ul></li>";
	

			}
			else
			{
			echo "<li><a href=\"$img_url/shopping/product_list.php?p_code1=$row1[c_code1]\" title=\"Category 1\">$row1[name]</a></li>";
			}

				
			$menu_num++;
			unset($sub_category);
			unset($sub_num);
		}


		return $row1;
	}
	function printBrandList_td(){
		
		global $dbConn;

		$img_url = _WEB_BASE_DIR;

		$qry1 = "select * from chan_shop_brand where main_print = 'YES' order by posiNum asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$img_size = @getimagesize("./upload/$row1[userfile1]");

			if($img_size[0]>$img_size[1])
			{
				// 가로가 크다면,
				$width = "width=120";
			}
			else
			{
				$width = "height=75";
			}

			//echo "<option value=$row1[seq_no]>$row1[name]";<a href=$img_url/shopping/product_brand.php?brand=$row1[seq_no]>
			echo "<td bgcolor=#FFFFFF width=100 height=\"90\" align=center style=\"cursor:hand\" onClick=\"javascript:location.replace('$img_url/shopping/product_brand.php?brand=$row1[seq_no]')\" ><img src=./upload/$row1[userfile1] $width></td>";

		}
			

	}

	function printBrandList(){
		
		global $dbConn;

		$img_url = _WEB_BASE_DIR;

		$qry1 = "select * from chan_shop_brand order by name asc";
		$rst1 = mysql_query($qry1,$dbConn);

		while($row1 = mysql_fetch_assoc($rst1)){
			
			//echo "<option value=$row1[seq_no]>$row1[name]";<a href=$img_url/shopping/product_brand.php?brand=$row1[seq_no]>
			echo "<tr><td height=\"25\" background=\"$img_url/images/leftmenu_dot.gif\" style=\"cursor:hand\" onClick=\"javascript:location.replace('$img_url/shopping/product_brand.php?brand=$row1[seq_no]')\" >$row1[name]</td></tr>";

		}
			

	}


	function getCategoryInfo(){

		global $dbConn,$domain;


		$qry1 = "select * from chan_shop_category where name = '$domain' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}

	function printTopcategory(){

		global $dbConn,$domainCategory;


		$qry1 = "select * from chan_shop_category where c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' && activate = 'Active' order by pos asc";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);

		$num = 1;


		while($row1 = mysql_fetch_assoc($rst1))
		{

			if($row1[url_link])
			{
				$row1[url_link] = str_replace(" ","-",$row1[url_link]);
				$link = _WEB_BASE_DIR."/".$row1[url_link];
			}
			else
			{
				$link = _WEB_BASE_DIR."/";
			}

			$qry2 = "select * from chan_shop_category where c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' && activate = 'Active'";
			$rst2 = mysql_query($qry2);
			$num2 = mysql_num_rows($rst2);

			if($num2>0)
			{
				$sub_content = "<div><ul>";
				while($row2 = mysql_fetch_assoc($rst2)){
					

					$qry3 = "select * from chan_shop_category where c_code1 = '$row2[c_code1]' && c_code2 = '$row2[c_code2]' && c_code3 <> '0' && activate = 'Active'";
					$rst3 = mysql_query($qry3);
					$num3 = mysql_num_rows($rst3);

					if($num3>0)
					{
						$third_content = "<div><ul>";
						while($row3 = mysql_fetch_assoc($rst3)){
							
							$row3[url_link] = str_replace(" ","-",$row3[url_link]);
							$link3 = _WEB_BASE_DIR."/products/".$row3[url_link];
							$third_content .= "<li><a href=$link3>$row3[name]</a></li>";

						}
						$third_content .= "</ul></div>";
					}

					$row2[url_link] = str_replace(" ","-",$row2[url_link]);

					$link2 = _WEB_BASE_DIR."/products/".$row2[url_link];

					$sub_content .= "<li><a href=$link2>$row2[name]</a>$third_content</li>";
					unset($third_content);

				}
				$sub_content .= "</ul></div>";
			}

			$link = _WEB_BASE_DIR."/products/".$row1[url_link];
			$content .= "<li><a href=$link>$row1[name]</a>$sub_content</li>";
			unset($sub_content);


			$num++;
		}

	
		return $content;

	}

	function printLeftcategory(){

		global $dbConn,$domainCategory;


		$qry1 = "select * from chan_shop_category where c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' && activate = 'Active' order by pos asc";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);

		$num = 1;


		while($row1 = mysql_fetch_assoc($rst1))
		{

			if($row1[url_link])
			{
				$row1[url_link] = str_replace(" ","-",$row1[url_link]);
				$link = _WEB_BASE_DIR."/".$row1[url_link];
			}
			else
			{
				$link = _WEB_BASE_DIR."/";
			}

			$qry2 = "select * from chan_shop_category where c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' && activate = 'Active'";
			$rst2 = mysql_query($qry2);
			$num2 = mysql_num_rows($rst2);

			if($num2>0)
			{
				$sub_content = "<ul>";
				while($row2 = mysql_fetch_assoc($rst2)){
					

					$qry3 = "select * from chan_shop_category where c_code1 = '$row2[c_code1]' && c_code2 = '$row2[c_code2]' && c_code3 <> '0' && activate = 'Active'";
					$rst3 = mysql_query($qry3);
					$num3 = mysql_num_rows($rst3);

					if($num3>0)
					{
						$third_content = "<ul>";
						while($row3 = mysql_fetch_assoc($rst3)){
							
							$row3[url_link] = str_replace(" ","-",$row3[url_link]);
							$link3 = _WEB_BASE_DIR."/products/".$row3[url_link];
							$third_content .= "<li><a href=$link3>$row3[name]</a></li>";

						}
						$third_content .= "</ul>";
					}

					$row2[url_link] = str_replace(" ","-",$row2[url_link]);
					$link2 = _WEB_BASE_DIR."/products/".$row2[url_link];

					$sub_content .= "<li><a href=$link2>$row2[name]</a>$third_content</li>";
					unset($third_content);

				}
				$sub_content .= "</ul>";
			}
			
			$row1[url_link] = str_replace(" ","-",$row1[url_link]);
			$link = _WEB_BASE_DIR."/products/".$row1[url_link];
			$content .= "<li><a href=$link>$row1[name]</a>$sub_content</li>";
			unset($sub_content);


			$num++;
		}

	
		return $content;

	}

	/**
	* @ 카테고리 가져오기
	*/
	function printLeftCategory2($p_code1 = false, $p_code2 = false, $p_code3 = false){

		global $dbConn;

		if($p_code1 == false)
		{
			$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		}
		else
		{
			$qry1 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$p_code1' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
			
			$big_name = Category_name_member('BIG',$p_code1,'0','0');

			echo "<tr><td height=\"25\" align=center bgcolor=#FFFFFF background=\"$img_url/images/leftmenu_dot.gif\"><b>$big_name</b></td></tr>";
		}

		$rst1 = mysql_query($qry1,$dbConn);
		
		$menu_num = 1;

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$img_url = _WEB_BASE_DIR;

			$menu_sidenum = "td".$menu_num;
			$menu_lay = "divSmall".$menu_num;

			// 이 상품의 c_code2 값으로 하위 상품 가져오기
			if($p_code1 == false)
			{
				$qry2 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
				$menu_link = "$img_url/shopping/product_first.php?p_code1=$row1[c_code1]";
			}
			else
			{
				$qry2 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$p_code1' && c_code2 = '$row1[c_code2]' && c_code3 <> '0' order by pos asc";
				$menu_link = "$img_url/shopping/product_second.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]";
			}

			$rst2 = mysql_query($qry2,$dbConn);

			while($row2 = mysql_fetch_assoc($rst2)){
				
				if($row2[c_code3] == "0")
				{
				$sub_category .= "
					<tr><td width=*><a href='$img_url/shopping/product_second.php?p_code1=$row2[c_code1]&p_code2=$row2[c_code2]' class='sub_menu'>$row2[name]</a></td></tr>
						";
				}
				else
				{
				$sub_category .= "
					<tr><td width=*><a href='$img_url/shopping/product_list.php?p_code1=$row2[c_code1]&p_code2=$row2[c_code2]&p_code3=$row2[c_code3]' class='sub_menu'>$row2[name]</a></td></tr>
						";
				}

			}

			if($sub_category)
			{
				$sub_ok = "onMouseover=\"javascript: openDiv($menu_num);this.style.backgroundColor='#990000'\" onMouseout=\"javascript: closeDiv($menu_num);this.style.backgroundColor=''\"";
			}
			else
			{
				$sub_ok = "onMouseover=\"this.style.backgroundColor='#990000';\" onMouseout=\"this.style.backgroundColor=''\"";
			}
			
			if($p_code1 == $row1[c_code1] && $p_code2 == $row1[c_code2])
			{
				$this_icon = "<img src=$img_url/img/arr_o.gif align=absmiddle>";
			}
			else
			{
				$this_icon = "";
			}
			// 990000
			echo "
				<tr $sub_ok style=\'cursor: hand\' >
				  <td height=\"25\" id=$menu_sidenum style=\"cursor:hand\" onClick=\"javascript:location.replace('$menu_link')\" background=\"$img_url/images/leftmenu_dot.gif\" >$this_icon&nbsp;$row1[name]
					<div id=$menu_lay style='position: absolute; z-index: 1; left: 0 px; margin:-10 0 0 380; filter: alpha(opacity=95);  visibility: hidden; overflow: hidden;'>
					<table width='137' cellpadding='0' cellspacing='0' border='0'>
					<tr><td width='9' background='$img_url/img/ca_bg.gif' valign='top'>
						<td width='128' colspan='2'><img src='$img_url/img/ca_top.gif'><br></td>
					</tr>
					<tr><td width='9' background='$img_url/img/ca_bg.gif' valign='top'>
							<img src='$img_url/img/ca_mid.gif'>
						</td>
						<td width='137' bgcolor='#FFFFF6' align=center>
								<table width=80% border=0 cellspacing=0 cellpadding=1 valign=top>
								$sub_category
								</table>
						</td>
						<td width='1' bgcolor='#D2D2D2'></td>
					</tr>
					<tr><td width='9' background='$img_url/img/ca_bg.gif' valign='top'>
						<td colspan='2'><img src='$img_url/img/ca_bom.gif'><br></td></tr>
					</table>
					</div>
					</td>
				</tr>
				";

			$menu_num++;
			unset($sub_category);
		}


		return $row1;
	}


	/**
	* @ 카테고리 가져오기
	*/
	function printLeftCategory3($p_code1 = false){

		global $dbConn;


		$qry1 = "select * from chan_shop_category where activate = 'Active' && c_code1 <> '0' && c_code2 = '0' && c_code3 = '0' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$menu_num = 1;

		while($row1 = mysql_fetch_assoc($rst1)){
			
			$img_url = _WEB_BASE_DIR;

			$menu_sidenum = "td".$menu_num;
			$menu_lay = "divSmall".$menu_num;

			// 이 상품의 c_code2 값으로 하위 상품 가져오기
			if($p_code1 == false)
			{
				$qry2 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$row1[c_code1]' && c_code2 <> '0' && c_code3 = '0' order by pos asc";
				$menu_link = "$img_url/shopping/product_first.php?p_code1=$row1[c_code1]";
			}
			else
			{
				$qry2 = "select * from chan_shop_category where activate = 'Active' &&  c_code1 = '$p_code1' && c_code2 = '$row1[c_code2]' && c_code3 <> '0' order by pos asc";
				$menu_link = "$img_url/shopping/product_second.php?p_code1=$row1[c_code1]&p_code2=$row1[c_code2]";
			}

			$rst2 = mysql_query($qry2,$dbConn);

			while($row2 = mysql_fetch_assoc($rst2)){
				
				if($row2[c_code3] == "0")
				{
				$sub_category .= "
					<tr><td width=*><a href='$img_url/shopping/product_second.php?p_code1=$row2[c_code1]&p_code2=$row2[c_code2]'>$row2[name]</a></td></tr>
						";
				}
				else
				{
				$sub_category .= "
					<tr><td width=*><a href='$img_url/shopping/product_list.php?p_code1=$row2[c_code1]&p_code2=$row2[c_code2]&p_code3=$row2[c_code3]'>$row2[name]</a></td></tr>
						";
				}

			}

			if($sub_category)
			{
				$sub_ok = "onMouseover=\"javascript: openDiv($menu_num);this.style.backgroundColor='#990000'\" onMouseout=\"javascript: closeDiv($menu_num);this.style.backgroundColor=''\"";
			}
			else
			{
				$sub_ok = "onMouseover=\"this.style.backgroundColor='#990000';\" onMouseout=\"this.style.backgroundColor=''\"";
			}

			if($p_code1 == $row1[c_code1])
			{
				$this_icon = "<img src=$img_url/img/arr_o.gif align=absmiddle>";
			}
			else
			{
				$this_icon = "";
			}

			echo "
				<tr $sub_ok style=\'cursor: hand\' >
				  <td height=\"25\" id=$menu_sidenum style=\"cursor:hand\" onClick=\"javascript:location.replace('$menu_link')\" background=\"$img_url/images/leftmenu_dot.gif\" >$this_icon&nbsp;$row1[name]</td>
				</tr>
				";

			$menu_num++;
			unset($sub_category);
		}


		return $row1;
	}


	/**
	* @ 오더 넘버로 오더 정보 가져오기
	*/
	function get_orderinfo($orderNum){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_orderinfo where orderNum = '$orderNum'";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}



	function get_orderinfo_temp($orderNum){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_orderinfo where temp_order = '$orderNum'";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}

	function fedexProcess($orderNum,$total_weight,$path){

		global $dbConn,$base_info,$_SESSION;

				$temp_order_info = get_orderinfo_temp($orderNum);


				include $path.'/fedex/library/fedex-common.php';

				//The WSDL is not included with the sample code.
				//Please include and reference in $path_to_wsdl variable.
				$path_to_wsdl = $path."/fedex/library/RateService_v14.wsdl";

				ini_set("soap.wsdl_cache_enabled", "0");
				 


				$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information


				$lbs_weight = ceil($total_weight/16);

				$request['WebAuthenticationDetail'] = array(
					'UserCredential' => array(
						'Key' => getProperty('key'), 
						'Password' => getProperty('password')
					)
				); 
				$request['ClientDetail'] = array(
					'AccountNumber' => getProperty('shipaccount'), 
					'MeterNumber' => getProperty('meter')
				);
				$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Available Services Request v14 using PHP ***');
				$request['Version'] = array(
					'ServiceId' => 'crs', 
					'Major' => '14', 
					'Intermediate' => '0', 
					'Minor' => '0'
				);
				$request['ReturnTransitAndCommit'] = true;
				$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
				$request['RequestedShipment']['ShipTimestamp'] = date('c');
				// Service Type and Packaging Type are not passed in the request
				$request['RequestedShipment']['Shipper'] = array(
					'Address'=>array(
					'StreetLines' => array('226 ROFF AVE'),
					'City' => 'Palisades Park',
					'StateOrProvinceCode' => 'NJ',
					'PostalCode' => '07650',
					'CountryCode' => 'US'
				)
				);


				if($temp_order_info[ship_country] == "US")
				{
						$request['RequestedShipment']['Recipient'] = array(
							'Address'=>array(
							'StreetLines' => array($temp_order_info[ship_address1]),
							'City' => $temp_order_info[ship_city],
							'StateOrProvinceCode' => $temp_order_info[ship_state],
							'PostalCode' => $temp_order_info[ship_zipcode],
							'CountryCode' => $temp_order_info[ship_country],
							'Residential' => 0
						)
						);
				}
				else
				{
						$request['RequestedShipment']['Recipient'] = array(
							'Address'=>array(
							'PostalCode' => $temp_order_info[ship_zipcode],
							'CountryCode' => $temp_order_info[ship_country],
							'Residential' => 0
						)
						);

				}

				$request['RequestedShipment']['ShippingChargesPayment'] = array(
					'PaymentType' => 'SENDER',
					'Payor' => array(
						'ResponsibleParty' => array(
							'AccountNumber' => getProperty('billaccount'),
							'Contact' => null,
							'Address' => array(
								'CountryCode' => 'US'
							)
						)
					)
				);		
				//$request['RequestedShipment']['ServiceType'] = 'FEDEX_GROUND';
				$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
				$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
				$request['RequestedShipment']['PackageCount'] = '2';
				$request['RequestedShipment']['RequestedPackageLineItems'] = array(
					'0' => array(
						'SequenceNumber' => 1,
						'GroupPackageCount' => 1,
						'Weight' => array(
							'Value' => $lbs_weight,
							'Units' => 'LB'
						)
					)
				);



				try {
					if(setEndpoint('changeEndpoint')){
						$newLocation = $client->__setLocation(setEndpoint('endpoint'));
					}
					
					$response = $client ->getRates($request);
					   
					$fedexRate = "";

					//PRINT_R($response);
					// 
					if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR' && $response -> HighestSeverity != 'WARNING'){
						//echo 'Rates for following service type(s) were returned.'. Newline. Newline;
						
						//$fedexRate .= '<table border="1">';
						//$fedexRate .= '<tr><td>Service Type</td><td>Amount</td>';

						if(is_array($response -> RateReplyDetails)){
							foreach ($response -> RateReplyDetails as $rateReply){
								$fedexRate .= printRateReplyDetails($rateReply);
							}
						}else{
							$fedexRate .= printRateReplyDetails($response -> RateReplyDetails);          
						}




					}else{

						if($temp_order_info['shipping_method'] == "FEDEX_GROUND_TMP")
						{
							$fedexRate = "<tr><td colspan=2><label><input type=radio name=shipping_method id=\"optionsRadios99\" value=\"9@FEDEX_GROUND_TMP@0\" checked>&nbsp;Currently FeDex can't calculate accurate shipping rate to this destination.</label></td></tr>";
						}
						else
						{
							$fedexRate = "<tr><td colspan=2><label><input type=radio name=shipping_method id=\"optionsRadios99\" value=\"9@FEDEX_GROUND_TMP@0\" >&nbsp;FEDEX</label></td></tr><tr><td colspan=2>Currently FeDex/USPS can't calculate accurate shipping rate to this destination. Response : Due to shipping policy of certain countries/destination.</td></tr>";
						}
						
						$fedexRate = "";

						/*
						if($_SESSION['user_id'] == "100798")
						{
							$fedexRate .= "<tr><td>".$response -> HighestSeverity."</td></tr><tr><td>".printError($client, $response)."</td></tr>";
							printError($client, $response); 
						}
						*/
					} 
					
					//writeToLog($client);    // Write to log file   
				} catch (SoapFault $exception) {
				   //printFault($exception, $client);        
				$fedexRate = "<tr><td colspan=2><label><input type=radio name=shipping_method id=\"optionsRadios99\" value=\"9@FEDEX_GROUND_TMP@0\" >&nbsp;Currently FeDex can't calculate accurate shipping rate to this destination.</label></td></tr>";
				$fedexRate = "";
				}

			return $fedexRate;
	}
	// fedex func
	function printRateReplyDetails($rateReply,$shipNum = false){

		global $temp_order_info,$base_info;

		// 배송비 최소금액: $base_info['ship_minium_price'];
		// 배송비 핸들링피%: $base_info['ship_handling_price'];
		// 배송비 FLAT 마진: $base_info['ship_margin_price'];
		
		$insurance_amt = 0;


		$fedex_origin_price = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;



		// FEDEX LAST AMOUNT
		$fedex_calculated_price = $fedex_origin_price;

		switch($rateReply -> ServiceType)
		{
			case "PRIORITY_OVERNIGHT":
				$service_minium = "24.95";
				break;
			case "STANDARD_OVERNIGHT":
				$service_minium = "21.95"; 
				break;
			case "FEDEX_2_DAY_AM":
				$service_minium = "18.95";
				break;
			case "FEDEX_2_DAY":
				$service_minium = "16.95";
				break;
			case "FEDEX_EXPRESS_SAVER":
				$service_minium = "13.95";
				break;
			case "FEDEX_GROUND":
				$service_minium = "10.95";
				break;
			default:
				$service_minium = "20";
				break;
		}

		if($service_minium>$fedex_calculated_price)
		{
			// flat_addtion_charge
			$fedex_price = sprintf("%.2f",$service_minium);
		}
		else
		{

			$fedex_price = sprintf("%.2f",$fedex_calculated_price);
		}


		/*
		if(@array_key_exists('DeliveryTimestamp',$rateReply)){
        	$deliveryDate= $rateReply->DeliveryTimestamp;
        }else if(@array_key_exists('TransitTime',$rateReply)){
        	$deliveryDate= $rateReply->TransitTime;
        }else {
        	$deliveryDate='&nbsp;';
        }
		*/


		if($rateReply -> ServiceType != 'FIRST_OVERNIGHT')
		{
			
			$serviceType_msg = str_replace("_"," ",$rateReply -> ServiceType);

			if(($temp_order_info[ship_country] == "CA" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "PR" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "VI" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "GU" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "AS" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "MP" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "AK" && $rateReply -> ServiceType == 'FEDEX_GROUND') || ($temp_order_info[ship_state] == "HI" && $rateReply -> ServiceType == 'FEDEX_GROUND'))
			{
				$data = '';
			}
			else
			{

					if($temp_order_info[shipping_method] == $rateReply -> ServiceType)
					{
						$data = '<tr>';
						$serviceType = '<td><label><input type=radio name=shipping_method id="optionsRadios'.$shipNum.'" checked value="1@'.$rateReply -> ServiceType.'@'.$fedex_price.'" >&nbsp;'.$serviceType_msg . '&nbsp</lable></td><td>&nbsp;</td>';
						$amount = '<td align=center>$' . $fedex_price . '</td>';
						$data .= $serviceType . $amount;
						$data .= '</tr>';

					}
					else
					{
						$data = '<tr>';
						$serviceType = '<td><label><input type=radio name=shipping_method id="optionsRadios'.$shipNum.'" value="1@'.$rateReply -> ServiceType.'@'.$fedex_price.'" >&nbsp;'.$serviceType_msg . '&nbsp</lable></td><td>&nbsp;</td>';
						$amount = '<td align=center>$' . $fedex_price . '</td>';
						$data .= $serviceType . $amount;
						$data .= '</tr>';
					}

			}

		
		}


		return $data;
	}

	function printRateReplyDetails_noselect($rateReply,$shipNum = false){

		global $temp_order_info;

		if($rateReply -> ServiceType != 'FIRST_OVERNIGHT')
		{


				$data = '<tr>';
				$serviceType = '<td><label><input type=radio name=shipping_method id="optionsRadios'.$shipNum.'" value="1@'.$rateReply -> ServiceType.'@'.$rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount.'" >&nbsp;FEDEX&nbsp;'.$rateReply -> ServiceType . '</lable></td>';
				$amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
				$data .= $serviceType . $amount;
				$data .= '</tr>';



		}


		return $data;
	}

	function get_total_weight($orderNum){
		
		global $dbConn;

		$qry1 = "select sum(order_qty*item_weight) from chan_shop_orderproduct where orderNum = '$orderNum'";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = @mysql_result($rst1,0,0);

		if(empty($row1) || $row1 == "0.00")
		{
			$row1 = "5";
		}

		return $row1;
	}


	/**
	* @ 아이디로 오더 주소기록 가져오기
	*/
	function check_oldhistory(){
		
		global $dbConn,$user_info;

		$qry1 = "select * from chan_shop_orderinfo where user_id = '$user_info[user_id]' order by seq_no desc limit 1";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}

	/**
	* @ 오더 넘버로 오더 정보 가져오기
	*/
	function get_agorderinfo($orderNum){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_agorderinfo where orderNum = '$orderNum'";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}

	function printMainProduct($flag){
		
		global $base_info;

		$qry1 = "select * from chan_shop_mainitem where view_position = '$flag' order by pos asc";
		$rst1 = mysql_query($qry1);

		while($row1 = mysql_fetch_assoc($rst1)){
		

		$row = get_iteminfo($row1[itemCode]);
		if($row[userfile1])
			{
				$userfile1 = _WEB_BASE_DIR."/productimages/".$row[userfile1];
			}
		else
			{
				$userfile1 = _WEB_BASE_DIR."/images/sample.jpg";
			}

		$item_url = str_replace(" ","+",$row[item_url]);
		$product_link = _WEB_BASE_DIR."/details/$item_url";

		switch($row[item_icon])
			{
				case "NEW":
					$add_icon = "<span class=\"sale-text new-sale\">NEW</span>";
					break;
				case "HOT":
					$add_icon = "<span class=\"sale-text\">HOT</span>";
					break;
				case "SALE":
					$add_icon = "<span class=\"sale-text\">SALE</span>";
					break;
			}

		if($row[item_price2]>0)
			{
				$price = "<span class=\"old-price\">$$row[item_price1]</span><span class=\"new-price\">$$row[item_price2]</span>";
				$jyp_price = "<span class=\"old-price\">￥".number_format($row[item_price1]*$base_info[currency])."</span><span class=\"new-price\">￥".number_format($row[item_price2]*$base_info[currency])."</span>";
			}
		else
			{
				$price = "<span class=\"new-price\">$$row[item_price1]</span>";
				$jyp_price = "<span class=\"new-price\">￥".number_format($row[item_price1]*$base_info[currency])."</span>";
			}


		$s_qry1 = "select sum(rate1+rate2+rate3), count(*) from chan_shop_product_rate where item_code = '$row[item_code]'";
		$s_rst1 = mysql_query($s_qry1);
		$s_sum1 = @mysql_result($s_rst1,0,0);
		$s_cnt1 = @mysql_result($s_rst1,0,1);

		$rate_ave = 5*($s_sum1/15*$s_cnt1);

		for($star=1; $star<6;$star++)
		{
			if($star>$rate_ave)
			{
				$star_icon .= "<i class=\"fa fa-star-o\"></i>&nbsp;";
			}
			else
			{
				$star_icon .= "<i class=\"fa fa-star\"></i>&nbsp;";
			}
		}

		$row[item_title] = SUBSTR($row[item_title],0,8);

		$content .= "
						<div class=\"col-lg-3 col-md-3 col-sm-3 col-xs-12\">
							<div class=\"single-product\">
								<div class=\"product-img\">
									$add_icon
									<a href=\"$product_link\">
										<img class=\"primary-img\" src=\"$userfile1\" alt=\"\" width=400 height=400>
										<img class=\"secondary-img\" src=\"$userfile1\" alt=\"\" width=400 height=400>
									</a>
									<div class=\"add-action\">
										<ul>
											<li><a href=\"javascript:add_cart('wish','$row[item_code]','regular')\" data-toggle=\"tooltip\" title=\"Add to Wishlist\"><i class=\"fa fa-heart-o\"></i></a></li>
											<li class=\"quickview\"><a data-toggle=\"tooltip\" href=\"$product_link\" title=\"Detail View\"><i class=\"fa fa-eye\"></i></a></li>
										</ul>
									</div>
								</div>
								<div class=\"product-details\">
									<div class=\"ratings no-rating\">
										<ul>
											$star_icon
										</ul>
									</div>
									<div class=\"product-name\">
										<h3><a href=\"$product_link\">$row[item_title]</a></h3>
									</div>
									<div class=\"price-box\">
										$price
									</div>
									<div class=\"price-box\">
										$jyp_price
									</div>
								</div>

							</div>
						</div>";
			
			unset($star_icon);

		}
		


		return $content;
	}


	/**
	* @상품 뿌려주기 펑션 - 리스트형식
	*/
	function printProductBest($best_flag,$last_row,$p_code1 = false,$p_code2 = false){

		global $total,$cols,$result,$flag,$start,$scale,$page_scale,$page,$total_page,$limit,$page_total,$p_code1,$p_code2,$p_code3,$base_info;
      
		/**
		* 게시판 시작
		*/
		$tableName = "chan_shop_mainitem";

		// DB에서 한페이지에 보여줄 갯수 구하기
		$board_col = 4;
		$board_row = 20;

		$limit = $board_row*$board_col;
		// 열 갯수 변수치환

		$cols = $board_col;

		// DB접근을 위한 START 값

		if(!$start)
			{
			$start=0;
			}

		$move_start = $start;
		
		if(empty($Sort))
		{
			$Sort = "new";
		}

		switch($Sort)
		{
			case "new":
				$sort_qry = "order by seq_no desc";
				break;
			case "good":
				$sort_qry = "order by count desc";
				break;
			case "high_price":
				$sort_qry = "order by item_price desc";
				break;
			case "low_price":
				$sort_qry = "order by item_price asc";
				break;
			case "sale":
				$sort_qry = "order by item_sale<>'0' desc";
				break;
		}


		if($p_code1)
		{
			$code_qry1 = "&& A.p_code1 = '$p_code1'";
		}
		
		if($p_code2)
		{
			$code_qry2 = "&& A.p_code2 = '$p_code2'";
		}

		$que = "select A.* from $tableName as A, chan_shop_product as B where A.itemCode = B.item_code && B.print_option ='YES' && A.view_position = '$best_flag' $code_qry1 $code_qry2 order by A.seq_no desc limit $start,$limit";
		//print_r($que);

		// 한 페이지당 뿌려줄 게시물 갯수를 정한다.
		$scale=$limit;

		// 한페이지에 보여줄 목록수를 정한다.
		$page_scale=10;

		// 페이지 갯수를 구한다.
		$page=@floor($start/($scale*$page_scale));

		// DB QUERY
		$result=@mysql_query($que);
		$result_rows=@mysql_num_rows($result);

		// 한페이지의 총 게시물 갯수
		$total=mysql_affected_rows();

		// 전체 갯수 구하기
		$total_num_query = mysql_query("select count(A.*) from $tableName as A, chan_shop_product as B where A.itemCode = B.item_code && B.print_option ='YES' && A.view_position = '$best_flag' $code_qry1 $code_qry2");
		$total_num = @mysql_result($total_num_query,0,0);

		$page_total = $total_num;

		// 전체의 마지막 페이지수 구하기 
		$last=@floor($total_num/$scale);

        // 총 줄수
        $total_row = ceil($total/$board_col);

        // 총 페이지수
        $total_page = @ceil($total/($board_col*$board_row));

		for($i=0; $i < $total;)
		{
		echo "<tr>";
		if($total < $cols)
			{ 		
			$cols = $total;
			}
				echo "<td><table align=center border=0 width=100%><tr>";

					if($cols<4)
					{
						$cols = 4;
					}

                 	for($j=0; $j < $cols; $j++,$i++)
						{     
							echo "<td align=center width=25% valign=top>";
                     	  	$obj = mysql_fetch_array($result);
			
							if($obj[seq_no])
							{
								// 상품정보 가져오기
								$item_info = get_iteminfo($obj[itemCode]);

								$item_info[userfile1] = get_firstpic($item_info[userfile1]);
								$file_name = "thum_".$item_info[userfile1];

								$img_url = _WEB_BASE_DIR;
								if($item_info[userfile1])
									{
										$file_image = "<img src=\"$img_url/thum_upload/$file_name\" border=0 style='border-color=#CCCCCC' alt='$item_info[item_title]'>";
									}
								else
									{
										$file_image = "<font style='color:#CCCCCC'>No images</font>";
									}

								// 제목 자르기
								$item_info[item_title] = Misc::cutLongString($item_info[item_title],22,true);

								// 브랜드 명
								$brand_name = brand_name($item_info[brand]);


								// 가격 명
								$item_price = get_itemPricehistory($obj[itemCode]);

								if($item_price[item_save])
								{
									$credit_view = "Credit:$item_price[item_save_msg]";
								}
								else
								{
									$credit_view = "";
								}

								if($item_info[item_stock] == "Out")
								{
									$stock_icon = "<img src=$img_url/images/out-of-stock.gif align=absmiddle>";
								}
								else
								{
									$stock_icon = "";
								}

								if($item_info[item_icon])
								{
									$icon = "<img src=$img_url/img/icon01.gif align=absmiddle>";
								}
								else
								{
									$icon = "";
								}

								// 링크걸기
								$link_url = _WEB_BASE_DIR."/shopping/product_view.php?itemCode=$item_info[item_code]";

								echo  "
								<table width=\"160\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
								<tr> 
								  <td height=\"150\" align=\"center\" valign=\"middle\" ><a href=$link_url>$file_image</a></td>
								</tr>
								</table>
								<table width=\"160\" align=center border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
									<tr> 
									  <td height=\"20\" align=\"center\"><b>$item_info[item_title]</b></td>
									</tr>
								  </table>
								";
							}
							else
							{
								echo "
								<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
								<tr> 
								  <td height=\"100\" align=\"center\" valign=\"middle\" >&nbsp;</td>
								</tr>
								</table>
								<table width=\"100%\" align=center border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
									<tr> 
									  <td height=\"20\" align=\"center\">&nbsp;</td>
									</tr>
								  </table>
								";
							}

						echo "</td>";
			  			}

				echo "</tr></table></td>";

				echo "</tr>
				<tr><td>
			  <table width=10% border=0 cellspacing=0 cellpadding=0>
				<tr> 
				  <td height=15></td>
				</tr>
			  </table>
			  </td></tr>	
				";
		}

		if($total == "0")
			{
				echo "<tr><td height=100 align=center><table width=100% border=0 cellspacing=0 cellpadding=0 class=\"dot_point\"><tr><td height=150 align=center>Nothing Found.</td></tr></table></td></tr>";
			}
	}

	// 갯수 세기
	function countProduct($p_code1 = false, $p_code2 = false, $p_code3 = false)
	{
		global $dbConn;

		if($p_code2)
		{
			$p_qry2 = "&& p_code2 = '$p_code2'";
		}

		if($p_code3)
		{
			$p_qry3 = "&& p_code3 = '$p_code3'";
		}

		$qry1 = "select count(distinct(item_code)) from chan_shop_c_product where print_option = 'YES' && p_code1 = '$p_code1' $p_qry2 $p_qry3";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$result1 = mysql_result($rst1,0,0);

		return $result1;
	}

	/*
	* @ Gift 펑션
	*/
	function get_orderinfo_gift($orderNum){
		
		global $dbConn;

		$qry1 = "select * from chan_shop_gift where orderNum = '$orderNum'";
		$rst1 = mysql_query($qry1,$dbConn);

		$row1 = mysql_fetch_assoc($rst1);

		return $row1;
	}
?>