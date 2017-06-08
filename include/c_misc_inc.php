<?php

/**
* class Misc
* 기타 유용한 것을 두서없이 만듦
* class 로 만드는 것이 대부분 비효율적이지만 api 문서 작성 위해 만듦.
* @access public
* @package util
*/

class Misc {
	
	
	/**
	* 쿠키 굽기	
	* 자바 스크립트 출력은 임시로 작성되어서 다시 코딩되어야함.
	* $expire 파라미터에 주의 :  현재시간부터 추가될 시간(초단위) 으로 설정한다.
	* 자바스크립트로 출력할때로 php로 사용할때가 다름.
	* @access public
	* @param stirng $name
	* @param string $value
	* @param int $expire 현재시간부터 쿠키가 소멸될 시간(초단위)
	* 
	*
	*/
	
 function setCookie($name, $value = '', $expire = 0, $path = '', $domain= '', $secure = 0) {
          if (headers_sent()) {           // 이미 헤더가 출력되었으면 자바스크립트로 굽는다.
             			$value = urlencode($value);
                        $expire = $expire * 1000;               // 자바스크립트는 밀리세컨즈 단위
                        $optionString = '';
                        if (!empty($path)) {
                                $optionString .= ";path=$path";
                        }
                        if (!empty($domain)) {
                                $optionString .= ";domain=$domain";
                        }
                        if ($secure) {
                                $optionString .= ";secure=$secure";
                        }
                        if (!empty($optionString)) {
                                $optionJS = "document.cookie += \"$optionString\";";
                        }
                        echo "<Script Language='JavaScript'>
                                        document.cookie=\"$name={$value}\";";
                        if($expire !=0) {
                                echo "var today = new Date();
                                          var expire = new Date(today.getTime() + $expire);
                                          document.cookie +=\";expires=\" + expire.toGMTString();";

                        }
                        echo $optionJS;
                        echo "</Script>";

                } else {
                        if ($expire != 0) {
                                setcookie($name, $value, time()+$expire, $path, $domain, $secure);
                        } else {
                                setcookie($name, $value, $expire, $path, $domain, $secure);
                        }
                }
        }
	
	/** 
	* 전자우편 체크
	* @access public
	* @param string $email  체크할 전자우편 주소
	* @return boolean
	*/
	
	function checkEmail($email) {
		if (!eregi("^[^@ ]+@[a-zA-Z0-9\-]+\.+[a-zA-Z0-9\-]", $email)) {
			return false;
  		}
  		/* 한글이 포함되었는지 체크 */
    	for($i = 1; $i <= strlen($email); $i++) {
			if ((Ord(substr("$email", $i - 1, $i)) & 0x80)) {
		    	return false;
			}
    	}
    	return true;
	}
	
	
	/**
	* java script alert 출력
	* 자바스크립트로 리턴값 없이 바로 사용자 브라우져로 출력한다.
	* @access public
	* @param string $msg 자바스크립트 alert()로 출력할 메세지
	* @param string $nextCmd alert()이후 자바스크립트 명령
	*/
	
