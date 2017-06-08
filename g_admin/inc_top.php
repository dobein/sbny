<html>
<TITLE><?= $base_info[site_title] ?> : Administrator</TITLE>
<meta http-equiv="X-UA-Compatible" content="IE=9">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
body {margin:0px;background:#FFFFFF}
TD,SELECT,input,DIV,option,form,TEXTAREA,center,pre,blockquote {font-size:8pt; font-family:tahoma; color:#666666;line-height:16px;}

A:link    {color:#000000;text-decoration:none;}
A:visited {color:#000000;text-decoration:none;}
A:active  {color:#000000;text-decoration:none;}
A:hover  {color:#999999;text-decoration:underline;}
</style>
<link rel="stylesheet" type="text/css" href="<?= _WEB_BASE_DIR ?>/g_admin/jqueryslidemenu.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<script type="text/javascript" src="<?= _WEB_BASE_DIR ?>/g_admin/jqueryslidemenu.js"></script>

</head>
<body topmargin=10 leftmargin=0>

<table width=960 align=center border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#ffffff>
<td height=25 width=50%>&nbsp;<u><b><a href=<?= _WEB_BASE_DIR ?>/g_admin/main.php>HOME</a></b></u>&nbsp;&nbsp;<?= $_SESSION['member_id'] ?>&nbsp;&nbsp;<a href=<?= _WEB_BASE_DIR ?>/g_admin/logout.php><span style="color:red">LOGOUT</span></a></td>
<td width=50% align=right><?= date("Y-m-d"); ?>&nbsp;&nbsp;</td></tr>
</table>
<table width=100% align=center border=0 cellpadding=0 cellspacing=0>
<tr>
<td bgcolor=#414141>
<table width=960 align=center border=0 cellpadding=0 cellspacing=0>
<tr>
	<td colspan=2>
		<div id="myslidemenu" class="jqueryslidemenu">
		<ul>

		<li><a href="#"><img src=<?= _WEB_BASE_DIR ?>/icon/package.png align=absmiddle border=0> Product</a>
		  <ul>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/setup_base.php?area=2-1><img src=<?= _WEB_BASE_DIR ?>/icon/sitemap_color.png align=absmiddle border=0>&nbsp; Basic SETUP</a></li>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/banner_list.php?area=2-1><img src=<?= _WEB_BASE_DIR ?>/icon/sitemap_color.png align=absmiddle border=0>&nbsp; Banner Manager</a></li>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/category.php?area=2-1><img src=<?= _WEB_BASE_DIR ?>/icon/sitemap_color.png align=absmiddle border=0>&nbsp; Category</a></li>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/product.php?area=2-2><img src=<?= _WEB_BASE_DIR ?>/icon/page_white_text.png align=absmiddle border=0>&nbsp; Product List</b></a></li>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/product_add.php?area=2-3><img src=<?= _WEB_BASE_DIR ?>/icon/style_edit.png align=absmiddle border=0>&nbsp; Product Add</a></li>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/product_add_batch.php?area=2-3><img src=<?= _WEB_BASE_DIR ?>/icon/style_edit.png align=absmiddle border=0>&nbsp; Product Batch Add</a></li>
		  </ul>
		</li>

		<li><a href="#"><img src=<?= _WEB_BASE_DIR ?>/icon/monitor.png align=absmiddle border=0> Order</a>
		  <ul>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/order_list.php?area=3-1><img src=<?= _WEB_BASE_DIR ?>/icon/server_database.png align=absmiddle border=0>&nbsp; Order List</a></li>
				<li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/report_sales.php?area=3-2><img src=<?= _WEB_BASE_DIR ?>/icon/money_dollar.png align=absmiddle border=0>&nbsp; Sales Summary</a></li>
		  </ul>
		</li>

		<li><a href="#"><img src=<?= _WEB_BASE_DIR ?>/icon/user.png align=absmiddle border=0> Member</a>
		  <ul>
		  <li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/member_list.php?level=10&area=4-1><img src=<?= _WEB_BASE_DIR ?>/icon/user_gray.png align=absmiddle border=0>&nbsp; Member list</a></li>
		  </ul>
		</li>

		<li><a href="#"><img src=<?= _WEB_BASE_DIR ?>/icon/phone.png align=absmiddle border=0> Customer</a>
		  <ul>
				 <li><a href=<?= _WEB_BASE_DIR ?>/g_admin/shop/faq_list.php?area=5-1><img src=<?= _WEB_BASE_DIR ?>/icon/telephone.png align=absmiddle border=0>&nbsp; Customer Center </a></li>
		  </ul>
		</li>
		</ul>
		<br style="clear: left" />
		</div>

	</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table width=960 align=center border=0 cellpadding=0 cellspacing=0>
<tr>
	<td valign=top>
