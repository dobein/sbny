<?
	include "./include/inc_base.php";


	$tableName = "chan_shop_member";


	if($_POST['mode'] == "save")
	{
		$action=mysql_real_escape_string(htmlentities($_POST['action'])); 

		$user_id = mysql_real_escape_string(htmlentities(trim($_POST['user_id'])));
		$passwd = mysql_real_escape_string(htmlentities($_POST['passwd']));
		$name_first = mysql_real_escape_string(htmlentities($_POST['name_first']));
		$name_last = mysql_real_escape_string(htmlentities($_POST['name_last']));
		$tax_id = mysql_real_escape_string(htmlentities($_POST['tax_id']));
		$company = mysql_real_escape_string(htmlentities($_POST['company']));
		$address1 = mysql_real_escape_string(htmlentities($_POST['address1']));
		$address2 = mysql_real_escape_string(htmlentities($_POST['address2']));
		$city = mysql_real_escape_string(htmlentities($_POST['city']));
		$state = mysql_real_escape_string(htmlentities($_POST['b_state']));
		$zipcode = mysql_real_escape_string(htmlentities($_POST['zipcode']));
		$country = mysql_real_escape_string(htmlentities($_POST['b_country']));
		$phone_flag = mysql_real_escape_string(htmlentities($_POST['phone_flag']));
		$cell_phone = mysql_real_escape_string(htmlentities($_POST['cell_phone']));
		$home_phone = mysql_real_escape_string(htmlentities($_POST['home_phone']));
		$corp_phone = mysql_real_escape_string(htmlentities($_POST['corp_phone']));
		$mail_flag = mysql_real_escape_string(htmlentities($_POST['mail_flag']));




		$security_passwd = md5($passwd);

		if($_POST['passwd'])
		{
		$qry1 = "update chan_shop_member set member_password = '$passwd',
																	first_name = '$name_first',
																	last_name = '$name_last',
																	company = '$company',
																	tax_id = '$tax_id',
																	email = '$email',
																	corp_phone = '$corp_phone',
																	address1 = '$address1',
																	address2 = '$address2',
																	city = '$city',
																	state = '$state',
																	zipcode = '$zipcode',
																	country = '$country' where member_id = '".$_SESSION['member_id']."'";
		}
		else
		{
		$qry1 = "update chan_shop_member set first_name = '$name_first',
																	last_name = '$name_last',
																	company = '$company',
																	tax_id = '$tax_id',
																	email = '$email',
																	corp_phone = '$corp_phone',
																	address1 = '$address1',
																	address2 = '$address2',
																	city = '$city',
																	state = '$state',
																	zipcode = '$zipcode',
																	country = '$country' where member_id = '".$_SESSION['member_id']."'";
		}


		$rst1 = mysql_query($qry1);

		echo "<meta http-equiv='refresh' content='0; url=myaccount.php'>";
		exit;
	}


	$mem_info = getinfo_dbMember($_SESSION['member_id']);

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
        <li class="active">Register Account</li>
      </ul>
      <div class="row">        
        <!-- Register Account-->
        <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
          <h1 class="heading1"><span class="maintext"> <i class="icon-signin"></i> Modify Account</span></h1>
		  <script>

			function choose_country(flag,country)
			{
				if(flag == 'bill')
				{
					if(country == 'US')
					{
						b_state_area.innerHTML = '<select name="b_state" id="b_state"  class="txt" style="width:180px"><?= printState(); ?></select>';
					}
					else
					{
						b_state_area.innerHTML = '<input name="b_state" type="text" class="itext" />';
					}
				}

			}
		  </script>
          <form class="form-horizontal form-custom" action=<?= $_SERVER['PHP_SELF'] ?> method=post>
		  <input type=hidden name=mode value=save>
            <h3 class="heading3">Your Personal Details</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> First Name:</label>
                  <div class="controls">
                    <input type="text"  name=name_first class="" value="<?= $mem_info['first_name'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Last Name:</label>
                  <div class="controls">
                    <input type="text"  name=name_last class="" value="<?= $mem_info['last_name'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Email:</label>
                  <div class="controls">
                    <input type="text"  name=user_id  class="" value="<?= $mem_info['email'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> New Password:</label>
                  <div class="controls">
                    <input type="password"  name=passwd class="" value=""> (※ If you want to change password, please enter new password))
                  </div>
                </div>
              </fieldset>
            </div>
            <h3 class="heading3">Company Information</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Company:</label>
                  <div class="controls">
                    <input type="text"  name=company class="" value="<?= $mem_info['company'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Tax ID:</label>
                  <div class="controls">
                    <input type="text" name=tax_id class="" value="<?= $mem_info['tax_id'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Phone:</label>
                  <div class="controls">
                    <input type="text" name=corp_phone class="" value="<?= $mem_info['corp_phone'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Address 1:</label>
                  <div class="controls">
                    <input type="text"  name=address1 class="" value="<?= $mem_info['address1'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Address 2:</label>
                  <div class="controls">
                    <input type="text"  name=address2 class="" value="<?= $mem_info['address2'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>City:</label>
                  <div class="controls">
                    <input type="text"  name=city class="" value="<?= $mem_info['city'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Post Code:</label>
                  <div class="controls">
                    <input type="text"  name=zipcode class="" value="<?= $mem_info['zipcode'] ?>">
                  </div>
                </div>
                <div class="control-group">
                  <label for="select01" class="control-label">
                    <span class="red">*</span>Country:</label>
                  <div class="controls">
                    <select name=b_country onChange="javascript:choose_country('bill',this.value)"><?= printCountryList($mem_info['country']); ?></select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Region / State:</label>
                  <div class="controls">
                    <span id="b_state_area"><select name="b_state" id="b_state"  class="txt" style="width:180px"><?= printState($mem_info['state']); ?></select></span>
                  </div>
                </div>
              </fieldset>
            </div>
            <h3 class="heading3">Newsletter</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label class="control-label">Subscribe:</label>
                  <div class="controls">
                    <label class="checkbox inline">
                      <input type="checkbox" name=mail_flag value="YES" >
                      Yes </label>
                      I want to receive newsletter.
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="pull-right">
              <input type="Submit" class="btn btn-orange" value="Continue">
            </div>
          </form>
          <div class="clearfix"></div>
          <br>
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