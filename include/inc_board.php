<?
	/**
	* 게시판 시작
	*/
	//mysql_query("set names utf8");

	$tableName = "chan_shop_board";


	
	if(!$_GET['table_id'])
	{
		//Misc::jvAlert("테이블명이 없습니다.","history.go(-1)");
		$table_id = "health";
	}


	switch($_GET['table_id'])
	{
		case "health":
			$board_title = "건강상식";
			break;
		case "sample":
			$board_title = "게르마늄 사용후기";
			break;
	}

	if(!$_GET['board_mode'])
	{
		$board_mode = "list";
	}

	if($board_mode == "list")
	{
		if(!$_GET['start'])
				{
				$start = 0;
				}
		else
		{
			$start = $_GET['start'];
		}

		$board_scale = 30;
		$board_page = 10;

		/**
		* 한페이지당 글수
		*/
		$scale=$board_scale;

		/*
		* 한페이지당 페이지수
		*/
		$page_scale=$board_page;
	}
	else if($_GET['board_mode'] == "view")
	{
		$no = $_GET['no'];

		$board_qry1 = "update $tableName set count=count+1 where seq_no='$no'";
		$board_rst1 = mysql_query($board_qry1,$dbConn);

		$board_qry2 = "select * from $tableName where seq_no='$no'";
		$board_rst2 = mysql_query($board_qry2,$dbConn);
		$board_row2 = mysql_fetch_assoc($board_rst2);

		// 비밀글이라.. 확인이 필요함
		if($mode_action == "security_save")
		{
			if($thisPagepasswd != $board_row2[passwd])
			{
				Misc::jvAlert("패스워드가 일치하지 않습니다.","history.go(-1)");
				exit;
			}
			else
			{
				$thisPagepasswd = $board_row2[passwd];
			}
		}

		//$t_date = date("Y-m-d",$row[wdate]);
		$today = explode(" ",$board_row2[wdate]);


		// 자동링크걸기
		function auto_link($text) 
		{ 
			$text = str_replace(";", "", $text);
		#******* www 
		$text = eregi_replace("([^/])www([0-9a-zA-Z./@~?&=_-]+)","\\1http://www\\2", $text); 

		#******* http 
		$text = eregi_replace("http://([0-9a-zA-Z./@~?&=_-]+)", "<a href=\"http://\\1\" target='_blank'>http://\\1</a>", $text); 

		#******* ftp 
		$text = eregi_replace("ftp://([0-9a-zA-Z./@~?&=_-]+)", "<a href=\"ftp://\\1\" target='_blank'>ftp://\\1</a>", $text); 

		#******* email 
		$text = eregi_replace("([_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*)@([0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*)", "<a href=\"mailto:\\1@\\3\">\\1@\\3</a>", $text); 

		return $text; 
		}
		
		/*
		if($board_row2[html_check] != "1")
			{
			$content = nl2br(htmlspecialchars($board_row2[content]));

			// HTML사용안할 경우 맞춤법에 맞지 않는 단어가 깨져 보이는 현상 제거 (BAWOO_30313)
			$content = eregi_replace("&amp;#","&#",$content);

			$content = auto_link($content);
			} 
		else 
			{
				$content = $board_row2[content];
			}
		*/

		$title = iconv("EUC-KR","UTF-8",$board_row2[title]);
		$content = iconv("EUC-KR","UTF-8",$board_row2[content]);

		$content = nl2br($content);

		if($board_config[noname_level] == "2")
			{
				$writer_name = "******";
			}
		else
			{
				if($board_row2[email])
				{
					$email = "( $board_row2[email] )";
				}

				$writer_name = "$board_row2[userid] $email";
			}


		if(!$board_row2[userfile1])
			{
				$down_file1 = "첨부파일 없음";
			}
		else
			{
				$down_file1 = "<a href=\"javascript:Download('$board_row2[userfile1]')\">$board_row2[userfile1]</a>";
			}

		if(!$board_row2[userfile2])
			{
				$down_file2 = "첨부파일 없음";
			}
		else
			{
				$down_file2 = "<a href=\"javascript:Download('$board_row2[userfile2]')\">$board_row2[userfile2]</a>";
			}

		$draw_file1 = Misc::getFileExtension($board_row2[userfile1]);
		if($draw_file1 == "gif" || $draw_file1 == "jpg" || $draw_file1 == "bmp" ||
		   $draw_file1 == "GIF" || $draw_file1 == "JPG" || $draw_file1 == "BMP" || $draw_file1 == "jpeg"){

			$img_size = getimagesize("../board_upload/$board_row2[userfile1]");

			$board_photo_size = 500;

			// 가로이미지가 기준값보다 작을경우 그대로 출력
			if($board_photo_size>$img_size[0])
				{
				$board_photo_size = $img_size[0];
				}
			else
				{
				$board_photo_size = 500;
				}


			$draw1 = "<p align=center><a href=\"javascript:popimage('$board_row2[userfile1]',$img_size[0],$img_size[1])\"><img src=\"../board_upload/$board_row2[userfile1]\" width=$board_photo_size border=0></a></p>";
		}

		$draw_file2 = Misc::getFileExtension($board_row2[userfile2]);
		if($draw_file2 == "gif" || $draw_file2 == "jpg" || $draw_file2 == "bmp" ||
		   $draw_file2 == "GIF" || $draw_file2 == "JPG" || $draw_file2 == "BMP" || $draw_file1 == "jpeg"){

			$img_size2 = getimagesize("../board_upload/$board_row2[userfile2]");

			$board_photo_size2 = 500;

			// 가로이미지가 기준값보다 작을경우 그대로 출력
			if($board_photo_size2>$img_size2[0])
				{
				$board_photo_size2 = $img_size2[0];
				}
			else
				{
				$board_photo_size2 = 500;
				}
			
			$draw2 = "<p align=center><a href=\"javascript:popimage('$board_row2[userfile2]',$img_size2[0],$img_size2[1])\"><img src=\"../board_upload/$board_row2[userfile2]\" width=$board_photo_size2 border=0></a></p>";
		}

	}
	else if($board_mode == "modify")
	{
		$board_qry2 = "select * from $tableName where seq_no='$no'";
		$board_rst2 = mysql_query($board_qry2,$dbConn);
		$board_row2 = mysql_fetch_assoc($board_rst2);

		if($board_config[noname_level] == "2")
			{
				$writer_name = "******";
			}
		else
			{
				$writer_name = "$board_row2[name]";
			}

	}
	else if($board_mode == "modify_write")
	{
		$qry5 = "select * from $tableName where seq_no='$no'";
		$rst5 = mysql_query($qry5);
		$row5 = mysql_fetch_array($rst5);



			if($row5[userid] != $user_info[user_id])
			{
				Misc::jvAlert("Check your password!.","history.go(-1)");
				exit;
			}

		if($photo_del1 != "1")
		{
		if(empty($_FILES['userfile1']['name']))
			{
			$attc1_name[savedName] = $row5[userfile1];
			}
		else
			{
			$tmpName1 = $HTTP_POST_FILES['userfile1']['tmp_name'];

			if(is_uploaded_file($tmpName1)){
				$pds_file1 = $HTTP_POST_FILES['userfile1']['name'];
				$board_pds_pos = "../board_upload";
				$attc1_name = Misc::uploadFileUnsafely($tmpName1 , $pds_file1 , $board_pds_pos);

				}
			}
		}
		else
		{
		@unlink("../board_upload/$row5[userfile1]");
		$attc1_name[savedName] = "";
		}


		$qry2 = "update $tableName set email = '$email', title='$title', content='$content', html_check='$html_check', userfile1='$attc1_name[savedName]', userfile2='$attc2_name[savedName]' where seq_no = '$no'";
		$rst2 = mysql_query($qry2,$dbConn);

		if($rst2)
                {
                echo "<meta http-equiv='refresh' content='0; url=./board_view.php?board_mode=view&table_id=$table_id&directory=$directory&no=$no&start=0&Mode=&how=&S_content='>";
                exit;
                }
        else
                {
                Misc::jvAlert('실패!','history.go(-1)');
                }
	}
	else if($board_mode == "cmt_save")
	{
			
		$qry1 = "insert into chan_shop_boardcomment values ('','NY','$table_id','$no','$comment',now(),'$member_info[user_id]')";
		$rst1 = mysql_query($qry1,$dbConn);

		if($rst1)
                {
                echo "<meta http-equiv='refresh' content='0; url=./view.php?board_mode=view&table_id=$table_id&directory=$directory&no=$no&start=0&Mode=&how=&S_content='>";
                exit;
                }
        else
                {
                Misc::jvAlert('실패!','history.go(-1)');
                }

	}
	else if($board_mode == "cmt_del")
	{
		$qry1 = "delete from chan_shop_boardcomment where seq_no = '$seqNo'";
		$rst1 = mysql_query($qry1,$dbConn);

		if($rst1)
                {
                echo "<meta http-equiv='refresh' content='0; url=./view.php?board_mode=view&table_id=$table_id&directory=$directory&no=$no&start=0&Mode=&how=&S_content='>";
                exit;
                }
        else
                {
                Misc::jvAlert('실패!','history.go(-1)');
                }
	}
	else if($board_mode == "write")
	{
        // 쓰기처리
        $str_query=mysql_query("select max(seq_no),min(fid) from $tableName",$dbConn);
        if(!str_query)
                {
                Misc::jvAlert('고유값이 없습니다.','history.go(-1)');
                }
        $row = mysql_fetch_row($str_query);

        if($row[0]){
                $new_seq_no = $row[0] + 1;
                }
        else {
                $new_seq_no = 1;
                }

        if($row[1]){
                $new_fid = --$row[1];
                }
        else {
                $new_fid = -1;
                }


		$tmpName1 = $HTTP_POST_FILES['userfile1']['tmp_name'];

		if(is_uploaded_file($tmpName1)){
				$pds_file1 = $HTTP_POST_FILES['userfile1']['name'];
				$board_pds_pos = "../board_upload";
				$attc_name1 = Misc::uploadFileUnsafely($tmpName1 , $pds_file1 , $board_pds_pos);
				}

		$tmpName2 = $HTTP_POST_FILES['userfile2']['tmp_name'];

		if(is_uploaded_file($tmpName2)){
				$pds_file2 = $HTTP_POST_FILES['userfile2']['name'];
				$board_pds_pos = "../board_upload";
				$attc_name2 = Misc::uploadFileUnsafely($tmpName2 , $pds_file2 , $board_pds_pos);
				}

        // query insert
        $ip = $REMOTE_ADDR;
        $wdate = time();

		if(!$HTTP_COOKIE_VARS[MEMLOGIN_INFO])
		{
			$user_id = $user_name;
			$user_name = $user_name;
		}
		else
		{
			$user_id = $user_info[user_id];
			$user_name = $user_info[last_name].$user_info[first_name];
		}

		//$content = addslashes($content);

        $query = "insert into $tableName (
                                seq_no,
                                fid,
                                thread,
								area,
								tablename,
                                category,
                                userid,
                                name,
                                email,
                                itemCode,
                                title,
                                content,
                                userfile1,
								userfile2,
                                html_check,
                                passwd,
                                count,
                                ip,
                                vote,
                                reply_mail,
                                wdate
                                ) values (
                                '$new_seq_no',
                                '$new_fid',
                                'A',
								'$choose_lang',
								'$table_id',
                                '$category',
                                '$user_id',
                                '$user_name',
                                '$email',
                                '$itemCode',
                                '$title',
                                '$content',
                                '$attc_name1[savedName]',
								'$attc_name2[savedName]',
                                '$html_check',
                                '$passwd',
                                0,
                                '$ip',
                                '$vote',
                                '$reply_mail',
                                now())";

		$result = mysql_query($query,$dbConn);


        if($result)
                {
                echo "<meta http-equiv='refresh' content='0; url=./board_list.php?table_id=$table_id'>";
                exit;
                }
        else
                {
                Misc::jvAlert('실패!','history.go(-1)');
                }
	}


	/**
	* 게시판 내용뿌려주기 함수
	*/
	function board_contentPrint(){

		global $dbConn,$start,$total,$scale,$page_scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$table_id,$board_config,$division,$choose_lang,$directory;


	
		$table_id = $_GET['table_id'];

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


				$que = "select * from $tableName where tablename='$table_id' && $S_category order by fid asc,thread limit $start,$scale";
				//print_r($que);
		}
		else
		{

				$que = "select * from $tableName where tablename='$table_id' order by fid asc,thread limit $start,$scale";
	
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
						$page_total_qry = mysql_query("select count(*) from $tableName where tablename='$table_id' && $S_category");
				}
		else
				{
						$page_total_qry = mysql_query("select count(*) from $tableName where tablename='$table_id'");
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

				$row[title] = Misc::cutLongString($row[title], 64, $dot=true);

				//$row[content] = htmlspecialchars($row[content]);
				$row[content] = strip_tags($row[content],'<br><p><a><img>');
				$row[content] = Misc::cutLongString($row[content], 1200, $dot=true);

				$today = explode(" ",$row[wdate]);


				$img_url = _WEB_BASE_DIR;

				$yesterday1 = date("Y-m-d H:i:s",time()-86400);
				if($row[wdate] > $yesterday1)
					{
					$new_icon = "<img src=\"$img_url/img/icon01.gif\">";
					}
				else
					{
					$new_icon = "&nbsp;";
					}

				// reply 달기
				$spacer = "";
				$spacer = strlen($row[thread]) - 1;
				$space = "";
				if($spacer > $reply_indent) $spacer = $reply_indent;					
				for($j = 0; $j < $spacer; $j++) {
					$space = $space . "&nbsp;";
				}
				if($spacer == "0")
						{
						$re_img = "";
						}
				else
						{
						$re_img = $space."&nbsp;&nbsp;[RE]&nbsp;";
						}


				// 코멘트 갯수세기
				$cm_qry1 = "select count(*) from chan_shop_boardcomment where board_no = '$row[seq_no]'";
				$cm_rst1 = mysql_query($cm_qry1,$dbConn);
				$cm_num1 = mysql_result($cm_rst1,0,0);

				if($cm_num1>0)
					{
						$cm_number = "[$cm_num1]";
					}
				else
					{
						$cm_number = "";
					}

				// 레벨 $member_icon[level]

				$row[name] = Misc::cutLongString($row[name], 12, $dot=true);

				if($board_config[noname_level] == "2")
					{
						$writer_name = "******";
					}
				else
					{
						if($row[name])
						{
							$user_name = "$member_icon[mylogo] $row[name]";
						}
						else
						{
							$user_name = $row[userid];
						}

						$writer_name = "$user_name";
					}
	
				$title = iconv("EUC-KR","UTF-8",$row[title]);
				$writer_name = iconv("EUC-KR","UTF-8",$row[userid]);

				//$title = $row[title];

				if($n%2 == "0")
				{ 
					$bgcolor="#F5F5F5"; 
				} 
				else 
				{ 
					$bgcolor="#FFFFFF"; 
				}

				if($row[security] == "YES")
					{
						$lock_icon = "<img src=$img_url/img/lock.gif>";
					}
				else
					{
						$lock_icon = "";
					}

				if($row[userfile1])
					{
						$pda_icon = "<img src=\"$img_url/img/$choose_lang/board/but_data.gif\">";
					}
				else
					{
						$pda_icon = "";
					}

				$upfile = $row[userfile1];

				if($table_id == "flea" || $table_id == "review")
					{
						$table_content="
						<tr> 
						  <td height=\"25\" ><br><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							  <tr> 
								<td width=\"120\" align=\"center\" height=75 valign=top><a href=board_view.php?board_mode=view&table_id=$table_id&directory=$directory&no=$row[seq_no]&start=$start&Mode=$Mode&how=$how&S_content=$S_content><img src=\"../board_upload/$upfile\" width=100 border=0></a></td>
								<td valign=top><table width=100% border=0><tr><td>&nbsp;[ $today[0] ]</td></tr><tr><td height=22>&nbsp;<a href=board_view.php?board_mode=view&table_id=$table_id&directory=$directory&no=$row[seq_no]&start=$start&Mode=$Mode&how=$how&S_content=$S_content><b>$title</b></a></td></tr><tr><td>&nbsp;$row[content]</td></tr></table>
								</td>
							  </tr>
							  <tr><td colspan=2 height=1 bgcolor=#F4F4F4></td></tr>
							</table></td>
						</tr>
						";

					}
				else
					{
						$table_content="
						<tr> 
						  <td height=\"25\" ><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							  <tr> 
								<td width=\"50\" align=\"center\" height=28>$n</td>
								<td>&nbsp;$re_img&nbsp;<a href=board_view.php?board_mode=view&table_id=$table_id&directory=$directory&no=$row[seq_no]&start=$start&Mode=$Mode&how=$how&S_content=$S_content>$title</a> $new_icon&nbsp;</td>
								<td width=\"100\" align=\"center\">$writer_name</td>
								<td width=\"130\" align=\"center\">$row[count]</td>
							  </tr>
							  <tr><td colspan=4 height=1 bgcolor=#F4F4F4></td></tr>
							</table></td>
						</tr>
						";
					}



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
                              <td align=center height=50>Nothing Found.</td>
                            </tr>
                ";
        }
        }//contentPrint function end


        /**
        * 게시물 페이징
        */
        function board_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$S_date,$S_content,$how,$table_id,$division,$choose_lang,$directory;

        $Parameter_value = "division=$division&table_id=$table_id&directory=$directory&Mode=$Mode&S_date=$S_date&how=$how&S_content=$S_content";

        if($page_total>$scale) //검색 결과가 페이지당 출력수보다 크면
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<a href='$PHP_SELF?start=0&$Parameter_value'>[first]</a>&nbsp;";
                echo "<a href='$PHP_SELF?start=$pre_start&$Parameter_value'><img src=\"../img/$choose_lang/shop_pre.gif\" width=\"9\" height=\"11\" align=\"absmiddle\" border=0></a>&nbsp;";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<a href='$PHP_SELF?start=$ln&$Parameter_value'> $vk </a>.</font>";
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
                echo "&nbsp;<a href='$PHP_SELF?start=$n_start&$Parameter_value'><img src=\"../img/$choose_lang/shop_next.gif\" width=\"9\" height=\"11\" align=\"absmiddle\" border=0></a></a>&nbsp;";
                echo "<a href='$PHP_SELF?start=$last_start&$Parameter_value'>[last]</a>";
                }
        }
        }// pageNavigation function end


		function board_printComment($table_id,$no,$directory = false)
		{
			global $dbConn,$HTTP_COOKIE_VARS,$board_config,$member_info;

			echo "
			<table width=100% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td height=25 align=left>&nbsp;<b>Comment</b></td>
			</tr>";
			
			$qry1 = "select * from chan_shop_boardcomment where tablename = '$table_id' && board_no = '$no'";
			$rst1 = mysql_query($qry1,$dbConn);

			$num1 = 0;
			while($row1 = mysql_fetch_assoc($rst1))
				{
				$cmt_date = explode(" ",$row1[wdate]);

				//division,seqNo,table_id,no
				if($row1[userid] == $member_info[user_id])
					{
						$cmt_delete = "<a href=\"javascript:cmt_delete('$row1[seq_no]','$table_id','$no','$directory')\">[del]</a>";
					}
				else
					{
						$cmt_delete = "";
					}

				if($board_config[noname_level] == "2")
					{
						$com_writer = "******";
					}
				else
					{
						$com_writer = $row1[userid];
					}

				echo "
					<tr>
						<td valign=top align=left height=50 bgcolor=#F4F4F4><table width=100% border=0 cellpadding=3 cellspacing=3 height=100%><tr><td valign=top>$row1[comment]</td></tr></table></td>
					</tr>
					<tr>
						<td align=right height=25><b>$com_writer</b> $cmt_delete&nbsp; ($row1[wdate]) &nbsp;&nbsp;</td>
					</tr>
					<tr><td colspan=2 height=1 bgcolor=#CCCCCC></td></tr>
				";
				$num1++;
				}

			if($num1 == "0")
			{
				echo "<tr><td colspan=2 bgcolor=#CCCCCC></td></tr><tr><td colspan=2 height=50 align=center>Empty comment.</td></tr>";
			}

			if($board_config[noname_level] == "2")
			{
				$cm_writer = "******";
			}
			else
			{
				$cm_writer = $HTTP_COOKIE_VARS[NY_nicname];
			}

			
			if($member_info[user_id])
			{
				$web_url = _WEB_BASE_DIR;

				echo "
				<tr><td height=1 bgcolor=#CCCCCC></td></tr>
				<form action=$web_url/talk/view.php method=post onSubmit=\"return cmt_chk(this)\">
				<input type=hidden name=board_mode value=cmt_save>
				<input type=hidden name=table_id value=$table_id>
				<input type=hidden name=directory value=$directory>
				<input type=hidden name=no value=$no>
				<tr>
					<td align=left height=30>&nbsp;Write Comment</td>
				</tr>
				<tr>
					<td height=35><textarea name=comment cols=90 rows=4 class=line></textarea>&nbsp;<input type=submit value=\"Submit\"><br><br></td>
				</tr></form>
				<tr><td height=1 bgcolor=#CCCCCC></td></tr>
				<tr>
					<td height=20></td>
				</tr>
				</table>";
			}
			else
			{
				echo "
				<tr><td height=1 bgcolor=#CCCCCC></td></tr>
				<tr>
					<td height=30 align=center>$board_msg[18]</font></td>
				</tr>
				<tr><td height=1 bgcolor=#CCCCCC></td></tr>
				<tr>
					<td height=20></td>
				</tr>
				</table>";
			}

		}

?>