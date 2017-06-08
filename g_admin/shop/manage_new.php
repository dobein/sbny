<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_mainitem";

	if($_POST['Mode'] == "SAVE")
	{
		$seqNo = $_POST['seqNo'];

		for($i = 0; $i<count($seqNo); $i++)
		{
			//echo $seqNo[$i]."<br>";
			$re_qry1 = "delete from $tableName where seq_no = '$seqNo[$i]'";
			$re_rst1 = mysql_query($re_qry1,$dbConn);		
		}

		Misc::jvAlert("Completed!","location.replace('manage_new.php?flag=$flag')");
		exit;	
	}


	if(!$flag)
	{
		$flag = "New";
	}


	if(!$start)
			{
			$start = 0;
			}

	$board_scale = 20;
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

		global $dbConn,$start,$total,$scale,$page,$page_last,$page_scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$codeValue,$flag;


		if($Mode == "SEARCH")
		{
		# how : 검색카테고리,
		# S_date : 검색일자.
		# category = 1 : 공지사항

				switch($how){

					case "1":
							$S_category = "name like '%$S_content%'";
							break;
					case "2":
							$S_category = "title like '%$S_content%'";
							break;
							break;
					case "3":
							$S_category = "content like '%$S_content%'";
							break;
				}


				$que = "select * from $tableName where p_code1 = '$codeValue[0]' && p_code2 = '$codeValue[1]' && p_code3 = '$codeValue[2]' order by seq_no desc limit $start,$scale";
				//print_r($que);
		}
		else
		{

				$que = "select * from $tableName where view_position = '$flag' order by seq_no desc limit $start,$scale";

				//print_r($que);
		}

		$page=floor($start/($scale*$page_scale));

		$result=mysql_query($que);
		$result_rows=mysql_num_rows($result);



		$total=mysql_affected_rows();
		$last=floor($total/$scale);

		/**
		* 페이징을 위한 토탈을 구한다.
		*/
		if($Mode == "SEARCH")
				{
						$page_total_qry = mysql_query("select count(*) from $tableName where p_code1 = '$codeValue[0]' && p_code2 = '$codeValue[1]' && p_code3 = '$codeValue[2]'");
				}
		else
				{
						$page_total_qry = mysql_query("select count(*) from $tableName where view_position = '$flag'");
				}

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
				$item_info = get_iteminfo($row[itemCode]);

				$file_name = "thum_".get_firstpic($item_info[userfile1]);

				if($item_info[userfile1])
					{
						$file_image = "<img src=\"../../thum_upload/$file_name\" border=0 style='border-color=#CCCCCC'>";
					}
				else
					{
						$file_image = "<font style='color:#CCCCCC'>No images</font>";
					}

				$item_info[item_title] = Misc::cutLongString($item_info[item_title], 30, $dot=true);

				// 상품 가격가져오기
				$item_price = get_itemPricehistory($row[itemCode]);

				$brand_name = brand_name($item_info[brand]);

				$c_name1 = Category_name_member('BIG',$row[p_code1],'0','0');
				//$c_name2 = Category_name_member('MIDDLE',$row[p_code1],$row[p_code2],'0');
				//$c_name3 =Category_name_member('SMALL',$row[p_code1],$row[p_code2],$row[p_code3]);

				$category_name = "<span class='blue'>$c_name1 / $c_name2 / $c_name3</span>";


				$table_content="
					<tr bgcolor=#FFFFFF>
						<td align=center><input type=checkbox name=seqNo[] value=$row[seq_no]></td>
						<td align=center height=30>$file_image</td>
						<td align=left>&nbsp;[$brand_name] $item_info[item_title]</td>
						<td align=center >$$item_info[item_costco]</td>
						<td align=center >$$item_info[item_price1]</td>
						<td align=center >$$item_info[item_price2]</td>
						<td align=left>&nbsp;$c_name1 Category</td>
					</tr>
				";


			// table 뿌려주기
			echo $table_content;

                }
        $n--;
        }

        }
        else
        {
                echo "
                            <tr bgcolor=#FFFFFF> 
                              <td align=center height=50 colspan=7>Empty</td>
                            </tr>
                ";
        }
        }//contentPrint function end


        /**
        * 게시물 페이징
        */
        function admin_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$S_date,$S_content,$how,$Category3,$flag;

        $Parameter_value = "flag=$flag&Mode=$Mode&Category3=$Category3&S_date=$S_date&how=$how&S_content=$S_content";

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



	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>

	function change_print(status,no,position){
		
		alert(no);

	}

</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Product Best</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 cellpadding=2 bgcolor='#a9a9a9'>
<form name=register action=<?= $_SERVER['PHP_SELF'] ?> method=post>
<input type=hidden name=Mode value="SAVE">
<input type=hidden name=flag value="<?= $flag ?>">
	<tr bgcolor='#FFFFFF'>
		<td colspan=7 align=left height=40>&nbsp;
		<a href=<?= $_SERVER['PHP_SELF'] ?>?area=<?= $area ?>&flag=New>New Arrival Items</a><!--  |
		<a href=<?= $_SERVER['PHP_SELF'] ?>?area=<?= $area ?>&flag=Best>Best Sellers</a> | 
		<a href=<?= $_SERVER['PHP_SELF'] ?>?area=<?= $area ?>&flag=Trendy>Trendy</a> | 
		<a href=<?= $_SERVER['PHP_SELF'] ?>?area=<?= $area ?>&flag=FIRST_BEST>Best products of main category --></a>
		</td>
	</tr>
	<tr bgcolor='#eee8aa'>
		<td align=center width=5%>No</td>
		<td align=center width=10%>Image</td>
		<td align=center width=25% height=30>Name</td>
		<td align=center width=10%>Regular Price</td>
		<td align=center width=10%>Our Price</td>
		<td align=center width=10%>Sale Price</td>
		<td align=center width=30%>Category</td>
	</tr>
	<? contentPrint(); ?>
	<tr bgcolor=#FFFFFF>
		<td colspan=7 height=35 align=center>&nbsp;<? admin_pageNavigation(); ?>&nbsp;</td>
	</tr>
	<tr bgcolor=#FFFFFF>
		<td colspan=7 height=35 align=left>&nbsp;<input type=submit value="Delete"></td>
	</tr></form>
</table>
<br>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>