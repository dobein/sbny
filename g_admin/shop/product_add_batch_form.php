<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	if($_POST['mode'] == "save")
	{
		$totalCnt = 0;

		for($i=0; $i<count($_POST['no']); $i++)
		{
					$keychars2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
					$length2 = 4;
					$max2=strlen($keychars2)-1;
					for ($j=0;$j<=$length2;$j++) {
					  $randkey2 .= substr($keychars2, rand(0, $max2), 1);
					}


					// item code 만들기
					$item_code = $randkey.date("d").date("m").date("y")."K".$randkey2.date("h").date("i");


					/**
					* @ 멀티 카테고리 등록
					*/
					$print_option = $_POST['print_option'][$i];
					$sub_category = explode("@",$_POST['category'][$i]);

					$pre_qry1 = "select min(pos) from chan_shop_c_product";
					$pre_rst1 = mysql_query($pre_qry1);
					$min_pos = @mysql_result($pre_rst1,0,0);

					if(empty($min_pos))
					{
						$min_pos = -1;
					}
					else
					{
						$min_pos = $min_pos-1;
					}

					for($k=0; $k<count($sub_category); $k++)
					{
						//echo $sub_category[$i]."<br>";
						$sub_c = explode("/",$sub_category[$k]);
						
						if($sub_c[0])
						{
							$category_qry1 = "insert into chan_shop_c_product (p_code1,p_code2,p_code3,item_code,print_option,pos) values ('$sub_c[0]','$sub_c[1]','$sub_c[2]','$item_code','$print_option','$min_pos')";
							$category_rst1 = mysql_query($category_qry1);
						}
					}



					$item_url = $_POST['item_url'][$i];
					$pos = $_POST['pos'][$i];

					$print_option = $_POST['print_option'][$i];

					$icon = $_POST['icon'][$i];
					$item_title = addslashes($_POST['item_title'][$i]);
					$barcode = addslashes($_POST['barcode'][$i]);
					$item_type = $_POST['item_type'][$i];
					$model_no = $_POST['model_no'][$i];

					$editor1 = addslashes($_POST['editor1'][$i]);

					$item_stock = $_POST['item_stock'][$i];
					$stock_cnt = $_POST['stock_cnt'][$i];
					$ship_flag = $_POST['ship_flag'][$i];
					$item_manufacture = $_POST['item_manufacture'][$i];
					$item_origin = $_POST['item_origin'][$i];
					$item_package = $_POST['item_package'][$i];
					$item_weight = $_POST['item_weight'][$i];
					$item_price1 = $_POST['item_price1'][$i];
					$item_price2 = $_POST['item_price2'][$i];
					$item_costco = $_POST['item_costco'][$i];
					$item_icon = $_POST['tag'][$i];

					$color = addslashes($_POST['color'][$i]);
					$size = addslashes($_POST['size'][$i]);


					$tmpName1 = $_FILES['userfile1']['tmp_name'];
					if(is_uploaded_file($tmpName1)){
							$pds_file1 = $_FILES['userfile1']['name'];
							$board_pds_pos = "../../upload";
							$attc_name1 = Misc::uploadFileUnsafely($tmpName1 , $pds_file1 , $board_pds_pos);
							}

					$src = '../../upload/'.$attc_name1[savedName];        //-- 원본 
					$dst = '../../upload/thum_'.$attc_name1[savedName];     //-- 저장 

					$quality = '150';    //-- jpg 퀄리티 
					$size = '400';    //-- 줄일 크기 pixel (너비, 또는 높이에 적용) 
					//$ratio = '1:2';        //-- 이미지를 4:3 비율로 잘라냄 
					$ratio = 'false';        //-- 원본 이미지비율을 유지 

					$get_size = _getimagesize($src, $size, $ratio); 
					$result = resize_image($dst, $src, $get_size, $quality, $ratio); 



					$tmpName2 = $_FILES['userfile2']['tmp_name'];
					if(is_uploaded_file($tmpName2)){
							$pds_file2 = $_FILES['userfile2']['name'];
							$board_pds_pos = "../../upload";
							$attc_name2 = Misc::uploadFileUnsafely($tmpName2 , $pds_file2 , $board_pds_pos);
							}

					$tmpName3 = $_FILES['userfile3']['tmp_name'];
					if(is_uploaded_file($tmpName3)){
							$pds_file3 = $_FILES['userfile3']['name'];
							$board_pds_pos = "../../upload";
							$attc_name3 = Misc::uploadFileUnsafely($tmpName3 , $pds_file3 , $board_pds_pos);
							}



					$item_stock = "In";

					if($category_rst1)
					{
						$qry1 = "insert into chan_shop_product (item_code,
																				barcode,
																				print_option,
																				item_type,
																				brand,
																				item_style,
																				model_no,
																				item_title, 
																				item_description, 
																				item_notice, 
																				userfile1,
																				userfile2,
																				userfile3,
																				color, 
																				size,
																				size_inventory,
																				opt1,
																				file_name,
																				stock_cnt,
																				ship_flag,
																				ship_esti,
																				item_manufacture, 
																				item_origin, 
																				item_package,
																				item_weight,
																				gift_box,
																				item_icon,
																				new_product,
																				on_sale,
																				item_price1,
																				item_price2,
																				item_costco,
																				item_url) values ('$item_code',
																											'$barcode',
																											'$print_option',
																											'$item_type',
																											'$brand',
																											'$item_style',
																											'$model_no',
																											'$item_title',
																											'$editor1',
																											'$kor_content',
																											'$attc_name1[savedName]',
																											'$attc_name2[savedName]',
																											'$attc_name3[savedName]',
																											'$color',
																											'$size',
																											'$size_inventory',
																											'$opt1',
																											'$file_name',
																											'$stock_cnt',
																											'$ship_flag',
																											'$ship_esti',
																											'$item_manufacture',
																											'$item_origin',
																											'$item_package',
																											'$item_weight',
																											'$gift_box',
																											'$item_icon',
																											'$new_product',
																											'$on_sale',
																											'$item_price1',
																											'$item_price2',
																											'$item_costco',
																											'$item_url')";

						$rst1 = mysql_query($qry1,$dbConn);
					}

		}




		if($rst1)
		{

			Misc::jvAlert("Completed!","location.replace('product.php')");
			exit;
		}
		else
		{
			echo "fail";
			exit;
		}
	}





	/**
	* 상단 INCLUDE
	*/
	include _BASE_DIR . "/g_admin/inc_top.php";


