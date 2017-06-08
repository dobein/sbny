<?
	$categoryTable = "chan_shop_category";

	if($Category3)
	{
		$category_value = explode("/",$Category3);
		$first_qry1 = "select c_code1 from $categoryTable where activate = 'Active' && c_code1 = '$category_value[0]' && c_code2 = '0' && c_code3 = '0' order by pos asc limit 1";
	}
	else
	{
		$first_qry1 = "select c_code1 from $categoryTable where activate = 'Active' && c_code2 = '0' && c_code3 = '0' order by pos asc limit 1";
	}

	$first_rst1 = mysql_query($first_qry1,$dbConn);
	$first_result1 = mysql_result($first_rst1,0,0);
	
	// 두번째 값을 구한다.
	if($category_value)
	{
		$second_qry1 = "select c_code2 from $categoryTable where activate = 'Active' && c_code1 = '$category_value[0]' && c_code2 = '$category_value[1]' && c_code3 = '0' order by pos asc limit 1";
	}
	else
	{
		$second_qry1 = "select c_code2 from $categoryTable where activate = 'Active' && c_code1 = '$first_result1' && c_code2 <> '0' && c_code3 = '0' order by pos asc limit 1";
	}

	print_r($second_qry1);

	$second_rst1 = mysql_query($second_qry1,$dbConn);
	$second_result1 = mysql_result($second_rst1,0,0);


	// 미리 뿌려주기 펑션
	function printCategory($step,$first_result1 = 0, $second_result1 = 0){
		
		global $dbConn,$category_value,$categoryTable,$bro_language;

		if($step == "first")
		{
			$qry1 = "select * from $categoryTable where activate = 'Active' && c_code2 = '0' && c_code3 = '0' order by pos asc";

			$selectValue = $category_value[0];
		}
		else if($step == "second")
		{
			$qry1 = "select * from $categoryTable where activate = 'Active' && c_code1 = '$first_result1' && c_code2 <> '0' && c_code3 = '0' order by pos asc";

			$selectValue = $category_value[1];
		}
		else if($step == "third")
		{
			$qry1 = "select * from $categoryTable where activate = 'Active' && c_code1 = '$first_result1' && c_code2 = '$second_result1' && c_code3 <> '0' order by pos asc";
			
			$selectValue = $category_value[2];
		}

		$rst1 = mysql_query($qry1,$dbConn);
		
		while($row1 = mysql_fetch_assoc($rst1)){
			
			if($step == "first")
			{
				$nowValue = $row1[c_code1];
			}
			else if($step == "second")
			{
				$nowValue = $row1[c_code2];
			}
			else if($step == "third")
			{
				$nowValue = $row1[c_code3];
			}

		
			$name = $row1[name];


			if($selectValue == $nowValue)
			{
				$content .="<option value=\"$row1[c_code1]/$row1[c_code2]/$row1[c_code3]\" selected>$name";
			}
			else
			{
				$content .="<option value=\"$row1[c_code1]/$row1[c_code2]/$row1[c_code3]\">$name";
			}

		}

		return $content;
	}
?>