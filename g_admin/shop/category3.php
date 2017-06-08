<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_category";

	if($_GET['mode'] == "del")
	{
		$c_code1 = $_GET['c_code1'];
		$c_code2 = $_GET['c_code2'];
		$no = $_GET['no'];

		$qry1 = "delete from $tableName where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);

		Misc::jvAlert("Completed!","location.replace('category3.php?c_code1=$c_code1&c_code2=$c_code2')");
		exit;

	}
	else if($_POST['mode'] == "pos_adjust")
	{
		$seqNo = $_POST['seqNo'];
		$c_code1 = $_POST['c_code1'];
		$c_code2 = $_POST['c_code2'];

		$pos = $_POST['pos'];

		for($k=0; $k<count($seqNo); $k++)
		{
			$r_qry1 = "update chan_shop_category set pos = '$pos[$k]' where seq_no = '$seqNo[$k]'";
			$r_rst1 = mysql_query($r_qry1);

		}

		Misc::jvAlert("Completed!","location.replace('category3.php?c_code1=$c_code1&c_code2=$c_code2')");
		exit;	
	}


	/**
	* 활성화 시키기
	*/
	if($_GET['mode'] == "change")
	{
		$division = $_GET['division'];
		$no = $_GET['no'];

		$qry1 = "update $tableName set activate = '$division' where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);
	}

	/**
	* 카테고리 저장하기
	*/
	if($_POST['mode'] == "save")
	{
		$c_code1 = $_POST['c_code1'];
		$c_code2 = $_POST['c_code2'];

		$url_link = $_POST['url_link'];


		$qry1 = "select max(c_code3),max(pos) from $tableName where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0'";
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

		$C_name = trim($_POST['C_name']);

		if($num1 == "0")
		{
			$qry2 = "insert into $tableName (c_code1,c_code2,c_code3,parent,name,userfile1,pos,activate,url_link) values ('$c_code1','$c_code2','1','$parent_no','$C_name','$attc_name1[savedName]','1','Active','$url_link')";

			//$qry2 = "insert into $tableName values ('','$c_code1','$c_code2','1','$parent_no','$C_name','$attc_name1[savedName]','1','Active','$link_use','$special_link','')";
			$rst2 = mysql_query($qry2,$dbConn);
		}
		else
		{
			$max_value2 = $max_value1 + 1;
			$max_pos2 = $max_pos1 + 1;

			$qry2 = "insert into $tableName (c_code1,c_code2,c_code3,parent,name,userfile1,pos,activate,url_link) values ('$c_code1','$c_code2','$max_value2','$parent_no','$C_name','$attc_name1[savedName]','$max_pos2','Active','$url_link')";

			//$qry2 = "insert into $tableName values ('','$c_code1','$c_code2','$max_value2','$parent_no','$C_name','$attc_name1[savedName]','$max_pos2','Active','$link_use','$special_link','')";
			$rst2 = mysql_query($qry2,$dbConn);
		}

		echo "<meta http-equiv='refresh' content='0; url=./category3.php?c_code1=$c_code1&c_code2=$c_code2'>";
		exit;

	}

	if($_GET['mode'] == "up")
		{
		$pos = $_GET['pos'];
		$seqNo = $_GET['seqNo'];
		$c_code1 = $_GET['c_code1'];

		$qry1 = "select max(pos) from $tableName where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' && pos<$pos";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_result($rst1,0,0);

		$qry2 = "update $tableName set pos='$pos' where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' && pos='$row1'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "update $tableName set pos='$row1' where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' && seq_no='$seqNo'";
		$rst3 = mysql_query($qry3,$dbConn);
		}
	else if($_GET['mode'] == "down")
		{
		$pos = $_GET['pos'];
		$seqNo = $_GET['seqNo'];
		$c_code1 = $_GET['c_code1'];

		$qry1 = "select min(pos) from $tableName where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' && pos>$pos";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_result($rst1,0,0);

		$qry2 = "update $tableName set pos='$pos' where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' && pos='$row1'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "update $tableName set pos='$row1' where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' && seq_no='$seqNo'";
		$rst3 = mysql_query($qry3,$dbConn);
		}

	function Category_list(){

		global $dbConn,$tableName,$c_code1,$c_code2,$lang;

		$qry1 = "select * from $tableName where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);
		
		$num = 0;
		while($row1 = mysql_fetch_array($rst1)){

			$qry2 = "select min(pos),max(pos) from $tableName where c_code1='$c_code1' && c_code2='$c_code2' && c_code3<>'0'";
			$rst2 = mysql_query($qry2,$dbConn);
			$min_value = mysql_result($rst2,0,0);
			$max_value = mysql_result($rst2,0,1);

			if($row1[pos] == $min_value)
				{
				$pos_msg = "<a href=category3.php?lang=$lang&c_code1=$c_code1&c_code2=$c_code2&mode=down&pos=$row1[pos]&seqNo=$row1[seq_no]>down</a>";
				}
			else if($row1[pos] == $max_value)
				{
				$pos_msg = "<a href=category3.php?lang=$lang&c_code1=$c_code1&c_code2=$c_code2&mode=up&pos=$row1[pos]&seqNo=$row1[seq_no]>up</a>";
				}
			else
				{
				$pos_msg = "<a href=category3.php?lang=$lang&c_code1=$c_code1&c_code2=$c_code2&mode=up&pos=$row1[pos]&seqNo=$row1[seq_no]>up</a> <a href=category3.php?lang=$lang&c_code1=$c_code1&c_code2=$c_code2&mode=down&pos=$row1[pos]&seqNo=$row1[seq_no]>down</a>";
				}



			if($row1[activate] == "Active")
			{
				$active_msg = "<a href=\"javascript:change_active('$row1[seq_no]','Inactive','$row1[c_code1]','$row1[c_code2]')\">View</a>";
			}
			else
			{
				$active_msg = "<a href=\"javascript:change_active('$row1[seq_no]','Active','$row1[c_code1]','$row1[c_code2]')\"><font style=\"color:red\">Hidden</font></a>";
			}



			if($row1[link_use] == "YES")
			{
				$link_value = "<b>Link</b>";
			}
			else
			{
				$link_value = "";
			}

			if($row1[userfile1])
			{
				$userfile1 = "<img src='../../upload/$row1[userfile1]'>";
			}
			else
			{
				$userfile1 = "";
			}

			echo "
				<tr bgcolor='#FFFFFF'>
					<td align=center height=25>$row1[url_link]</td>
					<td align=left height=25 bgcolor=#F4F4F4>&nbsp;[$row1[c_code1],$row1[c_code2],$row1[c_code3]]&nbsp;$row1[name]</td>
					<td align=center ><input type=hidden name=seqNo[] value=$row1[seq_no]><input type=text name=pos[] value=$row1[pos] size=4></td>
					<td align=center ><a href=category_modify.php?lang=$lang&no=$row1[seq_no]&c_code1=$c_code1&c_code2=$c_code2>Modify</a> | <a href=\"javascript:category_del('$row1[seq_no]','$c_code1','$c_code2')\">Delete</a></td>
				</tr>
			";
		$num++;
		}
	
		if($num == "0")
		{
			echo "
			<tr bgcolor='#FFFFFF'>
					<td colspan=4 align=center height=35>Empty Category!</td>
			</tr>";
		}

	}

	$c_code1 = $_GET['c_code1'];
	$c_code2 = $_GET['c_code2'];

	$qry1 = "select * from $tableName where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 = '0'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>
	function change_active(no,mode,code1,code2){
		
		if(mode == 'Active')
		{
			answer = confirm("View?");

			if(answer == true)
			{
				location.replace('category3.php?mode=change&division=' + mode + '&no=' + no + '&c_code1=' + code1 + '&c_code2=' + code2);
				exit;
			}
			else return;
		}
		else
		{
			answer = confirm("Hidden?");

			if(answer == true)
			{
				location.replace('category3.php?mode=change&division=' + mode + '&no=' + no + '&c_code1=' + code1 + '&c_code2=' + code2);
				exit;
			}
			else return;
		}
	}
