<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";

	if($_POST['Mode'] == "DEL")
	{
		for($i=0; $i<count($_POST['seqNo']); $i++)
		{
			$qry1 = "delete from chan_shop_member where seq_no = '".$_POST['seqNo'][$i]."'";
			$rst1 = mysql_Query($qry1);

		}

	}

	$tableName = "chan_shop_member";

	if(!$_GET['start'])
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}

	$board_scale = 20;


	$board_page = 10;

	$scale=$board_scale;

	$page_scale=$board_page;

		$domain = $_GET['domain'];
		$search_content = $_GET['search_content'];

		// in case, search

		if($search_content)
		{
			$search_qry = "&& (member_id like '%$search_content%' || email like '%$search_content%' || first_name like '%$search_content%' || last_name like '%$search_content%' || corp_phone like '%$search_content%' || birthday like '%$search_content%')";
		}

		if($domain)
		{
			$domain_qry = "&& domain = '$domain'";
		}

		if($age_start)
		{
			$age_start_qry = "&& date_format(birthday,'%Y')>='$age_start' and date_format(birthday,'%Y')<='$age_end'";
		}


		$que = "select * from $tableName where member_id <> '' $search_qry $member_qry $domain_qry $age_start_qry order by seq_no desc limit $start,$scale";
		//print_r($que);



	$page=floor($start/($scale*$page_scale));

	$result=mysql_query($que);
	$result_rows=mysql_num_rows($result);



	$total=mysql_affected_rows();
	$last=floor($total/$scale);



	$page_total_qry = mysql_query("select count(*) from $tableName where member_id <> '' $search_qry $member_qry $domain_qry $age_start_qry");


	$page_total = mysql_result($page_total_qry,0,0);
	$page_last = floor($page_total/$scale);


	$total_page_num = ceil($page_total/$scale);

	$now_page_num = floor($start/$scale) + 1;


	function mem_contentPrint(){

		global $dbConn,$start,$total,$page,$page_last,$scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$area;

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
        {
        if($i<$page_total)
                {
                $row=mysql_fetch_array($result);

				$date =explode(" ",$row[wdate]);

				switch($row[level])
					{
						case "10":
							$level_msg = "Pendding";
							break;
						case "9":
							$level_msg = "Approved";
							break;
						case "8":
							$level_msg = "Level2";
							break;
						case "7":
							$level_msg = "Level3";
							break;
					}

				// <input type=checkbox name=seqNo[] value=\"$row[last_name]<$row[email]>NaN$row[member_id]\">

				switch($row[mail_flag])
					{
						case "YES":
							$mail_flag = "YES";
							break;
						case "NO":
							$mail_flag = "STOP";
							break;
					}

				$table_content="
					<tr bgcolor='#FFFFFF'>
						<td align=center><input type=checkbox name=seqNo[] value=$row[seq_no]></td>
						<td align=center>$row[domain]</td>
						<td align=left>&nbsp;<a href=member_view.php?area=$area&seq_no=$row[seq_no]>$row[member_id]</a></td>
						<td align=left>&nbsp;$row[first_name] $row[last_name]</td>
						<td align=center >$row[cell_phone]</td>
						<td align=center>$date[0]</td>
						<td align=center>$mail_flag</td>
						<td align=center>$level_msg</td>
					</tr>
					";
				unset($mail_flag);

				echo $table_content;

                }
        $n--;
        }

        }
        else
        {
                echo "
					<tr bgcolor='#FFFFFF'>
						<td align=center colspan=8 height=30>Nothing Found!</td>
					</tr>
                ";
        }
        }//contentPrint function end


        function mem_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$how,$search_content,$member_level;

        $Parameter_value = "area=$area&Mode=$Mode&how=$how&member_level=$member_level&search_content=$search_content";

        if($page_total>$scale)
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<a href='?start=0&$Parameter_value'>[first]</a>&nbsp;";
                echo "<a href='?start=$pre_start&$Parameter_value'>[...]</a>&nbsp;";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<a href='?start=$ln&$Parameter_value'><font class=darkgray> $vk </a>.</font>";
                        }
                        else
                        {
                        echo "<span class=darkgray>[$vk].</span></font>";
                        }
                }
            }
        if($page_total>(($page+1)*$scale*$page_scale))
                {
                $n_start=($page+1)*$scale*$page_scale;
                $last_start=$page_last*$scale;
                echo "&nbsp;<a href='?start=$n_start&$Parameter_value'>[...]</a>&nbsp;";
                echo "<a href='?start=$last_start&$Parameter_value'>[last]</a>";
                }
        }
        }// pageNavigation function end

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Member Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<form action=<?= $_SERVER['PHP_SELF']?> METHOD=GET>
<INPUT TYPE=HIDDEN NAME=Mode VALUE="SEARCH">
<INPUT TYPE=HIDDEN NAME=area VALUE="<?= $area ?>">
<tr bgcolor='#eee8aa'>
	<td colspan=8 height=35>&nbsp;<b>Member List</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=8 height=30>&nbsp;Total member : <?= $page_total ?></td>
</tr>
<tr bgcolor='#eee8aa'>
	<td colspan=8 height=35>&nbsp;Domain : <select name=domain><option value="">Choose your domain<? printDomainList($_GET['domain']); ?></select>&nbsp;&nbsp;Keyword : <input type=text name=search_content size=30 VALUE="<?= $_GET['search_content'] ?>">&nbsp;
	&nbsp;<input type=submit value=" SEARCH ">
	</td>
</tr></form>
		<script>
			function GoCheckAll() {
				var FormChkObj = document.getElementsByName("seqNo[]"); 	
					
				for (var orderidx = 0; orderidx<FormChkObj.length; orderidx++) {						
					if (FormChkObj[orderidx].checked==true) {
						FormChkObj[orderidx].checked=false;
					}
					else {
						FormChkObj[orderidx].checked=true;
					}		
				}		
			}	

		function select_del(){
			tf = document.purchaseList;

			if(confirm("Do you want to delete selected member?") == true)
			{
				tf.Mode.value = 'DEL';
				tf.submit();
			}
		}

		</script>
<form name=purchaseList action=<?= $_SERVER['PHP_SELF'] ?> METHOD=POST onSubmit="return change_status()">
<INPUT TYPE=HIDDEN NAME=Mode VALUE="SEARCH">
<tr bgcolor=#f4f4f4>
	<td width=5% height=28 align=center><input type=checkbox onclick="GoCheckAll();" ></td>
	<td width=15% align=center >Domain</td>
	<td width=15% height=28 align=center>ID</td>
	<td width=15% align=center>Name</td>
	<td width=10% align=center>Phone</td>
	<td width=10% align=center>Date</td>
	<td width=10% align=center>Newletter</td>
	<td width=20% align=center>Level</td>
</tr>
<? mem_contentPrint(); ?>
<tr bgcolor='#FFFFFF'>
	<td colspan=8 height=30 align=left><input type=button value="Selected Delete" onClick="select_del()"></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=8 height=30 align=center><? mem_pageNavigation(); ?></td>
</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>