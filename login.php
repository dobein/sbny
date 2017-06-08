<?
	include "./include/inc_base.php";

	if($_POST['login_mode2'] == "save")
	{
		$goUrl=mysql_real_escape_string(htmlentities($_POST['goUrl'])); 


		$userid2=mysql_real_escape_string(htmlentities($_POST['userid2'])); 
		$password2=mysql_real_escape_string(htmlentities($_POST['password2'])); 


		$remember_id = $_POST['remember_id'];
		$remember_pw = $_POST['remember_pw'];

		if(Member_login($userid2,$password2,'MEMBER',$remember_id,$remember_pw))
		{
			if(!$goUrl)
				{
					$goUrl_1 = "./index.php";
				}
			else
				{
					$goUrl_1 = "$goUrl";
				}

			// 로그인이 완료되면 현재 아이피를 이 아이디로 다 업데이트 한다
			//$login_qry1 = "update chan_shop_cart set user_id = '$userid2' where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
			//$login_rst1 = mysql_query($login_qry1,$dbConn);

			//$t_qry2 = "update chan_shop_today set user_id = '$userid2' where user_id = '$myip'";
			//$t_rst2 = mysql_query($t_qry2);


			echo "<meta http-equiv='refresh' content='0; url=$goUrl_1'>";
			exit;
		}
		else
		{
			Misc::jvAlert("Check your Login info!","history.go(-1)");
			exit;
		}

	}


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
        <li class="active">Login</li>
      </ul>
       <!-- Account Login-->
      <div class="row">  
        <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
          <h1 class="heading1"><span class="maintext"> <i class="icon-lock"></i> Login</span></h1>
          <section class="newcustomer">
            <h2 class="heading2">New Customer </h2>
            <div class="loginbox">
              <h4 class="heading4"> Register Account</h4>
              <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
              <br>
              <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
              <br>
            
              <a href="join.php" class="btn btn-orange">Continue</a>
            </div>
          </section>
          <section class="returncustomer">
            <h2 class="heading2">Returning Customer </h2>
            <div class="loginbox">
              <h4 class="heading4">I am a returning customer</h4>
              <form class="form-vertical" action=<?= $_SERVER['PHP_SELF'] ?> method=post>
				<input type=hidden name=login_mode2 value=save>
				<input type=hidden name=goUrl value="<?= $_GET['goUrl'] ?>">
                <fieldset>
                  <div class="control-group">
                    <label  class="control-label">E-Mail Address:</label>
                    <div class="controls">
                      <input type="text" name=userid2 class="">
                    </div>
                  </div>
                  <div class="control-group">
                    <label  class="control-label">Password:</label>
                    <div class="controls">
                      <input type="password"  name=password2 class="">
                    </div>
                  </div>
                  <a class="" href="#">Forgotten Password</a>
                  <br>
                  <br>
                  <input type=submit class="btn btn-orange" value="Login">
                </fieldset>
              </form>
            </div>
          </section>
        </div>
        
        <!-- Sidebar Start-->
        <aside class="col-lg-3 col-md-3 col-xs-12 col-sm-12 span3">
          <div class="sidewidt">
            <h1 class="heading1"><span class="maintext"> <i class="icon-user"></i> Account</span></h1>
            <ul class="nav nav-list categories">
              <li>
                <a href="#"> My Account</a>
              </li>
              <li>
                <a href="#">Edit Account</a>
              </li>
              <li><a href="#">Order History</a></li>
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