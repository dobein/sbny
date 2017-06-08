<?
	include "./include/inc_base.php";

	$seo_value = explode("@",$item);

	$category_value = explode("_",$seo_value[0]);
	$p_code1 = $category_value[0];
	$p_code2 = $category_value[1];

	$item_title = str_replace("_"," ",$seo_value[1]);
	//echo "<br>";

	//$qry1 = "select * from chan_shop_product where item_url = '$item'";
	
	$t_qry1 = "select * from chan_shop_product where item_url like '%$item_title%' order by seq_no desc limit 1";
	//print_r($t_qry1);
	$t_rst1 = mysql_query($t_qry1);
	$t_row1 = mysql_fetch_assoc($t_rst1);


	$itemCode = $t_row1[item_code];


	   //$URL = _WEB_BASE_DIR ."/shopping/product_list.php?p_code1=$p_code1&p_code2=$p_code2&p_code3=0";

	   $URL = _WEB_BASE_DIR ."/shopping/product_view.php?itemCode=$itemCode&seqNo=$seqNo&start=0";
	   $URL = urlencode($URL); 

	$img_url = _WEB_BASE_DIR;


	/**
	* @ 오늘 본 상품 등록
	*/
	putTodayView($itemCode);


	/**
	* @상품정보
	*/
	$item_info = get_iteminfo($itemCode);


	$item_cinfo = get_itemcategory($itemCode);

	if(empty($p_code1))
	{
		$p_code1 = $item_cinfo[p_code1];
	}

	if(empty($p_code2))
	{
		$p_code2 = $item_cinfo[p_code2];
	}

	if(empty($p_code3))
	{
		$p_code3 = $item_cinfo[p_code3];
	}


	if($item_info[item_stock] == "Out")
	{
		$order_possible = "NO";
	}
	else
	{
		$order_possible = "YES";
	}

	if($item_info[print_option] == "NO")
	{
		Misc::jvAlert("Please contact admin.","history.go(-1)");
		exit;
	}


	/**
	* @ 상품 가격가져오기
	* @ array ( sale_msg / sale_price )
	*/
	$item_price = get_itemPricehistory($itemCode);


	/**
	* @ 콤보상품있는지 검색하기
	*/
	$combo_qry1 = "select * from chan_shop_comboitem where item_code = '$itemCode'";
	$combo_rst1 = mysql_query($combo_qry1,$dbConn);
	
	$combo_num1 = 1;

	while($combo_row1 = mysql_fetch_assoc($combo_rst1)){
	
		//$combo_row1[item_code]
		// 콤보 정보
		$combo_qry2 = "select * from chan_shop_combo where combo_no = '$combo_row1[combo_no]'";
		$combo_rst2 = mysql_query($combo_qry2,$dbConn);
		$combo_row2 = mysql_fetch_assoc($combo_rst2);

		// 상품 리스팅
		$combo_qry3 = "select * from chan_shop_comboitem where combo_no = '$combo_row1[combo_no]'";
		$combo_rst3 = mysql_query($combo_qry3,$dbConn);
		while($combo_row3 = mysql_fetch_assoc($combo_rst3)){
			
			$combo_item_info = get_iteminfo($combo_row3[item_code]); 

			if($combo_item_info[userfile1])
			{
				$first_pic = "<img border=1 style='border-color=#CCCCCC' src='/thum_upload/thum_".get_firstpic($combo_item_info[userfile1])."' width=50 >";
			}
			else
			{
				$first_pic = "No image";
			}

			$combo_item_gallery .= "<td width=75 height=50 align=center>$first_pic</td><td width=12></td>";

		}


		$combo_result .= "<tr><td bgcolor=#f4f4f4 class='black t7 letter1px' width=50%>&nbsp;<a href=combo_product.php?combo_no=$combo_row2[combo_no]>$combo_row2[combo_name]</a> &nbsp;&nbsp;</td><td width=50% bgcolor=#f4f4f4 class='black t7 letter1px' align=right><font class='t7 blue'><u><b>Combo Price : $$combo_row2[combo_price]</b></u></font>&nbsp;&nbsp;<a href=combo_product.php?combo_no=$combo_row2[combo_no]>Detail view...</a>&nbsp;&nbsp;</td></tr><tr><td colspan=2 height=1 bgcolor=#f4f4f4></td></tr><tr><td height=50 colspan=2><table border=0 ><tr>$combo_item_gallery</tr></table></td></tr><tr><td colspan=2 height=1 bgcolor=#f4f4f4></td></tr>";

		unset($combo_item_gallery);
		$combo_num1++;

	}




	/**
	* 상품 사진 뿌려주기
	*/
	$first_picture = get_firstpic($item_info[userfile1]);

	$file_name = "list_".get_firstpic($item_info[userfile1]);

	$photo_count = count(explode("NaN",$item_info[userfile1]));

	$img_size = @getimagesize("./upload/$first_picture");

	if($img_size[0]>$img_size[1])
	{
		// 가로가 길면 가로를 줄여야함
		if($img_size[0]>339)
		{
			$image_size = "width=339";
		}
		else
		{
			$image_size = $img_size[0];
		}
	}
	else
	{
		// 세로가 기니.. 세로를 확 줄여야지
		if($img_size[1]>400)
		{
			$image_size = "height=400";
		}
		else
		{
			$image_size = $img_size[1];
		}
	}



	if($first_picture)
	{
		$main_first_picture = "<a href=\"$img_url/upload/$first_picture\" class=\"jqzoom\" rel='gal1'  title=\"$item_info[model_no]\" ><img align=center src=\"$img_url/thum_upload/main_$first_picture\" name=main_img id=\"image1\" title=\"$item_info[model_no]\" border=0 width=336 height=596></a>";
	}
	else
	{
		$main_first_picture = "<img src=\"$img_url/img/noimage.jpg\" name=main_img border=0>";
	}

	function print_thumimg($image){
		
		global $img_url,$itemCode;

		$photo_arr = explode("NaN",$image);

		$total_tr = count($photo_arr)-1;

		$k = 0;
		for($m=0; $m<$total_tr; $m++)
		{
				$imgName = 2;


					if($photo_arr[$m])
					{

					$z = $p + 2;

					$zoom = "zoom".$z;

					$img_size = @getimagesize("/upload/$photo_arr[$k]");

					//class = 'cloud-zoom' id=$zoom rel='adjustX: 10, adjustY:-4'

					$imgNameValue = "image".$imgName;

					if($p == 0)
						{
						$classValue = "class=\"zoomThumbActive\"";
						}
					else
						{
						$classValue = "";
						}

					// <a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: './imgProd/triumph_small2.jpg',largeimage: './imgProd/triumph_big2.jpg'}">
					//<a href=\"javascript:pic_view2('$itemCode','$photo_arr[$k]','$img_size[0]','$img_size[1]')\" >
					echo "<li><a href='javascript:void(0);' rel=\"{gallery: 'gal1', smallimage: '$img_url/thum_upload/main_$photo_arr[$k]',largeimage: '/upload/$photo_arr[$k]'}\"><img src=\"$img_url/thum_upload/thum_".$photo_arr[$k]."\" style=\"border:1px soild #000;\" height=100></a></li>";
					}

					$k++;
					$imgName++;


		}
	
	}


	/**
	* @상품 뿌려주기 펑션 - 리스트형식
	*/
	$r_que = "select seq_no from chan_shop_relation where flag = 'Relation' && itemCode = '$itemCode'";
	$r_rst = mysql_query($r_que,$dbConn);
	$r_num = mysql_num_rows($r_rst);

	$c_que = "select seq_no from chan_shop_relation where flag = 'Competition' && itemCode = '$itemCode'";
	$c_rst = mysql_query($c_que,$dbConn);
	$c_num = mysql_num_rows($c_rst);

	function printRelation($view_opt,$itemCode){

		global $total,$cols,$result,$flag,$start,$scale,$page_scale,$page,$total_page,$limit,$page_total,$p_code1,$p_code2,$p_code3,$base_info,$user_dbinfo;
      
		/**
		* 게시판 시작
		*/
		$tableName = "chan_shop_relation";

		// DB에서 한페이지에 보여줄 갯수 구하기
		$board_col = 4;
		$board_row = 10;

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

		$que = "select * from $tableName where flag = '$view_opt' && itemCode = '$itemCode' group by relationCode limit 0,50";
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
		$total_num_query = mysql_query("select count(distinct(relationCode)) from $tableName where flag = '$view_opt' && itemCode = '$itemCode'");
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
				echo "<td valign=top><table width=100%><tr>";

                 	for($j=0; $j < $cols; $j++,$i++)
						{     
							echo "<td width=25% align=left valign=top>";
                     	  	$obj = mysql_fetch_array($result);
			
							if($obj[seq_no])
							{
								// 상품정보 가져오기
								$item_info = get_iteminfo($obj[relationCode]);

								$img_name = get_firstpic($item_info[userfile1]);

								$file_name = "list_".$img_name;
								$file_name_main = "main_".$img_name;
								$file_name_thum = "thum_".$img_name;
								$file_name_big = $img_name;


								$item_info[item_title] = Misc::cutLongString($item_info[item_title], 200, $dot=true);


								$img_size = @getimagesize("/upload/$img_name");

								if($img_size[0]>$img_size[1])
								{
									// 가로가 길면 가로를 줄여야함
									if($img_size[0]>160)
									{
										$image_size = "width=160";
									}
									else
									{
										$image_size = $img_size[0];
									}
								}
								else
								{
									// 세로가 기니.. 세로를 확 줄여야지
									if($img_size[1]>200)
									{
										$image_size = "height=200";
									}
									else
									{
										$image_size = $img_size[1];
									}
								}

								$item_info[item_url] = htmlspecialchars($item_info[item_url]);

								$seo_name = str_replace(" ","_",$item_info[item_url]);
								$seo_link = "/scarf/wholesale/".$p_code1."_".$p_code2."@".$seo_name;


								//217 257
								if($item_info[userfile1])
									{
										$file_image = "<table width=100% height=130 border=0 cellpadding=0 cellspacing=0><tr><td ><a href=$seo_link><img src=\"/thum_upload/$file_name_thum\" $image_size alt=\"$item_info[item_title]\" width=100 border=1 style='border-color:#dcdcdc;' style=\"cursor:hand\"></a></td></tr></table>";
									}
								else
									{
										$file_image = "<table width=100% height=130 border=0 cellpadding=0 cellspacing=1><tr><td align=center ><a href=$seo_link><img src=\"/images/no_image.gif\" border=0 alt=\"$item_info[item_title]\" height=75 style=\"cursor:hand\" border=0></a></td></tr></table>";
									}

								// 제목 자르기
								$item_info[item_name] = Misc::cutLongString($item_info[item_name],10,true);

								if(strstr($item_info[item_icon],"icon01.gif"))
								{
									$icon1 = "<img src=$img_url/img/icon01.gif align=absmiddle>";
								}
								else
								{
									$icon1 = "";
								}
								if(strstr($item_info[item_icon],"icon02.gif"))
								{
									$icon2 = "<img src=$img_url/img/icon02.gif align=absmiddle>";
								}
								else
								{
									$icon2 = "";
								}
								if(strstr($item_info[item_icon],"icon03.gif"))
								{
									$icon3 = "<img src=$img_url/img/icon03.gif align=absmiddle>";
								}
								else
								{
									$icon3 = "";
								}
								if(strstr($item_info[item_icon],"icon04.gif"))
								{
									$icon4 = "<img src=$img_url/img/icon04.gif align=absmiddle>";
								}
								else
								{
									$icon4 = "";
								}

								if($user_dbinfo[level] == "10" || !$user_dbinfo[level])
								{
									$price_chart = "please login to see price";
								}
								else
								{
									$price_chart = "$".$item_info[item_price2];
								}


								// 링크걸기
								$link_url = "/shopping/product_view.php?itemCode=$item_info2[item_code]&seqNo=$item_info2[seq_no]&p_code1=$p_code1&p_code2=$p_code2";

								echo  "<table width=100% border=0 cellspacing=0 cellpadding=0>
									<tr>
										<td>$file_image</td>
									</tr>
									<tr>
										<td><span class=b>$item_info[model_no]</span></td>
									</tr>
									<tr>
										<td><a href=$seo_link><span class=b>$item_info[item_title]</span></a><br>
											$price_chart </td>
									</tr>
									<tr>
										<td>$icon1 $icon2 $icon3 $icon4</td>
									</tr>
								</table>";
							}
							else
							{
								echo "
								<table width=100% border=0 cellspacing=0 cellpadding=0>
								<tr> 
								  <td height=\"120\" align=\"center\" valign=\"middle\" bgcolor=\"#FFFFFF\">&nbsp;</td>
								</tr>
								</table>";
							}
							echo "</td>";
			  				}

				echo "</tr></table></td>";

		}

		if($total == "0")
			{
				echo "<tr><td height=25 align=center>Nothing Found</td></tr>";
			}
	}

	$r_qry1 = "select * from chan_shop_cmtboard where itemCode = '$itemCode' order by seq_no desc";
	$r_rst1 = mysql_query($r_qry1);
	$r_num1 = mysql_num_rows($r_rst1);


	$r_qry2 = "select sum(star) from chan_shop_cmtboard where itemCode = '$itemCode'";
	$r_rst2 = mysql_query($r_qry2);
	$r_num2 = @mysql_result($r_rst2,0,0);


	$ratio_value = @ceil($r_num2/$r_num1);

	$ratio_value = "5";

	for($a=0; $a<$ratio_value; $a++)
	{
		$star_icon_a .= "<img src=/images/icon_star.png >&nbsp;";
	}

	$silver_value = 5-$ratio_value;
	for($b=0; $b<$silver_value; $b++)
	{
		$star_icon_a .= "<img src=/images/icon_star_empty.gif align=absmiddle>";
	}



	include _BASE_DIR ."/include/inc_top.php";
