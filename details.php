<?
	include "./include/inc_base.php";


	$item_info = get_iteminfo_by_url(mysql_real_escape_string(htmlentities($_GET['data1'])));


	$item_info[item_title] = ucwords(strtolower($item_info[item_title]));


	$userfile1 = "<img src='"._WEB_BASE_DIR."/upload/".$item_info[userfile1]."'>";

	$main_img = "<img class=\"my-foto-container\" src='"._WEB_BASE_DIR."/upload/".$item_info[userfile1]."'  data-large='"._WEB_BASE_DIR."/upload/".$item_info[userfile1]."' data-title=\"Your Product Name\" data-help=\"Your Product Name\" title=\"Your Product Name\" />";

	if($item_info[userfile1])
	{
		$userfile1 = "<img class=\"zoom\" src='"._WEB_BASE_DIR."/upload/".$item_info[userfile1]."' data-large='"._WEB_BASE_DIR."/upload/".$item_info[userfile1]."' data-title=\"Your Product Name\" data-help=\"Your Product Name\" title=\"Your Product Name\">";
	}

	if($item_info[userfile2])
	{
		$userfile2 = "<img class=\"zoom\" src='"._WEB_BASE_DIR."/upload/".$item_info[userfile2]."' data-large='"._WEB_BASE_DIR."/upload/".$item_info[userfile2]."' data-title=\"Your Product Name\" data-help=\"Your Product Name\" title=\"Your Product Name\">";
	}

	if($item_info[userfile3])
	{
		$userfile3 = "<img class=\"zoom\" src='"._WEB_BASE_DIR."/upload/".$item_info[userfile3]."' data-large='"._WEB_BASE_DIR."/upload/".$item_info[userfile3]."' data-title=\"Your Product Name\" data-help=\"Your Product Name\" title=\"Your Product Name\">";
	}

	
	


	if($_SESSION['member_id'])
		{
			if($item_info[item_price2]>0)
			{
				// 세일 한다면..
				$price = "$$item_info[item_price2]";
				$old_price = "$$item_info[item_price1]";
			}
			else
			{
				// 정가
				$price = "$$item_info[item_price1]";
			}


		}
	else
		{
			$price = "login to see price";
			$price2 = "";
		}


	include _BASE_DIR ."/include/inc_top.php";
?>

