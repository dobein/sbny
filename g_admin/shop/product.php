<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	$tableName = "chan_shop_product";


	if($_POST['Mode'] == "main_update")
	{
		
		$pos = 1;
		for($i=0; $i<count($_POST['seqNo']); $i++)
		{
			//echo $seqNo[$i]."<br>";
			$re_qry1 = "insert into chan_shop_mainitem (view_position,itemCode,pos,view_option) values ('".$_POST['view_position']."','".$_POST['seqNo'][$i]."','$pos','YES')";
			$re_rst1 = mysql_query($re_qry1);
			
			$pos++;
		}

		$choose_category = $_POST['choose_category'];
		$S_content = $_POST['S_content'];

		//?Mode=SAVE&area=&pCode=&choose_category=7&S_content=
		Misc::jvAlert("Completed!","location.replace('product.php?Mode=SAVE&area=$area&pCode=&choose_category=$choose_category&S_content=$S_content')");
		exit;	
	}

	if($_GET['mode'] == "del")
	{
		$itemCode = $_GET['itemCode'];
		$c_code1 = $_GET['c_code1'];
		$c_code2 = $_GET['c_code2'];
		$c_code3 = $_GET['c_code3'];

		$qry1 = "delete from $tableName where item_code = '$itemCode'";
		$rst1 = mysql_query($qry1,$dbConn);

		$qry2 = "delete from chan_shop_c_product where item_code = '$itemCode'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "delete from chan_shop_price where item_code = '$itemCode'";
		$rst3 = mysql_query($qry3,$dbConn);

		$qry4 = "delete from chan_shop_mainitem where itemCode = '$itemCode'";
		$rst4 = mysql_query($qry4,$dbConn);

		
		if($rst1 && $rst2 && $rst3)
		{
			Misc::jvAlert("Completed!","location.replace('product.php?c_code1=$c_code1&c_code2=$c_code2&c_code3=$c_code3')");
			exit;	
		}
	}
	elseif($_GET['mode'] == "del2")
	{

		$itemCode = $_GET['itemCode'];
		$c_code1 = $_GET['c_code1'];
		$c_code2 = $_GET['c_code2'];
		$c_code3 = $_GET['c_code3'];

		//$qry2 = "delete from chan_shop_c_product where item_code = '$itemCode'";
		//$rst2 = mysql_query($qry2,$dbConn);

		$qry2 = "delete from chan_shop_c_product where p_code1 = '$c_code1' && p_code2 = '$c_code2' && p_code3 = '$c_code3' && item_code = '$itemCode'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "delete form chan_shop_mainitem where itemCode = '$itemCode'";
		$rst3 = mysql_query($qry3);

		if($rst2)
		{
			Misc::jvAlert("Completed!","location.replace('product.php?c_code1=$c_code1&c_code2=$c_code2&c_code3=$c_code3')");
			exit;	
		}
	}



	$c_code1 = $_GET['c_code1'];
	$c_code2 = $_GET['c_code2'];
	$c_code3 = $_GET['c_code3'];


	function printCategory(){
		global $dbConn,$userid,$tableName;

		$c_code1 = $_GET['c_code1'];

		$qry1 = "select * from chan_shop_category where c_code2='0' && c_code3='0' order by pos asc";
		//print_r($qry1);

		$rst1 = mysql_query($qry1,$dbConn);

		$num = 0;
		while($row1 = mysql_fetch_array($rst1)){
			if($c_code1 == "$row1[c_code1]")
			{
			$printCategory .="<option value=$row1[c_code1] selected>$row1[name]";
			}
			else
			{
			$printCategory .="<option value=$row1[c_code1]>$row1[name]";
			}
			
			if($num == "0")
			{
				// start number 2
				//print_r($row1[c_code1]);
				if(!$c_code1)
				{
				$second_value = $row1[c_code1];
				}
				else
				{
				$second_value = $c_code1;
				}
			}

			$num++;
		}

		$printCat[second_value] = $second_value;
		$printCat[Category] = $printCategory;
		return $printCat;
	}

	function printCategory2($f_value){
		global $dbConn,$userid,$tableName;

		$c_code2 = $_GET['c_code2'];

		$qry1 = "select * from chan_shop_category where c_code1='$f_value' && c_code2<>'0' && c_code3='0' order by pos asc";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);

		$num1 = 0;
		while($row1 = mysql_fetch_array($rst1)){
			if($row1[c_code2] == "$c_code2")
			{
			$printCategory .="<option value=$row1[c_code2] selected>$row1[name]";
			}
			else
			{
			$printCategory .="<option value=$row1[c_code2]>$row1[name]";
			}

		
			if($num1 == "0")
			{
				if(!$c_code2)
				{
				$third_value = $row1[c_code2];
				}
				else
				{
				$third_value = $c_code2;
				}
			}
			
			$num1++;
		}

		$printCat[third_value] = $third_value;
		$printCat[Category] = $printCategory;
		return $printCat;
	}

	function printCategory3($f_value1,$f_value2){
		
		global $dbConn,$c_code3,$userid,$tableName;

		$c_code3 = $_GET['c_code3'];

		$qry1 = "select * from chan_shop_category where c_code1='$f_value1' && c_code2='$f_value2' && c_code3<>'0' order by pos asc";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);

		$num2 = "0";
		while($row1 = mysql_fetch_array($rst1)){
			if($row1[c_code3] == "$c_code3")
			{
			$printCategory .="<option value=$row1[c_code3] selected>$row1[name]";
			}
			else
			{
			$printCategory .="<option value=$row1[c_code3]>$row1[name]";
			}

			if($num2 == "0")
			{
				if(!$c_code3)
				{
				$forth_value = $row1[c_code3];
				}
				else
				{
				$forth_value = $c_code3;
				}
			}


			$num2++;
		}

		$printCat[forth_value] = $forth_value;
		$printCat[Category] = $printCategory;
		return $printCat;
	}


	$printValue = printCategory();	
	$printValue2 = printCategory2($printValue[second_value]);
	$printValue3 = printCategory3($printValue[second_value],$printValue2[third_value]);

	//echo "first code value $printValue[second_value] $printValue2[third_value] $printValue3[forth_value]";

	if($c_code1 == "ALL")
	{
		$c_code1 = "0";
	}


	if(!$c_code2)
	{
		$c_code2 = "ALL";
	}


	if($c_code2 == "ALL")
	{
		$c_code2 = "0";
	}

	if(!$c_code3)
	{
		$c_code3 = "ALL";
	}

	if($c_code3 == "ALL")
	{
		$c_code3 = "0";
	}






	if(!$_GET['start'])
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}

	$board_scale = 100;
	$board_page = 10;

	/**
	* 한페이지당 글수
	*/
	$scale=$board_scale;

	/*
	* 한페이지당 페이지수
	*/
	$page_scale=$board_page;

	/**
	* 게시판 내용뿌려주기 함수
	*/
	function contentPrint(){

		global $dbConn,$start,$total,$scale,$page,$page_last,$page_scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$c_code1,$c_code2,$c_code3,$first_result1,$second_result1,$search_flag,$search_code,$brand,$content_search,$page_last,$_GET,$_POST,$_SESSION;


		$start = $_GET['start'];


		if(empty($start))
		{
			$start = 0;
		}


		if($c_code2)
		{
			$c_qry2 = "&& A.p_code2 = '$c_code2'";
		}

		if($c_code3)
		{
			$c_qry3 = "&& A.p_code3 = '$c_code3'";
		}

		if($_GET['S_content'])
		{
			$s_content_qry = "&& B.item_title like '%".$_GET['S_content']."%'";
		}

		//$que = "select * from chan_shop_product $c_qry1order by seq_no asc limit $start,$scale";

		$que = "select * from chan_shop_c_product as A left join chan_shop_product as B on A.item_code = B.item_code where A.p_code1 = '$c_code1' $c_qry2 $c_qry3  $s_content_qry order by B.seq_no desc limit $start,$scale";

		//print_r($que);


		//PRINT_R($que);

		$page=floor($start/($scale*$page_scale));

		$result=mysql_query($que);
		$result_rows=mysql_num_rows($result);



		$total=mysql_affected_rows();
		$last=floor($total/$scale);

		/**
		* 페이징을 위한 토탈을 구한다.
		*/

		$page_qry = "select count(*) from chan_shop_c_product as A left join chan_shop_product as B on A.item_code = B.item_code where A.p_code1 = '$c_code1' $c_qry2 $c_qry3 $s_content_qry";
		$page_total_qry = mysql_query($page_qry);

		$page_total = mysql_result($page_total_qry,0,0);
		$page_last = floor($page_total/$scale);


		/**
		* 총 페이지수
		*/
		$total_page_num = ceil($page_total/$scale);

		$now_page_num = floor($start/$scale) + 1;

		if($start)
			{
			$n=$page_total-$start;
			}
		else
			{
			$n=$page_total;
			}

        if($page_total != "0")
        {
        for($i=$start; $i<$start+$scale; $i++)
        //$start 에서 scale 까지만
        {
        if($i<$page_total)
                {
                //mysql_data_seek($result, $i);
                $row=mysql_fetch_array($result);

				// 상품정보 가져오기
				//$item_info = get_iteminfo($row[item_code]);

				// thum 이미지
				$file_image = "<img src=\"../../upload/thum_".$row[userfile1]."\" border=0 style='border-color=#CCCCCC' width=120>";

				$row[title] = Misc::cutLongString($row[title], 30, $dot=true);



				//$brand_name = brand_name($row[brand]);




				if($row[print_option] == "YES")
					{
						$display = "<a href=\"javascript:change_active('$row[item_code]','NO','$area','$c_code1','$c_code2','$c_code3')\"><font color=blue><u>Display</u></font></a>";
					}
				else
					{
						$display = "<a href=\"javascript:change_active('$row[item_code]','Display','$area','$c_code1','$c_code2','$c_code3')\"><font color=red><u>Hidden</u></font></a>";
					}




						$modify_btn = "<a href=\"javascript:item_del('$row[item_code]','$c_code1','$c_code2','$c_code3','$start')\">Delete All</a><br><a href=\"javascript:item_del2('$row[item_code]','$c_code1','$c_code2','$c_code3','$start')\">Delete Category</a>";


				$table_content="
					<tr bgcolor=#FFFFFF>
						<td align=center ><input type=checkbox name=seqNo[] value=$row[item_code]></td> 
						<td align=center height=50>$file_image</td>
						<td align=left height=30 style=\"padding-left:10px\"><a href=product_modify.php?area=$area&itemCode=$row[item_code]&start=$start&Mode=$Mode&S_content=$S_content><b><u>$row[item_title]</u></b></a>$new_icon $sale_icon<br>$row[color] $row[size]<br><font color=green>$row[item_url]</font><br>$display&nbsp;&nbsp;$item_stock<br>&nbsp;$icon1 $icon2 $icon3 $icon4 $icon5</td>
						<td align=center><b>$row[model_no]</b></td>
						<td align=center><span style=\"font-size:14pt;font-weight:bold\">$row[stock_cnt]</span></td>
						<td align=center >$$row[item_costco]<br>$$row[item_price1]<br>$$row[item_price2]</td>
						<td align=center >$modify_btn</td>
					</tr>
				";
			unset($inventory);
			unset($price);

			// table 뿌려주기
			echo $table_content;

			unset($brand_name);

                }
        $n--;
        }

        }
        else
        {
                echo "
                            <tr bgcolor=#FFFFFF> 
                              <td align=center height=50 colspan=7>Empty items</td>
                            </tr>
                ";
        }
        }//contentPrint function end


        /**
        * 게시물 페이징
        */
        function admin_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$page_last,$Mode,$S_date,$S_content,$how,$c_code1,$c_code2,$c_code3,$brand,$search_code,$brand_search,$S_content,$_POST;

		
		$c_code1 = $_GET['c_code1'];
		$c_code2 = $_GET['c_code2'];
		$c_code3 = $_GET['c_code3'];


        $Parameter_value = "Mode=$Mode&c_code1=$c_code1&c_code2=$c_code2&c_code3=$c_code3&how=$how&search_code=$search_code&S_content=$S_content&brand=$brand&S_content=$S_content&brand_search=$brand_search&wholesaler=".$_GET['wholesaler'];

        if($page_total>$scale) //검색 결과가 페이지당 출력수보다 크면
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<a href='?start=0&$Parameter_value'>[first]</a>&nbsp;";
                echo "<a href='?start=$pre_start&$Parameter_value'>[Prev]</a>&nbsp;";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<a href='?start=$ln&$Parameter_value'> $vk </a>.</font>";
                        }
                        else
                        {
                        echo "[$vk].</font>";
                        }
                }
            }
        if($page_total>(($page+1)*$scale*$page_scale))
                {
                $n_start=($page+1)*$scale*$page_scale;
                $last_start=$page_last*$scale;
                echo "&nbsp;<a href='?start=$n_start&$Parameter_value'>[Next]</a></a>&nbsp;";
                echo "<a href='?start=$last_start&$Parameter_value'>[last]</a>";
                }
        }
        }// pageNavigation function end




	if($_GET['c_code2'])
	{
		$c_code2_qry = "&& p_code2 = '".$_GET['c_code2']."'";
	}
	if($_GET['c_code3'])
	{
		$c_code3_qry = "&& p_code3 = '".$_GET['c_code3']."'";
	}



	$total_qry1 = "select count(*) from chan_shop_c_product where p_code1 = '".$_GET['c_code1']."' $c_code2_qry $c_code3_qry $s_content_qry";
	//PRINT_R($total_qry1);
	// 전체 상품수

	$total_rst1 = mysql_query($total_qry1);
	$total_product1 = mysql_result($total_rst1,0,0);


	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>
	function add_product(){
		//alert(document.category.Category3.value);
		location.replace('product_add.php?area=<?= $area ?>&c_code1=' + <?= $c_code1 ?> + '&c_code2=' + <?= $c_code2 ?> + '&c_code3=' + <?= $c_code3 ?>);
	}

	function item_del(code,code1,code2,code3,area){
		answer = confirm("Do you want to delete this item on ALL Category?");

		if(answer == true){
			
			location.replace('product.php?mode=del&itemCode=' + code + '&c_code1=' + code1 + '&c_code2=' + code2 + '&c_code3=' + code3 + '&area=' + area);

		}
		else return;
	}

	function item_del2(code,code1,code2,code3,area){
		answer = confirm("Do you want to delete this item on this category?");

		if(answer == true){
			
			location.replace('product.php?mode=del2&itemCode=' + code + '&c_code1=' + code1 + '&c_code2=' + code2 + '&c_code3=' + code3 + '&area=' + area);

		}
		else return;
	}

	function chg1(){
	regi = document.register;
	//alert(document.product.code1.value);
	location.replace('product.php?area=<?= $area ?>&c_code1=' + regi.c_code1.value);
	}

	function chg2(){
	regi = document.register;
	//alert(regi.code1.value);
	//alert(regi.code2.value);
	location.replace('product.php?area=<?= $area ?>&c_code1=' + regi.c_code1.value + '&c_code2=' + regi.c_code2.value);
	}

	function chg3(){
	regi = document.register;
	location.replace('product.php?area=<?= $area ?>&c_code1=' + regi.c_code1.value + '&c_code2=' + regi.c_code2.value + '&c_code3=' + regi.c_code3.value);
	}

	function change_active(no,mode,area,c_code1,c_code2,c_code3){
		
		if(mode == 'Display')
		{
			answer = confirm("Do you want to display this item?");

			if(answer == true)
			{
				location.replace('product.php?mode=change&division=' + mode + '&item_code=' + no + '&area=' + area + '&c_code1=' + c_code1 + '&c_code2=' + c_code2 + '&c_code3=' + c_code3);
				exit;
			}
			else return;
		}
		else
		{
			answer = confirm("Do you want to hide this item?");

			if(answer == true)
			{
				location.replace('product.php?mode=change&division=' + mode + '&item_code=' + no + '&area=' + area + '&c_code1=' + c_code1 + '&c_code2=' + c_code2 + '&c_code3=' + c_code3);
				exit;
			}
			else return;
		}
	}
