<?
	include "./include/inc_base.php";

	$category_info = get_category_by_url(mysql_real_escape_string(htmlentities($_GET['data1'])));

	if($category_info[p_code1])
	{
		$qry_code1 = "&& a.p_code1 = '$category_info[p_code1]'";
	}
	if($category_info[p_code2])
	{
		$qry_code2 = "&& a.p_code2 = '$category_info[p_code2]'";
	}
	if($category_info[p_code3])
	{
		$qry_code3 = "&& a.p_code3 = '$category_info[p_code3]'";
	}

	if(!$_GET['start'])
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}

	$board_scale = 30;


	$board_page = 10;

	$scale=$board_scale;

	$page_scale=$board_page;

	$que = "select 
						a.seq_no,a.p_code1,a.p_code2,a.p_code3,a.item_code,
						b.userfile1,b.item_title,b.item_url,b.brand,b.item_stock,b.model_no,item_price1,item_price2 
					from 
						chan_shop_c_product as a, 
						chan_shop_product as b
					where a.item_code = b.item_code && a.print_option = 'YES' $wholesaler_qry $qry_code1 $qry_code2 $qry_code3 $content_qry $sort_type_qry group by a.item_code $sort_qry limit $start,$scale";

	print_r($que);

	$page=floor($start/($scale*$page_scale));

	$result=mysql_query($que);
	$result_rows=mysql_num_rows($result);



	$total=mysql_affected_rows();
	$last=floor($total/$scale);


	$t_qry1 = "select count(distinct(a.item_code)) from chan_shop_c_product a, chan_shop_product b where a.item_code = b.item_code && a.print_option = 'YES'  $qry_code1 $qry_code2 $qry_code3 $content_qry $sort_type_qry";

	$page_total_qry = mysql_query($t_qry1);


	$page_total = mysql_result($page_total_qry,0,0);
	$page_last = floor($page_total/$scale);


	$total_page_num = ceil($page_total/$scale);

	$now_page_num = floor($start/$scale) + 1;


	function contentPrint(){

		global $start,$total,$page,$page_last,$scale,$result,$code,$tableName,$Mode,$how,$S_date,$S_content, $page_total,$area;

		if($start)
			{
			$n=$page_total-$start;
			}
		else
			{
			$n=$page_total;
			}

				if($page_total != "0")
				{
					for($i=$start; $i<$start+$scale; $i++)
					{
						if($i<$page_total)
								{
								$row=mysql_fetch_array($result);

								$userfile1 = "<img src='"._WEB_BASE_DIR."/upload/".$row[userfile1]."'>";

								$item_url = str_replace(" ","+",$row[item_url]);

								$product_link = _WEB_BASE_DIR."/details/$item_url";

								if($_SESSION['member_id'])
									{
										$price = "<div class=\"pricenew\">$$row[item_price2]</div>";
										$price2 = "<div class=\"priceold\">$$row[item_price1]</div>";
									}
								else
									{
										$price = "login to see price";
										$price2 = "";
									}

								$table_content="
										<li class=\"col-lg-4 col-md-4 col-xs-12 col-sm-6 span3\"> 
                                            <div class=\"thumbnail\"> <span class=\"sale tooltip-test\"> <i class=\"icon-gift font24\"></i> <br>
                                                Sale</span> <a href=\"$product_link\">$userfile1</a>
                                                <div class=\"shortlinks\">
                                                    <button  data-original-title=\"Cart\" class=\"btn btn-orange tooltip-test\"> <i class=\"icon-shopping-cart icon-white\"></i> </button>
                                                    <button  data-original-title=\"Wishlist\" class=\"btn btn-orange btn-small tooltip-test\"> <i class=\"icon-heart icon-white\"></i> </button>
                                                    <button  data-original-title=\"Compare\" class=\"btn btn-orange btn-small tooltip-test\"> <i class=\"icon-refresh icon-white\"></i> </button>
                                                </div>
												<a class=\"prdocutname\" href=\"product.html\">$row[item_title] </a>
                                                <div class=\"price\">
													$price
                                                    $price2                                                    
                                                </div>
                                            </div>
                                        </li>
									";
								unset($mail_flag);

								echo $table_content;

								}
					$n--;
					}

				}

        }//contentPrint function end


        function pageNavigation(){

        global $page_total,$page,$start,$scale,$page_scale,$board_id,$page_last,$Mode,$how,$search_content,$member_level;

        $Parameter_value = "area=$area&Mode=$Mode&how=$how&member_level=$member_level&search_content=$search_content";

        if($page_total>$scale)
        {
        if($start+1>$scale*$page_scale)
                {
                $pre_start=$page*$scale*$page_scale-$scale;
                echo "<li><a href='?start=0&$Parameter_value'>First</a></li>";
                echo "<li><a href='?start=$pre_start&$Parameter_value'>...</a></li>";
                }
        for($vj=0; $vj<$page_scale; $vj++)
            {
            $ln=($page * $page_scale+$vj)*$scale;
            $vk=$page*$page_scale+$vj+1;
                if($ln<$page_total)
                {
                        if($ln!=$start)
                        {
                        echo "<li><a href='?start=$ln&$Parameter_value'><font class=darkgray> $vk </a></li>";
                        }
                        else
                        {
                        echo "<li><a href='?start=$ln&$Parameter_value' class=\"active\">[$vk]</a></li>";
                        }
                }
            }
        if($page_total>(($page+1)*$scale*$page_scale))
                {
                $n_start=($page+1)*$scale*$page_scale;
                $last_start=$page_last*$scale;
                echo "<li><a href='?start=$n_start&$Parameter_value'>...</a></li>";
                echo "<li><a href='?start=$last_start&$Parameter_value'>Last</a></li>";
                }
        }
        }// pageNavigation function end



	include _BASE_DIR ."/include/inc_top.php";
