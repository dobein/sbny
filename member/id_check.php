<?
	include "../include/inc_base.php";

	$user_id = $_GET['user_id'];

	$qry1 = "select * from chan_shop_member where domain = '$domain' && member_id = '$user_id'";
	$rst1 = mysql_query($qry1,$dbConn);

	$return_value = '<?xml version="1.0" encoding="iso-8859-1" standalone="yes"?>';
	$return_value .= '<total>';

	while($row1 = mysql_fetch_assoc($rst1)){
		$return_value .= '<name>'.$row1[member_id].'</name><value>'.$row1[member_password].'</value>';
	}
	$return_value .= '</total>';

	header('Content-Type: text/xml');
	echo $return_value;
?>