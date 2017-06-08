<?
$hostname='localhost';
$username='stylebyn_nananu';
$passwd='puchonA12!';
$db_name='stylebyn_nananu';


$dbConn = mysql_connect($hostname,$username,$passwd);
mysql_select_db($db_name);

		$qry1 = "select * from chan_shop_manager";
		print_r($qry1);
		
		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);
		$row1 = mysql_fetch_assoc($rst1);

		echo "<br>";
		echo $row1[member_id];
		echo "<br>";
		echo $num1;
		echo "<br>";
		echo $dbConn;

		phpinfo();

		exit;
?>