<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";

	/**
	* 상단 INCLUDE
	*/
	include _BASE_DIR . "/g_admin/inc_top.php";


?>
<table width="98%" align=center border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td class="title_16" align=left>Product Batch Add&nbsp;&nbsp;</td>   
			</tr>
			<tr><td height=5 bgcolor="#CC6600"></td></tr>
			<tr>
				<td>
				<br>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center" >
				<form method='post' enctype='multipart/form-data' name='fileUpForm' action='product_add_batch_form.php' class='form_02'>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="txt_12">

				
					<tr><td height=1 colspan=2 bgcolor=#cccccc></td></tr>


					<tr>
						<td width='20%' align='center' height=50 bgcolor="#ededed" align=left>
							Excel File
						</td>
						<td bgcolor=#FFFFFF width='80%' height=50 align=left>
							&nbsp;<input type='file' name='userfile1' class='form_02' size=40>
							<input type='submit' value='UPLOAD' class='form_02' style='width:70' >
						</td>
					</tr>
					<tr><td height=1 colspan=2 bgcolor=#cccccc></td></tr>
				</table>
				</form>
				<br>
				<a href=../FORMAT.csv><span style="font-size:16pt"><u>Download Format</u></span></a>
				</td>
			</tr>
			</table>

				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>