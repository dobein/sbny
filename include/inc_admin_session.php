<?
$ip = $_SERVER['REMOTE_ADDR'];

$ip_qry1 = "select * from chan_shop_ip where ip = '$ip'";
$ip_rst1 = mysql_query($ip_qry1);
$ip_num1 = mysql_num_rows($ip_rst1);

if($ip_num1>0)
{
	if(isset($_SESSION['admin_member_id']))
	{
	}
	else
	{
		echo "here";
		exit;
		echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
		exit;
	}
}
else
{
	echo "You don't have permission!";
	exit;
}


	if(!isset($_SESSION['admin_member_id']))
	{
		echo "permission error!";
		exit;
	}

?>
