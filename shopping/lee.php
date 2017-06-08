<?
	include "../include/inc_base.php";




	include _BASE_DIR ."/include/inc_top.php";
?>
<?
$qry1 = "select * from chan_shop_board";
$rst1 = mysql_query($qry1);
while($row1= mysql_fetch_assoc($rst1)){
	
	echo $row1[title]."<br>";

}

?>

<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>