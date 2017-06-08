<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	if($_POST['mode'] == "save")
		{
			$pos = $_POST['pos'];
			$title = addslashes($_POST['title']);
			$content = addslashes($_POST['content']);
			$etc = $_POST['etc'];

			$qry1 = "insert into chan_shop_faqboard values ('','$pos','$title','$content','$etc')";
			$rst1 = mysql_query($qry1,$dbConn);
			
			if($rst1)
				{
				Misc::jvAlert("Completed!.","location.replace('faq_list.php?no=$no&pos=$pos')");
				exit;
				}
			else
				{
				Misc::jvAlert("Fail!","history.go(-1)");
				exit;
				}
		}
	else if($_POST['mode'] == "c_save")
	{
			$c_name = $_POST['c_name'];


			// pos 값 구하기
			$qry2 = "select max(pos) from chan_shop_faqcategory";
			$rst2 = mysql_query($qry2,$dbConn);
			$row2 = @mysql_result($rst2,0,0);

			if(!$row2)
				{
				$row2 = "1";
				}
			else
				{
				$row2++;
				}

			$qry1 = "insert into chan_shop_faqcategory values ('','$c_name','$row2')";
			$rst1 = mysql_query($qry1,$dbConn);

			if($rst1)
				{
				Misc::jvAlert("Completed!.","location.replace('faq_list.php?no=$no&pos=$pos')");
				exit;
				}
			else
				{
				Misc::jvAlert("Fail!","history.go(-1)");
				exit;
				}
	}

	/*
	* 첫번째 카테고리 값 가져오기
	*/

	$pos = $_GET['pos'];

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
        function faq_contentPrint(){

			global $dbConn,$area,$category,$sub_category,$start,$total,$page,$last_page,$scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$base_row1,$no,$pos,$sub_category;

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


				$row[content] = nl2br($row[content]);


				$admin_msg = "<a href=\"javascript:modify('$row[seq_no]','$pos')\"><font color=999999>M</font></a><font color=999999> | </font><a href=\"javascript:del('$row[seq_no]','$pos')\"><font color=999999>D</font></a>";


				$table_content= "
					<tr>
						<td width=80% height=30>&nbsp;$file_icon<a onclick=\"menu('$row[seq_no]')\" style=\"cursor:hand\"style=\"color:#4CAAC7\">$row[title]</a></td>
						<td width=20% align=center>$admin_msg</td>
					</tr>
					<tr id=$s_id style=\"DISPLAY: none;\">
						<td colspan=2 height=50 valign=top style='padding:10;'>$row[content]</td>
					</tr>
					<tr><td colspan=2 bgcolor=#eeeeee height=1></td></tr>
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
                        <td height=80><p align=center>Nothing Found!</p></td>
                </tr>
                ";
        }
        }//contentPrint function end

        /**
        * 게시물 페이징
        */
        function faq_pageNavigation(){

        global $page_total,$area,$category,$sub_category,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$S_date,$S_content,$how,$pos,$no;

        $Parameter_value = "area=$area&category=$category&sub_category=$sub_category&no=$no&pos=$pos&Mode=$Mode&S_date=$S_date&how=$how&S_content=$S_content";

        if($page_total>$scale) //검색 결과가 페이지당 출력수보다 크면
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<a href='?start=0&$Parameter_value'>[first]</a>&nbsp;";
                echo "<a href='?start=$pre_start&$Parameter_value'>...</a>&nbsp;";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<a href='?start=$ln&$Parameter_value'><font class=darkgray> $vk </a></font>";
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
                echo "&nbsp;<a href='?start=$n_start&$Parameter_value'>...</a>&nbsp;";
                echo "<a href='?start=$last_start&$Parameter_value'>[last]</a>";
                }
        }
        }// pageNavigation function end


	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> FAQ Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<script>
		function regi_category2(no,area,category,sub_category){
			window.open("ysetup_category.php","write","width=500,height=400,scrollbars=yes,resizable=no,top=" + ((screen.height - 620) / 2) + ", left=" + ((screen.width - 330) / 2));
		}
		function regi_category(){
		
				tf = document.category_list;

				if(confirm('Do you want to add new FAQ Category?') == true)
				{
					tf.action = 'faq_list.php';
					tf.submit();
				}
				else return;
		}

		function del(seqNo,pos){
			answer = confirm("Delete?");

			if(answer == true)
				{
					location.replace('y_process.php?mode=del&seqNo=' + seqNo + '&pos=' + pos);
				}
			else return;
		}
		function modify(seqNo,pos){
			window.open("ysetup_boardmodify.php?seqNo=" + seqNo + "&pos=" + pos,"write","width=500,height=400,scrollbars=yes,resizable=no,top=" + ((screen.height - 620) / 2) + ", left=" + ((screen.width - 330) / 2));				
		}

		var old='';
		function menu(name){
				
			submenu=eval("submenu_prodeval"+name+".style");

			if(old!=submenu)
			{
				if(old!='')
				{
					old.display='none';
				}
				submenu.display='block';
				old=submenu;
			}
			else
			{
				submenu.display='none';
				old='';
			}
		}
