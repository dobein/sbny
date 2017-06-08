<?
	include "../include/inc_base.php";

		/*
	if(!$user_dbinfo[level])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/shopping/product_view.php?itemCode=$itemCode";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?goUrl=$URL");
	}

	if($user_dbinfo[level] == "10")
	{
	   $D_URL = _WEB_BASE_DIR ."/member/join_pending.php";

	   header("location: $D_URL");
	}
		*/

	/**
	* @ 제품 상세보기 (갤러리 형식) 펑션
	*/

		$tableName = "chan_shop_product";

		$board_col = 4;
		$board_row = 5;

		$limit = $board_row*$board_col;


		$cols = $board_col;



		// DB  START 

		if(!$start)
			{
			$start=0;
			}

		$move_start = $start;
		
		if(empty($Sort))
		{
			$Sort = "new";
		}


		$S_content = $_POST['S_content'];
		$wholesaler = $_POST['wholesaler'];

		if($_POST['S_content'])
		{
			$content_qry = "&& (b.item_title like '%$S_content%' || b.model_no like '%$S_content%' || b.barcode like '%$S_content%')";
		}

		if($wholesaler)
		{
			$wholesaler_qry = "&& a.member_id = '$wholesaler'";
		}


		if($_REQUEST['p_code1'])
		{
			$qry_code1 = "&& a.p_code1 = '".$_REQUEST['p_code1']."'";
		}
		if($_REQUEST['p_code2'])
		{
			$qry_code2 = "&& a.p_code2 = '".$_REQUEST['p_code2']."'";
		}
		/*
		else
		{
			// 첫번째 카테고리 값
			$c_qry1 = "select * from chan_shop_category where c_code1='$p_code1' && c_code2<>'0' && c_code3='0' order by pos desc limit 1";
			$c_rst1 = mysql_query($c_qry1);
			$c_row1 = mysql_fetch_assoc($c_rst1);

			$p_code2 = $c_row1[c_code2];

			$qry_code2 = "&& a.p_code2 = '$p_code2'";

		}
		*/

		if($p_code3)
		{
			$qry_code3 = "&& a.p_code3 = '$p_code3'";
		}

		if($sort_type && $sort_type != "NA")
		{
			$sort_type_qry = "&& b.item_style = '$sort_type'";
		}




		switch($sort_flag){
			
			case "price_high":
				$sort_qry = "order by CASE WHEN b.item_price2 = '0.00' THEN b.item_price1 WHEN b.item_price2 <> '0.00' THEN b.item_price2 END desc";
				break;
			case "price_low":
				$sort_qry = "order by CASE WHEN b.item_price2 = '0.00' THEN b.item_price1 WHEN b.item_price2 <> '0.00' THEN b.item_price2 END asc";
				break;
			default:
				$sort_qry = "order by b.seq_no desc";
				break;
		}

		//$que = "select * from chan_shop_c_product where print_option = 'YES' && p_code1 = '$p_code1' $qry_code2 $qry_code3 order by seq_no desc limit $start,$limit";
		
		//stock 개념이 들어간거
		//$que = "select a.seq_no,a.p_code1,a.p_code2,a.p_code3,a.item_code,b.brand,c.name,d.opt_stock from chan_shop_c_product a, chan_shop_product b, chan_shop_brand c,chan_shop_option d where a.item_code = b.item_code && a.item_code = d.item_code && a.print_option = 'YES' && b.brand = c.seq_no && a.p_code1 = '$p_code1' $qry_code2 $qry_code3 order by c.name,b.item_title asc limit $start,$limit";
		$que = "select 
							a.seq_no,a.p_code1,a.p_code2,a.p_code3,a.item_code,
							b.userfile1,b.item_title,b.brand,b.item_stock,b.model_no,b.opt2_content_arr 
						from 
							chan_shop_c_product as a, 
							chan_shop_product as b
						where a.item_code = b.item_code && a.print_option = 'YES' $wholesaler_qry $qry_code1 $qry_code2 $qry_code3 $content_qry $sort_type_qry group by a.item_code $sort_qry limit $start,$limit";

		//print_r($que);

		// 해당쿼리의 브랜드들 가져오기



		$scale=$limit;


		$page_scale=15;


		$page=floor($start/($scale*$page_scale));

		// DB QUERY
		$result=mysql_query($que);
		$result_rows=mysql_num_rows($result);

		$total=mysql_affected_rows();



		//echo "<br>";

		$t_qry1 = "select count(distinct(a.item_code)) from chan_shop_c_product a, chan_shop_product b where a.item_code = b.item_code && a.print_option = 'YES'  $qry_code1 $qry_code2 $qry_code3 $content_qry $sort_type_qry";
		//print_r($t_qry1);
		$total_num_query = mysql_query($t_qry1);


		$total_num = mysql_result($total_num_query,0,0);

		$page_total = $total_num;
		$page_last = floor($page_total/$scale);

		$last=floor($total_num/$scale);


        $total_row = ceil($total/$board_col);


        $total_page = ceil($total/($board_col*$board_row));


	function printProductbyGallery($Sort){

		global $total,$cols,$result,$flag,$start,$scale,$page_scale,$page,$total_page,$limit,$page_total,$p_code1,$p_code2,$p_code3,$base_info,$Mode,$brand,$start_price,$stop_price,$user_dbinfo,$S_content,$Mode,$sort,$flag,$HTTP_COOKIE_VARS,$p_code1,$p_code2,$base_info;
      

		for($i=0; $i < $total;)
		{
		//echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
		if($total < $cols)
			{ 		
			$cols = $total;
			}
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";

					if($cols<4)
					{
						$cols = 4;
					}


                 	for($j=0; $j < $cols; $j++,$i++)
						{     
							echo "<td width=25% valign=top>";
                     	  	$obj = mysql_fetch_array($result);

							
							$img_name = get_firstpic_array($obj[userfile1]);

							$file_name = "list_".$img_name[0];
							$file_name_main = "main_".$img_name[0];
							$file_name_thum = "thum_".$img_name[0];
							$file_name_big = $img_name[0];


							$obj[item_title] = Misc::cutLongString($obj[item_title], 200, $dot=true);


							$img_size = @getimagesize("../upload/$img_name[0]");

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
								if($img_size[1]>300)
								{
									$image_size = "height=596";
								}
								else
								{
									$image_size = $img_size[1];
								}
							}


							if($img_name[1])
							{
								$over_img = "onMouseover=\"this.src='../upload/thum_$img_name[1]'\" onMouseout=\"this.src='../thum_upload/thum_$img_name[0]'\"";
							}
							else
							{
								$over_img = "";
							}

							if($j == "0")
							{
								$td_align = "align=left";
								$td_padding = "style=\"padding-left:0px\"";
							}
							else if($j == "1")
							{
								$td_align = "align=center";
								$td_padding = "style=\"padding-left:20px\"";
							}
							else if($j == "2")
							{
								$td_align = "align=center";
								$td_padding = "style=\"padding-left:20px\"";
							}
							else if($j == "3")
							{
								$td_align = "align=right";
								$td_padding = "style=\"padding-left:35px\"";
							}

							$seo_link = "product_view.php?itemCode=$obj[item_code]";

							//217 257 
							if($obj[userfile1])
								{
									$file_image = "<a href=$seo_link><img src=\"../upload/$file_name_thum\" alt=\"$obj[item_title]\" border=1 style='border-color:#dcdcdc;' style=\"cursor:hand\"></a>";
								}
							else
								{
									$file_image = "<a href=$seo_link><img src=\"../images/noimage.jpg\" border=0 alt=\"$obj[item_title]\" style=\"cursor:hand\" border=0></a>";
								}

							$obj[item_title] = str_highlight($obj[item_title], $S_content);
							$brand = brand_name($obj[brand]);


							// 브랜드 명
							//$brand_name = brand_name($obj[brand]);

							$img_url = _WEB_BASE_DIR;



							if($obj[item_stock] == "Out")
							{
								$stock_icon = "<img src=$img_url/images/out-of-stock.gif align=absmiddle>";
							}
							else
							{
								$stock_icon = "";
							}







							// price
							$item_price = explode("SnS",$obj[opt2_content_arr]);

							$item_price_cnt = count($item_price)-2;

							$item_price_detail = explode("NaN",$item_price[$item_price_cnt]);

							$item_price_detail[0] = trim($item_price_detail[0]);
							$item_price_detail[1] = trim($item_price_detail[1]);

							$price_chart = "Price : $$item_price_detail[1]";


							if($obj[seq_no])
							{
								echo  "<table width=100% border=0 cellspacing=0 cellpadding=0>
									<tr>
										<td>$file_image</td>
									</tr>
									<tr>
										<td><b>$obj[model_no]</b></td>
									</tr>
									<tr>
										<td><a href=$seo_link><span class=b>$obj[item_title]</span></a></td>
									</tr>
									<tr>
										<td>$price_chart ~ </td>
									</tr>
								</table>";

								echo "</td>";

								unset($thumImg);

							}
							else
							{
								echo "<table width=100% border=0 cellspacing=0 cellpadding=0>
									<tr>
										<td height=257>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>";

								echo "</td>";
							}

							$eNum = $j+1;
							if($eNum%4 == 0)
							{
								echo "";
							}
							else
							{
								echo "<td width=30></td>";
							}

			  			}

				echo "</tr></table><br><br>";



		}

		if($total == "0")
			{
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td height=100 align=center>We could not find.</td></tr></table>";
			}
	}



	function product_pageNavigation(){

	global $page_total,$page,$start,$scale,$page_scale,$page_last,$Mode,$S_date,$S_content,$how,$Sort,$p_code1,$p_code2,$p_code3,$brand,$viewFlag,$stop_price,$sort_type,$sort_flag,$wholesaler;

	$Parameter_value = "p_code1=$p_code1&p_code2=$p_code2&p_code3=$p_code3&Sort=$Sort&page_total=$page_total&page=$page&scale=$scale&page_scale=$page_scale&page_last=$page_last&Mode=$Mode&wholesaler=$wholesaler&viewFlag=$viewFlag&S_content=$S_content&sort_type=$sort_type&sort_flag=$sort_flag";



	if($page_total>$scale) //
	{
	if($start+1>$scale*$page_scale)
			{
			$pre_start=$page*$scale*$page_scale-$scale;
			echo "<a href='/shopping/product_list.php?start=0&$Parameter_value'><font style=\"font-size:9pt\">[first]</font></a>&nbsp;";
			echo "<a href='/shopping/product_list.php?start=$pre_start&$Parameter_value'><font style=\"font-size:9pt\">...</font></a>&nbsp;";
			}
	for($vj=0; $vj<$page_scale; $vj++)
		{
		$ln=($page * $page_scale+$vj)*$scale;
		$vk=$page*$page_scale+$vj+1;
			if($ln<$page_total)
			{
					if($ln!=$start)
					{
					echo "&nbsp;<a href='/shopping/product_list.php?start=$ln&$Parameter_value'><u>$vk</u></a>&nbsp;";
					}
					else
					{
					echo "&nbsp;&nbsp;<font style=\"font-size:9pt\"><b>$vk</b></font>&nbsp;&nbsp;";
					}
			}
		}
	if($page_total>(($page+1)*$scale*$page_scale))
			{
			$n_start=($page+1)*$scale*$page_scale;
			$last_start=$page_last*$scale;
			echo "&nbsp;<a href='/shopping/product_list.php?start=$n_start&$Parameter_value'><font style=\"font-size:9pt\">...</font></a>&nbsp;";
			echo "<a href='/shopping/product_list.php?start=$last_start&$Parameter_value'><font style=\"font-size:9pt\">[last]</font></a>";
			}
	}
	}// pageNavigation function end



	function print_thumimg($itemCode,$image,$i){
		
		global $img_url;

		$photo_arr = explode("NaN",$image);

		$total_tr = ceil(count($photo_arr)/2);

		// <img src=\"../thum_upload/$file_name_thum\" alt=\"$obj[item_title]\" border=1 style='border-color:#dcdcdc;'>

		$k = 0;
		for($m=1; $m<=2; $m++)
		{
			$content .= "<tr>";

				for($p=0; $p<2; $p++)
				{

					if($photo_arr[$k])
					{

					$thumImg = $photo_arr[$k];


					$content .= "
							  <td width=100><table width=100% border=0 cellpadding=0 cellspacing=0>
								  <tr> 
									<td align=center valign=middle height=152><a href=\"javascript:pic_view('$itemCode','$thumImg','$i')\"><img src=\"../thum_upload/thum_".$photo_arr[$k]."\" border=1 style='border-color=#CCCCCC'></a></td>
								  </tr>
								</table></td>";
					}

					$k++;
				}

			$content .= "</tr>";
		}

		return $content;	
	}




	// 카테고리 사진
	if($p_code1 && $p_code2)
	{
		$c_qry1 = "select * from chan_shop_category where c_code1 = '$p_code1' && c_code2 = '$p_code2' && c_code3 = '0'";
		$c_rst1 = mysql_query($c_qry1);
		$c_row1 = mysql_fetch_array($c_rst1);
	}

	include _BASE_DIR ."/include/inc_top.php";
