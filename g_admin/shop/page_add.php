<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	include _BASE_DIR . "/g_admin/inc_top.php";

	$tableName = "chan_shop_page";


	if($_POST['mode'] == "save")
	{
		$item_code = $_POST['item_code'];
		$item_name = $_POST['item_name'];
		$edit_content = $_POST['edit_content'];

		$qry1 = "insert into $tableName (item_code,item_name, 
																item_description) values (
																							'$item_code',
																							'$item_name',
																							'$edit_content')";
		

		$rst1 = mysql_query($qry1,$dbConn);

		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('page_list.php?area=$area')");
			exit;
		}
	}



?>

<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Page Manager</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
<form name=category action=<?= $_SERVER['PHP_SELF'] ?> Enctype="multipart/form-data" method=post onSubmit="return saveArticle()">
<input type=hidden name=mode value="save" >
<input type=hidden name=area value="<?= $area ?>">
<tr bgcolor='#eee8aa'>
	<td colspan=2 height=35>&nbsp;<b>Add</b></td>
</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Item Code</td>
		<td>&nbsp;<input type=text name=item_code size=30 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Item Name</td>
		<td>&nbsp;<input type=text name=item_name size=30 ></td>
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
			$initialValue = '';
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
	<td colspan=2 align=center height=50><input type=submit value=" +++ SUBMIT +++ " class="line"></td>
</tr></form>
</table>
<br><br><br>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>
