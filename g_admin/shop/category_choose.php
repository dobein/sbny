<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_product";


	$c_code1 = $_GET['c_code1'];
	$c_code2 = $_GET['c_code2'];
	$c_code3 = $_GET['c_code3'];


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
?>
<html>
<head><title></title>
<script>
	function chg1(){
	regi = document.search;
	//alert(document.product.code1.value);
	location.replace('<?= $_SERVER['PHP_SELF'] ?>?c_code1=' + regi.code1.value);
	}

	function chg2(){
	regi = document.search;
	//alert(regi.code1.value);
	//alert(regi.code2.value);
	location.replace('<?= $_SERVER['PHP_SELF'] ?>?c_code1=' + regi.code1.value + '&c_code2=' + regi.code2.value);
	}

	function chg3(){
	regi = document.search;
	location.replace('<?= $_SERVER['PHP_SELF'] ?>?c_code1=' + regi.code1.value + '&c_code2=' + regi.code2.value + '&c_code3=' + regi.code3.value);
	}

	var idx = parent.document.tx_editor_form.idx.value;

	function inputCode(){

		//alert(idx);

		regi = document.search;
		
		if(parent.document.tx_editor_form.idx.value == '25')
		{
			return;
		}


		
		// 대분류 카테고리 1
		c_name1 = regi.code1.options[regi.code1.selectedIndex].text;

		// 중분류 카테고리 2
		if(regi.code2.value == '')
		{
			regi.code2.value = '0';
			c_name2 = 'NULL';
		}
		else
		{
			regi.code2.value = regi.code2.value;
			c_name2 = regi.code2.options[regi.code2.selectedIndex].text;
		}

		// 소분류 카테고리 3
		if(regi.code3.value == '')
		{
			regi.code3.value = '0';
			c_name3 = 'NULL';
		}
		else
		{
			regi.code3.value = regi.code3.value;
			c_name3 = regi.code3.options[regi.code3.selectedIndex].text;
		}




		// 넘기는 str 값
		str = regi.code1.value + '/' + regi.code2.value + '/' + regi.code3.value;
		//c_name = regi.code1.options[regi.code1.selectedIndex].text."/".regi.code2.options[regi.code2.selectedIndex].text."/".regi.code3.options[regi.code3.selectedIndex].text;

		// 넘기는 txt 값
		c_name = c_name1+"/"+c_name2+"/"+c_name3;

		v = parent.document.tx_editor_form.sub_category_value.value;
		//sub_category_value / str 하고 비교해서 같은값이 있으면 입력하지 않는다.
		if(v.match(str))
		{
			alert('already input');
			return;
		}
		else
		{

			new_regi = parent.document.tx_editor_form;
			
			if(new_regi.sub_category.options[idx].value != '0')
			{
				new_regi.sub_category.options[idx].text = c_name;
				new_regi.sub_category.options[idx].value = str;
				//new_regi.sub_category.options[idx].selected = true;
				
				if(new_regi.mode.value == "modify" && new_regi.mod_step.value == "1")
				{
					new_regi.sub_category_value.value = new_regi.sub_category_value.value + str;
					new_regi.mod_step.value = '2';
				}
				else
				{
					new_regi.sub_category_value.value = new_regi.sub_category_value.value + '@' + str;
				}

				parent.document.tx_editor_form.idx.value = parseInt(idx) + 1;
			}
			else
			{
				new_regi.sub_category.options[idx].text = c_name;
				new_regi.sub_category.options[idx].value = str;
				//new_regi.sub_category.options[idx].selected = true;

				new_regi.sub_category_value.value = str;

				parent.document.tx_editor_form.idx.value = parseInt(idx) + 1;
			}

		}

	}

</script>
<body  leftmargin=0 topmargin=0 bgcolor=#ffffff>
<table width=100% border=0 cellpadding=0 cellspacing=3>
<form name=search action=<?= $_SERVER['PHP_SELF'] ?> method=post>
<input type=hidden name=mode value="save" >
<tr>
<td>
  	<select name=code1 onChange="chg1()">
		<?
		echo $printValue[Category];
		?>
	</select>&nbsp;
	<select name=code2 onChange="chg2()">
		<?
		echo $printValue2[Category];
		?>
	</select>&nbsp;
	<select name=code3 onChange="chg3()">
		<? 
		//echo "$printValue[second_value] $printValue2[third_value]";
		//printCategory3($printValue[second_value],$printValue2[third_value]); 
		echo $printValue3[Category];
		?>
	</select>&nbsp;&nbsp;<input type=button value=" ADD " onClick="inputCode()" class="line">
</td>
</tr></form>
</table>
</body>
</html>