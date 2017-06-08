<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";


	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	$tableName = "chan_shop_orderinfo";


	if($_POST['Mode'] == "DEL")
	{
		for($i=0; $i<count($_POST['seqNo']); $i++)
		{
			$qry1 = "delete from chan_shop_orderinfo where orderNum = '".$_POST['seqNo'][$i]."'";
			$rst1 = mysql_Query($qry1);

			$qry2 = "delete from chan_shop_orderproduct where orderNum = '".$_POST['seqNo'][$i]."'";
			$rst2 = mysql_Query($qry2);

		}

	}


	$S_content = $_GET['S_content'];

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






	if($how == "2")
	{
		$p_qry1 = "select * from chan_shop_member where company like '%$S_content%' limit 1";

		$p_rst1 = mysql_query($p_qry1);
		$p_row1 = mysql_fetch_assoc($p_rst1);

		$S_content2 = $p_row1[member_id];
	}




	$domain = $_GET['domain'];

	if($domain)
	{
		$domain_qry = "&& domain = '$domain'";
	}

	// in case, search
	if($_GET['how'])
	{
			switch($_GET['how']){

				case "1":
						$S_category = "&& order_num like '%$S_content%'";
						break;
				case "2":
						$S_category = "&& user_id = '$S_content'";
						break;
				case "3":
						$S_category = "&& (bill_first_name like '%$S_content%' || bill_last_name like '%$S_content%' || bill_cellphone like '%$S_content%')";
						break;
				case "4":
						$S_category = "&& user_id like '%$S_content%'";
						break;
				case "5":
						$S_category = "&& order_date like '%$S_content%'";
						break;
			}
	}

	$que = "select * from $tableName where orderNum <> '' $S_category $domain_qry $member_qry order by order_date desc limit $start,$scale";
	//print_r($que);

	//print_r($que);

	$page=floor($start/($scale*$page_scale));

	$result=mysql_query($que);
	$result_rows=mysql_num_rows($result);



	$total=mysql_affected_rows();
	$last=floor($total/$scale);


	// in case, search
	$page_total_qry = mysql_query("select count(*) from $tableName where orderNum <> ''  $S_category $domain_qry $member_qry");


	$page_total = mysql_result($page_total_qry,0,0);
	$page_last = floor($page_total/$scale);


	$total_page_num = ceil($page_total/$scale);

	$now_page_num = floor($start/$scale) + 1;


	function order_contentPrint(){

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

				//$row[title] = Misc::cutLongString($row[title], 40, $dot=true);
				
				$client_info = getinfo_dbMember($row[user_id]);


				switch($row[pay_status]){
					
					case "1":
						$paystatus_msg = "Pending";
						break;
					case "2":
						$paystatus_msg = "Completed";
						break;
					default:
						$paystatus_msg = "..ing";
						break;
				}

				switch($row[order_status]){
					
					case "1":
						$status_msg = "Pending";
						$bgcolor = "#cc3300";
						break;
					case "2":
						$status_msg = "Processing";
						$bgcolor = "blue";
						break;
					case "3":
						$status_msg = "Shipped";
						$bgcolor = "green";
						break;
					case "4":
						$status_msg = "Canceled";
						$bgcolor = "red";
						break;
					case "5":
						$status_msg = "BackOrder";
						$bgcolor = "black";
						break;
					case "6":
						$status_msg = "Problem";
						$bgcolor = "red";
						break;
					default:
						$status_msg = "Check";
						$bgcolor = "#330000";
				}
				
				
				// 총 물건 갯수 구하기
				$total_qty_qry1 = "select count(*) from chan_shop_orderproduct where orderNum = '$row[orderNum]'";
				$total_qty_rst1 = mysql_query($total_qty_qry1,$dbConn);
				$total_qty = @mysql_result($total_qty_rst1,0,0);


				$order_info = unserialize($row[order_info]);

				$billing_name = Misc::cutLongString($order_info[order_krname],12,true);

				$last_price = number_format($row[last_price],2);

				if($row[balance]>0)
					{
						$balance = "<br><font color=red>(Balance : $".number_format($row[balance],2).")</font>";
					}
				else
					{
						$balance = "";
					}
				


//echo "<script> window.open(\"print_order.php?orderNum=$orderNum\",\"order\",\"width=700,height=500,scrollbars=1\"); </script>";

				$table_content="
					<tr bgcolor='#FFFFFF'>
						<td align=center><input type=checkbox name=seqNo[] value=$row[orderNum]></TD>
						<td align=center height=20>$row[order_date]</td>
						<td align=center height=20>$row[domain]</td>
						<td align=center><a href=order_view.php?area=$area&seqNo=$row[seq_no]&orderNum=$row[orderNum]><b>$row[orderNum]</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:print_invoice('$row[orderNum]')\"><u>$row[invoice]</u></a></td>
						<td align=left>&nbsp;$row[bill_first_name] $row[bill_last_name] ($row[bill_cellphone])</td>
						<td align=center>$$last_price</td>
						<td align=center><a href=order_view.php?area=$area&seqNo=$row[seq_no]&orderNum=$row[orderNum]><font color=$bgcolor>$status_msg</font></a></td>
						<td align=center><a href=\"javascript:print_invoice('$row[orderNum]')\"><img src='../../images/printer.png' align=absmiddle border=0></a> | <a href=print_order_word.php?orderNum=$row[orderNum] target=_blank>Word</a></td>
					</tr>
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
						<td align=center colspan=8 height=30>Nothing Found!</td>
					</tr>
                ";
        }
        }//contentPrint function end


        function order_pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$how,$lang;

        $Parameter_value = "Mode=$Mode&how=$how&lang=$lang";

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
		<td height=28>&nbsp;&nbsp;>> Order Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td align=right>&nbsp;</td>
	</tr>
