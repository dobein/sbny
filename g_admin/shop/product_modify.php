<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_product";


	include _BASE_DIR . "/g_admin/inc_top.php";

	/**
	* 편집기 소스
	*/
	//include _BASE_DIR . "/FCKeditor/fckeditor.php";


	if($_POST['mode'] == "modify")
	{

		$item_url = $_POST['item_url'];

		$item_code = $_POST['item_code'];


		$pre_qry1 = "select * from chan_shop_product where item_url = '$item_url'";
		$pre_rst1 = mysql_query($pre_qry1);
		$pre_num1 = mysql_num_rows($pre_rst1);
		
		if($pre_num1>0)
		{
			//Misc::jvAlert("URL 이 중복됩니다.","history.go(-1)");
			//exit;
		}


		$pos = $_POST['pos'];
		$sub_category_value = $_POST['sub_category_value'];
		$item_code = $_POST['item_code'];
		$itemCode = $_POST['itemCode'];
		$print_option = $_POST['print_option'];

		$icon = $_POST['icon'];
		$item_title = $_POST['item_title'];
		$barcode = $_POST['barcode'];
		$item_type = $_POST['item_type'];
		$model_no = $_POST['model_no'];

		$color = $_POST['color'];
		$size = $_POST['size'];
		

		$editor1 = addslashes($_POST['editor1']);
		$opt1 = $_POST['opt1'];
		$file_name = $_POST['file_name'];
		$opt1_name = $_POST['opt1_name'];
		$opt1_content = $_POST['opt1_content'];
		$opt1_content_arr = $_POST['opt1_content_arr'];
		$item_stock = $_POST['item_stock'];
		$stock_cnt = $_POST['stock_cnt'];
		$ship_flag = $_POST['ship_flag'];
		$item_manufacture = $_POST['item_manufacture'];
		$item_origin = $_POST['item_origin'];
		$item_package = $_POST['item_package'];
		$item_weight = $_POST['item_weight'];
		$item_price1 = $_POST['item_price1'];
		$item_price2 = $_POST['item_price2'];
		$item_price3 = $_POST['item_price3'];
		$item_costco = $_POST['item_costco'];
		$item_icon = $_POST['item_icon'];

		$item_position = $_POST['item_position'];

		$item_title = addslashes($item_title);
		$barcode = addslashes($barcode);



		// 기존 서브카테고리 삭제
		$sub_qry1 = "delete from chan_shop_c_product where item_code = '$itemCode'";
		$sub_rst1 = mysql_query($sub_qry1);

		$sub_category = explode("@",chop($_POST['sub_category_value']));

		// 끝이 @ 로 끝나면 배열 한개 줄여야 함. 
		if($_POST['mod_step'] == "1")
		{
			$sub_minus = "1";
		}
		else
		{
			$sub_minus = "0";
		}

		$pre_qry1 = "select min(pos) from chan_shop_c_product";
		$pre_rst1 = mysql_query($pre_qry1);
		$min_pos = @mysql_result($pre_rst1,0,0);

		$min_pos = $min_pos-1;

		for($i=0; $i<count($sub_category)-$sub_minus; $i++)
		{
			//echo $sub_category[$i]."<br>";

			$sub_c = explode("/",$sub_category[$i]);

			$category_qry1 = "insert into chan_shop_c_product (p_code1,p_code2,p_code3,item_code,print_option,pos) values ('$sub_c[0]','$sub_c[1]','$sub_c[2]','$itemCode','$print_option','$min_pos')";
			$category_rst1 = mysql_query($category_qry1);

		}

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
					}
			
			$userfile1 = $attc_name1[savedName];

			$src = '../../upload/'.$attc_name1[savedName];        //-- 원본 
			$dst = '../../upload/thum_'.$attc_name1[savedName];     //-- 저장 

			$quality = '150';    //-- jpg 퀄리티 
			$size = '234';    //-- 줄일 크기 pixel (너비, 또는 높이에 적용) 
			//$ratio = '1:2';        //-- 이미지를 4:3 비율로 잘라냄 
			$ratio = 'false';        //-- 원본 이미지비율을 유지 

			$get_size = _getimagesize($src, $size, $ratio); 
			$result = resize_image($dst, $src, $get_size, $quality, $ratio); 

		}

		if(empty($_FILES['userfile2']['tmp_name'])){
			
			$userfile2 = $_POST['userfile2_now'];

		}
		else
		{

			$tmpName2 = $_FILES['userfile2']['tmp_name'];

			if(is_uploaded_file($tmpName2)){
					$pds_file2 = $_FILES['userfile2']['name'];
					$board_pds_pos = "../../upload";
					$attc_name2 = Misc::uploadFileUnsafely($tmpName2 , $pds_file2 , $board_pds_pos);
					}
			
			$userfile2 = $attc_name2[savedName];
		}

		if(empty($_FILES['userfile3']['tmp_name'])){
			
			$userfile3 = $_POST['userfile3_now'];

		}
		else
		{

			$tmpName3 = $_FILES['userfile3']['tmp_name'];

			if(is_uploaded_file($tmpName3)){
					$pds_file3 = $_FILES['userfile3']['name'];
					$board_pds_pos = "../../upload";
					$attc_name3 = Misc::uploadFileUnsafely($tmpName3 , $pds_file3 , $board_pds_pos);
					}
			
			$userfile3 = $attc_name3[savedName];
		}

		$qry1 = "update chan_shop_product set barcode = '$barcode', 
																print_option = '$print_option', 
																model_no = '$model_no', 
																item_type = '$item_type', 
																brand = '$brand', 
																item_style = '$item_style',
																item_title = '$item_title', 
																item_description = '$editor1',
																item_notice = '$kor_content',
																userfile1 = '$userfile1',
																userfile2 = '$userfile2',
																userfile3 = '$userfile3',
																size = '$size', 
																color = '$color',
																file_name = '$file_name',
																ship_esti = '$ship_esti',
																stock_cnt = '$stock_cnt',
																item_icon = '$item_icon',
																item_package = '$item_package',
																item_weight = '$item_weight',
																item_price1 = '$item_price1', 
																item_price2 = '$item_price2',  
																item_costco = '$item_costco',
																item_url = '$item_url' where item_code = '$itemCode'";

		//print_r($qry1);
	

		$rst1 = mysql_query($qry1);





		$category33 = explode("/",$Category3);

		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('product.php?start=$start&Mode=&c_code1=$category33[0]&c_code2=$category33[1]&c_code3=$category33[2]&how=&search_code=&S_content=&brand=&S_content=&brand_search=')");
			//Misc::jvAlert("Completed!","location.replace('product.php?area=2-2&start=$start&Mode=SEARCH&S_content=$S_content')");
			exit;
			
			/*
			if($go_mode == "SEARCH")
			{

			}
			else
			{
				//Misc::jvAlert("Completed!","location.replace('product.php?area=2-2&c_code1=$category33[0]&c_code2=$category33[1]&c_code3=$category33[2]')");
				Misc::jvAlert("Completed!","location.replace('product_modify.php?area=2-2&itemCode=$itemCode')");
				exit;
			}
			*/

		}
		else
		{
			print_r($qry1);
			echo "Fail";
			exit;
		}
	}

	$itemCode = $_GET['itemCode'];


	// 상품정보 가져오기
	$itemInformation = get_iteminfo($itemCode);

	$itemInformation[item_name] = htmlspecialchars($itemInformation[item_name]);
	$itemInformation[item_title] = htmlspecialchars($itemInformation[item_title]);
	$itemInformation[barcode] = htmlspecialchars($itemInformation[barcode]);



	// 해당 카테고리 가져오기
	$c_qry1 = "select * from chan_shop_c_product where item_code = '$itemInformation[item_code]' order by seq_no asc";
	//print_r($c_qry1);

	$c_rst1 = mysql_query($c_qry1);


	$sub_count = 0;
	while($c_row1 = mysql_fetch_assoc($c_rst1))
	{
		// 이름 구하기
		$c_name1 = Category_name_nolink1($c_row1[p_code1],$c_row1[p_code2],$p_row1[p_code3]);
		$c_name2 = Category_name_nolink2($c_row1[p_code1],$c_row1[p_code2],$p_row1[p_code3]);
		$c_name3 = Category_name_nolink3($c_row1[p_code1],$c_row1[p_code2],$c_row1[p_code3]);

		$sub_category_view .= "<option value=\"$c_row1[p_code1]@$c_row1[p_code2]@$c_row1[p_code3]\">$c_name1/$c_name2/$c_name3";
		$sub_category_value .= "$c_row1[p_code1]/$c_row1[p_code2]/$c_row1[p_code3]@";
		$sub_count++;
	}


