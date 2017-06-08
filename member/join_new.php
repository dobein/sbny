<?
	include "../include/inc_base.php";

	session_start();

	$tableName = "chan_shop_member";


	if($mode == "save")
	{
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


		$captcha = @$_POST['ct_captcha']; 

	  require_once dirname(__FILE__) . '/securimage.php';
	  $securimage = new Securimage();

	  if ($securimage->check($captcha) == false) {

			Misc::jvAlert("Incorrect security code entered","location.replace('join_new.php')");
			exit;
	  }

		echo "good!";


	exit;


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

		$pre_qry1 = "select * from $tableName where member_id = '$user_id'";
		$pre_rst1 = mysql_query($pre_qry1,$dbConn);
		$pre_num1 = mysql_affected_rows();
		if($pre_num1>0)
		{
			Misc::jvAlert("Duplicate your ID!.","history.go(-1)");
			exit;
		}
	
		$level = "9";
		$save_money = $base_info[point_join];

		$cell_phone = $cell_phone1."-".$cell_phone2."-".$cell_phone3;
		$home_phone = $phone1."-".$phone2."-".$phone3;
		
		//$corp_phone = $corp_phone1."-".$corp_phone2."-".$corp_phone3;

		//$birth_day = $dob_year."-".$dob_month."-".$dob_day;

		if(empty($mail_flag)){
			
			$mail_flag = "NO";

		}

		$qry1 = "insert into chan_shop_member values ('','$user_id','$passwd','$level','$save_money','$name_first','$name_last','$user_id','$tax_id','$birth_day','$address1','$address2','$city','$state','$zipcode','$country','$phone_flag','$cell_phone','$home_phone','$corp_phone',now(),'$mail_flag','$memo','','','')";
		$rst1 = mysql_query($qry1,$dbConn);


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
				$login_qry1 = "update chan_shop_cart set user_id = '$user_id' where user_id = '$HTTP_COOKIE_VARS[TEMP_SHOPID]'";
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
				$login_qry1 = "update chan_shop_cart set user_id = '$user_id' where user_id = '$HTTP_COOKIE_VARS[TEMP_SHOPID]'";
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
				
				$mail_title = "Welcome $base_info[site_name]";

				$mailStr .= "
				<table width=600 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td colspan=2><a href=http://www.urbanbutterflyny.com target=_blank><img src=http://www.urbanbutterflyny.com/images/urban_logo.jpg border=0></a></td>
					</tr>
					<tr> 
						<td colspan=2>Dear $name_first $name_last</td>
					</tr>
					<tr> 
						<td colspan=2 height=40>Thank you for becoming a registered member at urbanbutterflyny.com</td>
					</tr>
					<tr> 
						<td colspan=2 height=20>User account information</td>
					</tr>
					<tr> 
						<td width=200 height=20>Email:</td>
						<td width=400>$user_id</td>
					</tr>
					<tr> 
						<td width=200 height=20>Password:</td>
						<td width=400>$passwd</td>
					</tr>
					<tr> 
						<td width=200 height=20>Login URL:</td>
						<td width=400>http://www.urbanbutterflyny.com</td>
					</tr>
					<tr> 
						<td height=40 colspan=2>Thank you for shopping at urbanbutterflyny.com</td>
					</tr>
					<tr> 
						<td height=40 colspan=2 >info@urbanbutterflyny.com<br>646.942.6716</td>
					</tr>
				</table>";

				$mail_result = mail($user_id, $mail_title, $mailStr, $headers);


				$admin_title = "Member Join Notification!";

				//$mail_result2 = mail($base_info[site_email], $admin_title, $mailStr, $headers);

				echo "<meta http-equiv='refresh' content='0; url=./join_completed.php?email=$user_id'>";
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
			<table width="960" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="33" style="padding-left:12px;"><img src="<?= _WEB_BASE_DIR ?>/images/ico_home.gif" align="absmiddle"> &nbsp; Home  >  <span class="b">CREATE AN ACCOUNT</span></td>
				</tr>
				<tr>
					<td height="1" bgcolor="#eeeeee"></td>
				</tr>
				<tr>
					<td height="5"></td>
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
<form action=<?= $PHP_SELF ?> method=post name=join onSubmit="return mem_chk(this)">
<input type=hidden name=mode value="save">
<input type=hidden name=action value="<?= $action ?>">
	  <tr>
		<td colspan=4 height=45 align=left>&nbsp;&nbsp;Please enter the following information, and keep a record of it. </td>
	  </tr>
	 <tr>
		<td  align="left" height="20" colspan=4>&nbsp;&nbsp;</td>
	 </tr>
	 <tr>
		<td width=50% valign=top colspan=2>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Personal Information</td>
				</tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;E-mail</td>
					<td  align='left' width=75%> &nbsp;<input name="user_id" type="text" class="input" size="25" onblur="show_data(this.value);" value="<?= $_SESSION["tmp_user_id"] ?>">&nbsp;&nbsp;<span id=id_msg></span></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;First Name</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=name_first size=25 class="input"  value="<?= $_SESSION["tmp_name_first"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Last Name</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=name_last size=25 class="input"  value="<?= $_SESSION["tmp_name_last"] ?>"></td>
				 </tr>

				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Tax ID </td>
					<td  align='left' width=75%> &nbsp;<input type=text name=tax_id size=25 class="input"  value="<?= $_SESSION["tmp_tax_id"] ?>"></td>
				 </tr>

			</table>
			<br>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Login Information</td>
				</tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Password</td>
					<td  align='left' width=75%> &nbsp;<input type=password name=passwd size=20 class="input" ></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Confirm Password</td>
					<td  align='left' width=75%> &nbsp;<input type=password name=passwd2 size=20 class="input" ></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Newsletter</td>
					<td  align='left' width=75%> &nbsp;<input type=checkbox name=mail_flag value="YES" class="input" checked> Subscribe</td>
				 </tr>
			</table>
		</td>
		<td width=50% valign=top colspan=2>
			<table width="100%" align=center border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan=2>&nbsp;<span style="font-size:12pt;font-weight:bold">Address Information</td>
				</tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Company</td>
					<td align='left' width=75%> &nbsp;<input type=text name=birth_day size=35 class="input"  value="<?= $_SESSION["tmp_birth_day"] ?>"></td>
				 </tr>
				 <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Telephone</td>
					<td align='left' width=75%> &nbsp;<input type=text name=cell_phone1 size=3 class="input"  value="<?= $_SESSION["tmp_cell_phone1"] ?>">&nbsp;-&nbsp;<input type=text name=cell_phone2 size=3 class="input"  value="<?= $_SESSION["tmp_cell_phone2"] ?>">&nbsp;-&nbsp;<input type=text name=cell_phone3 size=3 class="input"  value="<?= $_SESSION["tmp_cell_phone3"] ?>"></td>
				 </tr>
				 <!-- <tr>
					<td align="left" height="30" class=d8 width=25%>&nbsp;&nbsp;&nbsp;Company Phone</td>
					<td align='left' width=75%> &nbsp;<input type=text name=phone1 size=3 class="input" value="<?= $phone[0] ?>">&nbsp;-&nbsp;<input type=text name=phone2 size=3 class="input" value="<?= $phone[1] ?>">&nbsp;-&nbsp;<input type=text name=phone3 size=3 class="input" value="<?= $phone[2] ?>"></td>
				 </tr> -->
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
					<td  align='left' width=75%> &nbsp;<!-- <select name=state class="input"><?= printState(); ?></select> --><input type=text name=state size=20 class="input"  value="<?= $_SESSION["tmp_state"] ?>"></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Country</td>
					<td  align='left' width=75%> &nbsp;<select name="country" class="input">
                <option value="US">US - UNITED STATES </option>
				<option value="US-HAW">US - UNITED STATES (Hawaii)</option>
				<option value="US-PU">US - UNITED STATES (Puertorico)</option>
                <option value="CA">CA - CANADA </option>
                <option value="AD">AD - ANDORRA </option>
                <option value="AE">AE - UNITED ARAB EMIRATES </option>
                <option value="AF">AF - AFGHANISTAN </option>
                <option value="AG">AG - ANTIGUA AND BARBUDA </option>
                <option value="AI">AI - ANGUILLA </option>
                <option value="AL">AL - ALBANIA </option>
                <option value="AM">AM - ARMENIA </option>
                <option value="AN">AN - NETHERLANDS ANTILLES </option>
                <option value="AO">AO - ANGOLA </option>
                <option value="AR">AR - ARGENTINA </option>
                <option value="AS">AS - AMERICAN SAMOA </option>
                <option value="AT">AT - AUSTRIA </option>
                <option value="AU">AU - AUSTRALIA </option>
                <option value="AW">AW - ARUBA </option>
                <option value="AZ">AZ - AZERBAIJAN </option>
                <option value="BA">BA - BOSNIA AND HERZEGOWINA </option>
                <option value="BB">BB - BARBADOS </option>
                <option value="BD">BD - BANGLADESH </option>
                <option value="BE">BE - BELGIUM </option>
                <option value="BG">BG - BULGARIA </option>
                <option value="BH">BH - BAHRAIN </option>
                <option value="BI">BI - BURUNDI </option>
                <option value="BJ">BJ - BENIN </option>
                <option value="BM">BM - BERMUDA </option>
                <option value="BN">BN - BRUNEI DARUSSALAM </option>
                <option value="BO">BO - BOLIVIA </option>
                <option value="BR">BR - BRAZIL </option>
                <option value="BS">BS - BAHAMAS </option>
                <option value="BT">BT - BHUTAN </option>
                <option value="BW">BW - BOTSWANA </option>
                <option value="BY">BY - BELARUS </option>
                <option value="BZ">BZ - BELIZE </option>
                <option value="CF">CF - CENTRAL AFRICAN REPUBLIC </option>
                <option value="CG">CG - CONGO </option>
                <option value="CH">CH - SWITZERLAND </option>
                <option value="CI">CI - COTE D'IVOIRE </option>
                <option value="CK">CK - COOK ISLANDS </option>
                <option value="CL">CL - CHILE </option>
                <option value="CM">CM - CAMEROON </option>
                <option value="CN">CN - CHINA </option>
                <option value="CO">CO - COLOMBIA </option>
                <option value="CR">CR - COSTA RICA </option>
                <option value="CU">CU - CUBA </option>
                <option value="CV">CV - CAPE VERDE </option>
                <option value="CY">CY - CYPRUS </option>
                <option value="CZ">CZ - CZECH REPUBLIC </option>
                <option value="DE">DE - GERMANY </option>
                <option value="DJ">DJ - DJIBOUTI </option>
                <option value="DK">DK - DENMARK </option>
                <option value="DM">DM - DOMINICA </option>
                <option value="DO">DO - DOMINICAN REPUBLIC </option>
                <option value="DZ">DZ - ALGERIA </option>
                <option value="EC">EC - ECUADOR </option>
                <option value="EE">EE - ESTONIA </option>
                <option value="EG">EG - EGYPT </option>
                <option value="EH">EH - WESTERN SAHARA </option>
                <option value="ER">ER - ERITREA </option>
                <option value="ES">ES - SPAIN </option>
                <option value="ET">ET - ETHIOPIA </option>
                <option value="FI">FI - FINLAND </option>
                <option value="FJ">FJ - FIJI </option>
                <option value="FK">FK - FALKLAND ISLANDS </option>
                <option value="FM">FM - MICRONESIA, FEDERATED STATES OF </option>
                <option value="FR">FR - FRANCE </option>
                <option value="GA">GA - GABON </option>
                <option value="GB">GB - UNITED KINGDOM </option>
                <option value="GD">GD - GRENADA </option>
                <option value="GE">GE - GEORGIA </option>
                <option value="GF">GF - FRENCH GUIANA </option>
                <option value="GH">GH - GHANA </option>
                <option value="GI">GI - GIBRALTAR </option>
                <option value="GL">GL - GREENLAND </option>
                <option value="GM">GM - GAMBIA </option>
                <option value="GN">GN - GUINEA </option>
                <option value="GP">GP - GUADELOUPE </option>
                <option value="GQ">GQ - EQUATORIAL GUINEA </option>
                <option value="GR">GR - GREECE </option>
                <option value="GT">GT - GUATEMALA </option>
                <option value="GU">GU - GUAM </option>
                <option value="GW">GW - GUINEA-BISSAU </option>
                <option value="GY">GY - GUYANA </option>
                <option value="HK">HK - HONG KONG </option>
                <option value="HN">HN - HONDURAS </option>
                <option value="HR">HR - CROATIA </option>
                <option value="HT">HT - HAITI </option>
                <option value="HU">HU - HUNGARY </option>
                <option value="ID">ID - INDONESIA </option>
                <option value="IE">IE - IRELAND </option>
                <option value="IL">IL - ISRAEL </option>
                <option value="IN">IN - INDIA </option>
                <option value="IS">IS - ICELAND </option>
                <option value="IT">IT - ITALY </option>
                <option value="JM">JM - JAMAICA </option>
                <option value="JO">JO - JORDAN </option>
                <option value="JP">JP - JAPAN </option>
                <option value="KE">KE - KENYA </option>
                <option value="KG">KG - KYRGYZSTAN </option>
                <option value="KH">KH - CAMBODIA </option>
                <option value="KI">KI - KIRIBATI </option>
                <option value="KM">KM - COMOROS </option>
                <option value="KP">KP - KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF 
                </option>
                <option value="KR" >KR - KOREA, REPUBLIC OF </option>
                <option value="KW">KW - KUWAIT </option>
                <option value="KY">KY - CAYMAN ISLANDS </option>
                <option value="KZ">KZ - KAZAKHSTAN </option>
                <option value="LA">LA - LAO PEOPLE'S DEMOCRATIC REPUBLIC </option>
                <option value="LB">LB - LEBANON </option>
                <option value="LC">LC - SAINT LUCIA </option>
                <option value="LI">LI - LIECHTENSTEIN </option>
                <option value="LK">LK - SRI LANKA </option>
                <option value="LR">LR - LIBERIA </option>
                <option value="LT">LT - LITHUANIA </option>
                <option value="LU">LU - LUXEMBOURG </option>
                <option value="LV">LV - LATVIA </option>
                <option value="MA">MA - MOROCCO </option>
                <option value="MC">MC - MONACO </option>
                <option value="MD">MD - MOLDOVA, REPUBLIC OF </option>
                <option value="MG">MG - MADAGASCAR </option>
                <option value="MH">MH - MARSHALL ISLANDS </option>
                <option value="MK">MK - MACEDONIA, FORMER YUGOSLAV REPUBLIC OF 
                </option>
                <option value="ML">ML - MALI </option>
                <option value="MN">MN - MONGOLIA </option>
                <option value="MO">MO - MACAU </option>
                <option value="MP">MP - NORTHERN MARIANA ISLANDS </option>
                <option value="MQ">MQ - MARTINIQUE </option>
                <option value="MR">MR - MAURITANIA </option>
                <option value="MS">MS - MONTSERRAT </option>
                <option value="MT">MT - MALTA </option>
                <option value="MU">MU - MAURITIUS </option>
                <option value="MV">MV - MALDIVES </option>
                <option value="MW">MW - MALAWI </option>
                <option value="MX">MX - MEXICO </option>
                <option value="MY">MY - MALAYSIA </option>
                <option value="MZ">MZ - MOZAMBIQUE </option>
                <option value="NA">NA - NAMIBIA </option>
                <option value="NC">NC - NEW CALEDONIA </option>
                <option value="NE">NE - NIGER </option>
                <option value="NF">NF - NORFOLK ISLAND </option>
                <option value="NG">NG - NIGERIA </option>
                <option value="NI">NI - NICARAGUA </option>
                <option value="NL">NL - NETHERLANDS </option>
                <option value="NO">NO - NORWAY </option>
                <option value="NP">NP - NEPAL </option>
                <option value="NR">NR - NAURU </option>
                <option value="NZ">NZ - NEW ZEALAND </option>
                <option value="OM">OM - OMAN </option>
                <option value="PA">PA - PANAMA </option>
                <option value="PE">PE - PERU </option>
                <option value="PF">PF - FRENCH POLYNESIA </option>
                <option value="PG">PG - PAPUA NEW GUINEA </option>
                <option value="PH">PH - PHILIPPINES </option>
                <option value="PK">PK - PAKISTAN </option>
                <option value="PL">PL - POLAND </option>
                <option value="PR">PR - PUERTO RICO </option>
                <option value="PT">PT - PORTUGAL </option>
                <option value="PY">PY - PARAGUAY </option>
                <option value="QA">QA - QATAR </option>
                <option value="RO">RO - ROMANIA </option>
                <option value="RU">RU - RUSSIAN FEDERATION </option>
                <option value="RW">RW - RWANDA </option>
                <option value="SA">SA - SAUDI ARABIA </option>
                <option value="SC">SC - SEYCHELLES </option>
                <option value="SD">SD - SUDAN </option>
                <option value="SE">SE - SWEDEN </option>
                <option value="SG">SG - SINGAPORE </option>
                <option value="SI">SI - SLOVENIA </option>
                <option value="SK">SK - SLOVAKIA (Slovak Republic) </option>
                <option value="SL">SL - SIERRA LEONE </option>
                <option value="SM">SM - SAN MARINO </option>
                <option value="SN">SN - SENEGAL </option>
                <option value="SO">SO - SOMALIA </option>
                <option value="SR">SR - SURINAME </option>
                <option value="ST">ST - SAO TOME AND PRINCIPE </option>
                <option value="SV">SV - EL SALVADOR </option>
                <option value="SY">SY - SYRIAN ARAB REPUBLIC </option>
                <option value="SZ">SZ - SWAZILAND </option>
                <option value="TD">TD - CHAD </option>
                <option value="TG">TG - TOGO </option>
                <option value="TH">TH - THAILAND </option>
                <option value="TJ">TJ - TAJIKISTAN </option>
                <option value="TM">TM - TURKMENISTAN </option>
                <option value="TN">TN - TUNISIA </option>
                <option value="TO">TO - TONGA </option>
                <option value="TP">TP - EAST TIMOR </option>
                <option value="TR">TR - TURKEY </option>
                <option value="TT">TT - TRINIDAD AND TOBAGO </option>
                <option value="TV">TV - TUVALU </option>
                <option value="TW">TW - TAIWAN, PROVINCE OF CHINA </option>
                <option value="TZ">TZ - TANZANIA, UNITED REPUBLIC OF </option>
                <option value="UA">UA - UKRAINE </option>
                <option value="UG">UG - UGANDA </option>
                <option value="UM">UM - UNITED STATES MINOR OUTLYING ISLANDS </option>
                <option value="UY">UY - URUGUAY </option>
                <option value="UZ">UZ - UZBEKISTAN </option>
                <option value="VA">VA - VATICAN CITY STATE (HOLY SEE) </option>
                <option value="VC">VC - SAINT VINCENT AND THE GRENADINES </option>
                <option value="VE">VE - VENEZUELA </option>
                <option value="VG">VG - VIRGIN ISLANDS (BRITISH) </option>
                <option value="VI">VI - VIRGIN ISLANDS (U.S.) </option>
                <option value="VN">VN - VIET NAM </option>
                <option value="VU">VU - VANUATU </option>
                <option value="WS">WS - SAMOA </option>
                <option value="YE">YE - YEMEN, REPUBLIC OF </option>
                <option value="YU">YU - YUGOSLAVIA </option>
                <option value="ZA">ZA - SOUTH AFRICA </option>
                <option value="ZM">ZM - ZAMBIA </option>
                <option value="ZR">ZR - ZAIRE </option>
                <option value="ZW">ZW - ZIMBABWE</option>
              </select></td>
				 </tr>
				 <tr>
					<td  align="left" height="30" width=25%>&nbsp;&nbsp;<font class=pink>*</font>&nbsp;Zip/Postal Code</td>
					<td  align='left' width=75%> &nbsp;<input type=text name=zipcode size=5 class="input"  value="<?= $_SESSION["tmp_zipcode"] ?>"></td>
				 </tr>
			</table>
		</td>
	</tr>

	<tr><td colspan=4 height=30>&nbsp;</td></tr>
	 <tr>
		<td  align="left" height="30" colspan=4>
    <img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="./securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />
    <object type="application/x-shockwave-flash" data="./securimage_play.swf?bgcol=#ffffff&amp;icon_file=./images/audio_icon.png&amp;audio_file=./securimage_play.php" height="32" width="32">
    <param name="movie" value="./securimage_play.swf?bgcol=#ffffff&amp;icon_file=./images/audio_icon.png&amp;audio_file=./securimage_play.php" />
    </object>
    &nbsp;
    <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = './securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="./images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a><br />
    <strong>Enter Code*:</strong><br />
     <?php echo @$_SESSION['ctform']['captcha_error'] ?>
    <input type="text" name="ct_captcha" size="12" maxlength="16" />
  </p>		
		</td>
	 </tr>

	 <tr>
		<td colspan=4 height=70 align=center><input type=submit value="   REGISTER   "  class="summit_btn"></td>
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