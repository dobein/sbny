<?
	include "../include/inc_base.php";


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


		$captcha = strtolower($_POST['ct_captcha']); 

		if($captcha != "36zwta")
		{
			Misc::jvAlert("Incorrect security code entered","history.go(-1)");
			exit;
		}

		/*
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
		$name_first = $_POST['name_first'];
		$name_last = $_POST['name_last'];
		$tax_id = mysql_real_escape_string(htmlentities($_POST['tax_id']));
		$company = $_POST['company'];
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipcode = mysql_real_escape_string(htmlentities($_POST['zipcode']));
		$country = mysql_real_escape_string(htmlentities($_POST['country']));
		$phone_flag = mysql_real_escape_string(htmlentities($_POST['phone_flag']));
		$cell_phone = mysql_real_escape_string(htmlentities($_POST['cell_phone']));
		$home_phone = mysql_real_escape_string(htmlentities($_POST['home_phone']));
		$corp_phone = mysql_real_escape_string(htmlentities($_POST['corp_phone']));
		$mail_flag = mysql_real_escape_string(htmlentities($_POST['mail_flag']));

		$pre_qry1 = "select * from $tableName where domain = '$domain' && member_id = '$user_id'";
		$pre_rst1 = mysql_query($pre_qry1,$dbConn);
		$pre_num1 = mysql_affected_rows();
		if($pre_num1>0)
		{
			Misc::jvAlert("Duplicate your ID!.","history.go(-1)");
			exit;
		}
	
		$level = "10";
		$save_money = "0";

		$cell_phone = $cell_phone1."-".$cell_phone2."-".$cell_phone3;
		$home_phone = $phone1."-".$phone2."-".$phone3;
		
		//$corp_phone = $corp_phone1."-".$corp_phone2."-".$corp_phone3;

		//$birth_day = $dob_year."-".$dob_month."-".$dob_day;

		if(empty($mail_flag)){
			
			$mail_flag = "NO";

		}

		$security_passwd = md5($passwd);

		$qry1 = "insert into chan_shop_member (domain, 
																	member_id, 
																	member_password,
																	level,
																	first_name,
																	last_name,
																	wdate,
																	mail_flag) values ('$domain',
																							'$user_id',
																							'$security_passwd',
																							'$level',
																							'$name_first',
																							'$name_last',
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
				$login_qry1 = "update chan_shop_cart set user_id = '$user_id' where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
				$login_rst1 = mysql_query($login_qry1,$dbConn);

				echo "<meta http-equiv='refresh' content='0; url=../shopping/checkout.php'>";
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
				$login_qry1 = "update chan_shop_cart set user_id = '$user_id' where user_id = '".$_COOKIE['TEMP_SHOPID']."'";
				$login_rst1 = mysql_query($login_qry1,$dbConn);

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

				$mail_result = mail($user_id, $mail_title, $mailStr, $headers);


				$admin_title = "Member Join Notification!";

				//$mail_result2 = mail($base_info[site_email], $admin_title, $mailStr, $headers);

				echo "<meta http-equiv='refresh' content='0; url=join_completed.php'>";
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
			<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <b>CREATE AN ACCOUNT</b></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="10"></td>
				</tr>
				<tr>
					<td>

	<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
<script>
	var url = "id_check.php?user_id=";

	function handleHttpResponse(){
	
		if(http.readyState == 4){
			
			if(http.responseText.indexOf('invalid') == -1){
				
				var xmlDocument = http.responseXML;

				total_counts = xmlDocument.getElementsByTagName('name');

				for(i=0; i<total_counts.length; i++)
				{
					var name = xmlDocument.getElementsByTagName('name').item(i).firstChild.data;
				}

				v_msg = document.getElementById("id_msg"); 

				if(total_counts.length == '0')
				{
					v_msg.innerHTML = '<font style=\"color:blue\">This ID is available.</font>';
				}
				else
				{
					v_msg.innerHTML = '<font style=\"color:red\">This ID is unavailable.</font>';
				}

				isWorking = false;
			}
		}

	} 

	var isWorking = false;

	function show_data(tf){

			// 빈문자열이면 체크


			if(!tf)
			{
				v_msg = document.getElementById("id_msg"); 

				v_msg.innerHTML = '<font style=\"color:red\">Enter your Email address.</font>';
				return false;
			}

			// 문자열 사이즈 길이 체크

			if(tf.length < 4)
			{
				v_msg = document.getElementById("id_msg"); 

				v_msg.innerHTML = '<font style=\"color:red\">Four characters or more.</font>';
				return false;
			}

			// 다른 문자들 들어있는지 체크


			// ajax start
			if(!isWorking && http){

				http.open("GET",url + escape(tf),true);

				http.onreadystatechange = handleHttpResponse;
				isWorking = true;

				http.send(null);

			}
	}

	function getHTTPObject(){
		
		var xmlhttp;

	  /*@cc_on

	  @if (@_jscript_version >= 5)

		try {

		  xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

		} catch (e) {

		  try {

			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

		  } catch (E) {

			xmlhttp = false;

		  }

		}

	  @else

	  xmlhttp = false;

	  @end @*/


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

	function mem_chk(tf){

		var M_id = tf.user_id.value;

		if (M_id.length < 4){
		alert("ID may consist of Four characters or more");
		tf.user_id.focus();
		return false;
		}

		if(!tf.user_id.value)
		{
			alert('Enter your Email address!');
			tf.user_id.focus();
			return false;
		}
		if(!tf.passwd.value)
		{
			alert('Enter your Password!');
			tf.passwd.focus();
			return false;
		}
		if(tf.passwd.value != tf.passwd2.value)
		{
			alert('Your Password is not match!');
			tf.passwd.focus();
			return false;
		}
		if(!tf.name_first.value)
		{
			alert('Enter your first name!');
			tf.name_first.focus();
			return false;
		}
		if(!tf.name_last.value)
		{
			alert('Enter your last name!');
			tf.name_last.focus();
			return false;
		}
		if(!tf.tax_id.value)
		{
			alert('Enter your Tax ID!');
			tf.tax_id.focus();
			return false;
		}
		if(!tf.birth_day.value)
		{
			alert('Enter your Company!');
			tf.birth_day.focus();
			return false;
		}
		if(!tf.cell_phone1.value)
		{
			alert('Enter your Telephone!');
			tf.cell_phone1.focus();
			return false;
		}


	return true;
	}



