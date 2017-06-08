<?
	include "./include/inc_base.php";




	include _BASE_DIR ."/include/inc_top.php";
?>
<div id="maincontainer">
  <section id="product">
    <div class="container">
    <!--  breadcrumb -->  
      <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Checkout</li>
      </ul>
      <div class="row">        
        <!-- Account Login-->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <h2 class="heading1"><span class="maintext">Checkout</span></h2>


        <div class="checkoutsteptitle">Step 4: Payment  Method </div>
        <div class="checkoutstep">
          <p>Please select the preferred payment method to use on this order.</p>
          <label class=" inline">
            <input type="radio" value="option1">
            Cash On Delivery</label>
          <textarea rows="3" >Add Comment here...</textarea>
          <br>
          <br>
          <div class="pull-right"> <a href=checkout_finish.php class="btn btn-orange pull-right">Continue</a>
            <div class="privacy">I have read and agree to the <a >Privacy Policy</a> </div>
          </div>
        </div>
      </div>        
        <!-- Sidebar Start-->
        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3">
          <aside>
            <div class="sidewidt">
              <h2 class="heading2"><span><i class="icon-list-ol"></i> Checkout Steps</span></h2>
              <ul class="nav nav-list categories">
                <li>
                  <a href="#">Billing & Shipping Details</a>
                </li>
                <li>
                  <a href="#">Delivery Method</a>
                </li>               
                <li>
                  <a class="active"  href="#"> Payment Method</a>
                </li>
                <li>
                  <a href="#">Order Completed!</a>
                </li>   
              </ul>
            </div>
          </aside>
        </div>
        <!-- Sidebar End-->
      </div>
    </div>
  </section>
</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>