?>
<script>
	function file_delete(str){

		submenu2=eval("document.category."+str);
		submenu2.value ='';
	
	}
	function file_preview(str){

		submenu2=eval("document.category."+str);
		img_file = submenu2.value;
		
		window.open("preview_image.php?filename=" + img_file,"preview","width=700,height=500,scrollbars=1");

		//alert(img_file);
	}

	function addInputBox(){
	 var addStr = "<input type=text name=opt1_content_color[] size=14 value=\"Color\" onClick=\"this.value=''\">&nbsp;<input type=text name=opt1_content_size[] size=30 value=\"Size \" onClick=\"this.value=''\">&nbsp;<input type=text name=opt1_file_name[] size=30 value=\"File name\" onClick=\"this.value=''\">&nbsp;<input type=text name=opt1_inventory_arr[] size=30 value=\"1\">&nbsp;";
	 var table = document.getElementById("dynamic_table");
	 var newRow = table.insertRow();
	 var newCell = newRow.insertCell();
	 newCell.innerHTML = addStr;
	}

	function subtractInputBox(){
	 var table = document.getElementById("dynamic_table");
	 table.deleteRow(0);
	}
	function subtractInputBox_del(){
	
	var table = document.getElementById("dynamic_table");
	 
	cnt = table.rows.length-1;


			table.deleteRow(cnt);

	}

	function subtractInputBox2(){
	
	var table = document.getElementById("dynamic_table2");
	 
	cnt = table.rows.length-1;


	for(i=cnt; i>=0; i--)
		{
			table.deleteRow(i);
		}

	/*
	for(i=0; i<cnt; i++)
		{
			table.deleteRow(i);
		}
	*/
			//table.deleteRow(i);


	 //var t1 =document.getElementsByName("userfile1"); 
	 //alert(t1[0].value);
	 //table.disabled = true;
	 //document.category.userfile1.;
	 //alert(table);

	 //table.deleteRow();
	}

	function addInputBox_price(){
	 var addStr = "<input type=text name=opt2_content_qty[] size=14 value=\"11-20\" onClick=\"this.value=''\">&nbsp;<input type=text name=opt2_content_price[] size=30 value=\"0\"  onClick=\"this.value=''\">";
	 var table = document.getElementById("dynamic_table_price");
	 var newRow = table.insertRow();
	 var newCell = newRow.insertCell();
	 newCell.innerHTML = addStr;
	}
	function subtractInputBox(){
	 var table = document.getElementById("dynamic_table_price");
	 table.deleteRow(0);
	}
	function subtractInputBox_del_price(){
	
	var table = document.getElementById("dynamic_table_price");
	 
	cnt = table.rows.length-1;


			table.deleteRow(cnt);

	}


	function subtractInputBox3(str){

	//alert(str);

	//var table = document.getElementById("dynamic_table2");
	//table.deleteRow(str);
	
	str--;
	
	if(document.forms["tx_editor_form"]["userfile1[]"].length)
		{
			document.forms["tx_editor_form"]["userfile1[]"][""+str+""].value = 'deleted';
		}
	else
		{
			document.forms["tx_editor_form"]["userfile1[]"].value = 'deleted';
		}
	

	}

	function remove_category(choose_value){

		//alert(choose_value);

		if(confirm("Do you want to delete this category?\r\nAfter click OK button, You must click SUBMIT button!") == true)
		{
			myString = document.tx_editor_form.sub_category_value.value;

			myString2 = myString.replace(choose_value,"deleted");

		}

		document.tx_editor_form.sub_category_value.value = myString2;

		//alert(category);
		
		//str = document.category.sub_category_value.value;

		//result = str.replace(category, "111");

		//alert(result);


	}

	function saveContent() {

		tf = document.tx_editor_form;

		tf.submit();
	}

