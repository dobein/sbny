<?
	ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_DEPRECATED);
	ini_set('display_errors','On');
	ini_set('max_input_vars', 30000);
	ini_set("session.cache_expire", 180); // 세션 유효시간 : 분
	ini_set("session.gc_maxlifetime", 86400); // 세션 가비지 컬렉션(로그인시 세션지속 시간) : 초
	session_start();

	#define('_BASE_DIR', 'c:\xampp\htdocs\oglobal');          // 위치한 절대경로
	#define('_WEB_BASE_DIR', 'http://localhost:8012/oglobal');

	define('_BASE_DIR', '/home/stylebynewyorkcz/public_html'); 
	define('_WEB_BASE_DIR', '');

	include _BASE_DIR ."/include/dbconn.php";
	include _BASE_DIR ."/include/c_misc_inc.php";
	include _BASE_DIR ."/include/func_list.php";



	$base_info = getinfo_site_admin();



	$ip_address = $_SERVER['REMOTE_ADDR'];




		if($_SESSION['member_id'])
		{
			$cart_qry1 = "select count(*) as cnt,sum(item_sale*item_qty) as item_last from chan_shop_cart where user_id = '".$_SESSION['member_id']."' order by seq_no asc";

			$cart_rst1 = mysql_query($cart_qry1,$dbConn);
			$cart_top_count = @mysql_result($cart_rst1,0,0);
			$cart_sum_tmp = @mysql_result($cart_rst1,0,1);

			if(empty($cart_top_count)){
				
				$cart_top_count = 0;

			}


			if($cart_sum_tmp>0){

				$cart_sum_tmp = $cart_sum_tmp;
			}
			else
			{
				$cart_sum_tmp = "0.00";
			}

			//$cart_top_sum = "$".$cart_sum_tmp;

		}
		else
		{
			$cart_top_count = 0;
			$cart_sum_tmp = "0.00";
		}


		$discount = 0;


		if($_SESSION['member_id'])
		{
			$top_limit_contents = printTopCarts();
		}
		else
		{
			$top_limit_contents = "<tr><td>Please sign in</td></tr>";
		}

?>
