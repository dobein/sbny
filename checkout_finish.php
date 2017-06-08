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

        <div class="checkoutsteptitle">Step 5: Confirm Order</div>
        <div class="checkoutstep">
          <div class="cart-info">
            <table class="table table-striped table-bordered">
              <tr>
                <th class="image">Image</th>
                <th class="name">Product Name</th>
                <th class="model">Model</th>
                <th class="quantity">Quantity</th>
                <th class="price">Unit Price</th>
                <th class="total">Total</th>
              </tr>
              <tr>
                <td class="image"><a ><img title="product" alt="product" src="img/prodcut-40x40.jpg" height="50" width="50"></a></td>
                <td  class="name"><a >Jeans</a></td>
                <td class="model">My Product</td>
                <td class="quantity"><input type="text" size="1" value="1" name="quantity[40]" class="span1">
                  &nbsp; <a  class="mr10"> <i class="tooltip-test font24 icon-refresh " data-original-title="Update"> </i> </a> <a ><i class="tooltip-test font24 icon-remove-circle" data-original-title="Remove"> </i></a></td>
                <td class="price">$120.68</td>
                <td class="total">$120.68</td>
              </tr>
              <tr>
                <td class="image"><a ><img title="product" alt="product" src="img/prodcut-40x40.jpg" height="50" width="50"></a></td>
                <td   class="name"><a >T-Shirt</a></td>
                <td class="model">My Product</td>
                <td class="quantity"><input type="text" size="1" value="1" name="quantity[40]" class="span1">
                  &nbsp; <a  class="mr10"> <i class="tooltip-test font24 icon-refresh " data-original-title="Update"> </i> </a> <a ><i class="tooltip-test font24 icon-remove-circle" data-original-title="Remove"> </i></a></td>
                <td class="price">$120.68</td>
                <td class="total">$120.68</td>
              </tr>
              <tr>
                <td class="image"><a ><img title="product" alt="product" src="img/prodcut-40x40.jpg" height="50" width="50"></a></td>
                <td   class="name"><a >Mobile</a></td>
                <td class="model">My Product</td>
                <td class="quantity"><input type="text" size="1" value="1" name="quantity[40]" class="span1">
                  &nbsp; <a  class="mr10"> <i class="tooltip-test font24 icon-refresh " data-original-title="Update"> </i> </a> <a ><i class="tooltip-test font24 icon-remove-circle" data-original-title="Remove"> </i></a></td>
                <td class="price">$130.00</td>
                <td class="total">$110.25</td>
              </tr>
              <tr>
                <td class="image"><a ><img title="product" alt="product" src="img/prodcut-40x40.jpg" height="50" width="50"></a></td>
                <td   class="name"><a >T-Shirt</a></td>
                <td class="model">product 11</td>
                <td class="quantity"><input type="text" size="1" value="1" name="quantity[40]" class="span1">
                  &nbsp; <a  class="mr10"> <i class="tooltip-test font24 icon-refresh " data-original-title="Update"> </i> </a> <a ><i class="tooltip-test font24 icon-remove-circle" data-original-title="Remove"> </i></a></td>
                <td class="price">$124.38</td>
                <td class="total">$120.46</td>
              </tr>
            </table>
          </div>
          <div class="pull-right">
            <table class="table table-striped table-bordered ">
              <tbody>
                <tr>
                  <td><span class="extra bold">Sub-Total :</span></td>
                  <td><span class="bold">$101.0</span></td>
                </tr>
                <tr>
                  <td><span class="extra bold">Eco Tax (-2.00) :</span></td>
                  <td><span class="bold">$11.0</span></td>
                </tr>
                <tr>
                  <td><span class="extra bold">VAT (17.5%) :</span></td>
                  <td><span class="bold">$21.0</span></td>
                </tr>
                <tr>
                  <td><span class="extra bold totalamout">Total :</span></td>
                  <td><span class="bold totalamout">$120.68</span></td>
                </tr>
              </tbody>
            </table>
            <input type="submit" class="btn btn-orange pull-right" value="CheckOut">
            <input type="submit" class="btn btn-orange pull-right mr10" value="Continue Shopping">
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
                  <a href="#"> Payment Method</a>
                </li>
                <li>
                  <a class="active"   href="#">Order Completed!</a>
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