</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="jquery.uploadify.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>

<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<table width=100% align=center border=0 cellspacing=0>
	<tr>
		<td height=28>&nbsp;&nbsp;>> Product Modify</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<form name="tx_editor_form" id="tx_editor_form" action=<?= $_SERVER['PHP_SELF'] ?> method=post Enctype="multipart/form-data">
<input type=hidden name=mode value="modify">
<input type=hidden name=userfile1_now value="<?= $itemInformation[userfile1] ?>">
<input type=hidden name=userfile2_now value="<?= $itemInformation[userfile2] ?>">
<input type=hidden name=userfile3_now value="<?= $itemInformation[userfile3] ?>">
<input type=hidden name=itemCode value="<?= $_GET['itemCode'] ?>">
<input type=hidden name=start value="<?= $_GET['start'] ?>">
<input type=hidden name=go_mode value="<?= $_GET['Mode'] ?>">
<input type=hidden name=S_content value="<?= $S_content ?>">
<input type=hidden name=idx value="<?= $sub_count ?>">
<input type=hidden name=mod_step value="1">
<input type=hidden name=Category3 value="<?= $Category3 ?>">
<table width=100% align=center border=0 cellspacing=1 bgcolor='#eee8aa'>
<tr bgcolor='#eee8aa'>
	<td colspan=2 height=35>&nbsp;<b>Product modify</b></td>
