<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	$tableName = "chan_shop_faqboard";

	if($_GET['mode'] == "del")
		{
			$seqNo = $_GET['seqNo'];

			$qry1 = "delete from $tableName where seq_no='$seqNo'";
			$rst1 = mysql_query($qry1,$dbConn);

			if($rst1)
				{
				echo "<meta http-equiv='refresh' content='0; url=faq_list.php'>";
				exit;
				}
			else
				{
				Misc::jvAlert('삭제실패','history.go(-1)');
				exit;
				}
		}
?>