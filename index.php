<?
	include "./include/inc_base.php";



	include "./include/inc_top.php";
?>
<div id="maincontainer"> 
    <!-- Slider Start-->
    <section class="slider container">
        <div id="layerslider-container">
            <div id="layerslider1" style="width: 1200px; height: 550px; margin: 0 auto;">
                <?= printBanner('1'); ?>
            </div>
        </div>
    </section>
    <!-- Slider End--> 
    
    <!-- Section Start-->
    <section class="container otherddetails">
        <div class="otherddetailspart">
            <div class="innerclass"> <i class="icon-truck font60"></i>
                <h2>Free shipping</h2>
                <p>All over in world over $100</p>
            </div>
        </div>
        <div class="otherddetailspart">
            <div class="innerclass"> <i class="icon-thumbs-up font60"></i>
                <h2>100% Guarantee </h2>
                <p>High quality</p>
            </div>
        </div>
        <div class="otherddetailspart">
            <div class="innerclass"> <i class="icon-money font60"></i>
                <h2>Easy Payment</h2>
                <p> Payment Gatway support</p>
            </div>
        </div>
        <div class="otherddetailspart">
            <div class="innerclass"> <i class="icon-time font60"></i>
                <h2>24hrs Shipping</h2>
                <p> UPS, FEDEX, USPS</p>
            </div>
        </div>
        <div class="otherddetailspart">
            <div class="innerclass"> <i class="icon-gift font60"></i>
                <h2>Over 5000 Choice</h2>
                <p>50,000+ Products</p>
            </div>
        </div>
        <div class="otherddetailspart">
            <div class="innerclass"> <i class="icon-tags font60"></i>
                <h2>Low Price</h2>
                <p>Available in Low Price</p>
            </div>
        </div>
    </section>
    <!-- Section End--> 
    
    <!-- Featured Product-->
    <section id="featured" class="row mt40">
        <div class="container">
            <h1 class="heading1"><span class="maintext"> <i class="icon-star"></i> Featured Products</span></h1>
            <div class="featuredcarousalwrap">
                <ul class="thumbnails" id="featuredcarousal">
                    <?= printIndexBottom('FEATURED',0,12); ?>
                </ul>
                <div class="clearfix"></div>
                <a id="prevfeatured" class="prev" href="#"><i class="icon-chevron-left"></i></a> <a id="nextfeatured" class="next" href="#"><i class="icon-chevron-right"></i></a> </div>
        </div>
    </section>
    
    <!-- Latest Product-->
    <section id="latest" class="row mt40">
        <div class="container">
            <h1 class="heading1"><span class="maintext"> <i class="icon-thumbs-up"></i> Latest Products</span></h1>
            <div class="latestcarousalwrap">
                <ul class="thumbnails" id="latestcarousal">
                    <?= printIndexBottom('BEST_SELLER',0,12); ?>
                </ul>
                <div class="clearfix"></div>
                <a id="prevlatest" class="prev" href="#"><i class="icon-chevron-left"></i></a> <a id="nextlatest" class="next" href="#"><i class="icon-chevron-right"></i></a> </div>
        </div>
    </section>
    


</div>
<!-- /maincontainer --> 
<?
	include "./include/inc_bottom.php";
?>