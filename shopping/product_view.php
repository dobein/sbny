<?
	include "../include/inc_base.php";




	$img_url = _WEB_BASE_DIR;

	/**
	* @ 오늘 본 상품 등록
	*/
	$itemCode = $_GET['itemCode'];

	putTodayView($itemCode);


	/**
	* @상품정보
	*/
	$item_info = get_iteminfo($itemCode);


	$item_cinfo = get_itemcategory($itemCode);

	if(empty($p_code1))
	{
		$p_code1 = $item_cinfo[p_code1];
	}

	if(empty($p_code2))
	{
		$p_code2 = $item_cinfo[p_code2];
	}

	if(empty($p_code3))
	{
		$p_code3 = $item_cinfo[p_code3];
	}


	if($item_info[item_stock] == "Out")
	{
		$order_possible = "NO";
	}
	else
	{
		$order_possible = "YES";
	}

	if($item_info[print_option] == "NO")
	{
		Misc::jvAlert("Please contact admin.","history.go(-1)");
		exit;
	}





	/**
	* 상품 사진 뿌려주기
	*/
	$first_picture = get_firstpic($item_info[userfile1]);

	$file_name = "list_".get_firstpic($item_info[userfile1]);

	$photo_count = count(explode("NaN",$item_info[userfile1]));

	$img_size = @getimagesize("../upload/$first_picture");

	if($img_size[0]>$img_size[1])
	{
		// 가로가 길면 가로를 줄여야함
		if($img_size[0]>339)
		{
			$image_size = "width=339";
		}
		else
		{
			$image_size = $img_size[0];
		}
	}
	else
	{
		// 세로가 기니.. 세로를 확 줄여야지
		if($img_size[1]>400)
		{
			$image_size = "height=400";
		}
		else
		{
			$image_size = $img_size[1];
		}
	}



	if($first_picture)
	{
		$main_first_picture = "<a href=\"$img_url/img/$first_picture\" class=\"jqzoom\" rel='gal1'  title=\"$item_info[model_no]\" ><img align=center src=\"$img_url/img/$first_picture\" name=main_img id=\"image1\" title=\"$item_info[model_no]\" border=0></a>";
	}
	else
	{
		$main_first_picture = "<img src=\"$img_url/images/noimage.jpg\" name=main_img border=0>";
	}



	include _BASE_DIR ."/include/inc_top.php";
?>

			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><a href=<?= _WEB_BASE_DIR ?>/><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle" border=0></a> &nbsp; Home  > Products > <b>Details</b></td>
				</tr>
			
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="50%" valign="top" align=center>
								<div align=center>
									<div class="clearfix">
										<?= $main_first_picture ?>
									</div>
								</div>
								</td>
								<td width="50%" valign="top">
								<form method=post name=item_view action=cart_process.php>
								<input type=hidden name=mode value="save">
								<input type=hidden name=itemCode value="<?= $item_info[item_code] ?>">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td colspan=2 height=35><b><?= $item_info[item_title] ?></b></td>
                                  </tr>
								  <tr>
									<td width=35% height=30>Sku #</td>
                                    <td width=65%><span class="product">G<?= $item_info[model_no]; ?></span></td>
								  </tr>
                                  <tr>
                                    <td colspan=2 background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                  </tr>
                                  <tr>
                                    <td height=30>Price</td>
									<td><span class="product">$<?= $item_info[item_price1]; ?></span></td>
                                  </tr>
                                  <tr>
                                    <td colspan=2 background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                  </tr>
								  <tr>
									<td height=30>Order Qty</td>
                                    <td><input type=text name=qty size=4 value="1"></td>
								  </tr>
                                  <tr>
                                    <td colspan=2 background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                  </tr>
                                  <tr>
                                    <td colspan=2 height="50" align="right"><input type=submit value="&nbsp;&nbsp;ADD TO CART&nbsp;&nbsp;" class="summit_btn" style="cursor:pointer"></td>
                                  </tr>
								  <tr>
									<td colspan=2 align=right></td>
								  </tr>
                                  <tr>
                                    <td colspan=2 ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="30"><span class="b">DESCRIPTION</span><br></td>
                                      </tr>
                                      <tr>
                                        <td background="<?= _WEB_BASE_DIR ?>/images/line_dot01.gif" height="1"></td>
                                      </tr> 
                                      <tr>
                                        <td style="padding:0px">
										<? if($item_info[userfile1]): ?>
										<?
										$file_name = get_firstpic($item_info[userfile1]);
										?>
										<? endif; ?>
										<?= stripslashes($item_info[item_description]); ?>										
										<br>
                                        <br></td>
                                      </tr>
                                    </table>
								    </form>
                                	</td>
                                  </tr>
							  </table>
							 </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

						<br>
						<br>
						<br>

	  
<?
	//include _BASE_DIR . "/include/htmledit_func2.php";
	// 왼쪽 include
	include _BASE_DIR ."/include/inc_bottom.php";
?>