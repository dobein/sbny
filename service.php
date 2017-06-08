<?
	include "./include/inc_base.php";


	$c_code1 = $domainCategory[c_code1];
	$c_code2 = $_GET['c_code2'];
	$c_code3 = $_GET['c_code3'];


	function printGermaniumcategory(){

		global $dbConn,$domainCategory;


		$qry1 = "select * from chan_shop_category where c_code1 = '$domainCategory[c_code1]' && c_code2 = '2' && c_code3 <> '0' order by pos asc";
		//print_r($qry1);

		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);

		$num = 1;


		while($row1 = mysql_fetch_assoc($rst1))
		{
			if($row1[name] == '<br>')
			{
				$content .= "<tr><td style=\"padding-left:5px;line-height:15px\">---------------------------------</td></tr>";
			}
			else
			{
					if($row1[url_link] == 'title')
					{
						$content .= "<tr><td style=\"padding-left:10px;line-height:35px;\"><img src=images/btn_more.gif align=absmiddle>&nbsp;<span style=\"font-size:12pt;font-weight:bold;\">$row1[name]</span></td></tr>";
						
					}
					else
					{
						$content .= "<tr><td style=\"padding-left:20px;line-height:28px\"><a href=germanium.php?c_code2=$row1[c_code2]&c_code3=$row1[c_code3]><span style=\"font-size:10pt;font-weight:bold;\">$row1[name]</span></a></td></tr>";
					}
			}

			

			$num++;
		}

	
		return $content;

	}

	// 상품설명
	$qry1 = "select * from chan_shop_category where c_code1 = '$c_code1' && c_code2 = '$c_code2' && c_code3 = '$c_code3'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_assoc($rst1);



	include "./include/inc_top.php";
?>
	<table width="94%" align=center border=0 cellpadding=0 cellspacing=0 >
		<tr bgcolor=#f4f4f4>
			<td height=35 align=left ><h3><?= Category_name($c_code1,$c_code2,'0') ?></h3></td>
		</tr>
	</table>
	<br>

	<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=25% valign=top height=450 >
				<table width=95% border=0 cellpadding=0 cellspacing=5 bgcolor=#FFFFFF>
					<?= printGermaniumcategory(); ?>
				</table>
			</td>
			<td width=75% valign=top bgcolor=#FFFFFF style="padding-top:10px">
<!-- 메인 메뉴 -->
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
	<tr>
		<td bgcolor=#f9f9f9 height=35 style="padding-left:10px"><h3><?= Category_name($c_code1,$c_code2,$c_code3) ?></h3></td>
	</tr>
	<tr>
		<td valign=top style="text-align:justify">
			<?= stripslashes($row1[content]); ?>
		</td>
	</tr>
</table>

<?
	include "./include/inc_bottom.php";
?>