</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Product Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 cellpadding=2 bgcolor='#a9a9a9'>
<script>
	function add_mainitem(str){

		tf  = document.register;

		tf.Mode.value = 'main_update';
		tf.view_position.value = str;

		tf.method = 'POST';
		tf.action = 'product.php';
		tf.submit();
	}
</script>
<form name=register method=get>
<input type=hidden name=Mode value="SAVE">
<input type=hidden name=view_position value="">
<input type=hidden name=area value="<?= $area ?>">
<input type=hidden name=pCode value="">
<tr bgcolor='#eee8aa'>
	<td colspan=7 height=35>&nbsp;&nbsp;
	<select name=c_code1 onChange="chg1()">
		<option value="ALL" <? if(empty($c_code1)) echo "selected"; ?>>ALL
		<?
		echo $printValue[Category];
		?>
	</select>&nbsp;
	<select name=c_code2 onChange="chg2()">
		<?
		echo $printValue2[Category];
		?>
		<option value="ALL" <? if($c_code2 == "0") echo "selected"; ?>>ALL
	</select>&nbsp;
	<select name=c_code3 onChange="chg3()">
		<? 
		//echo "$printValue[second_value] $printValue2[third_value]";
		//printCategory3($printValue[second_value],$printValue2[third_value]); 
		echo $printValue3[Category];
		?>
		<option value="ALL" <? if($c_code3 == "0") echo "selected"; ?>>ALL
	</select>	
	</td>
