<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	if($_POST['mode'] == "save")
		{
		$seqNo = $_POST['seqNo'];
		$title = $_POST['title'];
		$content = addslashes($_POST['content']);

		$qry5 = "select * from chan_shop_faqboard where seq_no='$seqNo'";
		$rst5 = mysql_query($qry5);
		$row5 = mysql_fetch_array($rst5);



		$qry2 = "update chan_shop_faqboard set title='$title', content='$content' where seq_no='$seqNo'";
		$rst2 = mysql_query($qry2,$dbConn);

		echo "<script>opener.location.reload();</script>";
		Misc::jvAlert("수정이 완료되었습니다.","self.close()");
		exit;

		}	

	$seqNo = $_GET['seqNo'];

	$qry1 = "select * from chan_shop_faqboard where seq_no='$seqNo'";
	$rst1 = mysql_query($qry1,$dbConn);
	$row1 = mysql_fetch_array($rst1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
<TITLE>상세정보 수정하기</TITLE>
<style>
TD,SELECT,input,option,form,TEXTAREA,center,pre,blockquote {font-size:9pt; font-family:굴림,gulim,tahoma; color:333333;line-height:18px;}
A:link    {color:2200ff;text-decoration:none;}
A:visited {color:2200ff;text-decoration:none;}
A:active  {color:2200ff;text-decoration:none;}
A:hover  {color:2200ff;text-decoration:underline;}
</style>
<style type="text/css">
    .link {position:absolute;left:0;width:100%;height:0;background:efefef;overflow:hidden;visibility:hidden;}
    .title   {position:relative;width:100%;background:fafad2;font-family:tahoma;font-size:11px;left:0;height:25;overflow:hidden;}
    .title_o {position:relative;width:200px;background:f0fff0;font-family:tahoma;font-size:11px;left:0;height:25;overflow:hidden;}
    .text {position:relative;text-align:justify;margin:5px;font-family:tahoma;font-size:11px;color:#000000;overflow:hidden;height:98%}
</style>
<style type="text/css">
.menutitle{
	float:center;
    cursor:pointer;
    margin-bottom: 5px;
    background-color:#F4F4F4;
    color:#FFFFFF;
    width:200px;
    padding:2px;
    text-align:center;
    font-weight:bold;
    border:1px solid #FFFFFF;
}

.submenu{
    margin-bottom: 0.5em;
	width:200px;
}
</style>
</HEAD>
<BODY>
					<table width=100% border=0 cellpadding=0 cellspacing=0 class="default_text">
					<script>
						function chk(tf){

							if(!tf.title.value)
								{
								alert('제목이 빠졌습니다.');
								tf.title.focus();
								return false;
								}
							if(!tf.content.value)
								{
								alert('내용이 빠졌습니다.');
								tf.content.focus();
								return false;
								}
							return true;
						}
					</script>
					<form name=board action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)">
					<input type=hidden name=mode value="save">
					<input type=hidden name=seqNo value="<?= $_GET['seqNo'] ?>">
					<input type=hidden name=pos value="<?= $_GET['pos'] ?>">
						<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
						<tr>
							<td colspan=2 align=center height=35 bgcolor=#f4f4f4>상세정보 수정하기</td>
						</tr>
						<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
						<tr>
							<td width=20% height=25 bgcolor=#f4f4f4>&nbsp;&nbsp;제목</td>
							<td><input type=text name=title size=50 class="form_box" value="<?= $row1[title] ?>"></td>
						</tr>
						<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
						<tr>
							<td height=25 bgcolor=#f4f4f4>&nbsp;&nbsp;내용</td>
							<td><textarea name=content cols=50 rows=5 class="form_box"><?= $row1[content] ?></textarea></td>
						</tr>
						<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
						<tr>
							<td height=35 colspan=2 align=center><input type=submit value="수정완료" class="form_box"></td>
						</tr>
					</table>
</BODY>
</HTML>
