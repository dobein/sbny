<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_page";

	if($_POST['mode'] == "del")
	{
		$qry1 = "delete from $tableName where item_code = '$itemCode'";
		$rst1 = mysql_query($qry1,$dbConn);

	}



	if($_POST['mode'] == "SEARCH")
	{
		$codeValue = explode("/",$Category3);
	}


	if(!$start)
			{
			$start = 0;
			}

	$board_scale = 25;
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

		global $dbConn,$start,$total,$scale,$page,$page_last,$page_scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$c_code1,$c_code2,$c_code3,$first_result1,$second_result1,$search_flag,$search_code,$area;


		if($_POST['mode'] == "SEARCH")
		{
		# how : 검색카테고리,
		# S_date : 검색일자.
		# category = 1 : 공지사항

				if($search_flag == "1")
				{

					switch($search_code){

						case "1":
								$S_category = "item_name like '%$S_content%'";
								break;
						case "2":
								$S_category = "item_title like '%$S_content%'";
								break;
						case "3":
								$S_category = "item_code like '%$S_content%'";
								break;
					}


					$que = "select * from $tableName where $S_category order by seq_no desc limit $start,$scale";
				//print_r($que);
				}
				else
				{
					$que = "select * from $tableName where p_code1 = '$c_code1' && p_code2 = '$c_code2' && p_code3 = '$c_code3' order by seq_no desc limit $start,$scale";
				//print_r($que);
				}

		}
		else
		{

				$que = "select * from $tableName order by item_name asc limit $start,$scale";
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
		if($_POST['mode'] == "SEARCH")
				{
					if($search_flag == "1")
					{
					
					switch($search_code){

						case "1":
								$S_category = "item_name like '%$S_content%'";
								break;
						case "2":
								$S_category = "item_title like '%$S_content%'";
								break;
						case "3":
								$S_category = "item_code like '%$S_content%'";
								break;
					}

						$page_total_qry = mysql_query("select count(*) from $tableName where $S_category");
					}
					else
					{
						$page_total_qry = mysql_query("select count(*) from $tableName");
					}

				}
		else
				{
						$page_total_qry = mysql_query("select count(*) from $tableName");
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


				$table_content="
					<tr bgcolor=#FFFFFF>
						<td align=center>$n</td>
						<td align=center><b>$row[item_code]</b></td>
						<td align=left height=28>&nbsp;<a href=page_modify.php?area=$area&no=$row[seq_no]&item_code=$row[item_code]>$row[item_name]</a></td>
						<td align=center ><a href=page_modify.php?area=$area&item_code=$row[item_code]>Modify</a></td>
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
                              <td align=center height=50 colspan=4>Empty items</td>
                            </tr>
                ";
        }
        }//contentPrint function end


        /**
        * 게시물 페이징
        */
        function admin_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$S_date,$S_content,$how,$Category3;

        $Parameter_value = "Mode=$Mode&Category3=$Category3&S_date=$S_date&how=$how&S_content=$S_content";

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
	function add_product(){
		//alert(document.category.Category3.value);
		location.replace('page_add.php?area=5-4');
	}

</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Page Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<form name=register action=<?= $_SERVER['PHP_SELF'] ?> method=post>
<input type=hidden name=Mode value="SAVE">
<tr bgcolor=#eee8aa>
	<td align=center width=10% height=30>No</td>
	<td align=center width=20%>Item Code</td>
	<td align=center width=60%>Item Name</td>
	<td align=center width=10%>Modify</td>
</tr>
<? contentPrint(); ?>
<!-- <tr bgcolor=#FFFFFF>
	<td colspan=3 height=35 align=center>&nbsp;<? admin_pageNavigation(); ?>&nbsp;</td>
</tr> -->
<tr bgcolor=#FFFFFF>
	<td colspan=4 height=40 align=left>
		<table width=100% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td width=50%>&nbsp;</td>
				<td width=50% height=40 align=right>
				<input type=button value=" Add item " onClick="add_product()">&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</td>
</tr></form>
</table>
<BR><BR><BR>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>