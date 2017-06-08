<?
	include "../include/inc_base.php";

	if (!$HTTP_COOKIE_VARS[MEMLOGIN_INFO])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/member/tracking_gift.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?goUrl=$URL");
	}


	include _BASE_DIR ."/include/inc_top.php";


	$tableName = "chan_shop_gift";

	if(!$start)
			{
			$start = 0;
			}

	$board_scale = 10;
	$board_page = 10;

	$scale=$board_scale;

	$page_scale=$board_page;

	if($Mode == "SEARCH")
	{
		// in case, search
		switch($how)
		{
			case "user_id":
				$sort_qry = "user_id like '%$Content%'";
				break;
			case "name":
				$sort_qry = "first_name like '%$Content%'";
				break;
			case "email":
				$sort_qry = "email like '%$Content%'";
				break;
		}

		$que = "select * from $tableName where $sort_qry order by seq_no desc limit $start,$scale";
		//print_r($que);
	}
	else
	{
		$que = "select * from $tableName where user_id = '$user_info[user_id]' order by seq_no desc limit $start,$scale";
		//print_r($que);
	}


	$page=floor($start/($scale*$page_scale));

	$result=mysql_query($que);
	$result_rows=mysql_num_rows($result);



	$total=mysql_affected_rows();
	$last=floor($total/$scale);

	if($Mode == "SEARCH")
			{
				// in case, search
				$page_total_qry = mysql_query("select count(*) from $tableName where $sort_qry");
			}
	else
			{
				$page_total_qry = mysql_query("select count(*) from $tableName where user_id = '$user_info[user_id]'");
			}

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

				switch($row[order_status]){
					
					case "1":
						$status_msg = "Pending";
						$bgcolor = "#f4f4f4";
						break;
					case "2":
						$status_msg = "Credit Paid";
						$bgcolor = "blue";
						break;
					case "3":
						$status_msg = "Completed";
						$bgcolor = "green";
						break;
					case "4":
						$status_msg = "Cancel";
						$bgcolor = "pink";
						break;
					default:
						$status_msg = "Check";
						$bgcolor = "red";
				}

				$table_content="
					<tr bgcolor=#FFFFFF>
						<td align=center height=40>$row[pin_number]</td>
						<td align=center ><b>$$row[total_amt]</b></td>
						<td align=center >$row[email]<br>($row[first_name] $row[last_name])</td>
						<td align=center ><font color=$bgcolor>$status_msg</font></td>
						<td align=center >$date[0]</td>
					</tr>
					<tr><td colspan=5 height=1 bgcolor=#F4F4F4></td></tr>
					";

				echo $table_content;

                }
        $n--;
        }

        }
        else
        {
                echo "
					<tr bgcolor='#FFFFFF'>
						<td align=center colspan=5 height=30>Empty product!</td>
					</tr>
                ";
        }
        }//contentPrint function end


        function mem_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$how,$area;

        $Parameter_value = "area=$area&Mode=$Mode&how=$how";

        if($page_total>$scale)
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<a href='$PHP_SELF?start=0&$Parameter_value'>[first]</a>&nbsp;";
                echo "<a href='$PHP_SELF?start=$pre_start&$Parameter_value'>[...]</a>&nbsp;";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<a href='$PHP_SELF?start=$ln&$Parameter_value'><font class=darkgray> $vk </a>.</font>";
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
                echo "&nbsp;<a href='$PHP_SELF?start=$n_start&$Parameter_value'>[...]</a>&nbsp;";
                echo "<a href='$PHP_SELF?start=$last_start&$Parameter_value'>[last]</a>";
                }
        }
        }// pageNavigation function end


?>
	<table width=100% border=0 cellpadding=0 cellspacing=0><tr><td height=25></td></tr></table>

      <table width="95%" align=center border="0" cellspacing="0" cellpadding="0" class="dot_point">
        <tr> 
          <td valign="top" class='black title' height=25>&nbsp;Order Tracking</td>
        </tr>
		<tr> 
		<td height="1" bgcolor="#eeeeee" colspan=3><img height=1 class=hidden></td>
		</tr>
      </table>
      <table width="10%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="15"></td>
        </tr>
      </table>
      <table width="95%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height=50>&nbsp;&nbsp;<img src="../icon/icon_package.gif" align=absmiddle>&nbsp;<a href=tracking.php>Products Order</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<img src="../icon/page_white_swoosh.png" align=absmiddle>&nbsp;<a href=tracking_gift.php><b>Gift Certificates</b></a></td>
		</tr>
		<tr><td height=1 bgcolor=#f4f4f4></td></tr>
		<tr>
			<td height=35>- Click on an order number to see the details of your order, or to track your order. </td>
		</tr>
		<tr>
			<td></td>
		</tr>
        <tr> 
          <td>
			<TABLE WIDTH='100%' BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<form action=<?= $PHP_SELF ?> method=post>
			<input type=hidden name=mode value="update">
				<tr bgcolor=#FFFFFF>
					<td align=center width=25%>Pin Number</td>
					<td align=center width=15%>Amount</td>
					<td align=center width=35%>Send to</td>
					<td align=center width=10%>Status</td>
					<td align=center width=15%>Date</td>
				</tr>
				<tr><td colspan=6 bgcolor=#EEB4B4 height=1><img height=1 class=hidden></td></tr>
				<? mem_contentPrint(); ?>
				<tr>
				  <td height="30" align="center" colspan=5><span class="contents_2"><? mem_pageNavigation(); ?></span></td>
				</tr>
			</table>
		  </td>
        </tr>

      </table>
	  <br><br><br><br>

	  
<?
	// ¿ÞÂÊ include
	include _BASE_DIR ."/include/inc_bottom.php";
?>