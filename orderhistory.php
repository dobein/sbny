<?
	include "./include/inc_base.php";

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
		$que = "select * from $tableName where orderNum<>'' && user_id = '".$_SESSION['member_id']."' order by seq_no desc limit $start,$scale";
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
				$page_total_qry = mysql_query("select count(*) from $tableName where orderNum<>'' && user_id = '".$_SESSION['member_id']."'");
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
						$tracking = "UPS : <a href=http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=$tracking_info[1] target=_blank><u>$tracking_info[1]</u></a>";
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
						<td align=center height=28><b><a href=\"orderdetails.php?orderNum=$row[orderNum]\"><span class=\"pink\"><u>$row[orderNum]</u></span></a></b></td>
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


	include _BASE_DIR ."/include/inc_top.php";
?>
<div id="maincontainer">
  <section id="product">
    <div class="container">
     <!--  breadcrumb --> 
      <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Order History</li>
      </ul>
      <div class="row">        
        <!-- Register Account-->
        <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
          <h1 class="heading1"><span class="maintext"> <i class="icon-signin"></i> Order History</span></h1>
            <table class="table table-striped table-bordered">
				<tr bgcolor=#FFFFFF>
					<th width=15% align=center>Order Num</th>
					<th width=15% align=center>Order Date</th>
					<th width=15% align=center>Total</th>
					<th width=20% align=center>Tracking #</th>
					<th width=15% align=center>Status</th>
					<th width=20% align=center>Invoice</th>
				</tr>
				<? mem_contentPrint(); ?>
				<tr>
				  <td height="30" align="center" colspan=6><span class="contents_2"><? mem_pageNavigation(); ?></span></td>
				</tr>
            </table>
          <div class="clearfix"></div>
          <br>
        </div>        
        <!-- Sidebar Start-->
        <aside class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3">
          <div class="sidewidt">
            <h1 class="heading1"><span class="maintext"> <i class="icon-user"></i> Account</span></h1>
            <ul class="nav nav-list categories">
              <li>
                <a href="#"> My Account</a>
              </li>
              <li>
                <a href="#">Edit Account</a>
              </li>
              <li><a href="#">Order History</a>
              </li>
            </ul>
          </div>
        </aside>
        <!-- Sidebar End-->
      </div>
    </div>
  </section>
</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>