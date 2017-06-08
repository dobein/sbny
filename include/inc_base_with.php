<?
	$pre_doamin =  $_SERVER['HTTP_HOST'];
	$pre_doamin = str_replace("www.","",$pre_doamin); 
	$c_domain = '.'.$pre_doamin; 

	ini_set("session.cookie_domain", $c_domain);
	ini_set("session.cache_expire", 180); // 세션 유효시간 : 분
	ini_set("session.gc_maxlifetime", 86400); // 세션 가비지 컬렉션(로그인시 세션지속 시간) : 초
	session_start();
    #define('_BASE_DIR', ereg_replace("/include$", "", dirname(__FILE__)));          // 위치한 절대경로
    #define('_WEB_BASE_DIR', ereg_replace(ereg_replace("/$", "", $HTTP_SERVER_VARS[DOCUMENT_ROOT]), '', _BASE_DIR));
	//header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"'); 
	//header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"'); 

	#define('_BASE_DIR', '/homepages/8/d509859345/htdocs');
    #define('_WEB_BASE_DIR', '');
	define('_BASE_DIR', '/homepages/2/d245088082/htdocs');
    define('_WEB_BASE_DIR', '');

	//session_start();

	include _BASE_DIR ."/include/dbconn.php";
	include _BASE_DIR ."/include/c_misc_inc.php";
	include _BASE_DIR ."/include/func_list.php";




	$cookie_name_id = "NOW_DOMAIN";
	SetCookie($cookie_name_id,$pre_doamin,0,"/",$c_domain);


	if(empty($_COOKIE['NOW_DOMAIN']))
	{
		//echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
		//exit;
	}

	//$domain = "germanium.net";


	/*
	$com_qry1 = "select * from chan_shop_category where c_code1 <> '0' && c_code2 = '0' && c_code3 = '0'";
	$com_rst1 = mysql_query($com_qry1);
	while($com_row1 = mysql_fetch_assoc($com_rst1)){
		
		$domain_value .= "<a href="._WEB_BASE_DIR."/choose_domain.php?domain=$com_row1[name]>$com_row1[name]</a>&nbsp;&nbsp;";
	}
	*/

	if($_COOKIE['NOW_DOMAIN'])
	{
		$domain = $_COOKIE['NOW_DOMAIN'];
	}
	else
	{
		$domain = $pre_doamin;
	}

	if(empty($domain)){
		
		$domain = "germanium.net";

	}

	$domainCategory = getCategoryInfo();


	$base_info = getinfo_site_admin($pre_doamin);


	$page_title = $base_info[site_title];
	$meta_desc = $base_info[meta_desc];
	$meta_keyword = $base_info[meta_keyword];


	if($base_info[top_banner])
	{
		$top_logo = "<img src=\""._WEB_BASE_DIR."/upload/".$base_info[top_banner]."\" >";
	}
	else
	{
		$top_logo = "<img src=\""._WEB_BASE_DIR."/images/top_logo.gif\" width=\"163\" height=\"28\">";
	}

	//$bro_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];





	$ip_address = $_SERVER['REMOTE_ADDR'];




	/**
	* @ 로그인 하지 않는 고객을 위해서 temp id 를 만들어준다.
	*/
	if(empty($_COOKIE['TEMP_SHOPID']))
	{
		$temp_cookie = "TEMP_SHOPID";
		
		$keychars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$length = 7;

		// RANDOM KEY GENERATOR
		$randkey = "";
		$max=strlen($keychars)-1;
		for ($i=0;$i<=$length;$i++) {
		  $randkey .= substr($keychars, rand(0, $max), 1);
		}

		// item code 만들기
		$login_info = $randkey.date("d").date("m").date("s").date("y")."K".date("h").date("i");

		$loginTime2 = "0";
		
		SetCookie($temp_cookie,$login_info,$loginTime2,"/");

	}

		if($_SESSION['member_id'])
		{
			$cart_qry1 = "select count(*) as cnt,sum(item_sale*item_qty) as item_last from chan_shop_cart where domain = '$domain' && user_id = '".$_SESSION['member_id']."' order by seq_no asc";
		}
		else
		{
			$cart_qry1 = "select count(*) as cnt,sum(item_sale*item_qty) as item_last from chan_shop_cart where domain = '$domain' && user_id = '".$_COOKIE['TEMP_SHOPID']."' order by seq_no asc";
		}
		//print_r($qry1);

		$cart_rst1 = mysql_query($cart_qry1,$dbConn);
		$cart_top_count = @mysql_result($cart_rst1,0,0);
		$cart_sum_tmp = @mysql_result($cart_rst1,0,1);

		if(empty($cart_sum_tmp)){
			$cart_sum_tmp = "0.00";
		}
		else
		{
			$cart_sum_tmp = $cart_sum_tmp;
		}

		$cart_top_sum = "$".$cart_sum_tmp;



	/*
	** 기본 설정 단어
	* 프랑스어/독일어/일본어/중국어/라틴어/
	*/


	if($domain == "germaniumkr.com" || $domain == "germaniumnara.com")
	{
		$bnt_base_account = "마이 어카운트";
		$bnt_base_cart = "장바구니";
		$bnt_base_logout = "로그아웃";
		$bnt_base_join = "회원가입";


		// 버튼 번역
		$btn_continue_shoppping = "계속 쇼핑하기";
		$btn_checkout = "결제하기";
		$btn_addtocart = "장바구니 담기";
		$btn_login = "로그인";
		$btn_join = "회원가입";
		$btn_search = "찾기";
		$btn_agree = "네, 동의하고 계속 진행합니다.";
		$btn_continue = "계속 진행";
		$btn_pay_now = "주문하기";

		// 회원가입
		$btn_join_title = "아래 입력사항을 정확히 기입해 주십시요.";
		$btn_personal_title = "개인 정보";
		$btn_login_title = "로그인 정보";
		
		$btn_join_firstname = "이름";
		$btn_join_lastname = "성";
		$btn_join_email = "E-mail";
		$btn_join_passwd = "비밀번호";
		$btn_join_passwd2 = "비밀번호 확인";
		$btn_join_newsletter = "뉴스레터";
		$btn_join_newsletter_confirm = "네, 뉴스레터를 받습니다.";

		// 로그인 
		$btn_login_title = "로그인";
		$btn_login_message = "이미 회원가입된 회원이라면<br>아래 이메일과 비밀번호를 입력해주세요.";
		$btn_login_register_title = "회원가입";
		$btn_login_register_message = "신규고객입니다. <a href=join.php><u>회원가입 하기</u></a>";	
		$btn_login_lostid = "아이디/비밀번호를 잊어버리셨나요?&nbsp;&nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>아이디/비밀번호 찾기</u></a>";
	
		// 체크아웃
		$btn_checkout_contact = "연락처 정보";
		$btn_checkout_billing = "결제자 정보";
		$btn_checkout_shipping = "배송지 정보";

		$btn_checkout_email = "이메일주소";
		$btn_checkout_Telephone= "연락처";

		$btn_checkout_name = "이름";

		$btn_checkout_firstname = "이름 (First Name)";
		$btn_checkout_lastname = "성 (Last Name)";
		$btn_checkout_country = "국가";
		$btn_checkout_address = "주소";
		$btn_checkout_address2 = "상세주소";
		$btn_checkout_city = "도시(City)";
		$btn_checkout_state = "도(State)";
		$btn_checkout_zipcode = "우편번호";

		$btn_checkout_disclaimer = "주의사항";
		$btn_checkout_readmust = "주문전에, 아래 환불정책을 꼭 읽어본 후, 동의하신후 진행해 주십시요.";
		$btn_checkout_clickhere = "결제자 정보와 같다면 체크해주세요.";	

		// 체크아웃 쉽핑
		$btn_shipping_summary = "주문내역";
		$btn_shipping_method = "배송방법을 선택하세요.";
		$btn_shipping_comment = "관리자에게 전달할 메모가 있으면 남겨주세요.";
		$btn_shipping_sub_total = "합계";
		$btn_shipping_tax = "세금";
		$btn_shipping_ship = "배송비";
		$btn_shipping_amt = "최종합계";

		$btn_payment_method = "결제방법을 선택해주세요.";

		$btn_payment_credit = "신용카드";
		$btn_payment_wire = "은행송금(미국)";
		$btn_payment_check = "개인수표";

		$btn_order_finish = "주문이 완료되었습니다.";
		$btn_order_num = "주문번호 :";


		// contact us
		$btn_contactus_title1 = "저희는 항상 고객님의 의견을 들을 준비가 되어 있습니다.";
		$btn_contactus_title2 = "질문이 있으시면, 이메일, 우편메일로 연락주세요.";

		$btn_contactus_subject = "제목";
		$btn_contactus_content = "질문내용";

		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=1\">게르마늄이란?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=9\">게르마늄의 안정성</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=10\">게르마늄의 복용방법</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=11\">왜 파우더를 복용해야 하는가?</a><br>";
	}
	else if($domain == "germaniumgermany.com")
	{
		$bnt_base_account = "Anmelden";
		$bnt_base_cart = "Warenkorb";
		$bnt_base_logout = "Logout";
		$bnt_base_join = "REGISTRIEREN SIE SICH";


		$btn_continue_shoppping = "WEITER Einkaufen";
		$btn_checkout = "BESTELLEN";
		$btn_addtocart = "IN DEN WARENKORB";
		$btn_login = "ANMELDEN";
		$btn_join = "MICH REGISTRIEREN";
		$btn_search = "Search";
		$btn_agree = "I agree & Continue";
		$btn_continue = "WEITER";
		$btn_pay_now = "EINKAUF AKZEPTIEREN";


		// 로그인 회원가입
		$btn_join_title = "LEGEN SIE IHREN GERMANIUM-ACCOUNT AN";
		$btn_personal_title = "KUNDENDATEN";
		$btn_login_title = "ZUGANGSDATEN";

		$btn_join_firstname = "Name";
		$btn_join_lastname = "Nachname";
		$btn_join_email = "E-mail";
		$btn_join_passwd = "Passwort";
		$btn_join_passwd2 = "Passwort wiederholen";
		$btn_join_newsletter = "Newsletter";
		$btn_join_newsletter_confirm = "Subscribe";




		// 로그인 
		$btn_login_title = "Registrierter Benutzer";
		$btn_login_message = "Falls Sie ein registrierter Benutzer sind, geben Sie bitte Ihren e-mail und Passwort um Ihren Daten aufzurufen:";
		$btn_login_register_title = "MICH REGISTRIEREN";
		$btn_login_register_message = "Neuer Benutzer <a href=join.php><u>MELDEN SIE SICH AN</u></a>";
		$btn_login_lostid = "Passwort vergessen? &nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>klicken Sie hier</u></a>";




		// 체크아웃
		$btn_checkout_contact = "Contact Information";
		$btn_checkout_billing = "KUNDENDATEN";
		$btn_checkout_shipping = "VERSANDADRESSE";

		$btn_checkout_email = "Email Address";
		$btn_checkout_Telephone= "Handy";

		$btn_checkout_name = "Name";

		$btn_checkout_firstname = "Name";
		$btn_checkout_lastname = "Nachname";
		$btn_checkout_country = "Land";
		$btn_checkout_address = "Wohnort";
		$btn_checkout_address2 = "Wohnort 2";
		$btn_checkout_city = "Stadt";
		$btn_checkout_state = "Bundesland";
		$btn_checkout_zipcode = "Postleitzahl";

		$btn_checkout_disclaimer = "DISCLAIMER";
		$btn_checkout_readmust = "Please read the following return policy information before proceeding";
		$btn_checkout_clickhere = "Check here if same as billing information";


		// 체크아웃 쉽핑
		$btn_shipping_summary = "IHR WARENKORB";
		$btn_shipping_method = "BITTE EINE VERSANDART AUSWÄHLEN";
		$btn_shipping_comment = "Add comments about your order.";
		$btn_shipping_sub_total = "ZWISCHENSUMME";
		$btn_shipping_tax = "Tax";
		$btn_shipping_ship = "Shipping";
		$btn_shipping_amt = "GESAMT";

		$btn_payment_method = "ZAHLUNGSMETHODEN";

		$btn_payment_credit = "Credit Card";
		$btn_payment_wire = "Wire Transfer";
		$btn_payment_check = "Check";


		$btn_order_finish = "Your order has been placed.";
		$btn_order_num = "Your order number: ";


		// contact us
		$btn_contactus_title1 = "We are always interested in hearing about how we can serve you better.";
		$btn_contactus_title2 = "If you have comments or questions, feel free to contact us anytime by email, or regular mail. ";


		$btn_contactus_subject = "Subject";
		$btn_contactus_content = "Comment";


		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=2\">Was ist Germanium?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=3\">Funktionen des Germaniums</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=7\">Wie nimmt man Oxi-Germanium(Pulver) richtig ein?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=8\">Warum muss man Germanium in Form von Pulver einnehmen?</a><br>";
	}
	else if($domain == "germaniumjapan.com")
	{
		$bnt_base_account = "サインイン";
		$bnt_base_cart = "ショッピングカート";
		$bnt_base_logout = "Logout";
		$bnt_base_join = "登録";


		$btn_continue_shoppping = "Continue Shopping";
		$btn_checkout = "Checkout";
		$btn_addtocart = "買い物かごに追加する";
		$btn_login = "サインイン";
		$btn_join = "登録";
		$btn_search = "Search";
		$btn_agree = "I agree & Continue";
		$btn_continue = "Continue";
		$btn_pay_now = "PLACE YOUR ORDER";


		// 로그인 회원가입
		$btn_join_title = "お客様の のアカウントを作成しましょう ";
		$btn_personal_title = "お客様情報";
		$btn_login_title = "アクセスの詳細";

		$btn_join_firstname = "名";
		$btn_join_lastname = "姓";
		$btn_join_email = "E-mail";
		$btn_join_passwd = "パスワード";
		$btn_join_passwd2 = "パスワードの再入力";
		$btn_join_newsletter = "Newsletter";
		$btn_join_newsletter_confirm = "Subscribe";

		// 로그인 
		$btn_login_title = "会員の方";
		$btn_login_message = "ご登録済みのお客様はメールアドレスとパスワードを入力するとデータの回復ができます。";
		$btn_login_register_title = " 新しいユーザー  ";
		$btn_login_register_message = "I am a new customer. <a href=join.php><u>登録する</u></a>";
		$btn_login_lostid = " パスワードをお忘れですか？ &nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>ここをクリックしてください </u></a>";




		// 체크아웃
		$btn_checkout_contact = "以下に、お客様のご連絡先を入力してください。";
		$btn_checkout_billing = "Billing Information";
		$btn_checkout_shipping = "Shipping  Information";

		$btn_checkout_email = "Email Address";
		$btn_checkout_Telephone= "携帯電話";

		$btn_checkout_name = "姓名";

		$btn_checkout_firstname = "名";
		$btn_checkout_lastname = "姓";
		$btn_checkout_country = "国";
		$btn_checkout_address = "住所";
		$btn_checkout_address2 = "住所 2";
		$btn_checkout_city = "市";
		$btn_checkout_state = "国";
		$btn_checkout_zipcode = "郵便番号";

		$btn_checkout_disclaimer = "DISCLAIMER";
		$btn_checkout_readmust = "Please read the following return policy information before proceeding";
		$btn_checkout_clickhere = "Check here if same as billing information";


		// 체크아웃 쉽핑
		$btn_shipping_summary = "お買い物かご";
		$btn_shipping_method = "配送方法を選択";
		$btn_shipping_comment = "Add comments about your order.";
		$btn_shipping_sub_total = "小計";
		$btn_shipping_tax = "Tax";
		$btn_shipping_ship = "Shipping";
		$btn_shipping_amt = "合計";

		$btn_payment_method = "お支払い方法";

		$btn_payment_credit = "Credit Card";
		$btn_payment_wire = "Wire Transfer";
		$btn_payment_check = "Check";


		$btn_order_finish = "Your order has been placed.";
		$btn_order_num = "Your order number : ";

		// contact us
		$btn_contactus_title1 = "の質問に親身にダプハエデウいたします.";
		$btn_contactus_title2 = "回答は2 ? 3日かかる場合があります. ";

		$btn_contactus_subject = "タイトル";
		$btn_contactus_content = "質問内容";

		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=2\">ゲルマニウムとは?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=3\">ゲルマニウムの効果</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=7\">インターフェロンとゲルマニウム</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=8\">ゲルマニウムの有効性および安全性の実験</a><br>";

	}
	else if($domain == "germaniumchina.com")
	{
		$bnt_base_account = "我的账户";
		$bnt_base_cart = "购物车";
		$bnt_base_logout = "Logout";
		$bnt_base_join = "注册会员";

		$btn_continue_shoppping = "继续购物";
		$btn_checkout = "结账";
		$btn_addtocart = "添加到购物篮";
		$btn_login = "登录";
		$btn_join = "点击注册";
		$btn_search = "Search";
		$btn_agree = "I agree & Continue";
		$btn_continue = "Continue";
		$btn_pay_now = "确认购买";



		// 로그인 회원가입
		$btn_join_title = "请立即注册，获取独家折扣。您不仅将收到包含优惠活动和最新资讯的邮件，还能够将心仪的货品加入愿望清单、进行订单追踪并缩短购物流程和时间。";
		$btn_personal_title = "顾客详情";
		$btn_login_title = "我是一名老顾客";

		$btn_join_firstname = "名";
		$btn_join_lastname = "姓";
		$btn_join_email = "电子邮箱";
		$btn_join_passwd = "密码";
		$btn_join_passwd2 = "重新输入密码";
		$btn_join_newsletter = "Newsletter";
		$btn_join_newsletter_confirm = "Subscribe";

		// 로그인 
		$btn_login_title = "注册用户";
		$btn_login_message = "如果你是已注册用户，请输入你的邮件地址及密码来查看你的个人信息。";
		$btn_login_register_title = "新用户";
		$btn_login_register_message = "	 在germanium.com注册可享受众多优惠 <a href=join.php><u>注册</u></a>";
		$btn_login_lostid = "忘记密码？ &nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>点击这里</u></a>";




		// 체크아웃
		$btn_checkout_contact = "顾客详情";
		$btn_checkout_billing = "更改信息";
		$btn_checkout_shipping = "发送地址";

		$btn_checkout_email = "电子邮件";
		$btn_checkout_Telephone= "手机号码";

		$btn_checkout_name = "姓名";

		$btn_checkout_firstname = "名";
		$btn_checkout_lastname = "姓";
		$btn_checkout_country = "Country";
		$btn_checkout_address = "地址";
		$btn_checkout_address2 = "区";
		$btn_checkout_city = "城市";
		$btn_checkout_state = "省/市/县";
		$btn_checkout_zipcode = "邮编";

		$btn_checkout_disclaimer = "DISCLAIMER";
		$btn_checkout_readmust = "Please read the following return policy information before proceeding";
		$btn_checkout_clickhere = "Check here if same as billing information";


		// 체크아웃 쉽핑
		$btn_shipping_summary = "您的购物篮";
		$btn_shipping_method = "选择送货方式";
		$btn_shipping_comment = "Add comments about your order.";
		$btn_shipping_sub_total = "小计";
		$btn_shipping_tax = "Tax";
		$btn_shipping_ship = "Shipping";
		$btn_shipping_amt = "总计金额";

		$btn_payment_method = "付款方式";

		$btn_payment_credit = "Credit Card";
		$btn_payment_wire = "Wire Transfer";
		$btn_payment_check = "Check";


		$btn_order_finish = "Your order has been placed.";
		$btn_order_num = "Your order number : ";


		// contact us
		$btn_contactus_title1 = "我们一直倾听各位顾客的宝贵意见。";
		$btn_contactus_title2 = "若有咨询事项，请用电子邮件或信函联系我们。";


		$btn_contactus_subject = "Subject";
		$btn_contactus_content = "Comment";

		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=2\">何谓锗（Germanium）？</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=3\">锗的效力</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=9\">锗的服用方法</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=10\">为何要服用粉末?</a><br>";
	}
	else if($domain == "germaniumlatin.com")
	{
		$bnt_base_account = "INICIAR SESIÓN";
		$bnt_base_cart = "Bolsa";
		$bnt_base_logout = "Logout";
		$bnt_base_join = "REGÍSTRATE";


		$btn_continue_shoppping = "SEGUIR DE SHOPPING";
		$btn_checkout = "Comprar";
		$btn_addtocart = "Añadir a la bolsa";
		$btn_login = "INICIAR SESIÓN";
		$btn_join = "REGÍSTRATE";
		$btn_search = "búsqueda";
		$btn_agree = "Acordar & Continuar";
		$btn_continue = "Continuar";
		$btn_pay_now = "PLACE YOUR ORDER";


		// 로그인 회원가입
		$btn_join_title = "CREA TU CUENTA EN GermaniumLatin.com ";
		$btn_personal_title = "Personal Information";
		$btn_login_title = "Usuario registrado";

		$btn_join_firstname = "Nombre";
		$btn_join_lastname = "Primer apellido";
		$btn_join_email = "E-mail";
		$btn_join_passwd = "Contraseña";
		$btn_join_passwd2 = "Repetir contraseña";
		$btn_join_newsletter = "Newsletter";
		$btn_join_newsletter_confirm = "Subscribe";

		// 로그인 
		$btn_login_title = "Sign In";
		$btn_login_message = "If you're already registered<br>please sign in using your login id and your password.";
		$btn_login_register_title = " Nuevo usuario";
		$btn_login_register_message = "Registrarse en germaniumlatin.com tiene muchas ventajas: <a href=join.php><u>Registrarse</u></a>";
		$btn_login_lostid = "Has olvidado tu contraseña? &nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>click here</u></a>";




		// 체크아웃
		$btn_checkout_contact = "Contacto información";
		$btn_checkout_billing = "Facturación información";
		$btn_checkout_shipping = "Envío  información";

		$btn_checkout_email = "Email Address";
		$btn_checkout_Telephone= "Móvil";

		$btn_checkout_name = "Nombre";

		$btn_checkout_firstname = "Nombre";
		$btn_checkout_lastname = "Primer apellido";
		$btn_checkout_country = "País";
		$btn_checkout_address = "Dirección";
		$btn_checkout_address2 = "Dirección 2";
		$btn_checkout_city = "Población";
		$btn_checkout_state = "Provincia";
		$btn_checkout_zipcode = "Código postal";

		$btn_checkout_disclaimer = "DISCLAIMER";
		$btn_checkout_readmust = "Please read the following return policy information before proceeding";
		$btn_checkout_clickhere = "Check here if same as billing information";


		// 체크아웃 쉽핑
		$btn_shipping_summary = "Your order summary";
		$btn_shipping_method = "SELECCIONA UN MÉTODO DE ENVÍO";
		$btn_shipping_comment = "Add comments about your order.";
		$btn_shipping_sub_total = "Sub total";
		$btn_shipping_tax = "Tax";
		$btn_shipping_ship = "Shipping";
		$btn_shipping_amt = "Total Amount";

		$btn_payment_method = "Pay method";

		$btn_payment_credit = "Credit Card";
		$btn_payment_wire = "Wire Transfer";
		$btn_payment_check = "Check";


		$btn_order_finish = "Your order has been placed.";
		$btn_order_num = "Your order number : ";

		// contact us
		$btn_contactus_title1 = "We are always interested in hearing about how we can serve you better.";
		$btn_contactus_title2 = "If you have comments or questions, feel free to contact us anytime by email, or regular mail. ";
	
		$btn_contactus_subject = "Subject";
		$btn_contactus_content = "Comment";


		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=2\">¿Qué es el germanio?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=5\">Datos de eficacia y la seguridad del germanio</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=7\">Cómo tomar el germanio</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=8\">¿Por qué hay que tomar polvo?</a><br>";
	}
	else if($domain == "germaniumfrance.com")
	{
		$bnt_base_account = "Mon compte";
		$bnt_base_cart = "Panier";
		$bnt_base_logout = "Quitter";
		$bnt_base_join = "ENREGISTREMENT";


		$btn_continue_shoppping = "CONTINUER VOTRE SHOPPING";
		$btn_checkout = "ACHETER";
		$btn_addtocart = "Ajouter au panier";
		$btn_login = "Login";
		$btn_join = "ENREGISTREMENT";
		$btn_search = "Search";
		$btn_agree = "I agree & Continue";
		$btn_continue = "CONTINUER";
		$btn_pay_now = "ACHETER";


		// 로그인 회원가입
		$btn_join_title = "Please enter the following information, and keep a record of it. ";
		$btn_personal_title = "Personal Information";
		$btn_login_title = "Login Information";

		$btn_join_firstname = "Prénom";
		$btn_join_lastname = "Nom";
		$btn_join_email = "E-mail";
		$btn_join_passwd = "Mot de passe";
		$btn_join_passwd2 = "Répéter mot de passe";
		$btn_join_newsletter = "Newsletter";
		$btn_join_newsletter_confirm = "Subscribe";

		// 로그인 
		$btn_login_title = "Vous avez déjà un compte ";
		$btn_login_message = "Si vous êtes déjà cliente, introduisez votre Email et votre mot de passe pour accéder à vos coordonnées. ";
		$btn_login_register_title = "Créez votre compte ";
		$btn_login_register_message = "I am a new customer. <a href=join.php><u>Create a New Account.</u></a>";
		$btn_login_lostid = " Vous avez oublié votre mot de passe  ? &nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>Inscrivez votre e-mail et cliquez ici </u></a>";




		// 체크아웃
		$btn_checkout_contact = "Contact Information";
		$btn_checkout_billing = "Données de client ";
		$btn_checkout_shipping = "Adresse d'envoi ";

		$btn_checkout_email = "Email Address";
		$btn_checkout_Telephone= "Téléphone portable";

		$btn_checkout_name = "Nom";

		$btn_checkout_firstname = "Prénom";
		$btn_checkout_lastname = "Nom";
		$btn_checkout_country = "Pays";
		$btn_checkout_address = "Adresse";
		$btn_checkout_address2 = "Adresse 2";
		$btn_checkout_city = "Ville";
		$btn_checkout_state = "Département";
		$btn_checkout_zipcode = "Code postal";

		$btn_checkout_disclaimer = "DISCLAIMER";
		$btn_checkout_readmust = "Please read the following return policy information before proceeding";
		$btn_checkout_clickhere = "Check here if same as billing information";


		// 체크아웃 쉽핑
		$btn_shipping_summary = "VOTRE PANIER";
		$btn_shipping_method = "SÉLECTIONNEZ UN MODE DE LIVRAISON";
		$btn_shipping_comment = "Add comments about your order.";
		$btn_shipping_sub_total = "SOUS-TOTAL";
		$btn_shipping_tax = "Tax";
		$btn_shipping_ship = "Shipping";
		$btn_shipping_amt = "Montant total";

		$btn_payment_method = "MODES DE PAIEMENT";

		$btn_payment_credit = "Credit Card";
		$btn_payment_wire = "Wire Transfer";
		$btn_payment_check = "Check";


		$btn_order_finish = "Votre commande a été passée.";
		$btn_order_num = "Your order number : ";

		// contact us
		$btn_contactus_title1 = "We are always interested in hearing about how we can serve you better.";
		$btn_contactus_title2 = "If you have comments or questions, feel free to contact us anytime by email, or regular mail. ";
	
		$btn_contactus_subject = "Subject";
		$btn_contactus_content = "Comment";

		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=2\">Qu’est-ce que le germanium ?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=3\">Les effets du germanium</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=10\">Pourquoi en poudre ?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=11\">Qui a besoin du germanium ?</a><br>";
	}
	else
	{
		$bnt_base_account = "My Account";
		$bnt_base_cart = "Shopping Cart";
		$bnt_base_logout = "Logout";
		$bnt_base_join = "Join Us";


		$btn_continue_shoppping = "Continue Shopping";
		$btn_checkout = "Checkout";
		$btn_addtocart = "Add to cart";
		$btn_login = "Login";
		$btn_join = "Join";
		$btn_search = "Search";
		$btn_agree = "I agree & Continue";
		$btn_continue = "Continue";
		$btn_pay_now = "PLACE YOUR ORDER";


		// 로그인 회원가입
		$btn_join_title = "Please enter the following information, and keep a record of it. ";
		$btn_personal_title = "Personal Information";
		$btn_login_title = "Login Information";

		$btn_join_firstname = "First Name";
		$btn_join_lastname = "Last Nmae";
		$btn_join_email = "E-mail";
		$btn_join_passwd = "Password";
		$btn_join_passwd2 = "Confirm Password";
		$btn_join_newsletter = "Newsletter";
		$btn_join_newsletter_confirm = "Subscribe";

		// 로그인 
		$btn_login_title = "Sign In";
		$btn_login_message = "If you're already registered<br>please sign in using your login id and your password.";
		$btn_login_register_title = "Register";
		$btn_login_register_message = "I am a new customer. <a href=join.php><u>Create a New Account.</u></a>";
		$btn_login_lostid = "Have you forgotten your password? &nbsp;&nbsp;<a href=\"javascript:looking_id()\" ><u>click here</u></a>";




		// 체크아웃
		$btn_checkout_contact = "Contact Information";
		$btn_checkout_billing = "Billing Information";
		$btn_checkout_shipping = "Shipping  Information";

		$btn_checkout_email = "Email Address";
		$btn_checkout_Telephone= "Telephone";

		$btn_checkout_name = "Name";

		$btn_checkout_firstname = "First Name";
		$btn_checkout_lastname = "Last Name";
		$btn_checkout_country = "Country";
		$btn_checkout_address = "Address";
		$btn_checkout_address2 = "Address2";
		$btn_checkout_city = "City";
		$btn_checkout_state = "State";
		$btn_checkout_zipcode = "Zipcode";

		$btn_checkout_disclaimer = "DISCLAIMER";
		$btn_checkout_readmust = "Please read the following return policy information before proceeding";
		$btn_checkout_clickhere = "Check here if same as billing information";


		// 체크아웃 쉽핑
		$btn_shipping_summary = "Your order summary";
		$btn_shipping_method = "Choose your shipping method.";
		$btn_shipping_comment = "Add comments about your order.";
		$btn_shipping_sub_total = "Sub total";
		$btn_shipping_tax = "Tax";
		$btn_shipping_ship = "Shipping";
		$btn_shipping_amt = "Total Amount";

		$btn_payment_method = "Pay method";

		$btn_payment_credit = "Credit Card";
		$btn_payment_wire = "Wire Transfer";
		$btn_payment_check = "Check";


		$btn_order_finish = "Your order has been placed.";
		$btn_order_num = "Your order number : ";

		// contact us
		$btn_contactus_title1 = "We are always interested in hearing about how we can serve you better.";
		$btn_contactus_title2 = "If you have comments or questions, feel free to contact us anytime by email, or regular mail. ";
	
		$btn_contactus_subject = "Subject";
		$btn_contactus_content = "Comment";

		$germanium_article1 = "- <a href=\"germanium.php?c_code2=2&c_code3=3\">What is Germanium ?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=4\">Safety of Germanium ?</a><br>
										- <a href=\"book_view.php\">Related books to germanium</a><br>";

		$germanium_article2 = "- <a href=\"germanium.php?c_code2=2&c_code3=6\">How to take organic germanium power?</a><br>
										- <a href=\"germanium.php?c_code2=2&c_code3=7\">Why must germanium be taken in powder?</a><br>";
	}

	

?>
