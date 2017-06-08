<?
	// 기본 설정 파일모음
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



	if($_POST['mode'] == "save")
		{
			if(empty($name))
			{
				Misc::jvAlert("카테고리 명을 넣어주세요","history.go(-1)");
				exit;
			}

			// pos 값 구하기
			$qry2 = "select max(pos) from chan_shop_faqcategory";
			$rst2 = mysql_query($qry2,$dbConn);
			$row2 = @mysql_result($rst2,0,0);

			if(!$row2)
				{
				$row2 = "1";
				}
			else
				{
				$row2++;
				}

			$name = iconv("EUC-KR","UTF-8",$name);

			$qry1 = "insert into chan_shop_faqcategory values ('','$name','$row2')";
			$rst1 = mysql_query($qry1,$dbConn);

			echo "<script>opener.location.reload();</script>";

		}	

	if($_POST['mode'] == "del")
		{
			$seqNo = $_GET['seqNo'];
			$pos = $_GET['pos'];

			$qry3 = "delete from chan_shop_faqcategory where seq_no='$seqNo'";
			$rst3 = mysql_query($qry3,$dbConn);

			$qry4 = "delete from chan_shop_faqboard where category_no='$pos'";
			$rst4 = mysql_query($qry4,$dbConn);

			if($rst3 && $rst4)
				{
					echo "<meta http-equiv='refresh' content='0; url=ysetup_category.php'>";
					exit;
				}
			else
				{
					Misc::jvAlert("삭제실패!","history.go(-1)");
					exit;
				}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
<TITLE>카테고리 등록하기</TITLE>
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
<table width=100% align=center border=0 cellpadding=0 cellspacing=0 class="default_text">
<script>
	function chk(tf){
		if(!tf.name.value)
			{
			alert('카테고리명이 빠졌습니다.');
			tf.name.focus();
			return false;
			}
		return true;
	}
	function del(seqNo,pos){

		answer = confirm("정말 삭제하시겠습니까? \r\r카테고리 게시물도 같이 삭제됩니다.");

		if(answer == true)
			{
				location.replace('ysetup_category.php?mode=del&seqNo=' + seqNo + '&pos=' + pos);
			}
		else return;
	}
</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=no value="<?= $no ?>">
<input type=hidden name=area value="<?= $area ?>">
<input type=hidden name=category value="<?= $category ?>">
<input type=hidden name=sub_category value="<?= $sub_category ?>">
	<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
	<tr>
		<td colspan=2 bgcolor=#f4f4f4 align=center height=30><b>카테고리 목록</b></td>
	</tr>
	<tr>
		<td valign=top colspan=2>
		<table width=100% border=0 cellpadding=0 cellspacing=0 class="default_text">
			<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
			<tr>
				<td width=80% align=center height=30>카테고리 명</td>
				<td width=20% align=center>수정 | 삭제</td>
			</tr>
			<tr><td bgcolor="#CCCCCC" height="1" colspan=2></td></tr>
			<?
			$c_qry1 = "select * from chan_shop_faqcategory order by pos asc";
			$c_rst1 = mysql_query($c_qry1,$dbConn);

			while($c_row1 = mysql_fetch_array($c_rst1)):

			$c_row1[name] = iconv("UTF-8","EUC-KR",$c_row1[name]);
			?>
			<tr>
				<td width=80% height=28>&nbsp;&nbsp;<?= $c_row1[name] ?></td>
				<td width=20% align=center><a href=ysetup_categorymodify.php?seqNo=<?= $c_row1[seq_no] ?>>수정</a> | <a href="javascript:del('<?= $c_row1[seq_no] ?>','<?= $c_row1[pos] ?>')">삭제</a></td>
			</tr>
			<tr><td colspan=2 height=1 bgcolor=#F4F4F4></td></tr>
			<?
			endwhile;
			?>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr></form>
</table>
</BODY>
</HTML>
