<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";




	$tableName = "chan_shop_banner";


	if($_POST['mode'] == "save")
	{

		if($_POST['photo1'] == "YES")
		{
			$userfile1 = "";
		}
		else
		{
			if(empty($_FILES['userfile1']['tmp_name'])){
				
				$userfile1 = $_POST['userfile1_now'];

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

		$qry1 = "update $tableName set name='".$_POST['brand']."', banner_spot = '".$_POST['banner_spot']."', brand_url='".$_POST['brand_url']."', userfile1='$userfile1', brand_content='".$_POST['brand_content']."', html_check='".$_POST['html_check']."', main_print='".$_POST['main_print']."', view_print='".$_POST['view_print']."' where seq_no='".$_POST['no']."'";
		$rst1 = mysql_query($qry1,$dbConn);

		Misc::jvAlert("Completed!","location.replace('banner_list.php?area=$area')");
		exit;
	}

	$qry1 = "select * from $tableName where seq_no = '".$_GET['no']."'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>

<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Banner Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<script>
	function chk(tf){
		if(!tf.brand.value)
			{
			alert('이름을 넣어주세요!');
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
<input type=hidden name=no value="<?= $_GET['no'] ?>">
	<tr bgcolor=#eee8aa height=30>
		<td colspan=2>&nbsp;&nbsp;<b>Banner Add</b></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Name</td>
		<td>&nbsp;&nbsp;<input type=text name=brand size=30 value="<?= $row1[name] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Spot</td>
		<td>&nbsp;&nbsp;<select name=banner_spot>
		<option value="1"  <? if($row1[banner_spot] == "1") echo "selected"; ?>>MAIN BANNER 1 (1200 x 550 pixel)
		</select></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Link</td>
		<td>&nbsp;&nbsp;<input type=text name=brand_url size=50 value="<?= $row1[brand_url] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Image</td>
		<td>&nbsp;&nbsp;<?= $row1[userfile1] ?>&nbsp;<input type=checkbox name=photo1 value="YES"> delete file</td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>Image</td>
		<td>&nbsp;&nbsp;<input type=file name=userfile1 size=30></td>
	</tr>
	<tr bgcolor='#FFFFFF' height=30>
		<td width=200 height=28 align=center>View</td>
		<td>&nbsp;&nbsp;<input type=radio name=view_print value="YES" <? if($row1[view_print] == "YES") echo "checked"; ?>> View 
		<input type=radio name=view_print value="NO" <? if($row1[view_print] == "NO") echo "checked"; ?>> Hold </td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="   Banner modify   "></td>
	</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>