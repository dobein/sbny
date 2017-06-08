<?
	include "./include/inc_base.php";

	/*
	* 첫번째 카테고리 값 가져오기
	*/

	$no = mysql_real_escape_string(htmlentities($_GET['no']));

	$pos = mysql_real_escape_string(htmlentities($_GET['pos']));

	if(!$pos)
		{
		$p_qry1 = "select min(pos) from chan_shop_faqcategory";
		$p_rst1 = mysql_query($p_qry1,$dbConn);
		$pos = mysql_result($p_rst1,0,0);
		//$pos = "1";
		}


	$f_qry1 = "select * from chan_shop_faqcategory where pos='$pos'";
	$f_rst1 = mysql_query($f_qry1,$dbConn);
	$f_row1 = mysql_fetch_array($f_rst1);


	$tableName = "chan_shop_faqboard";

	if(!$start)
			{
			$start = 0;
			}

	$board_scale = 10;
	$board_page = 10;

	/**
	* 한페이지당 글수
	*/
	$scale=$board_scale;

	/**
	* 한페이지당 페이지수
	*/
	$page_scale=$board_page;



	if($Mode == "SEARCH")
	{
	switch($how){
			case "1":
					$S_category = "where name like '%$S_content%' order by seq_no asc limit $start,$scale";
					break;
			case "2":
					$S_category = "where userid like '%$S_content%' order by seq_no asc limit $start,$scale";
					break;
			case "3":
					$S_category = "where level='$S_content' order by seq_no asc limit $start,$scale";
					break;
			case "4":
					$S_category = "order by point desc";
					break;
			}

			$que = "select * from $tableName $S_category";
			echo $que;
	}
	else
	{
	$que = "select * from $tableName where category_no='$pos' order by seq_no asc limit $start,$scale";
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
			$page_total_qry = mysql_query("select count(*) from $tableName $S_category");
			}
	else
			{
			$page_total_qry = mysql_query("select count(*) from $tableName where category_no='$pos'");
			}

	$page_total = mysql_result($page_total_qry,0,0);
	$page_last = floor($page_total/$scale);


	/**
	* 총 페이지수
	*/
	$total_page_num = ceil($page_total/$scale);

	$now_page_num = floor($start/$scale) + 1;


        /**
        * 게시판 내용뿌려주기 함수
        */
        function contentPrint(){

			global $dbConn,$area,$category,$sub_category,$start,$total,$scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$base_row1,$no,$pos,$sub_category;

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

				// 아이디값
				$s_id = "submenu_prodeval".$row[seq_no];


				$row[content] = nl2br(stripslashes($row[content]));

				//$row[title] = iconv("UTF-8","EUC-KR",$row[title]);
				//$row[content] = iconv("EUC-KR","UTF-8",$row[content]);

				// <a onclick=\"menu('$row[seq_no]')\" style=\"cursor:hand\"style=\"color:#4CAAC7\"> </a>
				// id=$s_id style=\"DISPLAY: none;\"
				$table_content= "
					<tr>
						<td width=80% height=30 align=left>&nbsp;$file_icon<font color=#FF6600>$row[title]</font></td>
						<td width=20% align=center>&nbsp;</td>
					</tr>
					<tr >
						<td colspan=2 height=50 valign=top style='padding:10;'  align=left>$row[content]</td>
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
                <tr>
                        <td height=80><p align=center>Nothing Found.</p></td>
                </tr>
                ";
        }
        }//contentPrint function end

        /**
        * 게시물 페이징
        */
        function pageNavigation(){

        global $page_total,$area,$category,$sub_category,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$S_date,$S_content,$how,$pos,$no;

        $Parameter_value = "area=$area&category=$category&sub_category=$sub_category&no=$no&pos=$pos&Mode=$Mode&S_date=$S_date&how=$how&S_content=$S_content";

        if($page_total>$scale) //검색 결과가 페이지당 출력수보다 크면
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<a href='$PHP_SELF?start=0&$Parameter_value'>[first]</a>&nbsp;";
                echo "<a href='$PHP_SELF?start=$pre_start&$Parameter_value'>...</a>&nbsp;";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<a href='$PHP_SELF?start=$ln&$Parameter_value'><font class=darkgray> $vk </a></font>";
                        }
                        else
                        {
                        echo "<font class=darkgray><b>[$vk]</b></font>";
                        }
                }
            }
        if($page_total>(($page+1)*$scale*$page_scale))
                {
                $n_start=($page+1)*$scale*$page_scale;
                $last_start=$page_last*$scale;
                echo "&nbsp;<a href='$PHP_SELF?start=$n_start&$Parameter_value'>...</a>&nbsp;";
                echo "<a href='$PHP_SELF?start=$last_start&$Parameter_value'>[last]</a>";
                }
        }
        }// pageNavigation function end

	include _BASE_DIR ."/include/inc_top.php";
?>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; <a href=<?= _WEB_BASE_DIR ?>/>Home</a>  >  <b>FAQ</b></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td>
							<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width=25% valign=top height=450 >
			<table width=95% align=center border=0 cellpadding=0 cellspacing=0 bgcolor=#FFFFFF>
 				<?

					$g_qry = "select * from chan_shop_faqcategory order by pos asc";
					$g_result=mysql_query($g_qry,$dbConn);
					
					while($g_obj = mysql_fetch_array($g_result))
					{
						// 갯수 세기
						$n_qry1 = "select count(*) from chan_shop_faqboard where category_no='$g_obj[pos]'";
						$n_rst1 = mysql_query($n_qry1,$dbConn);
						$n_num = mysql_result($n_rst1,0,0);

						echo "<tr><td height=35 style=\"padding-left:15px\"><a href=faq.php?no=$g_obj[seq_no]&pos=$g_obj[pos] >$g_obj[name] ({$n_num})</a></td></tr>";
					}



				?>
			</table>	
									</td>
									<td width=75% valign=top bgcolor=#FFFFFF >
									<!-- 메인 메뉴 -->
									<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
										<tr>
											<td height=30  align=left >&nbsp;<b><?= $f_row1[name]; ?></b></td>
										</tr>
										<tr><td bgcolor="#cccccc" height="1"></td></tr>
									</table>
									<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
										<? contentPrint(); ?>
									</table>
									<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
										<tr>
											<td align=center height=30><? pageNavigation(); ?></td>
										</tr>
									</table>

									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
			<br><br>


<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>