?>
<script>
	function pic_view(itemCode,name,imgNo){
		
		//alert(name);

		//document.getElementsByName("total_"+p)[0].value; 
		eval("mainImg"+imgNo).src = '../thum_upload/main_' + name;

		//getElementsByName("mainImg"+imgNo).src = '../thum_upload/main_' + name;


	}
	function go_view(itemCode,pic_img){
		
		window.open("large_view.php?itemCode=" + itemCode + "&pic_img=" + pic_img,"image","width=800,height=600,scrollbars=1,left=300,top=100");

	}
function go_sort(division,p_code1,p_code2,p_code3,wholesaler,value){
	
	//alert(document.product.sort_type.value);

	/*
	if(document.product.sort_type.value)
	{
		sort_type_value = document.product.sort_type.value;
	}
	else
	{
		sort_type_value = 'NA';
	}
	*/


	if(division == '1')
	{

		location.replace('product_list.php?wholesaler=' + wholesaler + '&p_code1=' + p_code1 + '&p_code2=' + p_code2 + '&p_code3=' + p_code3 + '&sort_flag=' + sort_value);
	}
	else
	{

		location.replace('product_list.php?wholesaler=' + wholesaler + '&p_code1=' + p_code1 + '&p_code2=' + p_code2 + '&p_code3=' + p_code3 + '&sort_flag=' + value);
	}
	

}