?>
<style>
.p_img { border:1px soild #000;} 
</style>
<script>
	var url = "/shopping/cart_process.php?o_code=";
	var url2 = "/shopping/wish_process.php?o_code=";

	function deleteMsg(){
		cart_msg.innerHTML = '';
	}

	function handleHttpResponse(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('cart_total');

				for(i=0; i<total_counts.length; i++)
				{
					var name1 = xmlDocument.getElementsByTagName('cart_total').item(i).firstChild.data;
					//var name2 = xmlDocument.getElementsByTagName('cart_total_amt').item(i).firstChild.data;
				}

				cart_sum.innerHTML = name1;
				//cart_sum_amount.innerHTML = '$'+name2;
				//document.forms["product"]["kr_shipping_fee[]"].value = name1;
				
				cart_msg.innerHTML = '<font color=red>'+name1 + ' item(s) has been added.</font><br><br><input type=button value="   CONTINUE SHOPPING   "  class="summit_btn" onClick="javascript:history.go(-1)">&nbsp;&nbsp;<input type=button style="cursor:hand" value="&nbsp;&nbsp;&nbsp;CHECK OUT&nbsp;&nbsp;&nbsp;" onClick="location.replace(\'/shopping/cart.php\')"  class="summit_btn">';

				isWorking = false;

				//setInterval("deleteMsg()", 3000);
			}
		}

	} 

	function handleHttpResponse2(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

			
				cart_msg.innerHTML = '<font color=red>item(s) has been added to wishlist.</font><br><br><input type=button value="   CONTINUE SHOPPING   "  class="summit_btn" onClick="javascript:history.go(-1)">';

				isWorking = false;

				//setInterval("deleteMsg()", 3000);
			}
		}

	} 

	var isWorking = false;

	function add_cart(str){
			
			var item = '';

			if (document.forms["item_view"]["itemCode[]"].length) { 
				
				for(i=0; i<document.forms["item_view"]["itemCode[]"].length; i++)
				{
					if(document.forms["item_view"]["qty[]"][""+i+""].value == '')
					{
						document.forms["item_view"]["qty[]"][""+i+""].value = '0';
					}

					if(parseInt(document.forms["item_view"]["qty[]"][""+i+""].value)>0)
					{
						item = item + document.forms["item_view"]["itemCode[]"][""+i+""].value + '/' + document.forms["item_view"]["optCode[]"][""+i+""].value + '/' + document.forms["item_view"]["qty[]"][""+i+""].value + '/' + document.forms["item_view"]["item_package[]"][""+i+""].value + 'NaN';
					}
				}

				//alert('1'+item);

			} else { 

					if(document.forms["item_view"]["qty[]"].value == '')
					{
						document.forms["item_view"]["qty[]"].value = '0';
					}

					if(parseInt(document.forms["item_view"]["qty[]"].value)>0)
					{
						item = item + document.forms["item_view"]["itemCode[]"].value + '/' + document.forms["item_view"]["optCode[]"].value + '/' + document.forms["item_view"]["qty[]"].value + '/' + document.forms["item_view"]["item_package[]"].value + 'NaN';
					}

					//alert('2'+item);
			} 

			cart_msg.innerHTML = 'processing....';

			//document.write(item);

			// ajax start
			//alert(isWorking);

			if(http){

				if(str == 'cart')
				{
					http.open("GET",url + escape(item) + "&random=" + Math.random(),true);
					http.onreadystatechange = handleHttpResponse;
					isWorking = true;

					http.send(null);
				}
				else
				{
					http.open("GET",url2 + escape(item) + "&random=" + Math.random(),true);
					http.onreadystatechange = handleHttpResponse2;
					isWorking = true;

					http.send(null);

				}
				

			}


	}

	function getHTTPObject(){
		
		var xmlhttp;


		if(!xmlhttp && typeof XMLHttpRequest != 'underfined'){
			
			try{
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
	
	return xmlhttp;
	}

	var http = getHTTPObject();
</script>
<script>
		function go_price(str){

			var temp=str
			var temparray = new Array();
			temparray = temp.split("@");

		}

		function go_img(str){

			var temp=str
			var temparray = new Array();
			temparray = temp.split("@");

			//alert(temparray[1]);

			if(temparray[1])
			{
				document.item_view.main_img.src = '<?= _WEB_BASE_DIR ?>/upload/' + temparray[1];
				//document.item_view.main_img.src = '<?= _WEB_BASE_DIR ?>/img/noimage.jpg';
			}

		}

		// 칼라별 상품사진 보여주기
		function go_img2(str){

			//tem = str.split("/");

			tf = str;

			var temp="<?= $item_info[opt1_file_name] ?>"
			var temparray = new Array();
			temparray = temp.split("NaN");
			
			//alert(temparray[tf]);
			//if(temparray[tf] == '해당파일명' || temparray[tf] == '')

			document.item_view.main_img.height = 596;

			if(temparray[tf] == '' || temparray[tf] == 'image file name')
			{
				//document.item_view.main_img.src = '<?= _WEB_BASE_DIR ?>/img/no_image.jpg';
			}
			else
			{
				document.item_view.main_img.src = '<?= _WEB_BASE_DIR ?>/upload/' + temparray[tf];
			}

			//document.item_view.main_img.src = '<?= _WEB_BASE_DIR ?>/upload/' + str;
		}

		function pic_view(itemCode,pic_img){
			
			if(document.item_view.now_pic.value)
			{
				now_img = document.item_view.now_pic.value;
			}
			else
			{
				now_img = pic_img;
			}
			window.open("large_view.php?itemCode=" + itemCode + "&pic_img=" + now_img,"image","width=800,height=600,scrollbars=1,left=300,top=100,resizable=yes");

		}

		function pic_view2(itemCode,str,wid,hig){
			
			if(document.item_view.now_pic.value)
			{
				now_img = document.item_view.now_pic.value;
			}
			else
			{
				now_img = str;
			}

			
			if(parseInt(wid)>parseInt(hig))
			{
				document.item_view.main_img.width = 360;
			}
			else
			{
				document.item_view.main_img.height = 400;
			}
			

			document.item_view.main_img.src = '<?= _WEB_BASE_DIR ?>/upload/' + str;
			//window.open("large_view.php?itemCode=" + itemCode + "&pic_img=" + now_img,"image","width=800,height=600,scrollbars=1,left=300,top=100,resizable=yes");

		}

		function size_chart(brand_code){
			
			window.open("size_chart.php?brand_code=" + brand_code,"size","width=650,height=500,left=400,top=100,scrollbars=1");

		}

		function pic_view(itemCode,pic_img){
			
			window.open("large_view.php?itemCode=" + itemCode + "&pic_img=" + pic_img,"image","width=800,height=600,scrollbars=1,left=300,top=100");

		}


		function direct_view(img){

			document.item_view.main_img.height = 350;

			document.item_view.main_img.src = '/upload/' + img;
		
		}


		</script>

		<form method=post name=item_view>
		<input type=hidden name=mode value="save">
		<input type=hidden name=itemCode value="<?= $item_info[item_code] ?>">
		<input type=hidden name=cart_flag value="">
		<input type=hidden name=now_pic value="">
			<table width="960" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><a href=<?= _WEB_BASE_DIR ?>/><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle" border=0></a> &nbsp; Home  >  <a href=<?= _WEB_BASE_DIR ?>/shopping/product_list.php?p_code1=<?= $p_code1 ?>><?= Category_name_member('BIG',$p_code1,'0','0'); ?></a>  >  <a href=<?= _WEB_BASE_DIR ?>/shopping/product_list.php?p_code1=<?= $p_code1 ?>&p_code2=<?= $p_code2 ?>><?= Category_name_member('MIDDLE',$p_code1,$p_code2,'0'); ?></a> > <span class="b">Details</span></td>
				</tr>
			
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="30"></td>
				</tr>
			</table>
			<table width="960" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="70" valign="top">
								<div class="clearfix" >
									<ul id="thumblist" class="clearfix" >
									<? print_thumimg($item_info[userfile1]); ?>
									</ul>
								</div>
								</td>
								<td width="15"></td>
								<td width="390" valign="top" align=center>
								<div align=center>
									<div class="clearfix" align=center>
										<?= $main_first_picture ?>
									</div>
								</div>
								</td>

								<td width="15"></td>
								<td valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><span class="product"><?= $item_info[model_no]; ?></span><br>
                                        <span class="b"><?= $item_info[item_title] ?></span><br></td>
                                  </tr>
                                  <tr>
                                    <td height="12"></td>
                                  </tr>
                                  <tr>
                                    <td background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                  </tr>
                                  <tr>
                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
										<? if($item_info[item_package]>1): ?>
                                        <tr>
                                          <td width="50%" height="36" align="left" class="b">PRODUCT NAME </td>
                                          <td width="20%" align="center" class="b">PRICE</td>
                                          <td width="15%" align="center" class="b">PACK QTY</td>
										  <td width="15%" align="center" class="b">PACK</td>
                                        </tr>
                                        <tr>
                                          <td height="1" colspan="4" bgcolor="#eeeeee"></td>
                                        </tr>
										<? else: ?>
                                        <tr>
                                          <td width="60%" height="36" align="left" class="b">PRODUCT NAME </td>
                                          <td width="25%" align="center" class="b">PRICE</td>
                                          <td width="15%" align="center" class="b">QTY</td>
                                        </tr>
                                        <tr>
                                          <td height="1" colspan="3" bgcolor="#eeeeee"></td>
                                        </tr>
										<? endif; ?>


										<?
											if($item_info[item_price2]>0)
											{
												$opt_price = $item_info[item_price2];
											}
											else
											{
												$opt_price = $item_info[item_price1];
											}

											

											// 색상별 사이즈 옵션 배열만들기
											$size_value = explode("SnS",$item_info[opt1_content_arr]);

											$this_inventory = explode("NaN",$item_info[opt1_inventory_arr]);
											$this_file_name = explode("NaN",$item_info[opt1_file_name]);
											$this_extra = explode("NaN",$item_info[opt1_extraprice_arr]);

											$p = 0;

											for($k = 0; $k<count($size_value)-1; $k++)
											{
												// 또 배열 만들기
												$color_array = explode("NaN",$size_value[$k]);


												$color_result = $color_array[0];

												$size_result = explode(",",$color_array[1]);

												$inventory_arr = explode(",",$this_inventory[$k]);
												$extra_arr = explode(",",$this_extra[$k]);

												for($m=0; $m<count($size_result); $m++)
												{
												

													$opt_price_result = number_format($opt_price+$extra_arr[$m],2);


													if($user_dbinfo[level] == "10" || !$user_dbinfo[level])
													{
														$opt_price_result = "-";
														//$opt_price_result = "$".$opt_price_result;
													}
													else
													{
														$opt_price_result = "$".$opt_price_result;
													}


													if($inventory_arr[$m] == "0")
													{
														$inventory_msg = "-- out of stock";
													}
													else
													{
														$inventory_msg = "<input type=text name=qty[] size=3>";
													}

													if($this_file_name[$k])
													{
														$opt_file_img = "<img src=/thum_upload/thum_".$this_file_name[$k]." width=20 height=20>";
													}
													else
													{
														$opt_file_img = "";
													}

													if($size_result[$m])
													{
														$size_msg = ", ".$size_result[$m];
													}
													else
													{
														$size_msg = "";
													}

													//echo "<option value=\"$color_result/$size_result[$m]/$extra_arr[$m]/$inventory_arr[$m]/$k\">$color_result , $size_result[$m] ($$opt_price_result) $inventory_msg";

													if($item_info[item_package]>1)
													{
													echo "
													<tr onMouseover=\"this.style.backgroundColor='#E3E3E3';go_img2($k)\" onMouseout=\"this.style.backgroundColor='#ffffff'\">
													  <td height=30 style=padding-left:0px><table width=100% border=0 cellspacing=0 cellpadding=0>
														  <tr>
															<td width=35>$opt_file_img</td>
															<td >$color_result $size_msg</td>
														  </tr>
													  </table></td>
													  <td align=center>$opt_price_result</td>
													  <td align=center><input type=hidden name=item_package[] style=\"text-align:center:border:0px\" size=3 value=\"$item_info[item_package]\">$item_info[item_package]</td>
													  <td align=center><input type=hidden name=itemCode[] value=\"$itemCode\"><input type=hidden name=optCode[] value=\"$p\"><input type=text name=qty[] size=3></td>
													</tr>";
													}
													else
													{
													echo "
													<tr onMouseover=\"this.style.backgroundColor='#E3E3E3';go_img2($k)\" onMouseout=\"this.style.backgroundColor='#ffffff'\">
													  <td height=30 style=padding-left:0px><table width=100% border=0 cellspacing=0 cellpadding=0>
														  <tr>
															<td width=35>$opt_file_img</td>
															<td >$color_result $size_msg</td>
														  </tr>
													  </table></td>
													  <td align=center>$opt_price_result</td>
													  <td align=center><input type=hidden name=item_package[] size=3 value=\"$item_info[item_package]\"><input type=hidden name=itemCode[] value=\"$itemCode\"><input type=hidden name=optCode[] value=\"$p\"><input type=text name=qty[] size=3></td>
													</tr>";
													}


													$p++;

													//$price_array[] = $opt_price+$extra_arr[$m];
												}

											}

										?>		
										<? if($item_info[item_package]>1): ?>
                                        <tr>
                                          <td height="15" colspan="4"></td>
                                        </tr>
                                        <tr>
                                          <td height="1" colspan="4" bgcolor="#eeeeee"></td>
                                        </tr>
										<? else: ?>
                                        <tr>
                                          <td height="15" colspan="3"></td>
                                        </tr>
                                        <tr>
                                          <td height="1" colspan="3" bgcolor="#eeeeee"></td>
                                        </tr>
										<? endif; ?>
                                    </table></td>
                                  </tr>
								  <? 
								  if($user_dbinfo[level] == "10" || !$user_dbinfo[level]):
								  ?>
                                  <tr>
                                    <td height="50" align="right">Please <a href=/member/login.php><u>log in</u></a> to see price</td>
                                  </tr>
								  <?
								  else:
								  ?>
                                  <tr>
                                    <td height="50" align="right"><span id="cart_msg"><input type=button value="&nbsp;&nbsp;ADD TO WISHLIST&nbsp;&nbsp;" class="summit_btn" onClick="javascript:add_cart('wish')" style="cursor:pointer">&nbsp;&nbsp;&nbsp;<input type=button value="&nbsp;&nbsp;ADD TO CART&nbsp;&nbsp;" class="summit_btn" onClick="javascript:add_cart('cart')" style="cursor:pointer"></span></td>
                                  </tr>
								  <?
								  endif;
								  ?>
								  <tr>
									<td align=right></td>
								  </tr>
                                  <tr>
                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="30"><span class="b">DESCRIPTION</span><br></td>
                                      </tr>
                                      <tr>
                                        <td background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                      </tr> 
                                      <tr>
                                        <td bgcolor="#ffffff" style="padding:0px">
										<? if($item_info[userfile1]): ?>
										<?
										$file_name = get_firstpic($item_info[userfile1]);
										?>
										<? endif; ?>
										<?= stripslashes($item_info[item_description]); ?>										
										<br>
                                        <br></td>
                                      </tr>
                                    </table>
                                	</td>
                                  </tr>
								  <tr>
									<td align=right></td>
								  </tr>
                                  <tr>
                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="30"><span class="b">You may also like</span><br></td>
                                      </tr>
                                      <tr>
                                        <td background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                      </tr> 
                                      <tr>
                                        <td bgcolor="#ffffff" style="padding:0px">
										<table width=100% border=0 cellpadding=0 cellspacing=0>
										<? printRelation('Relation',$itemCode); ?>
										</table>
										<br>
                                        <br></td>
                                      </tr>
                                    </table>
                                	</td>
                                  </tr>
							  </table>
							 </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
						<br>
						<br>
						<br>

	  
<?
	//include _BASE_DIR . "/include/htmledit_func2.php";
	// 왼쪽 include
	include _BASE_DIR ."/include/inc_bottom.php";
?>