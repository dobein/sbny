<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";


	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";


	$tableName = "chan_shop_base";


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



		$site_address = $_POST['site_address1']."@".$_POST['site_address2']."@".$_POST['site_address3']."@".$_POST['site_address4'];


		$qry1 = "update $tableName set site_title = '".$_POST['site_title']."',
															site_name = '".$_POST['site_name']."',
															site_email = '".$_POST['site_email']."',
															site_homepage = '".$_POST['site_homepage']."',
															site_address = '".$site_address."',
															site_phone = '".$_POST['site_phone']."',
															site_copyright = '".$_POST['site_copyright']."',
															tax_flag = '".$_POST['tax_flag']."',
															currency = '".$_POST['currency']."',
															payment_credit = '".$_POST['payment_credit']."', 
															payment_check = '".$_POST['payment_check']."',
															payment_wire = '".$_POST['payment_wire']."',
															return_policy = '".addslashes($_POST['return_policy'])."',
															top_banner = '".$userfile1."',
															meta_desc = '".addslashes($_POST['meta_desc'])."',
															meta_keyword = '".addslashes($_POST['meta_keyword'])."'";



		$rst1 = mysql_query($qry1);


	}


	// 사이트 정보 가져오기

	$base_info = getinfo_site_admin();


	$address = explode("@",$base_info[site_address]);

	include _BASE_DIR . "/g_admin/inc_top.php";
?>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Base Setup</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=left height=25 bgcolor=#eee8aa>&nbsp;&nbsp;<b>Account Information</b></td>
	</tr>
<script>
	function chk(tf){
		if(!tf.p_name.value)
		{
			alert('Enter your product name!');
			tf.p_name.focus();
			return false;
		}
		if(!tf.p_title.value)
		{
			alert('Enter your product title!');
			tf.p_title.focus();
			return false;
		}
		if(!tf.p_price.value)
		{
			alert('Enter your product price!');
			tf.p_price.focus();
			return false;
		}
	return true;
	}

	function change_sales(str){
		
		if(str == 'true')
		{
			document.regi.tax_base_sales.disabled = false;
			strikeInOut(percent1);
		}
		else
		{
			document.regi.tax_base_sales.disabled = true;
			strikeInOut(percent1);
		}
	}


	function strikeInOut(elem){
		elem.style.textDecoration = (elem.style.textDecoration == 'line-through')?'none':'line-through';
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> name=regi method=post Enctype="multipart/form-data" onSubmit="return chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=area value="<?= $area ?>">
<input type=hidden name=userfile1_now value="<?= $base_info[top_banner] ?>">
<input type=hidden name=domain value="<?= $domain ?>">

	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Site Name</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_name size=70 value="<?= $base_info[site_name] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Title</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_title size=70 value="<?= $base_info[site_title] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Homepage</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_homepage size=70 value="<?= $base_info[site_homepage] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;E-mail</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_email size=70 value="<?= $base_info[site_email] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Address</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_address1 size=70 value="<?= $address[0] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;City</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_address2 size=30 value="<?= $address[1] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;State</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_address3 size=2 maxlength=2 value="<?= $address[2] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Zipcode</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_address4 size=5 value="<?= $address[3] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Phone</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_phone size=70 value="<?= $base_info[site_phone] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width=25% height=25 align=left height=30>&nbsp;&nbsp;Copy Right</td>
		<td width=75% align=left>&nbsp;<input type=text name=site_copyright size=70 value="<?= $base_info[site_copyright] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td height=25>&nbsp;Company Logo</td>
		<td>&nbsp;<? if($base_info[top_banner]): ?><img src="../../upload/<?= $base_info[top_banner] ?>" height=40> <input type=checkbox name=photo1 value="YES"> Delete Logo<? else: ?>Nothing<? endif; ?></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td height=25>&nbsp;Company Logo upload</td>
		<td>&nbsp;<input type=file name=userfile1 size=30></td>
	</tr>


	<tr bgcolor='#F4F4F4'>
		<td colspan=2 height=25>&nbsp;- Disclaimer</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=28 align=left >&nbsp;&nbsp;Disclaimer message </td>
		<td  height=28 align=left ><textarea name=return_policy cols=80 rows=5><?= $base_info[return_policy] ?></textarea></td>
	</tr>
	<tr bgcolor='#F4F4F4'>
		<td colspan=2 height=25>&nbsp;- SEO</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=28 align=left >&nbsp;&nbsp;Meta Description</td>
		<td  height=28 align=left ><textarea name=meta_desc cols=80 rows=5><?= $base_info[meta_desc] ?></textarea></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=28 align=left >&nbsp;&nbsp;Meta Keyword</td>
		<td  height=28 align=left ><textarea name=meta_keyword cols=80 rows=5><?= $base_info[meta_keyword] ?></textarea></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td colspan=2 align=center height=45><input type=submit value="   SAVE   "></td>
	</tr></form>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>