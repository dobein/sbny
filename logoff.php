<?
	/**
	* Base Include
	* by david lee
	*/
	include "./include/inc_base.php";

				$_SESSION['member_id']='';

				$_SESSION['member_first_name']='';
				$_SESSION['member_last_name']='';
				// session id ְתְו
				$_SESSION['session_id'] = '';


				session_destroy();

			echo "<meta http-equiv='refresh' content='0; url=./login.php'>";
			exit;
?>