</script>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=left height=25 bgcolor=#eee8aa>&nbsp;&nbsp;<b>FAQ Category</b></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td colspan=2>
			<table width=100% border=0 cellpadding=0 cellspacing=0 class="default_text">
			<form name=category_list method=post>
			<input type=hidden name=mode value="c_save">
				<?
					$g_board_row = 10;
					$g_board_col = 3;
					$g_start = 0;
					$g_cols = $g_board_col;
					$g_limit = $g_board_row*$g_board_col;
					$g_scale=$g_limit;
					$g_qry = "select * from chan_shop_faqcategory order by pos asc limit $g_start,$g_limit";
					$g_result=mysql_query($g_qry,$dbConn);
					$g_total=mysql_num_rows($g_result);
					
					for($i=0; $i < $g_total;)

					{

					echo "<tr>";


					if($g_total < $g_cols)

						{ 		

						$g_cols = $g_total;

						}

								for($j=0; $j < $g_cols; $j++,$i++)

										{     

										$g_obj = mysql_fetch_array($g_result);

										// 갯수 세기
										$n_qry1 = "select count(*) from chan_shop_faqboard where category_no='$g_obj[pos]'";
										$n_rst1 = mysql_query($n_qry1,$dbConn);
										$n_num = mysql_result($n_rst1,0,0);


										if($g_obj[seq_no])
											{
											echo "
														<td width=33%>
																	<table width=100% border=0 cellspacing=0 cellpadding=0 class=default_text>
																	<tr> 
																	  <td height=25>&nbsp;&nbsp;&nbsp;&nbsp;<a href=faq_list.php?no=$g_obj[seq_no]&pos=$g_obj[pos]><font color=#00688B><b>$g_obj[name]</b></font></a>&nbsp;({$n_num})</td>	
																	</tr>
																  </table>
														</td>
																	
											";
											}

										else

											{					

											echo "<td width=33%>&nbsp;</td>";

											}
										//unset($sub_category);
										}
									echo "</tr>";

								}
				?> 
		</table>		
		</td>
	</tr>
	<tr>
		<td align=right height=35 bgcolor=#FFFFFF><input type=text name=c_name size=20 class="form_box"> <input type=button value="Add category" onClick="javascript:regi_category()">&nbsp;&nbsp;<input type=button value="Category Manage" onClick="javascript:regi_category2()"></td>
	</tr></form>
</table>


<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
	<tr><td bgcolor="#CCCCCC" height="1"></td></tr>
	<tr>
		<td height=30 bgcolor=#f4f4f4>&nbsp;<b><?= $f_row1[name] ?></b></td>
	</tr>
	<tr><td bgcolor="#CCCCCC" height="1"></td></tr>
</table>
<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
	<? faq_contentPrint(); ?>
</table>
<table width=100% align=center border=0 cellpadding=0 cellspacing=0 >
	<tr>
		<td align=center height=30><? faq_pageNavigation(); ?></td>
	</tr>
</table>
<br>
<table width=100% align=center border=0 cellpadding=0 cellspacing=0>
	<tr><td bgcolor="#CCCCCC" height="1"></td></tr>
	<tr>
		<td valign=top>
		<table width=100% border=0 cellpadding=0 cellspacing=0 class="default_text">
		<script>
			function chk(tf){

				if(!tf.title.value)
					{
					alert('제목이 빠졌습니다.');
					tf.title.focus();
					return false;
					}
				if(!tf.content.value)
					{
					alert('내용이 빠졌습니다.');
					tf.content.focus();
					return false;
					}
				return true;
			}
		</script>
		<form name=board action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)">
		<input type=hidden name=mode value="save">
		<input type=hidden name=no value="<?= $no ?>">
		<input type=hidden name=pos value="<?= $pos ?>">
			<tr>
				<td colspan=2 height=35 bgcolor=#f4f4f4>&nbsp;&nbsp;Content of <b><?= $f_row1[name] ?></b> </td>
			</tr>
			<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
			<tr>
				<td width=20% height=28 bgcolor=#f4f4f4>&nbsp;&nbsp;Title</td>
				<td><input type=text name=title size=50 class="form_box"></td>
			</tr>
			<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
			<tr>
				<td height=28 bgcolor=#f4f4f4>&nbsp;&nbsp;Content</td>
				<td><textarea name=content cols=70 rows=8 class="form_box"></textarea></td>
			</tr>
			<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
			<tr>
				<td height=35 colspan=2 align=center><input type=submit value="   ADD   " class="form_box"></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>