</script>
<script>
	function category_del(no,code1,code2){
		answer = confirm("Do you want to delete this category?");

		if(answer == true)
		{
			location.replace('category3.php?mode=del&no=' + no + '&c_code1=' + code1 + '&c_code2=' + code2);
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
<form name=search_ca action=<?= $_SERVER['PHP_SELF'] ?> method=post>
<input type=hidden name=mode value="pos_adjust">
<input type=hidden name=c_code1 value="<?= $c_code1 ?>">
<input type=hidden name=c_code2 value="<?= $c_code2 ?>">
<tr bgcolor='#eee8aa'>
	<td colspan=4  height=35>&nbsp;<b>Small category add</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=4>&nbsp;&nbsp;[ <a href=category.php><?= Category_name($c_code1,'0','0') ?></a>&nbsp;<a href=category2.php?c_code1=<?= $c_code1 ?>><?= Category_name($c_code1,$c_code2,'0') ?></a>&nbsp;]</td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=4 height=80><? if($row1[userfile1]): ?><img src="../../upload/<?= $row1[userfile1] ?>" height=70><? else: ?>&nbsp;No image<? endif; ?></td>
</tr>
<tr bgcolor=#FFFFFF>
	<td align=center width=40%>Link</td>
	<td align=center width=30% height=30>Name</td>
	<td align=center width=15%>Position</td>
	<td align=center width=15%>M / D</td>
</tr>
<? Category_list('two'); ?>
<tr>
	<td colspan=2 height=35 bgcolor=#ffffff align=center></td>
	<td height=35 bgcolor=#ffffff align=center>&nbsp;<input type=submit value="POS ADJUST"></td>
	<td colspan=1 height=35 bgcolor=#ffffff align=center></td>
</tr></form>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 cellpadding=2 bgcolor='#a9a9a9'>
<tr bgcolor='#eee8aa'>
	<td colspan=2 height=35>&nbsp;<b>Small category add</b></td>
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
<input type=hidden name=c_code1 value="<?= $c_code1 ?>">
<input type=hidden name=c_code2 value="<?= $c_code2 ?>">
<input type=hidden name=parent_no value="<?= $row1[seq_no] ?>">
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Name</td>
	<td>&nbsp;<input type=text name=C_name size=50></td></tr>
<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Image</td>
	<td>&nbsp;<input type=file name=userfile1 size=30></td></tr> -->
<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Link Use</td>
	<td>&nbsp;<input type=checkbox name=link_use value="YES"> Use Link</td></tr>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Link</td>
	<td>&nbsp;<input type=text name=special_link size=70 value="product_list.php?p_code1=X&p_code2=X&p_code3=X"></td></tr> -->
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Seo Link</td>
	<td>&nbsp;<input type=text name=url_link size=50 ></td></tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=2 align=center height=35><input type=submit value="Category add"></td>
</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>