<?
	include "../include/inc_base.php";

	if($_POST['mode'] == "guest_purchase")
	{

		$_SESSION['member_id']=$_POST['guest_email'];
		$_SESSION['member_first_name']='Guest';
		$_SESSION['member_last_name']='';

		// session id ����
		$_SESSION['session_id'] = session_id();



		// �α����� �Ϸ�Ǹ� ���� �����Ǹ� �� ���̵�� �� ������Ʈ �Ѵ�
		$login_qry1 = "update chan_shop_cart set user_id = '".$_SESSION['member_id']."' where domain = '$domain' && user_id = '".$_COOKIE['TEMP_SHOPID']."'";
		$login_rst1 = mysql_query($login_qry1,$dbConn);

	}


	$D_URL = "../shopping/checkout.php";
	header("location: $D_URL");
?>