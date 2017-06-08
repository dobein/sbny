
<!-- Footer -->
<footer id="footer">
    <section class="footersocial">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3 info">
                    <h2> <i class="icon-link"></i> Links </h2>
                    <ul>
                        <li><a href="#">My Account</a> </li>
                        <li><a href="#">Privacy Policy</a> </li>
                        <li><a href="#">Terms &amp; Conditions</a> </li>
                        <li><a href="#">Sitemap</a> </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3 contact">
                    <h2> <i class="icon-phone-sign"></i> Contact </h2>
                    <ul>
                        <li class="location"> <?= $base_info[site_address] ?></li>
                        <li class="phone"> <?= $base_info[site_phone] ?></li>
                        <li class="email"> <?= $base_info[site_email] ?></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3 twitter">
                    <h2> <i class="icon-twitter-sign"></i> Twitter </h2>
                    <div id="twitter"> </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-6 span3 facebook">
                    <h2> <i class="icon-facebook-sign"></i> Facebook </h2>
                    <div class="seperator"></div>

                </div>
            </div>
        </div>
    </section>
    <section class="copyrightbottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12  social">
                    <ul>
                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>
                        <li><a href="#"><i class="icon-google-plus"></i></a></li>
                        <li><a href="#"><i class="icon-pinterest"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 textcenter"> <?= $base_info[site_copyright] ?> </div>
                <div class=" col-lg-3 col-md-3 col-xs-12 col-sm-12 paymentsicons"> <img title="PayPal" alt="paypal" src="<?= _WEB_BASE_DIR ?>/img/payment_paypal.png"> <img title="American Express" alt="american-express" src="<?= _WEB_BASE_DIR ?>/img/payment_american.png"> <img title="2checkout" alt="2checkout" src="<?= _WEB_BASE_DIR ?>/img/payment_2checkout.png"> <img title="Maestro" alt="maestro" src="<?= _WEB_BASE_DIR ?>/img/payment_maestro.png"> <img title="Discover" alt="discover" src="<?= _WEB_BASE_DIR ?>/img/payment_discover.png"> </div>
            </div>
        </div>
    </section>
    <a id="gotop" href="#">Back to top</a> </footer>
<!-- javascript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="<?= _WEB_BASE_DIR ?>/js/jquery.js"></script>
<script src="<?= _WEB_BASE_DIR ?>/js/jquery-migrate.min.js"></script> 
<script type="text/javascript" src="<?= _WEB_BASE_DIR ?>/js/jquery.easing.js"></script> 
<script src="<?= _WEB_BASE_DIR ?>/js/respond.min.js"></script> 
<script src="<?= _WEB_BASE_DIR ?>/js/bootstrap.min.js"></script> 
<script  src="<?= _WEB_BASE_DIR ?>/js/jquery.prettyPhoto.js"></script> 
<script defer src="<?= _WEB_BASE_DIR ?>/js/jquery.flexslider.js"></script> 
<script src="<?= _WEB_BASE_DIR ?>/layerslider/js/greensock.js" type="text/javascript"></script> 
<script src="<?= _WEB_BASE_DIR ?>/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
<script src="<?= _WEB_BASE_DIR ?>/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= _WEB_BASE_DIR ?>/js/jquery.tweet.js"></script> 
<script  src="<?= _WEB_BASE_DIR ?>/js/zoomsl-3.0.min.js"></script> <script  type="text/javascript" src="js/jquery.validate.js"></script> 
<script type="text/javascript"  src="<?= _WEB_BASE_DIR ?>/js/jquery.carouFredSel-6.1.0-packed.js"></script> 
<script type="text/javascript"  src="<?= _WEB_BASE_DIR ?>/js/jquery.mousewheel.min.js"></script> 
<script type="text/javascript"  src="<?= _WEB_BASE_DIR ?>/js/jquery.touchSwipe.min.js"></script> 
<script type="text/javascript" src="<?= _WEB_BASE_DIR ?>/js/jquery.gmap.js"></script>
<script type="text/javascript" src="<?= _WEB_BASE_DIR ?>/js/jquery.countdown.js"></script>
<script defer src="<?= _WEB_BASE_DIR ?>/js/custom.js"></script>

