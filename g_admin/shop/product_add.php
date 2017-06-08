<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";




	include _BASE_DIR . "/g_admin/inc_top.php";


	/**
	* 편집기 소스
	*/
	//include _BASE_DIR . "/FCKeditor/fckeditor.php";


	$tableName = "chan_shop_product";


	if($_POST['mode'] == "save")
	{
		$item_code = $_POST['item_code'];

		$item_url = $_POST['item_url'];

		$pre_qry1 = "select * from chan_shop_product where item_url = '$item_url'";
		$pre_rst1 = mysql_query($pre_qry1);
		$pre_num1 = mysql_num_rows($pre_rst1);
		
		if($pre_num1>0)
		{
			Misc::jvAlert("URL 이 중복됩니다.","history.go(-1)");
			exit;
		}



		/**
		* @ 멀티 카테고리 등록
		*/
		$print_option = $_POST['print_option'];
		$sub_category = explode("@",$_POST['sub_category_value']);

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

		for($i=0; $i<count($sub_category); $i++)
		{
			//echo $sub_category[$i]."<br>";
			$sub_c = explode("/",$sub_category[$i]);

			$category_qry1 = "insert into chan_shop_c_product (p_code1,p_code2,p_code3,item_code,print_option,pos) values ('$sub_c[0]','$sub_c[1]','$sub_c[2]','$item_code','$print_option','$min_pos')";
			$category_rst1 = mysql_query($category_qry1);
		}



		$item_url = $_POST['item_url'];
		$pos = $_POST['pos'];
		$sub_category_value = $_POST['sub_category_value'];

		$print_option = $_POST['print_option'];

		$icon = $_POST['icon'];
		$item_title = addslashes($_POST['item_title']);
		$barcode = addslashes($_POST['barcode']);
		$item_type = $_POST['item_type'];
		$model_no = $_POST['model_no'];

		$editor1 = addslashes($_POST['editor1']);

		$item_stock = $_POST['item_stock'];
		$stock_cnt = $_POST['stock_cnt'];
		$ship_flag = $_POST['ship_flag'];
		$item_manufacture = $_POST['item_manufacture'];
		$item_origin = $_POST['item_origin'];
		$item_package = $_POST['item_package'];
		$item_weight = $_POST['item_weight'];
		$item_price1 = $_POST['item_price1'];
		$item_price2 = $_POST['item_price2'];
		$item_costco = $_POST['item_costco'];
		$item_icon = $_POST['item_icon'];

		$color = addslashes($_POST['color']);
		$size = addslashes($_POST['size']);


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


		//$re_qry1 = "insert into chan_shop_mainitem values ('','$code_value[0]','$code_value[1]','$code_value[2]','New','$item_code','$pos','YES')";
		//$re_rst1 = mysql_query($re_qry1,$dbConn);


		if($rst1)
		{
			Misc::jvAlert("Completed!","location.replace('product_add.php?area=$area')");
			exit;
		}
		else
		{
			echo "Fail";
			print_r($qry1);
			exit;
		}
	}


	function printCategory(){
		global $dbConn,$c_code1,$userid,$tableName;

		$qry1 = "select * from chan_shop_category where c_code2='0' && c_code3='0' order by pos asc";
		//print_r($qry1);

		$rst1 = mysql_query($qry1,$dbConn);

		$num = 0;
		while($row1 = mysql_fetch_array($rst1)){
			if($c_code1 == "$row1[c_code1]")
			{
			$printCategory .="<option value=$row1[c_code1] selected>$row1[name]";
			}
			else
			{
			$printCategory .="<option value=$row1[c_code1]>$row1[name]";
			}
			
			if($num == "0")
			{
				// start number 2
				//print_r($row1[c_code1]);
				if(!$c_code1)
				{
				$second_value = $row1[c_code1];
				}
				else
				{
				$second_value = $c_code1;
				}
			}

			$num++;
		}

		$printCat[second_value] = $second_value;
		$printCat[Category] = $printCategory;
		return $printCat;
	}

	function printCategory2($f_value){
		global $dbConn,$c_code2,$userid,$tableName;

		$qry1 = "select * from chan_shop_category where c_code1='$f_value' && c_code2<>'0' && c_code3='0' order by pos asc";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);

		$num1 = 0;
		while($row1 = mysql_fetch_array($rst1)){

			if($row1[name] != "BR")
			{
				if($row1[c_code2] == "$c_code2")
				{
				$printCategory .="<option value=$row1[c_code2] selected>$row1[name]";
				}
				else
				{
				$printCategory .="<option value=$row1[c_code2]>$row1[name]";
				}
			}

		
			if($num1 == "0")
			{
				if(!$c_code2)
				{
				$third_value = $row1[c_code2];
				}
				else
				{
				$third_value = $c_code2;
				}
			}
			
			$num1++;
		}

		$printCat[third_value] = $third_value;
		$printCat[Category] = $printCategory;
		return $printCat;
	}

	function printCategory3($f_value1,$f_value2){
		
		global $dbConn,$c_code3,$userid,$tableName;

		$qry1 = "select * from chan_shop_category where c_code1='$f_value1' && c_code2='$f_value2' && c_code3<>'0' order by pos asc";
		//print_r($qry1);
		$rst1 = mysql_query($qry1,$dbConn);

		$num2 = "0";
		while($row1 = mysql_fetch_array($rst1)){
			if($row1[c_code3] == "$c_code3")
			{
			$printCategory .="<option value=$row1[c_code3] selected>$row1[name]";
			}
			else
			{
			$printCategory .="<option value=$row1[c_code3]>$row1[name]";
			}

			if($num2 == "0")
			{
				if(!$c_code3)
				{
				$forth_value = $row1[c_code3];
				}
				else
				{
				$forth_value = $c_code3;
				}
			}


			$num2++;
		}

		$printCat[forth_value] = $forth_value;
		$printCat[Category] = $printCategory;
		return $printCat;
	}


	$printValue = printCategory();	
	$printValue2 = printCategory2($printValue[second_value]);
	$printValue3 = printCategory3($printValue[second_value],$printValue2[third_value]);

	//echo "first code value $printValue[second_value] $printValue2[third_value] $printValue3[forth_value]";


	if(!$c_code1)
	{
		$c_code1 = $printValue[second_value];
	}

	if(!$c_code2)
	{
		$c_code2 = $printValue2[third_value];
	
		if(!$c_code2)
		{
			$c_code2 = "0";
		}
	}

	if(!$c_code3)
	{
		$c_code3= $printValue3[forth_value];

		if(!$c_code3)
		{
			$c_code3 = "0";
		}
	}

	$keychars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$length = 3;

	// RANDOM KEY GENERATOR
	$randkey = "";
	$max=strlen($keychars)-1;
	for ($i=0;$i<=$length;$i++) {
	  $randkey .= substr($keychars, rand(0, $max), 1);
	}

	$keychars2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$length2 = 0;

	// RANDOM KEY GENERATOR
	$randkey2 = "";
	$max2=strlen($keychars2)-1;
	for ($j=0;$j<=$length2;$j++) {
	  $randkey2 .= substr($keychars2, rand(0, $max2), 1);
	}

	// item code 만들기
	$item_code = $randkey.date("d").date("m").date("y")."K".$randkey2.date("h").date("i");


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

	//<input type=text name=opt1_content_size[] size=30 value=\"Enter Size\" >&nbsp;
	function addInputBox(){
	 var addStr = "<input type=text name=opt1_content_color[] size=14 value=\"Enter Color\" >&nbsp;<input type=text name=opt1_file_name[] size=20 value=\"image file name\" onClick=\"this.value=''\">";
	 var table = document.getElementById("dynamic_table");
	 var newRow = table.insertRow();
	 var newCell = newRow.insertCell();
	 newCell.innerHTML = addStr;
	}

	function subtractInputBox(){
	 var table = document.getElementById("dynamic_table");
	 table.deleteRow(0);
	}

		//self.close();



