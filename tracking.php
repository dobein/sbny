<?
	include "./include/inc_base.php";

	if (!$_SESSION['member_id'])
	{
	   $D_URL = _WEB_BASE_DIR ."/member/login.php";

	   $URL = _WEB_BASE_DIR ."/tracking.php";
	   $URL = urlencode($URL); 

	   header("location: $D_URL?goUrl=$URL");
	}


	include _BASE_DIR ."/include/inc_top.php";

	$tableName = "chan_shop_orderinfo";

	if(!$start)
			{
			$start = 0;
			}

	$board_scale = 20;
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

		$que = "select * from $tableName where member_id like '%$S_content%' || name like '%$S_content%' || email like '%$S_content%' || eng_name like '%$S_content%' || address1 like '%$S_content%' || cell_phone like '%$S_content%' || home_phone like '%$S_content%' || corp_phone like '%$S_content%' order by seq_no desc limit $start,$scale";
		//print_r($que);
	}
	else
	{
		$que = "select * from $tableName where orderNum is not null && domain = '$domain' && user_id = '".$_SESSION['member_id']."' order by seq_no desc limit $start,$scale";
		//print_r($que);
	}
	
	//print_r($que);

	$page=floor($start/($scale*$page_scale));

	$result=mysql_query($que);
	$result_rows=mysql_num_rows($result);



	$total=mysql_affected_rows();
	$last=floor($total/$scale);

	if($Mode == "SEARCH")
			{
				// in case, search
				$page_total_qry = mysql_query("select count(*) from $tableName where member_id like '%$S_content%' || name like '%$S_content%' || email like '%$S_content%' || eng_name like '%$S_content%' || address1 like '%$S_content%' || cell_phone like '%$S_content%' || home_phone like '%$S_content%' || corp_phone like '%$S_content%' ");
			}
	else
			{
				$page_total_qry = mysql_query("select count(*) from $tableName where orderNum is not null && domain = '$domain' && user_id = '".$_SESSION['member_id']."'");
			}

	$page_total = mysql_result($page_total_qry,0,0);
	$page_last = floor($page_total/$scale);


	$total_page_num = ceil($page_total/$scale);

	$now_page_num = floor($start/$scale) + 1;


	function mem_contentPrint(){

		global $dbConn,$start,$total,$scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$lang,$rsa_key;

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

				
				// 1:결제완료 2: 최종확인 3: 주문취소

				// 트래킹
				$tracking_info = explode("@",$row[tracking]);

				switch($row[order_status]){
			
					case "1":
						$status_msg = "Pending";
						$tracking = "";
						break;
					case "2":
						$status_msg = "Processing";
						$tracking = "";
						break;
					case "3":
						$status_msg = "Shipped";
						$tracking = "UPS : <a href=http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=$row[tracking] target=_blank><u>$row[tracking]</u></a>";
						break;
					case "4":
						$status_msg = "Canceled";
						$tracking = "";
						break;
					case "5":
						$status_msg = "Back Order";
						$bgcolor = "black";
						break;
					case "6":
						$status_msg = "Processing";
						$bgcolor = "red";
						break;
					default:
						$status_msg = "Check";
				}

				$order_date = explode(" ",$row[order_date]);
				$last_price = round_to_penny($row[last_price]);


				$table_content="
					<tr >
						<td align=center height=28><b><a href=\"tracking_view.php?orderNum=$row[orderNum]\"><span class=\"pink\"><u>$row[orderNum]</u></span></a></b></td>
						<td align=center>$order_date[0]</td>
						<td align=center>$$last_price</td>
						<td align=center>$tracking</td>
						<td align=center><b>$status_msg</b></td>
						<td align=center><a href=\"javascript:print_invoice('$row[orderNum]')\"><u>Print</u></a></td>
					</tr>
					";

				echo $table_content;
				
                }
		unset($pin_option);
        $n--;
        }

        }
        else
        {
                echo "
					<tr bgcolor='#FFFFFF'>
						<td align=center colspan=6 height=30>Nothing Found.</td>
					</tr>
                ";
        }
        }//contentPrint function end


        function mem_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$how;

        $Parameter_value = "Mode=$Mode&how=$how";

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

	$date_qry1 = "select count(*) from $tableName";
	$date_rst1= mysql_query($date_qry1,$dbConn);
	$today_sum = $today_sum + mysql_result($date_rst1,0,0);

?>
<script>
		function print_invoice(orderNum){
			
			window.open("./shopping/order_print.php?orderNum=" + orderNum,"invoice","width=700,height=500,scrollbars=1");

		}
</script>
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <b>Tracking</b></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td valign=top>
						<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign=top>

      <table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height=50 align=left>&nbsp;&nbsp;&nbsp;<b><a href=tracking.php>My Order History</a></b></td>
		</tr>
		<tr><td height=1 bgcolor=#f4f4f4></td></tr>
		<tr>
			<td height=28>- Click on an order number to see the details of your order, or to track your order. </td>
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
					<td width=15% align=center>Order Num</td>
					<td width=15% align=center>Order Date</td>
					<td width=15% align=center>Total</td>
					<td width=20% align=center>Tracking #</td>
					<td width=15% align=center>Status</td>
					<td width=20% align=center>Invoice</td>
				</tr>
				<tr><td colspan=6 bgcolor=#f4f4f4 height=1><img height=1 class=hidden></td></tr>
				<? mem_contentPrint(); ?>
				<tr>
				  <td height="30" align="center" colspan=6><span class="contents_2"><? mem_pageNavigation(); ?></span></td>
				</tr>
			</table>
		  </td>
        </tr>
      </table>
	  <br><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

	  
<?
	// 왼쪽 include
	include _BASE_DIR ."/include/inc_bottom.php";
?>