<!-- notify -->
<link href="<?= _WEB_BASE_DIR ?>/css/toastr.css" rel="stylesheet" type="text/css" />
<script src="<?= _WEB_BASE_DIR ?>/js/toastr.js"></script>


<script>

	function addToCart(str){
	

		cart_qty = $("#item_quantity").val();


		$.post("<?= _WEB_BASE_DIR ?>/cart_proc.php",
		{
		  flag:str,
		  r_data:cart_qty
		},
		function(data,status){
		

			if(status == 'success')
			{

				var temparray = data;
				return_value = temparray.split("^");

				if(return_value[0] == 'ok')
				{
					toastr.options = {
					  "closeButton": false,
					  "debug": false,
					  "progressBar": true,
					  "positionClass": "toast-top-right",
					  "onclick": null,
					  "showDuration": "300",
					  "hideDuration": "1000",
					  "timeOut": "5000",
					  "extendedTimeOut": "1000",
					  "showEasing": "swing",
					  "hideEasing": "linear",
					  "showMethod": "fadeIn",
					  "hideMethod": "fadeOut"
					}

					toastr.info(return_value[1] +' has been added!<br>Total Amount is $' + return_value[2]);

					$("#top_cart_cnt").html(return_value[3]);
					$("#top_cart_amt").html(return_value[2]);

				}

			}
			else
			{
				$("#item_msg").html('Fail');
			}

		});

	}


	function getHTTPObject(){
		
		var xmlhttp;


		if(!xmlhttp && typeof XMLHttpRequest != 'underfined'){
			
			try{
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
	
	return xmlhttp;
	}

	var http = getHTTPObject();

	function checkout_update(str){
		
		if(str == 'first')
		{
			$('#checkut1_title').addClass('active');
			$('#checkut1').collapse('show');

			$('#checkut2_title').removeClass('active');
			$('#checkut2').collapse('hide');

			$('#checkut3_title').removeClass('active');
			$('#checkut3').collapse('hide');

		}
		else if(str == 'billing')
		{
			// billing update

			tf = document.shipping_info;

			error = true;

			b_first = tf.bill_first_name.value;
			if(b_first == '')
			  {
				$('input[id=bill_first_name]').css('border-color' , 'red');
				error = false;
			  }
			b_last = tf.bill_last_name.value;
			if(b_last == '')
			  {
				$('input[id=bill_last_name]').css('border-color' , 'red');
				error = false;
			  }

			b1 = tf.bill_address1.value;
			if(b1 == '')
			  {
				$('input[id=bill_address1]').css('border-color' , 'red');
				error = false;
			  }

			b2 = tf.bill_address2.value;

			b3 = tf.bill_city.value;
			if(b3 == '')
			  {
				$('input[id=bill_city]').css('border-color' , 'red');
				error = false;
			  }
			b4 = tf.bill_state.value;
			if(b4 == '')
			  {
				$('input[id=bill_state]').css('border-color' , 'red');
				error = false;
			  }
			b5 = tf.bill_zipcode.value;
			if(b5 == '')
			  {
				$('input[id=bill_zipcode]').css('border-color' , 'red');
				error = false;
			  }
			b6 = tf.bill_country.value;
			if(b6 == '')
			  {
				$('input[id=bill_country]').css('border-color' , 'red');
				error = false;
			  }


			b_phone = tf.bill_phone.value;
			if(b_phone == '')
			  {
				$('input[id=bill_phone]').css('border-color' , 'red');
				error = false;
			  }
			b_email = tf.bill_email.value;
			if(b_email == '')
			  {
				$('input[id=bill_email]').css('border-color' , 'red');
				error = false;
			  }


			s_first = tf.ship_first_name.value;
			if(s_first == '')
			  {
				$('input[id=ship_first_name]').css('border-color' , 'red');
				error = false;
			  }
			s_last = tf.ship_last_name.value;
			if(s_last == '')
			  {
				$('input[id=ship_last_name]').css('border-color' , 'red');
				error = false;
			  }
			s1 = tf.ship_address1.value;
			if(s1 == '')
			  {
				$('input[id=ship_address1]').css('border-color' , 'red');
				error = false;
			  }
			s2 = tf.ship_address2.value;

			s3 = tf.ship_city.value;
			if(s3 == '')
			  {
				$('input[id=ship_city]').css('border-color' , 'red');
				error = false;
			  }
			s4 = tf.ship_state.value;
			if(s4 == '')
			  {
				$('input[id=ship_state]').css('border-color' , 'red');
				error = false;
			  }
			s5 = tf.ship_zipcode.value;
			if(s5 == '')
			  {
				$('input[id=ship_zipcode]').css('border-color' , 'red');
				error = false;
			  }
			if(tf.ship_country.value == 'US')
			  {
				var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(s5);
				if (isValid)
				  {
				  }
				else {
					$('input[id=ship_zipcode]').css('border-color' , 'red');
					error = false;
				}
			  }

			s6 = tf.ship_country.value;
			if(s6 == '')
			  {
				$('input[id=ship_country]').css('border-color' , 'red');
				error = false;
			  }



			if(error == false)
			  {
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "positionClass": "toast-top-right",
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}

				toastr.error('Please fill out required field');

				  return false;
			  }

				$.post("checkout_info_update.php",
				{
				  flag:"ship_address",
				  bill_first_name:b_first,
				  bill_last_name:b_last,
				  bill_address1:b1,
				  bill_address2:b2,
				  bill_city:b3,
				  bill_state:b4,
				  bill_zipcode:b5,
				  bill_country:b6,
				  ship_first_name:s_first,
				  ship_last_name:s_last,
				  ship_address1:s1,
				  ship_address2:s2,
				  ship_city:s3,
				  ship_state:s4,
				  ship_zipcode:s5,
				  ship_country:s6,
				  bill_email:b_email,
				  bill_phone:b_phone
				},
				function(data,status){
				
					if(status == 'success')
					{
						var temparray = data;
						return_value = temparray.split("^");

						if(return_value[0] == 'ok')
						{

						
							// shipping_contents.php
							$("#shipRate_toggle_contents").load("shipping_contents.php",function(responseTxt,statusTxt,xhr){
							  if(statusTxt=="success")

								$('#checkut1_title').removeClass('active');
								$('#checkut1').collapse('hide');

								$('#checkut2_title').addClass('active');
								$('#checkut2').collapse('show');

								$('#checkut3_title').removeClass('active');
								$('#checkut3').collapse('hide');

							  if(statusTxt=="error")
								alert("Error: "+xhr.status+": "+xhr.statusText);
							});						
						}

					}
					else
					{
						//$("#address_ok").attr('src','/skin/default/images/fail.png');
						alert('update fail');
					}

				});



		}
		else if(str == 'shipmethod')
		{
	
			tf = document.shippmethod_info;

    
			s1 = $(':radio[name=shipping_method]:checked').val();


			if(s1 == undefined)
			{
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "positionClass": "toast-top-right",
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}

				toastr.error('Please choose your shipping method!');

				return false;
			}

			$.post("checkout_info_update.php",
			{
			  flag:"shipping_method",
			  ship_method:s1,
			  customer_comment:s2
			},
			function(data,status){

				if(status == 'success')
				{
					var temparray = data;

					return_value = temparray.split("^");

					if(return_value[0] == 'ok')
					{
							$('#checkut1_title').removeClass('active');
							$('#checkut1').collapse('hide');

							$('#checkut2_title').removeClass('active');
							$('#checkut2').collapse('hide');

							$('#checkut3_title').addClass('active');
							$('#checkut3').collapse('show');

							// open payment method
							$(".credit_form").load("payment_contents.php",function(responseTxt,statusTxt,xhr){
							  if(statusTxt=="success")
								//alert('good');
								//$(".credit_form").fadeIn(250);


							  if(statusTxt=="error")
								alert("Error: "+xhr.status+": "+xhr.statusText);
							});
					}

				}
				else
				{
					//$("#shipmethod_ok").attr('src','/skin/default/images/fail.png');
				}

			});



		}


		//window.location.href ='http://localhost:8012/ohbrand/checkout#checkut4';

	}

	</script>

</body>
</html>