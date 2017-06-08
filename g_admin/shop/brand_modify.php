<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_brand";


	if($_POST['mode'] == "save")
	{
		$no = $_POST['no'];
		$photo1 = $_POST['photo1'];
		$brand = $_POST['brand'];
		$brand_url = $_POST['brand_url'];
		$brand_content = $_POST['brand_content'];
		$html_check = $_POST['html_check'];
		$main_print = $_POST['main_print'];

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

						if(!getimagesize("../../upload/$attc_name1[savedName]"))
						{
							@unlink("../../upload/$attc_name1[savedName]");
							echo "no image";
							exit;
						}
				}



				$userfile1 = $attc_name1[savedName];
			}
		}

		$qry1 = "update $tableName set name='$brand', brand_url='$brand_url', userfile1='$userfile1', brand_content='$brand_content', html_check='$html_check', main_print='$main_print' where seq_no='$no'";
		$rst1 = mysql_query($qry1,$dbConn);

		Misc::jvAlert("Completed!","location.replace('brand_list.php?area=$area')");
		exit;
	}


	$no = $_GET['no'];

	$qry1 = "select * from $tableName where seq_no = '$no'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>

<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Brand Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<script>
	function chk(tf){
		if(!tf.brand.value)
			{
			alert('Enter your brand name!');
			tf.brand.focus();
			return false;
			}
		return true;
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)"  Enctype="multipart/form-data">
<input type=hidden name=mode value="save">
<input type=hidden name=userfile1_now value="<?= $row1[userfile1] ?>">
<input type=hidden name=area value="<?= $area ?>">
<input type=hidden name=no value="<?= $no ?>">
	<tr bgcolor=#eee8aa height=30>
		<td colspan=2>&nbsp;&nbsp;<b>Brand Add</b></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Name</td>
		<td>&nbsp;&nbsp;<input type=text name=brand size=30 value="<?= $row1[name] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Url</td>
		<td>&nbsp;&nbsp;<input type=text name=brand_url size=50 value="<?= $row1[brand_url] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>logo</td>
		<td>&nbsp;&nbsp;<?= $row1[userfile1] ?>&nbsp;<input type=checkbox name=photo1 value="YES"> delete file</td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>logo</td>
		<td>&nbsp;&nbsp;<input type=file name=userfile1 size=30></td>
	</tr>
	<!-- <tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>description</td>
		<td>&nbsp;&nbsp;<textarea name=brand_content cols=70 rows=10><?= $row1[brand_content] ?></textarea><br>
		&nbsp;<input type=checkbox name=html_check value="YES" <? if($row1[html_check] == "YES") echo "checked"; ?>>HTML </td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Main Print</td>
		<td>&nbsp;&nbsp;<input type=checkbox name=main_print value="YES" <? if($row1[main_print] == "YES") echo "checked"; ?>>  MAIN BANNER PRINT</td>
	</tr> -->
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="   Brand modify   "></td>
	</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>