function choose_wholesaler(wholesaler){
	
	tf = document.product;

	tf.wholesaler.value = wholesaler;
	tf.submit();

}
</script>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><a href=<?= _WEB_BASE_DIR ?>/><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle" border=0></a> &nbsp; Home  >  <a href=<?= _WEB_BASE_DIR ?>/shopping/product_list.php?p_code1=<?= $_GET['p_code1'] ?>><?= Category_name_member('BIG',$_GET['p_code1'],'0','0'); ?></a></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="30"></td>
				</tr>
				<tr>
					<td valign=top>


								<table width="100%" align=center border=0 cellpadding=0 cellspacing=0>
								<form name=product method=post action=<?= $_SERVER['PHP_SELF']; ?>>
								<input type=hidden name=wholesaler value="">
								<input type=hidden name=p_code1 value="<?= $_REQUEST['p_code1'] ?>">
								<input type=hidden name=p_code2 value="<?= $_REQUEST['p_code2'] ?>">
								<input type=hidden name=p_code3 value="">
									<tr>
										<td colspan=2 bgcolor=#f4f4f4 height=45>&nbsp;&nbsp;View by Wholesaler : <select name="wholesaler"  onChange="choose_wholesaler(this.value)"><option value="">Select Wholesaler<?= SelectWholesaler($wholesaler); ?></select></td>
									</tr>
									<tr>
										<td align=left height=35 class=sub width=50%>Page(s) <? product_pageNavigation(); ?>&nbsp;&nbsp;Total <?= $page_total ?> products</td>
										<td width=50% align=right></td>
									</tr></form>
								</table>
								<table width="100%" align=center border=0 cellpadding=0 cellspacing=0>
								<tr>
								<td>
								<? printProductbyGallery($Sort); ?>
								</td>
								</tr>
								</table>
								<table width="100%" align=center border=0 cellpadding=0 cellspacing=0>
									<tr>
										<td bgcolor=#FFFFFF width=50% align=left height=35 class=sub>Page(s) <? product_pageNavigation(); ?>&nbsp;&nbsp;Total <?= $page_total ?> products</td>
										<td bgcolor=#FFFFFF width=50% align=right><a href=#>up</a>&nbsp;</td>
									</tr>
								</table>

					</td>
				</tr>
				</table>
	  
<?
	//  include
	include _BASE_DIR ."/include/inc_bottom.php";
?>