</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Code</td>
		<td>&nbsp;<input type=text name=item_code size=26 value="<?= $itemInformation[item_code] ?>" style="font-weight:bold"  readonly>
	</tr>

	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;<font color=red>*</font>&nbsp;Item name</td>
		<td>&nbsp;<input type=text name=item_title size=70 value="<?= $itemInformation[item_title]; ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left width=150>&nbsp;&nbsp;Sub Title</td>
		<td>&nbsp;<input type=text name=barcode size=50  value="<?= $itemInformation[barcode] ?>">
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left width=150>&nbsp;&nbsp;Item Url (SEO)</td>
		<td>&nbsp;<input type=text name=item_url size=50 value="<?= $itemInformation[item_url] ?>">
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left >&nbsp;&nbsp;<font color=red>*</font>&nbsp;Model No</td>
		<td>&nbsp;<input type=text name=model_no size=16 value="<?= $itemInformation[model_no] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=40 align=left width=150>&nbsp;&nbsp;&nbsp;Category search</td>
		<td><iframe frameborder="0" src=category_choose.php name="base_category" width="100%" ></iframe>
		</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=200 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Category</td>
		<td valign=top>&nbsp;
		<select name=sub_category size=10 style="width:350px" multiple onClick="javascript:remove_category(this.value);">
		<?= $sub_category_view ?>
		<option value="2">
		<option value="3">
		<option value="4">
		<option value="5">
		<option value="6">
		<option value="7">
		<option value="8">
		<option value="9">
		</select><br>
		<input type=text name=sub_category_value size=50 value="<?= $sub_category_value ?>">
		</td>
	</tr>

	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left >&nbsp;&nbsp;Description</td>
		<td>&nbsp;<textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows=5><?= stripslashes($itemInformation[item_description]) ?></textarea></td>
	</tr>

	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Weight</td>
		<td>&nbsp;<input type=text name=item_weight size=4 value="<?= $itemInformation[item_weight] ?>"> lbs</td>
	</tr>
	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Product Stock</b></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Stock Count</td>
		<td>&nbsp;<input type=text name=stock_cnt size=12 value="<?= $itemInformation[stock_cnt] ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Color</td>
		<td>&nbsp;<input type=text name=color size=12 value="<?= $itemInformation[color] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Size</td>
		<td>&nbsp;<input type=text name=size size=12 value="<?= $itemInformation[size] ?>"></td>
	</tr>
	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Product Price</b></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Net Price</td>
		<td>&nbsp;<input type=text name=item_costco size=12 value="<?= $itemInformation[item_costco] ?>">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Our Price</td>
		<td>&nbsp;<input type=text name=item_price1 size=12 value="<?= $itemInformation[item_price1] ?>"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Sale Price</td>
		<td>&nbsp;<input type=text name=item_price2 size=12 value="<?= $itemInformation[item_price2] ?>"></td>
	</tr>
	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Product Image</b></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Image1</td>
		<td>&nbsp;<img src="../../upload/<?= $itemInformation[userfile1] ?>" width=50> <input type=file name=userfile1 size=30 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Image2</td>
		<td>&nbsp;<img src="../../upload/<?= $itemInformation[userfile2] ?>" width=50> <input type=file name=userfile2 size=30 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Image3</td>
		<td>&nbsp;<img src="../../upload/<?= $itemInformation[userfile3] ?>" width=50> <input type=file name=userfile3 size=30 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;TAG</td>
		<td>&nbsp;<input type=text name=item_icon size=80 value="<?= $itemInformation[item_icon] ?>"> (Ex. Jewelry,Wholesale,Gold,Yellow)</td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Display</td>
		<td>&nbsp;<input type=radio name=print_option value="YES" <? if($itemInformation[print_option] == "YES") { echo "checked"; } ?>>YES <input type=radio name=print_option value="NO" <? if($itemInformation[print_option] == "NO") { echo "checked"; } ?>>No</td>
	</tr>

<tr bgcolor='#FFFFFF'>
	<td colspan=2 align=center height=35><input type=button value="  SUBMIT  " onclick='saveContent()' class="line"></td>
</tr>
</table>
</form>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>