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
        <li class="active">My Account</li>
      </ul>
      <div class="row">
        
        <!-- My Account-->
        <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
<h1 class="heading1"><span class="maintext"><i class="icon-user"></i> My Accounts</span></h1>        
              <h3 class="heading3">My Accounts</h3>
          <div class="myaccountbox">
            <ul>
              <li>
                <a href="myinfo.php"> Edit your account information</a>
              </li>
            </ul>
          </div>
          <h3 class="heading3">My Orders</h3>
          <div class="myaccountbox">
            <ul>
              <li>
                <a href="orderhistory.php"> View your order history</a>
              </li>
            </ul>
          </div>
          <h3 class="heading3">Newsletter</h3>
          <div class="myaccountbox">
            <ul>
              <li>
                <a href="#"> Subscribe</a>
                <a href="#"> unsubscribe to newsletter</a>
              </li>
            </ul>
          </div>
       
          
          
          
          
          
          
          
          
          
        </div>
        
        <!-- Sidebar Start-->
          <aside class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3">
            <div class="sidewidt">
              <h1 class="heading1"><span class="maintext"> <i class="icon-user"></i> Account</span></h1>
              <ul class="nav nav-list categories">
                <li><a href="myaccount.php"> My Account</a></li>
                <li><a href="myinfo.php">Edit Account</a></li>
                <li><a href="orderhistory.php">Order History</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>
          </aside>
        <!-- Sidebar End-->
      </div>
    </div>
  </section>
</div>
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>