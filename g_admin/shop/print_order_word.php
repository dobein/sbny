<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	$orderNum = $_GET['orderNum'];


	$filename = "Invoice-Order Number-$orderNum";


	header( "Content-type: application/vnd.ms-word" ); 
	header( "Content-Disposition: attachment; filename=$filename.doc" ); 
	header( "Content-Description: PHP4 Generated Data" );

	$tableName = "chan_shop_orderinfo";


	$qry1 = "select * from $tableName where orderNum='$orderNum'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);


?>
<html>
<TITLE>INVOICE</TITLE>
<meta http-equiv="X-UA-Compatible" content="IE=9">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
input.line,TEXTAREA.line
{font-size:9pt; font-family:Arial; color:#5A5A5A; border:1px solid #CCCCCC;}
TD,SELECT,input,option,form,TEXTAREA,center,pre,blockquote {font-size:9pt;}
A:link    {color:2200ff;text-decoration:none;}
A:visited {color:2200ff;text-decoration:none;}
A:active  {color:2200ff;text-decoration:none;}
A:hover  {color:2200ff;text-decoration:underline;}

.dot_table {border-right: dotted #CCCCCC 1px; border-left: dotted #CCCCCC 1px; border-top: dotted #CCCCCC 1px; border-bottom: dotted #CCCCCC 1px;}

</style>
<style type="text/css">
    .link {position:absolute;left:0;width:100%;height:0;background:efefef;overflow:hidden;visibility:hidden;}
    .title   {position:relative;width:100%;background:FFFFFF;font-family:tahoma;font-size:11px;left:0;height:25;overflow:hidden;}
    .title_o {position:relative;width:200px;background:FFFFFF;font-family:tahoma;font-size:11px;left:0;height:25;overflow:hidden;border-right: dotted #CCCCCC 1px; border-left: dotted #CCCCCC 1px; border-top: dotted #CCCCCC 1px; border-bottom: dotted #CCCCCC 1px;}
    .text {position:relative;text-align:justify;margin:5px;font-family:tahoma;font-size:11px;color:#000000;overflow:hidden;height:98%}
</style>
<style type="text/css">
.menutitle{
	float:center;
    cursor:pointer;
    margin-bottom: 5px;
    background-color:#d8bfd8;
    color:#FFFFFF;
    width:200px;
    padding:2px;
    text-align:center;
    font-weight:bold;
    border:1px solid #FFFFFF;
}

.submenu{
    margin-bottom: 0.5em;
	width:200px;
}

body {margin:0px;background:#FFFFFF url(./img/background.gif) repeat-y fixed left top}
TD,SELECT,input,DIV,option,form,TEXTAREA,center,pre,blockquote {font-size:9pt; font-family:tahoma; color:#000000;line-height:16px;}

img {border:0;}

A:link    {color:#000000;text-decoration:underline;}
A:visited {color:#000000;text-decoration:underline;}
A:active  {color:#000000;text-decoration:underline;}
A:hover  {color:#00868B;text-decoration:none;}

.menu A:link    {color:#e0e0e0;text-decoration:none;}
.menu A:visited {color:#e0e0e0;text-decoration:none;}
.menu A:active  {color:#e0e0e0;text-decoration:none;}
.menu A:hover  {color:#ffffff;text-decoration:none;background-color:#FF52A0;}

.menu2 A:link    {color:#e0e0e0;text-decoration:none;}
.menu2 A:visited {color:#e0e0e0;text-decoration:none;}
.menu2 A:active  {color:#e0e0e0;text-decoration:none;}
.menu2 A:hover  {color:#ffffff;text-decoration:none;}

.bottom A:link    {color:#333333;text-decoration:none;}
.bottom A:visited {color:#333333;text-decoration:none;}
.bottom A:active  {color:#333333;text-decoration:none;}
.bottom A:hover  {color:#000000;text-decoration:none;background-color:#e0e0e0;}

.black A:link    {color:#000000;text-decoration:none;}
.black A:visited {color:#000000;text-decoration:none;}
.black A:active  {color:#000000;text-decoration:none;}
.black A:hover  {color:#00868B;text-decoration:underline;}

.underline A:hover  {text-decoration:underline;}

.white {color:#ffffff;}
.black {color:#000000;}
.pink {color:#FF52A0;}
.gray {color:#999999;}
.lgray {color:#c0c0c0;}
.title {font:12pt arial;font-weight:bold;}
.blue {color:#00868B;}

.product {border:solid 1px #e9e9e9;}

.t7 {font-family:tahoma;font-size:7pt;}
.t8 {font-family:tahoma;font-size:8pt;}
.d8 {font-family:tahoma;font-size:8pt;}
.t10 {font-size:10px;}
.t11 {font-family:tahoma;font-size:9pt;}
.letter1px {letter-spacing:1px;}

.input {border:solid 1px #e0e0e0;background-color:#ffffff;}

.submit {border:solid 0px #ffffff;background-color:#ffffff;color:#999999;font:10px tahoma;letter-spacing:1px;}

.hidden {visibility:hidden;}
</style>
<SCRIPT LANGUAGE='JavaScript'> 
<!-- 
function ThisWindowsPrint() { 
    with ( factory.printing ){ 
        header = ''; 
        footer = ''; 
        portrait = true; // true 세로출력 , false 가로출력 
        leftMargin = 30; 
        rightMargin = 30; 
        topMargin = 30; 
        bottomMargin = 0; 
        Print(false, window) // 첫번째 인자 : 대화상자표시여부 , 두번째인자 : 출력될 프레임 
    } 
} 
//--> 
</SCRIPT> 
<body onload="javascript:ThisWindowsPrint();">
<Object id='factory' viewastext style='display:none' classid='clsid:1663ed61-23eb-11d2-b92f-008048fdd814' codebase='../smsx.cab#Version=6,2,433,14'> 
</Object> 
<table width=98% align=center border=0 cellspacing=0 cellpadding=0>
<tr bgcolor='#FFFFFF'>
	<td width=30%>
	<img src="../../images/ger_logo.jpg">
	</td>
	<td width=70% align=left>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:Arial Black; font-size:24pt; line-height:50px;">INVOICE</span>
	</td>
</tr>
</table>

<table width=98% align=center border="1" bordercolor="#000000" style="border-collapse: collapse;">
<tr>
	<td>
		<table width=98% align=center border="0" bordercolor="#cccccc" style="border-collapse: collapse;">
			<tr>
				<td width=50% height=28>&nbsp;&nbsp;<b>Sold to </b></td>
				<td width=50%>&nbsp;&nbsp;<b>Ship to</b></td>
			</tr>
			<tr>
				<td height=120>&nbsp;<?= $row1[bill_last_name] ?> <?= $row1[bill_first_name] ?><br>&nbsp;<?= $row1[bill_address1] ?> <?= $row1[bill_address2] ?><br>&nbsp;<?= $row1[bill_city] ?><br>&nbsp;<?= $row1[bill_state] ?><br>&nbsp;<?= $row1[bill_zipcode] ?><br>&nbsp;<?= $row1[bill_country] ?></td>
				<td>&nbsp;<?= $row1[ship_last_name] ?> <?= $row1[ship_first_name] ?><br>&nbsp;<?= $row1[ship_address1] ?> <?= $row1[ship_address2] ?><br>&nbsp;<?= $row1[ship_city] ?><br>&nbsp;<?= $row1[ship_state] ?><br>&nbsp;<?= $row1[ship_zipcode] ?><br>&nbsp;<?= $row1[ship_country] ?></td>
			</tr>
			<tr>
				<td height=35 colspan=2>&nbsp;Phone : <?= $row1[bill_cellphone] ?></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table width=98% align=center border="0" bordercolor="#cccccc" style="border-collapse: collapse;">
			<tr>
				<td height=32>&nbsp;&nbsp;Invoice # : <?= $row1[orderNum] ?></td>
			</tr>
			<tr>
				<td height=32>&nbsp;&nbsp;Invoice Date : <?= $row1[order_date] ?></td>
			</tr>
			<tr>
				<td height=32>&nbsp;&nbsp;Memo : <?= $row1[feedback] ?></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
	<br>
<table width=98% align=center border="1" bordercolor="#dcdcdc" style="border-collapse: collapse;">
<tr bgcolor='#FFFFFF'>
	<td height=35 colspan=5>&nbsp;<b>Product</b></td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td width=20% height=28 align=center>Code</td>
	<td width=40% align=center>Description</td>
	<td width=15% align=center>Unit Price</td>
	<td width=10% align=center>Q'ty</td>
	<td width=15% align=center>Sub Total</td>
</tr>
<?
$qry2 = "select * from chan_shop_orderproduct where orderNum='$orderNum' order by seq_no asc";
$rst2 = mysql_query($qry2,$dbConn);

$sub_sum = "0";

$t_num1 = "0";

while($row2 = mysql_fetch_array($rst2)){
		
	//$us_price = number_format($row2[p_price],2);
	$img_url = _WEB_BASE_DIR;
	$item_info = get_iteminfo($row2[item_code]);



	$real_total_price = $row2[item_sale]*$row2[item_qty];

	$item_last_msg = number_format($row2[item_sale],2);
	$real_total_price_msg = number_format($real_total_price,2);

	echo "
		<tr bgcolor='#FFFFFF'>
			<td width=20% height=28 align=center style='border-bottom-color:white;'>$row2[item_code]</td>
			<td width=30% align=center style='border-bottom-color:white;'>$row2[item_title]</td>
			<td width=20% align=right style='border-bottom-color:white;'>$$item_last_msg&nbsp;</td>
			<td width=10% align=center style='border-bottom-color:white;'>$row2[item_qty]</td>
			<td width=20% align=right style='border-bottom-color:white;'>$$real_total_price_msg&nbsp;</td>
		</tr>";
	
	$sub_sum = $sub_sum + $real_total_price;
	$t_num1++;

}

$sub_total = round_to_penny($sub_sum);

if($t_num1<=5)
{
	for($k=0; $k<(5-$t_num1); $k++)
	{
		echo "
			<tr bgcolor='#FFFFFF' >
				<td width=20% height=28 align=center style='border-bottom-color:white;'>&nbsp;</td>
				<td width=30% align=center style='border-bottom-color:white;'>&nbsp;</td>
				<td width=20% align=right style='border-bottom-color:white;'>&nbsp;</td>
				<td width=10% align=center style='border-bottom-color:white;'>&nbsp;</td>
				<td width=20% align=right style='border-bottom-color:white;'>&nbsp;</td>
			</tr>";
	}
}
?>
</table>
<table width=98% align=center border="1" bordercolor="#dcdcdc" style="border-collapse: collapse;">
<tr bgcolor='#FFFFFF'>
	<td width=80% height=28 colspan=4 align=right style='border-bottom-color:white;'>Sub Total : &nbsp;</td>
	<td width=20% align=right style='border-bottom-color:white;'>$<?= number_format($sub_total,2); ?>&nbsp;</td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td width=80% height=28 colspan=4 align=right style='border-bottom-color:white;'>S & H : &nbsp;</td>
	<td width=20% align=right style='border-bottom-color:white;'>$<?= number_format($row1[shipping],2); ?>&nbsp;</td>
</tr>
<tr bgcolor='#FFFFFF'>
	<td width=80% height=28 colspan=4 align=right style='border-bottom-color:white;'>Total: &nbsp;</td>
	<td width=20% align=right style='border-bottom-color:white;'><B>$<?= number_format($row1[last_price],2); ?></B>&nbsp;</td>
</tr>
</table>
<br>
	</td>
</tr>
</table>
<br>
<table width=98% align=center border=0 cellspacing=0 cellpadding=0>
<tr bgcolor='#FFFFFF'>
	<td height=80 align=center>
Germanium Inc.(www.germanium.net)<br>
P. O. Box 313, Woodbury, NY 11797, USA<br>
Tel: 516-367-7072<br>
Toll Free: 1-800-955-7717 (In the USA)
	</td>
</tr>
</table>

<br><br>




<br>
<?
	include _BASE_DIR . "/g_admin/inc_bottom.php";
?>