	function jvAlert($msg, $nextCmd = '') {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
  				<Script Language='JavaScript'>
  					alert(\"$msg\");
  					$nextCmd;
  				</Script> \n";
	}	// end of function jvAlert
	
	
	
	/**
	* url redirect 헤더가 출력된경우와 아닌경우
	* 헤더가 출력된 경우 자바 스크립트로 처리
	* $replace가 true인 경우 자바스크립트 location.replace()함수 사용
	* @access public
	* @param $url	이동할 주소
	* @param $replace true일때 자바스크립트 location.replace()함수 사용
	*/
	
	function redirectUrl($url, $replace = false) {
		
		if ($replace) {
			echo "<Script Language='JavaScript'>
					location.replace('{$url}');
				</Script>";	
		} else {
			if (headers_sent()) {
				echo "<Script Language='JavaScript'>
						location.href='{$url}';
					</Script>";				
			} else {
				header("Location:{$url}");
			}
		}	
	
	}
	
	// 파일 다운로드	
	function fileDownload($fileDir='.', $fileName, $realFileName='') {
		global $HTTP_USER_AGENT;
		
		$fileDir = ereg_replace("/$", "", $fileDir);
		$fileDir .= '/';
		
		if (empty($realFileName)) {
			$realFileName = $fileName;
		}
		 
		$download_file_name=$fileDir.$fileName;
    	$download_file_size=filesize($download_file_name);
	    $ie_v=ereg_replace("^.+MSIE ","",$HTTP_USER_AGENT);
    	$ie_v=strtok($ie_v,';');
     
     	if($ie_v<5.0) {			// 5.0 이하 ... IE 가 아닌 브라우져는 고려하지 않았슴.
       		$c_type="application/octet-stream";
       		$c_disp="attachment;";
      	}else{				
       		$c_type="application/octet-stream";	
       		$c_disp="inline";
     	}
      
     	$fp = fopen($download_file_name, 'r');
     	if (!$fp) {
     		return false;
     	} else {
     		$download_file=fread($fp, $download_file_size);
        	header("Content-type: $c_type"); //파일 타입이 file/unknown 일경우 무조건 다운로드 
     		header("Content-length: $download_file_size"); //파일의 크기 
     		header("Content-Disposition: $c_disp;filename=$realFileName"); //파일 이름에 원래 realname 을 적어주면 다운로드시 그 이름으로 다운 
     		header("Content-Transfer-Encoding: binary"); 
  
     		print $download_file; //파일의 실제 내용을 전송 
     		return true;
     	}	
	}
	
	
	
	
	
	// 파일업로드 확장자 바꿈
	// $attachFile : 임시저장 디렉토리 파일명
	// $attachFileName : 업로드시 파일이름.
 	function uploadFile($attachFile, $attachFileName, $saveDir = '.'){
   		
   		$saveDir = ereg_replace("/$", "", $saveDir);
		$saveDir .= '/';
		
       	//$ext = date("YmdHis");
     	$saveFileName = $attachFileName;

     	/*
     	while (file_exists($saveDir . $saveFileName)) {
     		$ext++;
     		$saveFileName = $attachFileName . '.' . $ext;
     	}
       	*/

      	if(!is_dir($saveDir)){	// 파일 저장디렉토리가 존재하지 않으면
       		@mkdir($saveDir, 0755);
     	}
       	move_uploaded_file($attachFile, $saveDir . $saveFileName);
       	chmod($saveDir . $saveFileName, 0744);
       	$attc[size] = filesize($saveDir . $saveFileName);		//byte 
     	$attc[savedName] = $saveFileName;		// 저장되는 파일 이름
     	$attc[upName] = $attachFileName;		// 업로드시 파일네임
  
     	return $attc;
 	}  
 
 	// 파일업로드 확장자 바꾸지 않음
 	function uploadFileUnsafely($attachFile, $attachFileName, $saveDir = '.'){
   		
   		$saveDir = ereg_replace("/$", "", $saveDir);
		$saveDir .= '/';
		
		
		$ext = strrchr($attachFileName, '.');
	 	$tName = substr($attachFileName, 0, strlen($attachFileName) - strlen($ext));
	 	$saveFileName = $tName . $ext;
     	$i = 0;
     	while (file_exists($saveDir . $saveFileName)) {
     		$i++;
     		$saveFileName =  $tName . $i . $ext;
      	}
       	
       	if(!is_dir($saveDir)){	// 파일 저장디렉토리가 존재하지 않으면
       		@mkdir($saveDir, 0755);
     	}
       	
       	move_uploaded_file($attachFile, $saveDir . $saveFileName);
       	chmod($saveDir . $saveFileName, 0744);
       	$attc[size] = filesize($saveDir . $saveFileName);		//byte 
     	$attc[savedName] = $saveFileName;		// 저장되는 파일 이름
     	$attc[upName] = $attachFileName;		// 업로드시 파일네임
   
     	return $attc;
 	}  
 
 
 
 
 	## 홈페이지 체크
 
 	function checkUrl($url){
    	if (!eregi("[a-zA-Z0-9\-\.]+\.[a-zA-Z0-9\-\.]+.*", $url)) {
			return;
    	}
    	/* 한글이 포함되었는지 체크 */
/*
    	for ($i = 1; $i <= strlen($url); $i++) {
			if ((Ord(substr("$url", $i - 1, $i)) & 0x80)) {
	    		return;
			}
    	}
 */   
    	$url = eregi_replace("^http.*://", "", $url);
    	$url = eregi_replace("^", "http://", $url);

    	return $url;
 	}
 
 
 
 	## 문자열 자르기
 	function cutLongString($str, $length, $dot=false){
   
   		if (strlen($str) <= $length){
     		return $str;
    	}else{
     		$k=0;
     		for ($i=0; $i<$length*2; $i++) {
     	    	if( ord(substr($str, $i, 1)) > 127) {		## 한글포함
        			$i++;
         			$k++;
        		}else{
         			$k++;
       			}
       			if ($k >= $length)
         			break;
     		}
    		if ($dot) {
    			return substr($str, 0, $i+1)." ...";
    		} else {
       			return substr($str, 0,$i+1);
     		} 
      
   		}
 	}


		// 간단 html 메일 보내기
	
	function sendSimpleMail($mailTo, $mailFrom, $subject, $message) {
				 
		$mailHeader = "from:{$mailFrom}\n";
		$mailHeader .= "Return-Path:{$mailFrom}\n";
		$mailHeader .= "Reply-To:{$mailFrom}\n";
		$mailHeader .= "MIME-Version:1.0\n";
		$mailHeader .= "Content-Type:text/html\n";
	
		$flag = mail($mailTo, $subject, $message, $mailHeader); 
		return flag;
	}

	
	// 디렉토리내에 디렉토리와 파일 리스트 리턴
	// $arrEntry[dir] : 디렉토리배열, $arrEntry[file] : 파일배열
	function getDirectoryEntry($dir = '') {
		if (empty($dir)) {			// 주어진 디렉토리가 없을경우 현재 디렉토리
			$dir = '.';
		}
		$dir = ereg_replace("/$", '', $dir);
		$objDir = dir($dir);			// 디렉토리 읽어오기
		$arrEntry[dir] = array();		// 디렉토리저장
		$arrEntry[file] = array();		// 파일저장
		while ($entry = $objDir->read()) {
			if (is_dir("{$dir}/{$entry}") && ($entry != '.' && $entry != '..')) {
				$arrEntry[dir][] = $entry;
			} else {
				$arrEntry[file][] = $entry;
			}
		}
		
		return $arrEntry;
	}

	
	// 한글 체크
	function containsKorean($str) {
		for ($i = 1; $i <= strlen($str); $i++) {
			if ((Ord(substr($str, $i - 1, $i)) & 0x80)) {
	    		return true;
			}
		} 
		return false;
	}


	// 주민등록번호 유효성 검사: 올바른 경우 true, 틀린 경우 false 반환 
	function resnoCheck($resno1, $resno2) { 
		$resno = $resno1 . $resno2; 

		// 형태 검사: 총 13자리의 숫자, 7번째는 1..4의 값을 가짐 
		if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) 
			return false; 

		// 날짜 유효성 검사 
		$birthYear = ('2' >= $resno[6]) ? '19' : '20'; 
		$birthYear .= substr($resno, 0, 2); 
		$birthMonth = substr($resno, 2, 2); 
		$birthDate = substr($resno, 4, 2); 
		if (!checkdate($birthMonth, $birthDate, $birthYear)) 
			return false; 

		// Checksum 코드의 유효성 검사 
		for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i]; 
			$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5); 
		for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]); 
		if ((11 - ($sum % 11)) % 10 != $buf[12]) 
			return false; 

		 // 모든 검사를 통과하면 유효한 주민등록번호임 
		return true; 
	} 


	/**
	* 주민번호로 나이 계산.. 나이 리턴
	*
	*/

	function getAgeFromSocialNum($socialNum, $pattern = '-') {
		$arrS = split($pattern, $socialNum);
		$y = substr($arrS[1], 0, 1);
		
		// 2000년 이후 출생
		if ($y > 2 ) {
			$age = date('Y') - (int) ("20" . substr($arrS[0], 0, 2));
		} else {
			$age = date('Y') - (int) ("19" . substr($arrS[0], 0, 2));
		}
		
		return $age;
	} 


	/**
	* 주민번호로 성별 판별.. 성별 리턴
	*
	*/

	function getSexFromSocialNum($socialNum, $pattern = '-') {
		$arrS = split($pattern, $socialNum);
		$s = substr($arrS[1], 0, 1);
		
		if ($s == 1 || $s == 3) {
			$sex = '남';
		} else {
			$sex = '여';
		}
		
		return $sex;
	} 


	// 직렬화.... 디비에 넣을 경우는 꼭 addSlashes()를 하여 넣는다.
	function serialize(&$mix) {
		$serMix = serialize($mix);
		$serMix = addslashes($serMix);

		return $serMix;
	}

	// 역직렬화.... 디비에서 불러올때는 stripslashes() 한다.
	function unserialize(&$mix) {
		//$stripMix = stripslashes($mix);
		$unserMix = unserialize($mix);

		return $unserMix;
	}


	/**	
	* 호스팅 서버 같은 곳에서 보안상의 이유로 register_globals 를 OFF 로 변경
	* 하거나 또는 보안상 register_globals 를 OFF 로 변경하고 싶을때 사용
	* 작성자 : 김정균
	* @access public
	* @param integer $level 0 혹은 없을 때 POST, GET 만 제어, 1일때 POST, GET , COOKIE, SESSION, SERVER_var 를 모두 제어한다.
	*/
	function parseQueryString($level = 0) {
		
		// php.ini 의 register_globals 값을 확인한다.
		// register_globals = OFF 일 경우만 작동.
		if(ini_get("register_globals") && get_magic_quotes_gpc() == 1) return;

		// php 버젼이 4.1 보다 낮을 경우에는 함수 안에서 trackvar
		// 를 사용하기 위해 global 로 지정해 줘야 한다.
		if (!isset($HTTP_GET_VARS) || isset($HTTP_POST_VARS)) {
			global $HTTP_GET_VARS, $HTTP_POST_VARS;
		}
		if ($level) {
			if (!isset($HTTP_COOKIE_VARS) || !isset($HTTP_SESSION_VARS) || !isset($HTTP_SERVER_VARS)) {
				global $HTTP_COOKIE_VARS, $HTTP_SESSION_VARS, $HTTP_SERVER_VARS;
			}
		}

	/*	kwCho 2002.05.27 작동되지 않는 버젼있어  아래 코드를 위의 내용으로 수정
		if	(substr(PHP_VERSION, 0, 3) < 4.1) {
				global $HTTP_GET_VARS, $HTTP_POST_VARS;
				if ($level)
					global $HTTP_COOKIE_VARS, $HTTP_SESSION_VARS, $HTTP_SERVER_VARS;
		}
	*/
		// 4.1 부터는 trackvars 에 대해 무조건 배열로 생성을 하기
		// 때문에 is_array() 함수 보다는 count() 함수로 배열의 수를
		// 체크한다.
		if (count($HTTP_GET_VARS)) {
			foreach($HTTP_GET_VARS as $key => $value) {
				global ${$key};
				${$key} = Misc::getQueryStringWithMagicQuote($value);
			}
		}

		if (count($HTTP_POST_VARS)) {
				foreach($HTTP_POST_VARS as $key => $value) {
					global ${$key};
					${$key} = Misc::getQueryStringWithMagicQuote($value);
				}
		}

		if ( $level && count($HTTP_COOKIE_VARS) ) {
			foreach($HTTP_COOKIE_VARS as $key => $value) {
				global ${$key};
				${$key} = $value;
			}
		}

		if( $level && count($HTTP_SESSION_VARS) ) {
			foreach($HTTP_SESSION_VARS as $key => $value) {
				global ${$key};
				${$key} = $value;
			}
		}

		if( $level && count($HTTP_SERVER_VARS) ) {
			foreach($HTTP_SERVER_VARS as $key => $value) {
				global ${$key};
				${$key} = $value;
			}
		}
	}		// end of function parseQueryStr()

	
	/**
	* magic_quotes 설정이 off 일경우 addslashes()로 "\"를 붙인다.
	*/

	function getQueryStringWithMagicQuote($value) {
		if (get_magic_quotes_gpc() == 0) {
			$value = addslashes($value);
		}
		return $value;
	}

	
	function getFileExtension($fileName, $toLower = false) {
		$ext = strrchr($fileName, '.');
		$ext = substr($ext, 1);
		if ($toLower) {
			$ext = strtolower($ext);
		}
	
		return $ext;
	}
	
	
	
	// 테이블에 같은 값이 존재하나...

	function existsInTable($dbConn, $table, $field, $value) {
		$qry = "select count(*) from $table where $field = '$value'";
		$rst = mysql_query($qry, $dbConn);
		if (mysql_result($rst, 0, 0) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}	// end of class Misc

?>
