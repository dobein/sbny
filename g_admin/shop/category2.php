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
		$no = $_GET['no'];
		$c_code1 = $_GET['c_code1'];
		$c_code2 = $_GET['c_code2'];


		$qry1 = "delete from $tableName where seq_no = '$no'";
		$rst1 = mysql_query($qry1,$dbConn);

		// 하위 카테고리 지우기
		$qry2 = "delete from $tableName where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 <> '0'";
		$rst2 = mysql_query($qry2,$dbConn);

		Misc::jvAlert("Completed!","location.replace('category2.php?c_code1=$c_code1')");
		exit;

	}

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
		$c_code1 = $_POST['c_code1'];
		$c_code2 = $_POST['c_code2'];
		$C_name = $_POST['C_name'];

		$url_link = $_POST['url_link'];


		$qry1 = "select max(c_code2),max(pos) from $tableName where c_code1='$c_code1' && c_code2<>'0' && c_code3='0'";
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
			$qry2 = "insert into $tableName (c_code1,c_code2,c_code3,parent,name,userfile1,pos,activate,url_link) values ('$c_code1','1','0','$parent_no','$C_name','$attc_name1[savedName]','1','Active','$url_link')";
			$rst2 = mysql_query($qry2,$dbConn);
		}
		else
		{
			$max_value2 = $max_value1 + 1;
			$max_pos2 = $max_pos1 + 1;
			$qry2 = "insert into $tableName (c_code1,c_code2,c_code3,parent,name,userfile1,pos,activate,url_link) values ('$c_code1','$max_value2','0','$parent_no','$C_name','$attc_name1[savedName]','$max_pos2','Active','$url_link')";
			$rst2 = mysql_query($qry2,$dbConn);
		}

		echo "<meta http-equiv='refresh' content='0; url=./category2.php?c_code1=$c_code1'>";
		exit;
	}

	if($_GET['mode'] == "up")
		{
		$pos = $_GET['pos'];
		$seqNo = $_GET['seqNo'];
		$c_code1 = $_GET['c_code1'];

		$qry1 = "select max(pos) from $tableName where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' && pos<$pos";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_result($rst1,0,0);

		$qry2 = "update $tableName set pos='$pos' where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' && pos='$row1'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "update $tableName set pos='$row1' where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' && seq_no='$seqNo'";
		$rst3 = mysql_query($qry3,$dbConn);
		}
	else if($_GET['mode'] == "down")
		{
		$pos = $_GET['pos'];
		$seqNo = $_GET['seqNo'];
		$c_code1 = $_GET['c_code1'];

		$qry1 = "select min(pos) from $tableName where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' && pos>$pos";
		$rst1 = mysql_query($qry1,$dbConn);
		$row1 = mysql_result($rst1,0,0);

		$qry2 = "update $tableName set pos='$pos' where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' && pos='$row1'";
		$rst2 = mysql_query($qry2,$dbConn);

		$qry3 = "update $tableName set pos='$row1' where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' && seq_no='$seqNo'";
		$rst3 = mysql_query($qry3,$dbConn);
		}

	function Category_list(){

		global $dbConn,$tableName,$c_code1,$area;

		$qry1 = "select * from $tableName where c_code1='$c_code1' && c_code2<>'0' && c_code3='0' order by pos asc";
		$rst1 = mysql_query($qry1,$dbConn);

		$num = 0;
		while($row1 = mysql_fetch_array($rst1)){

			//$below_value = below_num($row1[c_code1],$row1[c_code2]);

			$qry2 = "select min(pos),max(pos) from $tableName where c_code1='$c_code1' && c_code2<>'0' && c_code3='0'";
			$rst2 = mysql_query($qry2,$dbConn);
			$min_value = mysql_result($rst2,0,0);
			$max_value = mysql_result($rst2,0,1);

			if($row1[pos] == $min_value)
				{
				$pos_msg = "<a href=category2.php?area=$area&c_code1=$c_code1&mode=down&pos=$row1[pos]&seqNo=$row1[seq_no]>DOWN</a>";
				}
			else if($row1[pos] == $max_value)
				{
				$pos_msg = "<a href=category2.php?area=$area&c_code1=$c_code1&mode=up&pos=$row1[pos]&seqNo=$row1[seq_no]>UP</a>";
				}
			else
				{
				$pos_msg = "<a href=category2.php?area=$area&c_code1=$c_code1&mode=up&pos=$row1[pos]&seqNo=$row1[seq_no]>UP</a> <a href=category2.php?lang=$lang&c_code1=$c_code1&mode=down&pos=$row1[pos]&seqNo=$row1[seq_no]>DOWN</a>";
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
				$active_msg = "<a href=\"javascript:change_active('$row1[seq_no]','Inactive','$row1[c_code1]')\">View</a>";
			}
			else
			{
				$active_msg = "<a href=\"javascript:change_active('$row1[seq_no]','Active','$row1[c_code1]')\"><font style=\"color:red\">Hidden</font></a>";
			}

			// 등록 상품갯수 구하기
			$count_qry1 = "select count(*) from chan_shop_product where p_code1 = '$row1[c_code1]' && p_code2 = '$row1[c_code2]'";
			$count_rst1 = mysql_query($count_qry1,$dbConn);
			$count_total = @mysql_result($count_rst1,0,0);

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
					<td align=center height=35><font color=green>$row1[url_link]</font></td>
					<td align=left height=25 bgcolor=#F4F4F4>&nbsp;[$row1[c_code1],$row1[c_code2],0]&nbsp;<a href=category3.php?area=$area&c_code1=$row1[c_code1]&c_code2=$row1[c_code2]>$row1[name] </a> </td>
					<td align=center >$pos_msg</td>
					<td align=center ><a href=category3.php?area=$area&c_code1=$row1[c_code1]&c_code2=$row1[c_code2]>Sub category</a></td>
					<td align=center>$active_msg</td>
					<td align=center ><a href=category_modify.php?area=$area&no=$row1[seq_no]&c_code1=$c_code1>Modify</a> | <a href=\"javascript:category_del('$row1[seq_no]','$row1[c_code1]','$row1[c_code2]')\">Delete</a></td>
				</tr>
			";

		$num++;
		unset($count_total);
		}

		if($num == "0")
		{
			echo "
			<tr bgcolor='#FFFFFF'>
					<td colspan=6 align=center height=35>Empty Category!</td>
			</tr>";
		}
	}

	$c_code1 = $_GET['c_code1'];
	$c_code2 = $_GET['c_code2'];

	$qry1 = "select * from $tableName where c_code1 = '$c_code1' && c_code2 = '0' && c_code3 = '0'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<script>
	function change_active(no,mode,code1){
		
		if(mode == 'Active')
		{
			answer = confirm("View?");

			if(answer == true)
			{
				location.replace('category2.php?mode=change&division=' + mode + '&no=' + no + '&c_code1=' + code1);
				exit;
			}
			else return;
		}
		else
		{
			answer = confirm("Hidden?");

			if(answer == true)
			{
				location.replace('category2.php?mode=change&division=' + mode + '&no=' + no + '&c_code1=' + code1);
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
			location.replace('category2.php?mode=del&no=' + no + '&c_code1=' + code1 + '&c_code2=' + code2);
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
	<td colspan=6 height=35>&nbsp;<b>Middle category</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=6>&nbsp;&nbsp;[ <a href=category.php><?= Category_name($c_code1,$c_code2,'0') ?></a>  ]</td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=6 height=80><? if($row1[userfile1]): ?><img src="../../upload/<?= $row1[userfile1] ?>" height=70><? else: ?>&nbsp;No image<? endif; ?></td>
</tr>
<tr bgcolor=#FFFFFF>
	<td align=center width=15% height=30>Link</td>
	<td align=center width=30% height=30>Name</td>
	<td align=center width=15%>Position</td>
	<td align=center width=10%>Add</td>
	<td align=center width=10%>Hold</td>
	<td align=center width=20%>M / D</td>
</tr>
<? Category_list('two'); ?>
</table>
<br>

<table width=100% align=center border=0 cellspacing=1 cellpadding=2 bgcolor='#a9a9a9'>
<tr bgcolor='#eee8aa'>
	<td colspan=2 height=35>&nbsp;<b>Middle category add</b></td>
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
<input type=hidden name=parent_no value="<?= $row1[seq_no] ?>">
<input type=hidden name=area value="<?= $area ?>">
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Name</td>
	<td>&nbsp;<input type=text name=C_name size=20>&nbsp;&nbsp;</td></tr>
<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Image</td>
	<td>&nbsp;<input type=file name=userfile1 size=30></td></tr> -->
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