?>
<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center">
		<table width=100% border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td class="title_16" align=left>Product Batch Add
			<tr><td height=5 bgcolor="#CC6600"></td></tr>
			<tr>
				<td>
				<br>

<div style="width:1200px; height:600px;overflow:scroll">
<script>
	function chk(tf){
		
		if(confirm("Do you want to register?") == true)
		{
			return true;
		}
		else return false;
	}

</script>
<form method='post' name='inputForm' action='<?= $_SERVER['PHP_SELF'] ?>' onSubmit="return chk(this)">
<input type=hidden name=mode value="save">
<table width=1700 border=0 cellpadding=1 cellspacing=1 bgcolor='#BBD0E5' class="txt_12">
	<tr bgcolor="#CC6600"  style="color:#ffffff" align='center' height='25'>
		<td width=100 align=center>No</td>
		<td width=100 align=center>Model No</td>
		<td width=100 align=center>Item Name</td>
		<td width=100 align=center>SEO URL</td>
		<td width=100 align=center>Category</td>
		<td width=200 align=center>Description</td>
		<td width=100 align=center>Tag</td>
		<td width=100 align=center>Weight</td>
		<td width=100 align=center>Stock</td>
		<td width=100 align=center>Color</td>
		<td width=100 align=center>Size</td>
		<td width=100 align=center>Net Price</td>
		<td width=100 align=center>Our Price</td>
		<td width=100 align=center>Sale Price</td>
		<td width=100 align=center>Image Name</td>
		<td width=100 align=center>Display</td>
	</tr>

	<!-- 구매대행 이라면... -->


	<?

	$tmpName1 = $_FILES['userfile1']['tmp_name'];

	if(is_uploaded_file($tmpName1)){
			//$HTTP_POST_FILES['userfile1']['name'];
			$pds_file1 =  $userInfo[userid]."_master_".date("Y_m_d_H_i_s").".csv";
			$board_pds_pos = "./csv";
			$attc_name1 = Misc::uploadFileUnsafely($tmpName1 , $pds_file1 , $board_pds_pos);
			}

	$dest = "./csv/$attc_name1[savedName]";
	//$dest = "./csv/2006_11_08_01_21_58.csv";

	setlocale(LC_CTYPE, "ko_KR.eucKR"); 


	// 파싱
	$fp = fopen($dest, "r");

	$next_orderid = "1";

	while($data[] = fgetcsv($fp, 10000, ",")) {;}


	$orderNo = 0;

	$ok_status = 1;

	for($i=2; $i<count($data)-1; $i++) {


	$model_no = $data[$i][0];
	$item_name = $data[$i][1];
	$seo_url = $data[$i][2];
	$category = $data[$i][3];
	$desc = $data[$i][4];
	$tag = $data[$i][5];
	$weight = $data[$i][6];
	$stock_cnt = $data[$i][7];
	$color = $data[$i][8];
	$size = $data[$i][9];
	$net_price = $data[$i][10];
	$our_price = $data[$i][11];
	$sale_price = $data[$i][12];
	$image_name = $data[$i][13];


	$display = $data[$i][14];

	if($display == "YES")
		{
			$print_option1 = "checked";
			$print_option2 = "";
		}
	else
		{
			$print_option1 = "";
			$print_option2 = "checked";
		}
	?>
	<tr bgcolor='#ffffff' align='center' height='25'>
		<td height=45><input type=text class="form_02"  name=no[] size=6 value="<?=$i-1?>"  style="border:0px"></td>
		<td ><input type=text class="form_02"  name=model_no[] size=12 value="<?=$model_no?>" ></td>
		<td ><input type=text class="form_02"  name=item_title[] size=12 value="<?=$item_name?>" ></td>
		<td ><input type=text class="form_02"  name=item_url[] size=12 value="<?=trim($seo_url)?>" ></td>
		<td ><input type=text class="form_02"  name=category[] size=12 value="<?=trim($category)?>" ></td>
		<td ><input type=text class="form_02"  name=editor1[] size=24 value="<?=trim($desc)?>" ></td>
		<td ><input type=text class="form_02"  name=tag[] size=12 value="<?=trim($tag)?>" ></td>
		<td ><input type=text class="form_02"  name=weight[] size=12 value="<?=trim($weight)?>" ></td>
		<td ><input type=text class="form_02"  name=stock_cnt[] size=12 value="<?=trim($stock_cnt)?>" ></td>
		<td ><input type=text class="form_02"  name=color[] size=12 value="<?=trim($color); ?>" ></td>
		<td ><input type=text class="form_02"  name=size[] size=12 value="<?=trim($size); ?>" ></td>
		<td >$<input type=text class="form_02"  name=item_costco[] size=6 value="<?=trim($net_price)?>" ></td>
		<td >$<input type=text class="form_02"  name=item_price1[] size=6 value="<?=trim($our_price)?>" ></td>
		<td >$<input type=text class="form_02"  name=item_price2[] size=6 value="<?=trim($sale_price)?>" ></td>
		<td ><input type=text class="form_02"  name=image_name[] size=12 value="<?=trim($image_name)?>" ></td>
		<td ><select name=print_option[]><option value="YES" <?= $print_option1 ?>>Yes<option value="NO" <?= $print_option2 ?>>No</select></td>
	</tr>
	<?
	}
	?>
</table>

<br>
&nbsp;&nbsp;&nbsp;<input type='submit' value=' SUBMIT ' >
</form>
<BR><BR><BR>
</div>

				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>