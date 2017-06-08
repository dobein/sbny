<?
	include "./include/inc_base.php";


	$tableName = "chan_shop_member";


	if($_POST['mode'] == "save")
	{
		$action=mysql_real_escape_string(htmlentities($_POST['action'])); 

		$_SESSION["tmp_user_id"]=$user_id;
		$_SESSION["tmp_name_first"]=$name_first;
		$_SESSION["tmp_name_last"]=$name_last;	
		$_SESSION["tmp_tax_id"]=$tax_id;	
		$_SESSION["tmp_birth_day"]=$birth_day;	
		$_SESSION["tmp_cell_phone1"]=$cell_phone1;	
		$_SESSION["tmp_cell_phone2"]=$cell_phone2;	
		$_SESSION["tmp_cell_phone3"]=$cell_phone3;	
		$_SESSION["tmp_address1"]=$address1;	
		$_SESSION["tmp_address2"]=$address2;	
		$_SESSION["tmp_city"]=$city;	
		$_SESSION["tmp_state"]=$state;	
		$_SESSION["tmp_zipcode"]=$zipcode;	

		/*
		$captcha = strtolower($_POST['ct_captcha']); 

		if($captcha != "36zwta")
		{
			Misc::jvAlert("Incorrect security code entered","history.go(-1)");
			exit;
		}


	  require_once dirname(__FILE__) . '/securimage.php';
	  $securimage = new Securimage();

	  if ($securimage->check($captcha) == false) {


	  }
		*/



		/*
		$zsfCode = stripslashes(trim($_POST['zsfCode']));
		$noticeText = 'ⓒ스팸방지코드 입력값이 ';
		include '../spam/zmSpamFree.php';


		$r = zsfCheck ( $_POST['zsfCode'],'DemoPage' );	# $_POST['zsfCode']는 입력된 스팸방지코드 값이고, 'DemoPage'는 기타 기록하고픈


		if($r == false)
		{
			Misc::jvAlert("Check your spam code!","location.replace('join.php')");
			exit;
		}
		*/
		
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

		$pre_qry1 = "select * from $tableName where member_id = '$user_id'";
		$pre_rst1 = mysql_query($pre_qry1,$dbConn);
		$pre_num1 = mysql_affected_rows();
		if($pre_num1>0)
		{
			Misc::jvAlert("Duplicate your ID!.","history.go(-1)");
			exit;
		}
	
		$level = "10";
		$save_money = "0";

		//$cell_phone = $cell_phone1."-".$cell_phone2."-".$cell_phone3;
		//$home_phone = $phone1."-".$phone2."-".$phone3;	
		//$corp_phone = $corp_phone1."-".$corp_phone2."-".$corp_phone3;
		//$birth_day = $dob_year."-".$dob_month."-".$dob_day;


		$security_passwd = md5($passwd);

		$qry1 = "insert into chan_shop_member (domain, 
																	member_id, 
																	member_password,
																	level,
																	first_name,
																	last_name,
																	company,
																	tax_id,
																	email,
																	address1,
																	address2,
																	city,
																	state,
																	zipcode,
																	country,
																	corp_phone,
																	wdate,
																	mail_flag) values ('$domain',
																							'$user_id',
																							'$security_passwd',
																							'$level',
																							'$name_first',
																							'$name_last',
																							'$company',
																							'$tax_id',
																							'$user_id',
																							'$address1',
																							'$address2',
																							'$city',
																							'$state',
																							'$zipcode',
																							'$country',
																							'$corp_phone',
																							now(),
																							'$mail_flag')";

		$rst1 = mysql_query($qry1);



		if($rst1)
		{
		
			/**
			* @ 메일 보내기
			* mail_join();
			*/
			$remember_id = "YES";
			$remember_pw = "YES";

			if($action == "buy")
			{
				Member_login($user_id,$passwd,'MEMBER',$remember_id,$remember_pw);

				// 로그인이 완료되면 현재 아이피를 이 아이디로 다 업데이트 한다
				//$login_qry1 = "update chan_shop_cart set user_id = '$user_id' where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
				//$login_rst1 = mysql_query($login_qry1,$dbConn);

				echo "<meta http-equiv='refresh' content='0; url=./checkout.php'>";
				exit;
			}
			else
			{
				Member_login($user_id,$passwd,'MEMBER',$remember_id,$remember_pw);

				// 환영메세지
				$qry1 = "select * from chan_shop_page where item_code = 'join'";
				$rst1 = mysql_query($qry1,$dbConn);
				$row1 = mysql_fetch_assoc($rst1);


				// 로그인이 완료되면 현재 아이피를 이 아이디로 다 업데이트 한다
				//$login_qry1 = "update chan_shop_cart set user_id = '$user_id' where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
				//$login_rst1 = mysql_query($login_qry1,$dbConn);

				$base_infosite_name = $base_info[site_name];

				$base_infosite_email = $base_info[site_email];


				// email
				$eol="\r\n";

				$boundary = "--------" . uniqid("part"); 
				$headers .= 'From: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol; 
				$headers .= 'Reply-To: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol; 
				$headers .= 'Return-Path: '.$base_infosite_name.' <'.$base_infosite_email.'>'.$eol;    // these two to set reply address 
				$headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
				$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters 
				$headers .= "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-Type:text/html; charset=euc-kr\r\n"; 
				$headers .= "Content-Transfer-Encoding: 8bit\n\n";
				
				$mail_title = "$base_info[site_title]";

				$mailStr .= "
				<table width=600 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td colspan=2><a href=$base_info[site_homepage] target=_blank>$base_info[site_title]</a></td>
					</tr>
					<tr> 
						<td colspan=2>Dear $name_first $name_last</td>
					</tr>
					<tr> 
						<td colspan=2 height=40>Thank you for becoming a registered member at $base_info[site_homepage]</td>
					</tr>
					<tr> 
						<td colspan=2 height=20>User account information</td>
					</tr>
					<tr> 
						<td width=200 height=20>Email:</td>
						<td width=400>$user_id</td>
					</tr>
					<tr> 
						<td height=40 colspan=2>Thank you for shopping at $base_info[site_title]</td>
					</tr>
					<tr> 
						<td height=40 colspan=2 >$base_info[site_email]<br>$base_info[site_phone]</td>
					</tr>
				</table>";

				//$mail_result = mail($user_id, $mail_title, $mailStr, $headers);


				$admin_title = "Member Join Notification!";

				//$mail_result2 = mail($base_info[site_email], $admin_title, $mailStr, $headers);

				echo "<meta http-equiv='refresh' content='0; url=myaccount.php'>";
				exit;
			}
		}
		else
		{
			Misc::jvAlert("Error!","history.go(-1)");
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
        <li class="active">Register Account</li>
      </ul>
      <div class="row">        
        <!-- Register Account-->
        <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
          <h1 class="heading1"><span class="maintext"> <i class="icon-signin"></i> Register Account</span></h1>
		  <script>

							function continueExecution1(){
								email_msg.innerHTML = '';
							}

							function join_chk(tf){
								tf = document.join;


								if(!tf.user_id.value)
								{
									tf.user_id.focus();
									email_msg.innerHTML = '<font color=#ff6600>* Enter your E-mail address</font>';
									return false;
								}


								var email = tf.user_id.value;
								var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/; 

								if(regex.test(email) === false) {
									tf.user_id.focus();
									email_msg.innerHTML = '<font color=#ff6600>* Check your E-mail address.</font>';

									setTimeout(continueExecution1, 3000);

									return false;
								}


								if(!tf.passwd.value)
								{
									tf.passwd.focus();
									password_msg.innerHTML = '<font color=#ff6600>* Enter your Password</font>';
									return false;
								}

								if(tf.passwd.value != tf.passwd2.value)
								{
									tf.passwd2.focus();
									password2_msg.innerHTML = '<font color=#ff6600>* The Password fields do not match.</font>';
									return false;
								}

								M_id = tf.passwd.value;

								if (M_id.length < 6){
									tf.passwd.focus();
									password_msg.innerHTML = '<font color=#ff6600>* Password must be at least 6 characters long.</font>';
									return false;
								}

								if(!tf.name_first.value)
								{
									tf.name_first.focus();
									contact_firstname_msg.innerHTML = '<font color=#ff6600>* Enter your first name</font>';
									return false;
								}
								if(!tf.name_last.value)
								{
									tf.name_last.focus();
									contact_lastname_msg.innerHTML = '<font color=#ff6600>* Enter your last name</font>';
									return false;
								}
								if(!tf.company.value)
								{
									tf.company.focus();
									contact_company_msg.innerHTML = '<font color=#ff6600>* Enter your Company name</font>';
									return false;
								}
								if(!tf.corp_phone.value)
								{
									tf.corp_phone.focus();
									contact_phone_msg.innerHTML = '<font color=#ff6600>* Enter your Phone Number</font>';
									return false;
								}
								if(!tf.tax_id.value)
								{
									tf.tax_id.focus();
									contact_taxid_msg.innerHTML = '<font color=#ff6600>* Enter your Tax ID #</font>';
									return false;
								}


								return true;

								
							}



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
          <form name="join" class="form-horizontal form-custom" action=<?= $_SERVER['PHP_SELF'] ?> method=post onSubmit="return join_chk(this)">
		  <input type=hidden name=mode value=save>
            <h3 class="heading3">Your Personal Details</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Email:</label>
                  <div class="controls">
                    <input type="text"  name=user_id  class="">&nbsp;<span id="email_msg"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Password:</label>
                  <div class="controls">
                    <input type="password"  name=passwd class="">&nbsp;<span id="password_msg">Password must be at least 6 characters </span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Password confirm:</label>
                  <div class="controls">
                    <input type="password"  name=passwd2 class="">&nbsp;<span id="password2_msg"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> First Name:</label>
                  <div class="controls">
                    <input type="text"  name=name_first class="">&nbsp;<span id="contact_firstname_msg"></span>
                  </div>
                </div>

				<div class="control-group">
                  <label class="control-label"><span class="red">*</span> Last Name:</label>
                  <div class="controls">
                    <input type="text"  name=name_last class="">&nbsp;<span id="contact_lastname_msg"></span>
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
                    <input type="text"  name=company class="">&nbsp;<span id="contact_company_msg"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Tax ID:</label>
                  <div class="controls">
                    <input type="text" name=tax_id class="">&nbsp;<span id="contact_taxid_msg"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Phone:</label>
                  <div class="controls">
                    <input type="text" name=corp_phone class="">&nbsp;<span id="contact_phone_msg"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Address 1:</label>
                  <div class="controls">
                    <input type="text"  name=address1 class="">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"> Address 2:</label>
                  <div class="controls">
                    <input type="text"  name=address2 class="">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>City:</label>
                  <div class="controls">
                    <input type="text"  name=city class="">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Post Code:</label>
                  <div class="controls">
                    <input type="text"  name=zipcode class="">
                  </div>
                </div>
                <div class="control-group">
                  <label for="select01" class="control-label">
                    <span class="red">*</span>Country:</label>
                  <div class="controls">
					<select name=b_country onChange="javascript:choose_country('bill',this.value)"><?= printCountryList('US'); ?></select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">
                    <span class="red">*</span>Region / State:</label>
                  <div class="controls">
                    <span id="b_state_area"><select name="b_state" id="b_state"  class="txt" style="width:180px"><?= printState($_SESSION['tmp_b_stated']); ?></select></span>
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
              <label class="checkbox inline">
                <input type="checkbox" value="option2" >
              </label>
              I have read and agree to the <a href="#" >Privacy Policy</a>
              &nbsp;
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
              <li>
                <a href="#"> My Account</a>
              </li>
              <li>
                <a href="#">Edit Account</a>
              </li>
              <li><a href="#">Order History</a>
              </li>
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