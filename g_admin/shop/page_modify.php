<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_page";


	include _BASE_DIR . "/g_admin/inc_top.php";


	if($_POST['mode'] == "modify")
	{


		if($_POST['flag'] == "1")
		{
		$item_code = $_POST['item_code'];
		$item_name = $_POST['item_name'];
		$edit_content = $_POST['edit_content'];

		$qry1 = "update $tableName set item_name = '$item_name', item_description = '$edit_content' where item_code = '$item_code'";
		}
		else
		{
			$qry1 = "delete from $tableName where item_code = '$item_code'";
		}

		$rst1 = mysql_query($qry1,$dbConn);

		
		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('page_list.php?area=$area')");
			exit;
		}
	}


	$item_code = $_GET['item_code'];


	// 상품설명
	$qry1 = "select * from $tableName where item_code = '$item_code'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);


?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Page Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<form name=category action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return saveArticle()">
<input type=hidden name=mode value="modify">
<input type=hidden name=item_code value="<?= $item_code ?>">
<input type=hidden name=no value="<?= $no ?>">
<input type=hidden name=area value="<?= $area ?>">
<tr bgcolor='#eee8aa'>
	<td colspan=2 height=35>&nbsp;<b>Product modify</b></td>
</tr>

	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Item name</td>
		<td>&nbsp;<input type=text name=item_name size=30 value="<?= $row1[item_name]; ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 colspan=2 align=left >&nbsp;&nbsp;Description</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td valign=top colspan=2>
		<?
			// Include the CKEditor class.
			include_once "../../ckeditor/ckeditor.php";
			// The initial value to be displayed in the editor.
			$initialValue = $row1[item_description];
			// Create a class instance.
			$CKEditor = new CKEditor();
			// Path to the CKEditor directory, ideally use an absolute path instead of a relative dir.
			//   $CKEditor->basePath = '/ckeditor/'
			// If not set, CKEditor will try to detect the correct path.
			$CKEditor->basePath = _WEB_BASE_DIR.'/ckeditor/';
			// Create a textarea element and attach CKEditor to it.
			$CKEditor->editor("edit_content", $initialValue);


	
		  ?>	
		</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Func</td>
		<td>&nbsp;<input type=radio name=flag value="1" CHECKED>Modify <input type=radio name=flag value="2" >Delete </td>
	</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=2 align=center height=35><input type=submit value=" +++ SUBMIT +++ " class="line"></td>
</tr></form>
</table>
<br><br><br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>