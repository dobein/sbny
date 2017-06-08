<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_brand";

	if($_GET['Mode'] == "del")
	{
		$no = $_GET['no'];

		$qry1 = "delete from $tableName where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);

		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('brand_list.php?area=$area')");
			exit;
		}
	}

	if($_POST['mode'] == "save")
	{
		$brand = $_POST['brand'];
		$brand_url = $_POST['brand_url'];
		$brand_content = $_POST['brand_content'];
		$html_check = $_POST['html_check'];
		$main_print = $_POST['main_print'];

		// 미리 체크
		$pre_qry1 = "select count(*) from $tableName where name = '$brand'";
		$pre_rst1 = mysql_query($pre_qry1,$dbConn);
		$pre_num1 = mysql_result($pre_rst1,0,0);

		if($pre_num1>0)
		{
			Misc::jvAlert("Already you register","history.go(-1)");
			exit;
		}

		$tmpName1 = $_FILES['userfile1']['tmp_name'];

		if(is_uploaded_file($tmpName1)){
				$pds_file1 = $_FILES['userfile1']['name'];
				$board_pds_pos = "../../upload";
				$attc_name1 = Misc::uploadFileUnsafely($tmpName1 , $pds_file1 , $board_pds_pos);

				if(!getimagesize("../../upload/$attc_name1[savedName]"))
				{
					@unlink("../../upload/$attc_name1[savedName]");
					echo "no image";
					exit;
				}
		}



		$qry1 = "insert into $tableName values ('','$brand','$brand_url','$attc_name1[savedName]','$brand_content','$html_check','$main_print')";
		$rst1 = mysql_query($qry1,$dbConn);

		Misc::jvAlert("Completed!","location.replace('brand_list.php?area=$area')");
		exit;
	}

	$brand = $_POST['brand'];
	$start = $_GET['start'];

	if(!$start)
			{
			$start = 0;
			}

	$board_scale = 10;
	$board_page = 10;

	$scale=$board_scale;

	$page_scale=$board_page;

	if($_POST['mode'] == "SEARCH")
	{
		// in case, search

		$que = "select * from $tableName where seq_no = '$brand' order by seq_no desc limit $start,$scale";
		//print_r($que);
	}
	else
	{
		$que = "select * from $tableName order by name asc limit $start,$scale";
	//print_r($que);
	}


	$page=floor($start/($scale*$page_scale));

	$result=mysql_query($que);
	$result_rows=mysql_num_rows($result);



	$total=mysql_affected_rows();
	$last=floor($total/$scale);

	if($_POST['mode'] == "SEARCH")
			{
				// in case, search
				$page_total_qry = mysql_query("select count(*) from $tableName where seq_no = '$brand'");
			}
	else
			{
				$page_total_qry = mysql_query("select count(*) from $tableName");
			}

	$page_total = mysql_result($page_total_qry,0,0);
	$page_last = floor($page_total/$scale);


	$total_page_num = ceil($page_total/$scale);

	$now_page_num = floor($start/$scale) + 1;


	function mem_contentPrint(){

		global $dbConn,$start,$total,$page,$last_page,$scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$HTTP_COOKIE_VARS,$area;

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

				if($row[userfile1])
					{
						$file_image = "<img src=\"../../upload/$row[userfile1]\" border=1 style='border-color=#CCCCCC' >";
					}
				else
					{
						$file_image = "<font style='color:#CCCCCC'>No images</font>";
					}

				// 이 브랜드 등록상품 갯수 세기
				$qry2 = "select count(*) from chan_shop_product where brand = '$row[seq_no]'";
				$rst2 = mysql_query($qry2,$dbConn);
				$total_item = @mysql_result($rst2,0,0);

				if($row[main_print] == "YES")
					{
						$main_print = "Main Print";
					}
				else
					{
						$main_print = "";
					}

				$table_content = "
				<tr bgcolor='#FFFFFF'>
					<td  height=95 align=center height=30><b>$row[name]</b> $main_print</td>
					<td align=center>$file_image</td>
					<td >&nbsp;<a href=$row[brand_url] target=_blank>$row[brand_url]</a></td>

					<td align=center><a href=brand_modify.php?no=$row[seq_no]&area=$area>M</a>&nbsp;|&nbsp;<a href=\"javascript:brand_del('$row[seq_no]','$area')\">D</a></td>
				</tr>";
//					<td align=center><a href=brand_item.php?brand_no=$row[seq_no]>$total_item </a></td>

				echo $table_content;

                }
        $n--;
        }

        }
        else
        {
                echo "
					<tr bgcolor='#FFFFFF'>
						<td align=center colspan=4 height=30>Empty.</td>
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
<script>
	function brand_del(str,area){
		
		answer = confirm("Delete?");

		if(answer == true)
		{
			location.replace('brand_list.php?Mode=del&no=' + str + '&area=' + area);
			exit;
		} else return;
	}

	function chg1(){
	regi = document.search_ca;
	//alert(document.product.code1.value);
	location.replace('<?= $_SERVER['PHP_SELF'] ?>?Mode=SEARCH&area=<?= $area ?>&brand=' + regi.brand_search.value);
	}
</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Brand Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<form name=search_ca action=<?= $_SERVER['PHP_SELF'] ?> method=post>
	<tr bgcolor='#FFFFFF'>
		<td colspan=4 align=left height=35>&nbsp;&nbsp;<b>Brand</b> : <select name=brand_search onChange="chg1()"><option value="NA">Choose Brand<? printBrand($brand); ?></select></td>
	</tr></form>
	<tr bgcolor=#eee8aa>
		<td width=35% height=28 align=center>Name</td>
		<td width=20% align=center>Logo</td>
		<td width=35% align=center>website</td>
		<td width=10% align=center>Func</td>
	</tr>
	<? mem_contentPrint(); ?>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1>
	<tr>
		<td align=center height=35><? mem_pageNavigation(); ?></td>
	</tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<script>
	function chk(tf){
		if(!tf.brand.value)
			{
			alert('Enter your name!');
			tf.brand.focus();
			return false;
			}
		return true;
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)"  Enctype="multipart/form-data">
<input type=hidden name=mode value="save">
<input type=hidden name=area value="<?= $area ?>">
	<tr bgcolor=#eee8aa height=30>
		<td colspan=2>&nbsp;&nbsp;<b>Brand Add</b></td>
	</tr>
	<!-- <tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Brand List</td>
		<td>&nbsp;&nbsp;<select name=brand_sort><? printBrand(); ?></select></td>
	</tr> -->
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Name</td>
		<td>&nbsp;&nbsp;<input type=text name=brand size=30></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>URL</td>
		<td>&nbsp;&nbsp;<input type=text name=brand_url size=50 value="http://"></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>LOGO</td>
		<td>&nbsp;&nbsp;<input type=file name=userfile1 size=30></td>
	</tr>
	<!-- <tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Description</td>
		<td>&nbsp;&nbsp;<textarea name=brand_content cols=70 rows=10></textarea><br>
		&nbsp;<input type=checkbox name=html_check value="YES">HTML</td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Main Print</td>
		<td>&nbsp;&nbsp;<input type=checkbox name=main_print value="YES">  MAIN BANNER PRINT</td>
	</tr> -->
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="   Brand Add   "></td>
	</tr></form>
</table>
<br><br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>