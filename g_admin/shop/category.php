<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_category";



	/**
	* 활성화 시키기
	*/
	if($_GET['mode'] == "change")
	{
		$no = $_GET['no'];

		$division = $_GET['division'];

		$qry1 = "update $tableName set activate = '$division' where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);
	}




	/**
	* 카테고리 저장하기
	*/
	if($_POST['mode'] == "save")
	{

		$C_name = $_POST['C_name'];
		$url_link = $_POST['url_link'];

		$p_qry1 = "select max(parent) from $tableName";
		$p_rst1= mysql_query($p_qry1,$dbConn);
		$parent_max = mysql_result($p_rst1,0,0);

		if($parent_max == "0")
		{
			$parent_no = "1";
		}
		else
		{
			$parent_no = $parent_max + 1;
		}

		$qry1 = "select max(c_code1),max(pos) from $tableName where c_code2='0' && c_code3='0'";
		$rst1= mysql_query($qry1,$dbConn);
		$num1 = mysql_num_rows($rst1);
		$max_value1 = mysql_result($rst1,0,0);
		$max_pos1 = mysql_result($rst1,0,1);

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



		
		if($num1 == "0")
		{
			$qry2 = "insert into $tableName (c_code1,c_code2,c_code3,parent,name,userfile1,pos,activate,url_link) values ('1','0','0','0','$C_name','$attc_name1[savedName]','1','Active','$url_link')";
			$rst2 = mysql_query($qry2,$dbConn);
		}
		else
		{
			$max_value2 = $max_value1 + 1;
			$max_pos2 = $max_pos1 + 1;
			$qry2 = "insert into $tableName (c_code1,c_code2,c_code3,parent,name,userfile1,pos,activate,url_link) values ('$max_value2','0','0','0','$C_name','$attc_name1[savedName]','$max_pos2','Active','$url_link')";
			$rst2 = mysql_query($qry2,$dbConn);
		}
	}

	if($_GET['mode'] == "up")
		{
		$pos = $_GET['pos'];
		$seqNo = $_GET['seqNo'];

		$qry1 = "select max(pos) from $tableName where c_code2='0' && c_code3='0' && pos<$pos";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_result($rst1,0,0);

		$qry2 = "update $tableName set pos='$pos' where c_code2='0' && c_code3='0' && pos='$row1'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "update $tableName set pos='$row1' where c_code2='0' && c_code3='0' && seq_no='$seqNo'";
		$rst3 = mysql_query($qry3,$dbConn);
		}
	else if($_GET['mode'] == "down")
		{
		$pos = $_GET['pos'];
		$seqNo = $_GET['seqNo'];

		$qry1 = "select min(pos) from $tableName where c_code2='0' && c_code3='0' && pos>$pos";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_result($rst1,0,0);

		$qry2 = "update $tableName set pos='$pos' where c_code2='0' && c_code3='0' && pos='$row1'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "update $tableName set pos='$row1' where c_code2='0' && c_code3='0' && seq_no='$seqNo'";
		$rst3 = mysql_query($qry3,$dbConn);
		}

	function Category_list(){

		global $dbConn,$tableName,$area;

		$qry1 = "select * from $tableName where c_code2='0' && c_code3='0' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$num = 0;
		while($row1 = mysql_fetch_array($rst1)){
			
			//$below_value = below_num($row1[c_code1]);

			$qry2 = "select min(pos),max(pos) from $tableName where c_code2='0' && c_code3='0'";
			$rst2 = mysql_query($qry2,$dbConn);
			$min_value = mysql_result($rst2,0,0);
			$max_value = mysql_result($rst2,0,1);

			if($row1[pos] == $min_value)
				{
				$pos_msg = "<a href=category.php?lang=$lang&mode=down&pos=$row1[pos]&seqNo=$row1[seq_no]>DOWN</a>";
				}
			else if($row1[pos] == $max_value)
				{
				$pos_msg = "<a href=category.php?lang=$lang&mode=up&pos=$row1[pos]&seqNo=$row1[seq_no]>UP</a>";
				}
			else
				{
				$pos_msg = "<a href=category.php?lang=$lang&mode=up&pos=$row1[pos]&seqNo=$row1[seq_no]>UP</a> <a href=category.php?lang=$lang&mode=down&pos=$row1[pos]&seqNo=$row1[seq_no]>DOWN</a>";
				}
			
			if($row1[jap_name])
			{
				$jp_msg = "Modify";
			}
			else
			{
				$jp_msg = "Add";
			}

			if($row1[activate] == "Active")
			{
				$active_msg = "<a href=\"javascript:change_active('$row1[seq_no]','Inactive')\">View</a>";
			}
			else
			{
				$active_msg = "<a href=\"javascript:change_active('$row1[seq_no]','Active')\"><font style=\"color:red\">Hidden</font></a>";
			}

			// 등록 상품갯수 구하기
			$count_qry1 = "select count(*) from chan_shop_product where p_code1 = '$row1[c_code1]'";
			$count_rst1 = mysql_query($count_qry1,$dbConn);
			$count_total = @mysql_result($count_rst1,0,0);

			if($row1[top_menu] == "YES")
			{
				$top_menu_msg = "<span style=\"color:red\">Top Only</span>";
			}
			else
			{
				$top_menu_msg = "";
			}

			if($row1[userfile1])
			{
				$userfile1 = "<img src='../../upload/$row1[userfile1]' width=150>";
			}
			else
			{
				$userfile1 = "";
			}

			echo "
				<tr bgcolor='#FFFFFF'>
					<td><font color=green>$row1[url_link]</font></td>
					<td align=left height=25 bgcolor=#F4F4F4>&nbsp;[$row1[c_code1],0,0]&nbsp;<a href=category2.php?area=$area&c_code1=$row1[c_code1]>$row1[name] ($count_total)</a>&nbsp;$top_menu_msg </td>
					<td align=center ><a href=category_modify.php?area=$area&no=$row1[seq_no]>Modify</a></td>
					<td align=center ><a href=category2.php?area=$area&c_code1=$row1[c_code1]>Menu</a></td>
				</tr>
			";
		$num++;

		unset($count_total);
		}

		if($num == "0")
		{
			echo "
			<tr bgcolor='#FFFFFF'>
					<td colspan=4 align=center height=35>Empty Category!</td>
			</tr>";
		}
	}

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>
	function change_active(no,mode){
		
		if(mode == 'Active')
		{
			answer = confirm("View?");

			if(answer == true)
			{
				location.replace('category.php?mode=change&division=' + mode + '&no=' + no);
				exit;
			}
			else return;
		}
		else
		{
			answer = confirm("Hidden?");

			if(answer == true)
			{
				location.replace('category.php?mode=change&division=' + mode + '&no=' + no);
				exit;
			}
			else return;
		}
	}

	function add_link(c_code1){
		
		window.open("add_link.php?c_code1=" + c_code1,"add","width=600,height=500,scrollbars=1,left=400,top=100");

	}

	function category_del(no,code1){
		answer = confirm("Do you want to delete this category?");

		if(answer == true)
		{
			location.replace('category.php?mode=del&no=' + no + '&c_code1=' + code1);
			exit;
		}
		else return;
	}