</tr>
<tr bgcolor='#ffffff'>
	<td colspan=7 height=40 align=left>&nbsp;
	&nbsp;<input type=text name=S_content size=26 value="<?= $_GET['S_content'] ?>">&nbsp;
	&nbsp;&nbsp;<input type=submit value="Search"></td>
</tr>
<tr bgcolor=#FFFFFF>
	<td colspan=7 height=25 align=right>&nbsp;Total item : <font color=red><?= $total_product1; ?></font>&nbsp;</td>
</tr>
<tr bgcolor=#eee8aa>
	<td align=center width=5%>No</td>
	<td align=center width=20%>Img</td>
	<td align=center width=25% height=30>Item / Title</td>
	<td align=center width=10% align=center>Model#</td>
	<td align=center width=10% align=center>Stock</td>
	<td align=center width=20%>Net/Price/Discount</td>
	<td align=center width=10%>Modify</td>
</tr>
<? contentPrint(); ?>
<tr bgcolor=#FFFFFF>
	<td colspan=3>&nbsp;<button type="button" class="btn btn-success" onClick="add_mainitem('FEATURED')">FEATURED PRODUCT</button>&nbsp;<button type="button" class="btn btn-success" onClick="add_mainitem('BEST_SELLER')">BEST SELLER</button></td>
	<td colspan=4 height=25 align=center>&nbsp;<? admin_pageNavigation(); ?>&nbsp;</td>
</tr>
</table>
</form>
<BR><BR><BR>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>