?>
<div id="maincontainer">
    <section id="product">
        <div class="container"> 
            <!--  breadcrumb -->
            <ul class="breadcrumb">
                <li> <a href="#">Home</a> <span class="divider">/</span> </li>
                <li class="active">Product Grid View <font color=red><?= $_GET['data1'] ?></font></li>
            </ul>
            <div class="row"> 
                <!-- Sidebar Start--> 
                <!-- Sidebar-->
                <aside class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3"> 
                    <!-- Category-->
                    <div class="sidewidt">
                        <h1 class="heading1"><span class="maintext"><i class="icon-th-list"></i> Categories</span></h1>
                        <ul class="nav nav-list categories">
                            <?= printLeftcategory(); ?>
							<li> <a href="category.html">Men Accessories</a>
                                <ul>
                                    <li> <a href="category.html">Women Accessories</a> </li>
                                    <li> <a href="category.html">Computers </a> </li>
                                    <li> <a href="category.html">Home and Furniture</a> </li>
                                </ul>
                            </li>
                            <li> <a href="category.html">Women Accessories</a> </li>
                            <li> <a href="category.html">Electronics </a> </li>
                            <li> <a href="category.html">Computers </a> </li>
                            <li> <a href="category.html">Home and Furniture</a> </li>
                            <li> <a href="category.html">Others</a> </li>
                        </ul>
                    </div>
                    <!-- Latest Product -->
                    <!-- <div class="sidewidt">
                        <h1 class="heading1"><span class="maintext"><i class="icon-trophy"></i> Latest Products</span></h1>
                        <ul class="bestseller">
                            <li> <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product"> <a class="productname" href="product.html"> Product Name</a> <span class="price">$250</span>
                                <div class="ratingstar"> <i class="icon-star"> </i><i class="icon-star"> </i><i class="icon-star"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></div>
                            </li>
                            <li> <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product"> <a class="productname" href="product.html"> Product Name</a> <span class="price">$250</span> <i class="icon-star"> </i><i class="icon-star"> </i><i class="icon-star"> </i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i></li>
                        </ul>
                    </div> -->
                    <!--  Best Seller -->
                    <!-- <div class="sidewidt">
                        <h1 class="heading1"><span class="maintext"><i class="icon-bookmark"></i> Best Seller</span></h1>
                        <ul class="bestseller">
                            <li> <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product"> <a class="productname" href="product.html"> Product Name</a> <span class="procategory">Women Accessories</span> <span class="price">$250</span> </li>
                            <li> <img width="50" height="50" src="img/prodcut-40x40.jpg" alt="product" title="product"> <a class="productname" href="product.html"> Product Name</a> <span class="procategory">Electronics</span> <span class="price">$250</span> </li>
                        </ul>
                    </div> -->
                    
                    <!--  Newsletters -->
                    
                    <div class="sidewidt">
                        <h1 class="heading1"><span class="maintext"><i class="icon-pencil"></i> Newsletters</span></h1>
                        <section id="newslettersignup">
                            <div class="pull-left mt20">
                                <form class="form-horizontal">
                                    <div class="input-prepend">
                                        <input type="text" placeholder="Subscribe to Newsletter" id="inputIcon" class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                                        <input value="Subscribe" class="btn btn-orange" type="submit">
                                        Sign in </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </aside>
                
                <!-- Sidebar End--> 
                <!-- Category-->
                <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12"> 
                    <!-- Category Products-->
                    <section id="category">
                        <div class="row">
                            <div class=""> 
                                <!-- Sorting-->
                                <div class="sorting well">
                                    <form class=" form-inline pull-left">
            Sort By :
            <select class="span2">
              <option>Default</option>
              <option>Name</option>
              <option>Pirce</option>
              <option>Rating </option>
              <option>Color</option>
            </select>
            &nbsp;&nbsp;
            Show:
            <select class="span1">
              <option>10</option>
              <option>15</option>
              <option>20</option>
              <option>25</option>
              <option>30</option>
            </select>
          </form>

                                </div>
                                <!-- Category-->
                                <section id="categorygrid">
                                    <ul class="thumbnails grid">
                                        
										<? contentPrint(); ?>

                                    </ul>

                                    <div class="pull-right">
                                        <ul class="pagination">
											<? pageNavigation(); ?>
                                        </ul>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>