</script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Category Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 cellpadding=2 bgcolor='#a9a9a9'>
<tr bgcolor='#eee8aa'>
	<td colspan=4 height=40>&nbsp;<b>Big category</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=4>&nbsp;&nbsp;[./ ]</td>
</tr>
<tr bgcolor=#FFFFFF>
	<td align=center width=40% height=30>URL</td>
	<td align=center width=30% height=30>Name</td>
	<td align=center width=10%>Modify</td>
	<td align=center width=20%>Make</td>
</tr>
<? Category_list('one'); ?>
</table>

<br>
<table width=100% align=center border=0 cellspacing=1 cellpadding=2 bgcolor='#a9a9a9'>
<tr bgcolor='#eee8aa'>
	<td colspan=2 height=35>&nbsp;<b>Big Category</b></td>
</tr>
<script>
	function chk(tf){
		if(!tf.C_name.value)
			{
			alert('Enter Category name');
			tf.C_name.focus();
			return false;
			}
		return true;
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)" Enctype="multipart/form-data">
<input type=hidden name=mode value="save">
<input type=hidden name=area value="<?= $area ?>">
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Name</td>
	<td>&nbsp;<input type=text name=C_name size=50></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;TOP image</td>
	<td>&nbsp;<input type=file name=userfile1 size=30></td></tr>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Seo Link</td>
	<td>&nbsp;<input type=text name=url_link size=50 value="http://"></td></tr>
<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;META</td>
	<td>&nbsp;<textarea name=meta_tag cols=70 rows=5></textarea></td></tr> -->
<tr bgcolor='#FFFFFF'>
	<td colspan=2 align=center height=35><input type=submit value="Category add"></td>
</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>