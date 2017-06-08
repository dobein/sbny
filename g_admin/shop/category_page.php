<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_category";


	include _BASE_DIR . "/g_admin/inc_top.php";


	if($_POST['mode'] == "modify")
	{



		$c_code1 = $_POST['c_code1'];
		$c_code2 = $_POST['c_code2'];
		$c_code3 = $_POST['c_code3'];

		$edit_content = addslashes($_POST['edit_content']);

		$qry1 = "update $tableName set content = '$edit_content' where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 = '$c_code3'";
		$rst1 = mysql_query($qry1,$dbConn);

		
		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('category3.php?area=&c_code1=$c_code1&c_code2=$c_code2')");
			exit;
		}
	}


	$item_code = $_GET['item_code'];

	$c_code1 = $_GET['c_code1'];
	$c_code2 = $_GET['c_code2'];
	$c_code3 = $_GET['c_code3'];




	// 상품설명
	$qry1 = "select * from $tableName where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 = '$c_code3'";
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
<input type=hidden name=c_code1 value="<?= $c_code1 ?>">
<input type=hidden name=c_code2 value="<?= $c_code2 ?>">
<input type=hidden name=c_code3 value="<?= $c_code3 ?>">
	<tr bgcolor='#FFFFFF'>
		<td colspan=5>&nbsp;&nbsp;[ <a href=category.php><?= Category_name($c_code1,'0','0') ?></a>&nbsp;<a href=category2.php?c_code1=<?= $c_code1 ?>><?= Category_name($c_code1,$c_code2,'0') ?></a>&nbsp;]</td>
	</tr>

	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Page name</td>
		<td>&nbsp;<?= Category_name($c_code1,$c_code2,$c_code3) ?></td>
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
			$initialValue = stripslashes($row1[content]);
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
	<td colspan=2 align=center height=35><input type=submit value="  SUBMIT  " class="line"></td>
</tr></form>
</table>
<br><br><br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>