<?
	include "./include/inc_base.php";

	$cookie_name = "NOW_DOMAIN";
	$login_info = $_GET['domain'];

	SetCookie($cookie_name,$login_info,0,"/");

	echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
	exit;
?>