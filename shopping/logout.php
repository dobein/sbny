<?
	date_default_timezone_set('America/New_York'); 
	ini_set("session.save_path", '/homepages/2/d245088082/htdocs/s_path');
	ini_set("session.cookie_domain", $c_domain);
	ini_set("session.cache_expire", 180); // ���� ��ȿ�ð� : ��
	ini_set("session.gc_maxlifetime", 86400); // ���� ������ �÷���(�α��ν� �������� �ð�) : ��
	session_start();

	$pre_doamin =  $_SERVER['HTTP_HOST'];
	$pre_doamin = str_replace("www.","",$pre_doamin); 
	$c_domain = '.'.$pre_doamin; 

	SetCookie("MEMLOGIN_INFO",'',0,"/",$c_domain);


	$_SESSION['member_id'] = "";
	$_SESSION['session_id'] = "";

	unset($_SESSION['member_id']);	
	unset($_SESSION['session_id']);

	session_destroy();

			echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
			exit;
?>