</script>
<script>
	var url = "barcode_check.php?barcode=";

	function handleHttpResponse(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('code');

				for(i=0; i<total_counts.length; i++)
				{
					var name = xmlDocument.getElementsByTagName('code').item(i).firstChild.data;
				}

				if(total_counts.length == '0')
				{
					id_msg.innerHTML = '<font style=\"color:blue\">Barcode is available.</font>';
				}
				else
				{
					id_msg.innerHTML = '<font style=\"color:red\">This Barcode is unavailable.</font>';
				}

				isWorking = false;
			}
		}

	} 

	var isWorking = false;

	function show_data(tf){

			// 빈문자열이면 체크
			if(!tf)
			{
				id_msg.innerHTML = '<font style=\"color:red\">Enter your ID.</font>';
				return false;
			}

			// 문자열 사이즈 길이 체크

			if(tf.length < 4)
			{
				id_msg.innerHTML = '<font style=\"color:red\">Four characters or more.</font>';
				return false;
			}


			// 다른 문자들 들어있는지 체크


			// ajax start
			if(!isWorking && http){

				http.open("GET",url + escape(tf),true);

				http.onreadystatechange = handleHttpResponse;
				isWorking = true;

				http.send(null);

			}
	}

	function getHTTPObject(){
		
		var xmlhttp;

	  /*@cc_on

	  @if (@_jscript_version >= 5)

		try {

		  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

		} catch (e) {

		  try {

			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

		  } catch (E) {

			xmlhttp = false;

		  }

		}

	  @else

	  xmlhttp = false;

	  @end @*/


		if(!xmlhttp && typeof XMLHttpRequest != 'underfined'){
			
			try{
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
	
	return xmlhttp;
	}

	var http = getHTTPObject();



	function saveContent() {

		tf = document.tx_editor_form;

		tf.submit();
	}

	function addInputBox(){
	 var addStr = "<input type=text name=opt1_content_color[] size=14 value=\"Enter Color\" onClick=\"this.value=''\">&nbsp;<input type=text name=opt1_content_size[] size=30 value=\"XS,S,M,L,XL\"  onClick=\"this.value=''\">&nbsp;<input type=text name=opt1_file_name[] size=30 value=\"Image file name\" onClick=\"this.value=''\">&nbsp;<input type=text name=opt1_inventory_arr[] size=30 value=\"1,1,1,1,1\">&nbsp;";
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

	function remove_category(choose_value){

		//alert(choose_value);

		alert(choose_value);

		

		if(confirm("Do you want to delete this category?\r\nAfter click OK button, You must click SUBMIT button!") == true)
		{
			myString = document.tx_editor_form.sub_category_value.value;

			alert(myString);
			myString2 = myString.replace(choose_value,"deleted");

		}

		document.tx_editor_form.sub_category_value.value = myString2;

		//alert(category);
		
		//str = document.category.sub_category_value.value;

		//result = str.replace(category, "111");

		//alert(result);


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
		<td height=28>&nbsp;&nbsp;>> Product Add</td>
	</tr>
	<tr><td height=1 bgcolor='#008080'></td></tr>
</table>
<br>
<form name="tx_editor_form" id="tx_editor_form" action=<?= $_SERVER['PHP_SELF'] ?> method=post Enctype="multipart/form-data">
<input type=hidden name=mode value="save" >
<input type=hidden name=idx value="0">
<input type=hidden name=area value="<?= $area ?>">
<input type=hidden name=item_code size=26 value="<?= $item_code ?>" style="font-weight:bold" >
<table width=100% align=center border=0 cellspacing=1 bgcolor='#a9a9a9'>
	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Base Information</b></td>
	</tr>


	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Item Name</td>
		<td>&nbsp;<input type=text name=item_title size=70 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left width=150>&nbsp;&nbsp;Item Url (SEO)</td>
		<td>&nbsp;<input type=text name=item_url size=50 >
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left width=150>&nbsp;&nbsp;Sub Title</td>
		<td>&nbsp;<input type=text name=barcode size=50 >
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;<font color=red>*</font>&nbsp;Model No</td>
		<td>&nbsp;<input type=text name=model_no size=16></td>
	</tr>

	<tr bgcolor='#FFFFFF'>
		<td  height=40 align=left width=150>&nbsp;&nbsp;Category Search</td>
		<td><iframe frameborder="0" src=category_choose.php name="base_category" width="100%" ></iframe>
		</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=180 align=left width=150>&nbsp;&nbsp;<font color=red>*</font>&nbsp;Categeory</td>
		<td valign=top>&nbsp;
		<select name=sub_category size=10 style="width:350px" multiple>
		<option value="0">Choose your category
		<option value="2">
		<option value="3">
		<option value="4">
		<option value="5">
		<option value="6">
		<option value="7">
		<option value="8">
		<option value="9">
		<option value="10">
		<option value="11">
		<option value="12">
		<option value="13">
		<option value="14">
		<option value="15">
		</select><br>
		&nbsp;&nbsp;* Total 10 category<br>
		<input type=hidden name=sub_category_value size=80>
		</td>
	</tr>


	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left >&nbsp;&nbsp;Weight</td>
		<td>&nbsp;<input type=text name=item_weight size=4> lbs</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=35 align=left >&nbsp;&nbsp;Description</td>
		<td>&nbsp;<textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows=5></textarea></td>
	</tr>
	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Product Stock</b></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Stock Count</td>
		<td>&nbsp;<input type=text name=stock_cnt size=12 value="0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Color</td>
		<td>&nbsp;<input type=text name=color size=12 value=""></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Size</td>
		<td>&nbsp;<input type=text name=size size=12 value=""></td>
	</tr>
	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Product Price</b></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Net Price</td>
		<td>&nbsp;<input type=text name=item_costco size=12 value="0">&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Our Price</td>
		<td>&nbsp;<input type=text name=item_price1 size=12 value="0"></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Sale Price</td>
		<td>&nbsp;<input type=text name=item_price2 size=12 value="0"></td>
	</tr>

	<tr bgcolor='#eee8aa'>
		<td colspan=2 height=35>&nbsp;<b>Product Image</b></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Image1</td>
		<td>&nbsp;<input type=file name=userfile1 size=30 > ( 1000 px * 1000 px )</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Image2</td>
		<td>&nbsp;<input type=file name=userfile2 size=30 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Image3</td>
		<td>&nbsp;<input type=file name=userfile3 size=30 ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;TAG</td>
		<td>&nbsp;<input type=text name=item_icon size=80 value="<?= $itemInformation[item_icon] ?>"> (Ex. Jewelry,Wholesale,Gold,Yellow)</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td  height=25 align=left >&nbsp;&nbsp;Display</td>
		<td>&nbsp;<input type=radio name=print_option value="YES" checked>Yes  <input type=radio name=print_option value="NO">No</td>
	</tr>
<tr bgcolor='#FFFFFF'>
	<td colspan=2 align=center height=50><input type=button value="  SUBMIT  " onclick='saveContent()' class="line"></td>
</tr>
</table>
</form>
<br><br><br>

<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>