<div id="maincontainer">
    <section id="product">
        <div class="container"> 
            <!-- Product Details-->
            <div class="row"> 
                <!-- Left Image-->
                <div class="col-lg-5 col-md-5 col-xs-12 col-sm-12 span5">
                      <ul class="thumbnails mainimage clearfix">
          <li class="col-lg-12 col-md-12 col-xs-12 col-sm-12 span5">  <?= $main_img ?></li>
        </ul>
        <div class="m5">Mouse move on Image to zoom</div>
        <ul class="thumbnails mainimage clearfix">
          <li class="producthtumb col-lg-4 col-md-4 col-xs-4 col-sm-4"> <?= $userfile1 ?></li>
          <li class="producthtumb col-lg-4 col-md-4 col-xs-4 col-sm-4"> <?= $userfile2 ?></li>
          <li class="producthtumb col-lg-4 col-md-4 col-xs-4 col-sm-4"> <?= $userfile3 ?></li>
                 </ul>
                </div>
                <!-- Right Details-->
                <div class="col-lg-7 col-md-7 col-xs-12 col-sm-12 span7">
                    <div class="row">
                        <div class="span7">
                            <h1 class="productname"><span class="bgnone"><?= $item_info[item_title] ?></span></h1>
                            
							<? if($_SESSION['member_id']): ?>

								<div class="productprice">
									<div class="productpageprice"> <span class="spiral"></span><?= $price ?></div>
									<? if($_SESSION['member_id'] && $item_info[item_price2]>0): ?>
									<div class="productpageoldprice">Old price : <?= $old_price ?></div>
									<? endif; ?>
								</div>
								

								<div class="controls">
								 <select  id="item_quantity" class="col-lg-9 col-md-9 col-xs-9 col-sm-9">
									<option>Select Quantity</option>
									<?
									for($i=1; $i<$item_info[stock_cnt]; $i++):
									?>
									<option value="<?= $item_info[item_code] ?>^<?= $i ?>"><?= $i ?></option>
									<?
									endfor;
									?>
								</select>
								</div>


								<div class="productbtn">
									<? if($_SESSION['member_id'] && $item_info[stock_cnt]>0): ?>
									<button class="btn btn-orange tooltip-test" data-original-title="Cart" onClick="javascript:addToCart('cart')"> <i class="icon-shopping-cart icon-white"></i>  Add to Cart</button>
									<button class="btn btn-orange btn-small tooltip-test" data-original-title="Wishlist" onClick="javascript:addToCart('wish')"> <i class="icon-heart icon-white"></i> Add to Wishlist </button>
									<? endif; ?>
								</div>
								<span id="item_msg"></span>

							<? else: ?>
								
								Sign in to view price

							<? endif; ?>


                            <!-- Product Description tab & comments-->
                            <div class="productdesc">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#description">Description</a> </li>
                                    <li><a href="#specification">Specification</a> </li>
                                    <li><a href="#producttag">Tags</a> </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="description">
                                        <?= $item_info[item_description] ?>
                                    </div>
                                    <div class="tab-pane " id="specification">
                                        <ul class="productinfo">
                                            <li> <span class="productinfoleft"> Product Code:</span>  <?= $item_info[model_no] ?> </li>
                                            <li> <span class="productinfoleft"> Availability: </span><?= $item_info[stock_cnt] ?> </li>

                                        </ul>
                                    </div>
                                    <div class="tab-pane" id="producttag">
                                        <p>
                                        </p>
                                        <ul class="tags">
											<?
											$item_icon = explode(",",$item_info[item_icon]);
											
											for($k=0; $k<count($item_icon); $k++):
											?>
                                            <li><a href="#"><i class="icon-tag"></i> <?= $item_icon[$k] ?></a> </li>
											<?
											endfor;
											?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  Related Products-->
    <!-- <section id="related" class="row mt40">
        <div class="container">
            <h1 class="heading1"><span class="maintext">Related Products</span></h1>
            <ul class="thumbnails">
                                <li class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3"> <a class="prdocutname" href="product.html">My First Product</a>
                                    <div class="thumbnail"> <a href="#"><img alt="" src="img/product2a.jpg"></a>
                                        <div class="shortlinks">
                                            <button  data-original-title="Cart" class="btn btn-orange tooltip-test"> <i class="icon-shopping-cart icon-white"></i> </button>
                                            <button  data-original-title="Wishlist" class="btn btn-orange btn-small tooltip-test"> <i class="icon-heart icon-white"></i> </button>
                                            <button  data-original-title="Compare" class="btn btn-orange btn-small tooltip-test"> <i class="icon-refresh icon-white"></i> </button>
                                        </div>
                                        <div class="price">
                                            <div class="pricenew">$4459.00</div>
                                            <div class="priceold">$5000.00</div>
                                            <div class="ratingstar"> <i class="icon-star orange"> </i><i class="icon-star orange"> </i><i class="icon-star orange"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></div>
                                        </div>
                                        <a  class="btn btn-orange btn-small  addtocartbutton">Add to Cart</a> </div>
                                </li>
                                <li class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3"> <a class="prdocutname" href="product.html">My First Product</a>
                                    <div class="thumbnail"> <span class="new tooltip-test"><i class="icon-lightbulb font24"></i> <br>
                                        New</span> <a href="#"><img alt="" src="img/product1a.jpg"></a>
                                        <div class="shortlinks">
                                            <button  data-original-title="Cart" class="btn btn-orange tooltip-test"> <i class="icon-shopping-cart icon-white"></i> </button>
                                            <button  data-original-title="Wishlist" class="btn btn-orange btn-small tooltip-test"> <i class="icon-heart icon-white"></i> </button>
                                            <button  data-original-title="Compare" class="btn btn-orange btn-small tooltip-test"> <i class="icon-refresh icon-white"></i> </button>
                                        </div>
                                        <div class="price">
                                            <div class="pricenew">$4459.00</div>
                                            <div class="priceold">$5000.00</div>
                                            <div class="ratingstar"> <i class="icon-star orange"> </i><i class="icon-star orange"> </i><i class="icon-star"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></div>
                                        </div>
                                        <a  class="btn btn-orange btn-small  addtocartbutton">Add to Cart</a> </div>
                                </li>
                                <li class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3"> <a class="prdocutname" href="product.html">My First Product</a>
                                    <div class="thumbnail"> <a href="#"><img alt="" src="img/product2a.jpg"></a>
                                        <div class="shortlinks">
                                            <button  data-original-title="Cart" class="btn btn-orange tooltip-test"> <i class="icon-shopping-cart icon-white"></i> </button>
                                            <button  data-original-title="Wishlist" class="btn btn-orange btn-small tooltip-test"> <i class="icon-heart icon-white"></i> </button>
                                            <button  data-original-title="Compare" class="btn btn-orange btn-small tooltip-test"> <i class="icon-refresh icon-white"></i> </button>
                                        </div>
                                        <div class="price">
                                            <div class="pricenew">$4459.00</div>
                                            <div class="priceold">$5000.00</div>
                                            <div class="ratingstar"> <i class="icon-star orange"> </i><i class="icon-star orange"> </i><i class="icon-star"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></div>
                                        </div>
                                        <a  class="btn btn-orange btn-small  addtocartbutton">Add to Cart</a> </div>
                                </li>
                               
                                <li class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3"> <a class="prdocutname" href="product.html">My First Product</a>
                                    <div class="thumbnail"> <a href="#"><img alt="" src="img/product2a.jpg"></a>
                                        <div class="shortlinks">
                                            <button  data-original-title="Cart" class="btn btn-orange tooltip-test"> <i class="icon-shopping-cart icon-white"></i> </button>
                                            <button  data-original-title="Wishlist" class="btn btn-orange btn-small tooltip-test"> <i class="icon-heart icon-white"></i> </button>
                                            <button  data-original-title="Compare" class="btn btn-orange btn-small tooltip-test"> <i class="icon-refresh icon-white"></i> </button>
                                        </div>
                                        <div class="price">
                                            <div class="pricenew">$4459.00</div>
                                            <div class="priceold">$5000.00</div>
                                            <div class="ratingstar"> <i class="icon-star orange"> </i><i class="icon-star orange"> </i><i class="icon-star"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></div>
                                        </div>
                                        <a  class="btn btn-orange btn-small  addtocartbutton">Add to Cart</a> </div>
                                </li>
                                <li class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3"> <a class="prdocutname" href="product.html">My First Product</a>
                                    <div class="thumbnail"> <a href="#"><img alt="" src="img/product2a.jpg"></a>
                                        <div class="shortlinks">
                                            <button  data-original-title="Cart" class="btn btn-orange tooltip-test"> <i class="icon-shopping-cart icon-white"></i> </button>
                                            <button  data-original-title="Wishlist" class="btn btn-orange btn-small tooltip-test"> <i class="icon-heart icon-white"></i> </button>
                                            <button  data-original-title="Compare" class="btn btn-orange btn-small tooltip-test"> <i class="icon-refresh icon-white"></i> </button>
                                        </div>
                                        <div class="price">
                                            <div class="pricenew">$4459.00</div>
                                            <div class="priceold">$5000.00</div>
                                            <div class="ratingstar"> <i class="icon-star orange"> </i><i class="icon-star orange"> </i><i class="icon-star"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></div>
                                        </div>
                                        <a  class="btn btn-orange btn-small  addtocartbutton">Add to Cart</a> </div>
                                </li>
                            </ul>
        </div>
    </section> -->

</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>