<?
	// 기본 설정 파일모음
	include "../include/inc_base.php";

	if($_POST['mode'] == "save")
	{
		$user_id=mysql_real_escape_string(htmlentities($_POST['userid'])); 
		$password=mysql_real_escape_string(htmlentities($_POST['password'])); 


		$qry1 = "select * from chan_shop_manager where member_id = '".$user_id."' && member_password = '".$password."'";
		
		$rst1 = mysql_query($qry1);
		$num1 = mysql_num_rows($rst1);


		if($num1>0)
		{
				$row1 = mysql_fetch_assoc($rst1);

				$_SESSION['admin_member_id']=$row1[member_id];
				$_SESSION['admin_member_seqNo']=$row1[seq_no];

				// session id 저장
				$_SESSION['session_id'] = session_id();

				echo "<meta http-equiv='refresh' content='0; url=./main.php'>";
				exit;



		}
		else
		{
				Misc::jvAlert("Login Fail.","history.go(-1)");
				exit;
		}


	}

?>
<HTML>
<HEAD>
<TITLE>Admin Login</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=euc-kr">
</HEAD>

<body bgcolor="#FFFFFF" text="#666666">
<br><br><br><br><br><br><br><br><br>
<table width="150" border="0" align="center">
<script>
	function chk(tf){
		if(!tf.userid.value)
		{
			alert('Enter your ID!');
			tf.userid.focus();
			return false;
		}

	return true;
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)" autocomplete=off>
<input type=hidden name=mode value="save">
  <tr>
    <td>
      <table width="422" border=0 cellpadding=0 cellspacing=0 align="center">
        <tr> 
          <td valign="top" colspan="2"><img src="./images/login_01.gif" width="422" height="87"></td>
        </tr>
        <tr> 
          <td valign="top" height="5" colspan="2"></td>
        </tr>
        <tr bgcolor="#F2F2F2" align="center"> 
            <td height="70" colspan="2" valign="middle"><font size=2>Enter your <b>ID</b> and <b>Password</b> !</font></td>
        </tr>
        <tr bordercolor="white" bordercolordark="white" bgcolor="#F2F2F2"> 
          <td width="60%" height="50%" align="right" valign="bottom"><font size=2>ID </font>
            <input name="userid" type="text"  style="border:1 solid gray;" size="13" maxlength="100" tabindex=1 value="">
          </td>
          <td width="40%" rowspan="2" style="padding:10pt;" bgcolor="#F2F2F2">
		  <input type='image' src="./images/login_04.gif" width="55" height="55" border="0" tabindex=3></td>
        </tr>
        <tr bordercolor="white" bordercolordark="white" bgcolor="#F2F2F2"> 
          <td width="60%" height="50%" align="right" valign="top"><font size=2>Password </font>
            <input name="password" type="password" style="border:1 solid gray" size="13" maxlength="16" tabindex=2 value="">
          </td>
        </tr>
        <tr bgcolor="#F2F2F2"> 
          <td valign="top" height="28" colspan="2" align="right">&nbsp;</td>
        </tr>
        <tr bgcolor="#F2F2F2"> 
          <td valign="top" height="5" colspan="2" align="right" bgcolor="#CCCCCC"></td>
        </tr>
        <tr align="center" bgcolor="#E8E8E8"> 
          <td height="30" bgcolor="#E8E8E8" colspan="2"><font color="#666666"><font size=2><?= $base_info[site_copyright] ?></font></font> </td>
        </tr>
      </table>
    </td>
  </tr>
</form>
</table>
</body>