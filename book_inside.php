<?
	include "./include/inc_base.php";

	if(empty($_GET['page'])){
		
		$page = "main";
	}
	else
	{
		$page = $_GET['page'];
	}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?= $base_info[site_title] ?></title>
<meta name="description" content="<?= $base_info[meta_desc] ?>" />
<meta name="keywords" content="<?= $base_info[meta_keyword] ?>" />
<link href="<?= _WEB_BASE_DIR ?>/css/common.css" rel="stylesheet" type="text/css">
</head>
<body>
<!-- 메인 메뉴 -->
<table width="98%" align=center border="0" cellspacing="0" cellpadding="0" style='border-top: dotted #CCCCCC 1px; border-bottom: dotted #CCCCCC 1px;'>
  <tr bgcolor='#fff5ee'> 
	<td height=23 colspan=3>&nbsp;&nbsp;<b>Germanium_A NEW APPROACH TO IMMUNITY</b></a></td>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width=120 valign=top>
			<table width=100% border=0 cellpadding=0 cellspacing=1 bgcolor=#cccccc>
				<tr>
					<td bgcolor=#FFFFFF>&nbsp;<b>Index</b></td>
				</tr>
				<tr>
					<td>&nbsp;<a href=<?= $_SERVER['PHP_SELF'] ?>?page=main>Main</a></td>
				</tr>
				<?
				for($i=1; $i<=48; $i++):

				if($_GET['page'] == $i)
				{
					$link = "<a href=book_inside.php?page=$i><b><u>Page $i</u></b></a>";
				}
				else
				{
					$link = "<a href=book_inside.php?page=$i>Page $i</a>";
				}
				?>
				<tr>
					<td bgcolor=#FFFFFF>&nbsp;<?= $link ?></td>
				</tr>
				<? endfor; ?>
			</table>
		</td>
		<td width=760 align=center valign=top><img src="./books/<?= $page ?>.jpg" border=1 width=640></td>
	</tr>
</table>
</body>
</html>