</table>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
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
		function print_invoice(orderNum){
			
			window.open("print_order.php?orderNum=" + orderNum,"invoice","width=700,height=500,scrollbars=1");

		}

        var old='';
        function view(name,flag){

                if(flag == 'first')
                {
                calStr.style.pixelTop = img1.offsetTop + 140;
                calStr.style.pixelLeft = img1.offsetLeft + 250;

                show_cal('',calStr,'first');
                }
                else
                {
                calStr.style.pixelTop = img2.offsetTop + 140;
                calStr.style.pixelLeft = img2.offsetLeft + 270;

                show_cal('',calStr,'last');
                }

                submenu=eval(name+".style");

                if(old!=submenu)
                {
                        if(old!='')
                        {
                                old.visibility='hidden';
                        }
                        submenu.visibility='visible';
                        old=submenu;
                }
                else
                {
                        submenu.visibility='hidden';
                        old='';
                }
        }

        function insert(str1,str2,str3,str4){
                if(str4 == 'first'){
                        document.date.m_year.value = str1;
                        document.date.m_month.value = str2;
                        document.date.m_day.value = str3;
                        
                        calStr.style.visibility='hidden';
                        old='';
                }
                else
                {
                        document.date.n_year.value = str1;
                        document.date.n_month.value = str2;
                        document.date.n_day.value = str3;
                        
                        calStr.style.visibility='hidden';
                        old='';

                }
        }

		function select_del(){
			tf = document.order_list;

			if(confirm("Do you want to delete selected order?") == true)
			{
				tf.Mode.value = 'DEL';
				tf.submit();
			}
		}

</script>
<form name=date action=<?= $_SERVER['PHP_SELF'] ?> method=get>
<input type=hidden name=Mode value="SEARCH">
<tr bgcolor='#eee8aa'>
	<td colspan=7 height=35 align=left>&nbsp;Domain : <select name=domain><option value="">Choose your domain<? printDomainList($_GET['domain']); ?></select>&nbsp;&nbsp;Search : <select name=how>
	<option value="">Select.
	<option value="1" <? if($_GET['how'] == "1") echo "selected"; ?>>Order Number
	<option value="3" <? if($_GET['how']  == "3") echo "selected"; ?>>Customer Name or Phone
	<option value="4" <? if($_GET['how']  == "4") echo "selected"; ?>>E-mail
	</select>&nbsp;<input type=text name=S_content size=16 value="<?= $_GET['S_content'] ?>">&nbsp;<input type=submit value="SEARCH">&nbsp;&nbsp;</td>
</tr></form>
</table>
<form name=order_list action=<?= $_SERVER['PHP_SELF'] ?> method=POST>
<input type=hidden name=Mode value="SEARCH">
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<tr bgcolor=#f4f4f4>
	<td width=5% align=center height=28><input type=checkbox onclick="GoCheckAll();" ></td>
	<td width=15% align=center height=28>Date</td>
	<td width=15% align=center height=28>Domain</td>
	<td width=15% align=center>Order # / Invoice</td>
	<td width=20% align=center>Name</td>
	<td width=10% align=center>Amount</td>
	<td width=10% align=center>Status</td>
	<td width=10% align=center>Print</td>
</tr>
<? order_contentPrint(); ?>
<tr bgcolor='#FFFFFF'>
	<td colspan=8 height=30 align=left><input type=button value="Selected Delete" onClick="select_del()"></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=8 height=30 align=center><? order_pageNavigation(); ?></td>
</tr>
</table>
</form>
<br>
<br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>