</script>
<form action=<?= $_SERVER['PHP_SELF'] ?> method=post name=join onSubmit="return mem_chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=action value="<?= $action ?>">
	  <tr>
		<td colspan=4 height=45 align=left>&nbsp;&nbsp;<?= $btn_join_title ?></td>
	  </tr>
	 <tr>
		<td  align="left" height="20" colspan=4>&nbsp;&nbsp;</td>
	 </tr>
	 <tr>
		<td colspan=4>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold"><?= $btn_personal_title ?></td>
				</tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;<?= $btn_join_firstname ?></td>
					<td  align='left' width=75%> &nbsp;<input type=text name=name_first size=25 class="input"  value="<?= $_SESSION["tmp_name_first"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;<?= $btn_join_lastname ?></td>
					<td  align='left' width=75%> &nbsp;<input type=text name=name_last size=25 class="input"  value="<?= $_SESSION["tmp_name_last"] ?>"></td>
				 </tr>

				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;<?= $btn_join_email ?></td>
					<td  align='left' width=75%> &nbsp;<input name="user_id" type="text" class="input" size="25" onblur="show_data(this.value);" value="<?= $_SESSION["tmp_user_id"] ?>">&nbsp;&nbsp;<span id=id_msg></span></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;<?= $btn_join_passwd ?></td>
					<td  align='left' width=75%> &nbsp;<input type=password name=passwd size=20 class="input" ></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;<?= $btn_join_passwd2 ?></td>
					<td  align='left' width=75%> &nbsp;<input type=password name=passwd2 size=20 class="input" ></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;<?= $btn_join_newsletter ?></td>
					<td  align='left' width=75%> &nbsp;<input type=checkbox name=mail_flag value="YES" class="input" checked> <?= $btn_join_newsletter_confirm ?></td>
				 </tr>


				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Spam Filter</td>
					<td  align='left' width=75%> &nbsp;<img src=../images/spamcode.JPG><br>
		<strong>Enter Code*:</strong><br />

		<input type="text" name="ct_captcha" size="12" maxlength="16" />					
					</td>
				 </tr>

			</table>
			<br>
		</td>
	</tr>
	<!-- <tr>
		<td colspan=4>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Address Information</td>
				</tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Company</td>
					<td align='left' width=75%> &nbsp;<input type=text name=company size=35 class="input"  value="<?= $_SESSION["tmp_birth_day"] ?>"></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Telephone</td>
					<td align='left' width=75%> &nbsp;<input type=text name=cell_phone1 size=3 class="input"  value="<?= $_SESSION["tmp_cell_phone1"] ?>">&nbsp;-&nbsp;<input type=text name=cell_phone2 size=3 class="input"  value="<?= $_SESSION["tmp_cell_phone2"] ?>">&nbsp;-&nbsp;<input type=text name=cell_phone3 size=3 class="input"  value="<?= $_SESSION["tmp_cell_phone3"] ?>"></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Company Phone</td>
					<td align='left' width=75%> &nbsp;<input type=text name=phone1 size=3 class="input" value="<?= $phone[0] ?>">&nbsp;-&nbsp;<input type=text name=phone2 size=3 class="input" value="<?= $phone[1] ?>">&nbsp;-&nbsp;<input type=text name=phone3 size=3 class="input" value="<?= $phone[2] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Street Address</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=address1 size=25 class="input"  value="<?= $_SESSION["tmp_address1"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;&nbsp;Address2</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=address2 size=25 class="input"  value="<?= $_SESSION["tmp_address2"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;City</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=city size=25 class="input"  value="<?= $_SESSION["tmp_city"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Region / State</td>
					<td  align='left' width=75%> &nbsp;<select name=state class="input"><?= printState(); ?></select><input type=text name=state size=20 class="input"  value="<?= $_SESSION["tmp_state"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Country</td>
					<td  align='left' width=75%> &nbsp;<select name="country" class="input"><option value="US">United States<?= printCountryList(); ?></select></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Zip/Postal Code</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=zipcode size=5 class="input"  value="<?= $_SESSION["tmp_zipcode"] ?>"></td>
				 </tr>
			</table>
		</td>
	</tr> -->



	 <tr>
		<td colspan=4 height=70 align=center><input type=submit value="   <?= $btn_join ?>   "  class="summit_btn"></td>
	 </tr>
	</table>
	<br>
	<br>
	</td>
</tr>
</table>
<!-- BODY END -->
<?
	include _BASE_DIR ."/include/inc_bottom.php";
?>