<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	$tableName = "chan_shop_category";

	if($_POST['mode'] == "save")
	{

		$C_name = $_POST['C_name'];
		$url_link = $_POST['url_link'];
		$no = $_POST['no'];

		$c_code2 = $_POST['c_code2'];

		if($photo1 == "YES")
		{
			$userfile1 = "";
		}
		else
		{
			if(empty($_FILES['userfile1']['tmp_name'])){
				
				$userfile1 = $userfile1_now;

			}
			else
			{
				$tmpName1 = $_FILES['userfile1']['tmp_name'];

				if(is_uploaded_file($tmpName1)){
						$pds_file1 = $_FILES['userfile1']['name'];
						$board_pds_pos = "../../upload";
						$attc_name1 = Misc::uploadFileUnsafely($tmpName1 , $pds_file1 , $board_pds_pos);
						}

				if(!getimagesize("../../upload/$attc_name1[savedName]"))
				{
					@unlink("../../upload/$attc_name1[savedName]");
					echo "no image";
					exit;
				}

				$userfile1 = $attc_name1[savedName];
			}
		}


		$qry2 = "update $tableName set name='$C_name', c_code2 = '$c_code2', userfile1 = '$userfile1', url_link = '$url_link' where seq_no='$no'";
		$rst2 = mysql_query($qry2,$dbConn);
		


		if($rst2)
		{
			$c_code1 = $_POST['c_code1'];
			$c_code2 = $_POST['c_code2'];

			if($c_code1 && $c_code2)
			{
			echo "<meta http-equiv='refresh' content='0; url=category3.php?c_code1=$c_code1&c_code2=$c_code2&lang=$lang'>";
			}
			elseif($c_code1)
			{
			echo "<meta http-equiv='refresh' content='0; url=category2.php?c_code1=$c_code1&lang=$lang'>";
			}
			else
			{
			echo "<meta http-equiv='refresh' content='0; url=category.php?lang=$lang'>";
			}
			exit;
		}
	}

	$no = $_GET['no'];


	$c_code1 = $_GET['c_code1'];
	$c_code2 = $_GET['c_code2'];

	$qry1 = "select * from $tableName where seq_no='$no'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Category Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<tr bgcolor=#eee8aa>
	<td colspan=2 height=35>&nbsp;<b>Category Modify</b></td>
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
<input type=hidden name=no value="<?= $no ?>">
<input type=hidden name=c_code1 value="<?= $c_code1 ?>">
<input type=hidden name=userfile1_now value="<?= $row1[userfile1] ?>">
<input type=hidden name=area value="<?= $area ?>">
<tr bgcolor='#FFFFFF'>
	<td width=200 bgcolor=#FFFFFF height=35>&nbsp;Category name</td>
	<td>&nbsp;<input type=text name=C_name size=20 value="<?= $row1[name] ?>"></td></tr>

<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Image</td>
	<td>&nbsp;<? if($row1[userfile1]): ?><img src="../../upload/<?= $row1[userfile1] ?>" > <input type=checkbox name=photo1 value="YES"> Delete Image<? else: ?>Empty<? endif; ?></td></tr>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;TOP image</td>
	<td>&nbsp;<input type=file name=userfile1 size=30></td></tr> -->

<? if($c_code2): ?>
<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Link Use</td>
	<td>&nbsp;<input type=checkbox name=link_use value="YES" <? if($row1[link_use] == "YES") echo "checked"; ?>> Use Link</td></tr>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Link</td>
	<td>&nbsp;<input type=text name=special_link size=70 value="<?= $row1[special_link] ?>"></td></tr> -->
<? endif; ?>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Url Link</td>
	<td>&nbsp;<input type=text name=c_code2 size=50 value="<?= $row1[c_code2] ?>"></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;Url Link</td>
	<td>&nbsp;<input type=text name=url_link size=50 value="<?= $row1[url_link] ?>"></td>
</tr>
<!-- <tr bgcolor='#FFFFFF'>
	<td width=200 height=30>&nbsp;META</td>
	<td>&nbsp;<textarea name=meta_tag cols=70 rows=5><?= $row1[meta_tag] ?></textarea></td></tr> -->
<tr>
	<td colspan=2 align=center bgcolor=#FFFFFF><input type=submit value="   SUBMIT   "></td>
</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>