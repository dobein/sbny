<?php

/**
* class Misc
* ��Ÿ ������ ���� �μ����� ����
* class �� ����� ���� ��κ� ��ȿ���������� api ���� �ۼ� ���� ����.
* @access public
* @package util
*/

class Misc {
	
	
	/**
	* ��Ű ����	
	* �ڹ� ��ũ��Ʈ ����� �ӽ÷� �ۼ��Ǿ �ٽ� �ڵ��Ǿ����.
	* $expire �Ķ���Ϳ� ���� :  ����ð����� �߰��� �ð�(�ʴ���) ���� �����Ѵ�.
	* �ڹٽ�ũ��Ʈ�� ����Ҷ��� php�� ����Ҷ��� �ٸ�.
	* @access public
	* @param stirng $name
	* @param string $value
	* @param int $expire ����ð����� ��Ű�� �Ҹ�� �ð�(�ʴ���)
	* 
	*
	*/
	
 function setCookie($name, $value = '', $expire = 0, $path = '', $domain= '', $secure = 0) {
          if (headers_sent()) {           // �̹� ����� ��µǾ����� �ڹٽ�ũ��Ʈ�� ���´�.
             			$value = urlencode($value);
                        $expire = $expire * 1000;               // �ڹٽ�ũ��Ʈ�� �и������� ����
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
	* ���ڿ��� üũ
	* @access public
	* @param string $email  üũ�� ���ڿ��� �ּ�
	* @return boolean
	*/
	
	function checkEmail($email) {
		if (!eregi("^[^@ ]+@[a-zA-Z0-9\-]+\.+[a-zA-Z0-9\-]", $email)) {
			return false;
  		}
  		/* �ѱ��� ���ԵǾ����� üũ */
    	for($i = 1; $i <= strlen($email); $i++) {
			if ((Ord(substr("$email", $i - 1, $i)) & 0x80)) {
		    	return false;
			}
    	}
    	return true;
	}
	
	
	/**
	* java script alert ���
	* �ڹٽ�ũ��Ʈ�� ���ϰ� ���� �ٷ� ����� �������� ����Ѵ�.
	* @access public
	* @param string $msg �ڹٽ�ũ��Ʈ alert()�� ����� �޼���
	* @param string $nextCmd alert()���� �ڹٽ�ũ��Ʈ ���
	*/
	
	function jvAlert($msg, $nextCmd = '') {
		echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
  				<Script Language='JavaScript'>
  					alert(\"$msg\");
  					$nextCmd;
  				</Script> \n";
	}	// end of function jvAlert
	
	
	
	/**
	* url redirect ����� ��µȰ��� �ƴѰ��
	* ����� ��µ� ��� �ڹ� ��ũ��Ʈ�� ó��
	* $replace�� true�� ��� �ڹٽ�ũ��Ʈ location.replace()�Լ� ���
	* @access public
	* @param $url	�̵��� �ּ�
	* @param $replace true�϶� �ڹٽ�ũ��Ʈ location.replace()�Լ� ���
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
	
	// ���� �ٿ�ε�	
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
     
     	if($ie_v<5.0) {			// 5.0 ���� ... IE �� �ƴ� �������� ������� �ʾҽ�.
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
        	header("Content-type: $c_type"); //���� Ÿ���� file/unknown �ϰ�� ������ �ٿ�ε� 
     		header("Content-length: $download_file_size"); //������ ũ�� 
     		header("Content-Disposition: $c_disp;filename=$realFileName"); //���� �̸��� ���� realname �� �����ָ� �ٿ�ε�� �� �̸����� �ٿ� 
     		header("Content-Transfer-Encoding: binary"); 
  
     		print $download_file; //������ ���� ������ ���� 
     		return true;
     	}	
	}
	
	
	
	
	
	// ���Ͼ��ε� Ȯ���� �ٲ�
	// $attachFile : �ӽ����� ���丮 ���ϸ�
	// $attachFileName : ���ε�� �����̸�.
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

      	if(!is_dir($saveDir)){	// ���� ������丮�� �������� ������
       		@mkdir($saveDir, 0755);
     	}
       	move_uploaded_file($attachFile, $saveDir . $saveFileName);
       	chmod($saveDir . $saveFileName, 0744);
       	$attc[size] = filesize($saveDir . $saveFileName);		//byte 
     	$attc[savedName] = $saveFileName;		// ����Ǵ� ���� �̸�
     	$attc[upName] = $attachFileName;		// ���ε�� ���ϳ���
  
     	return $attc;
 	}  
 
 	// ���Ͼ��ε� Ȯ���� �ٲ��� ����
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
       	
       	if(!is_dir($saveDir)){	// ���� ������丮�� �������� ������
       		@mkdir($saveDir, 0755);
     	}
       	
       	move_uploaded_file($attachFile, $saveDir . $saveFileName);
       	chmod($saveDir . $saveFileName, 0744);
       	$attc[size] = filesize($saveDir . $saveFileName);		//byte 
     	$attc[savedName] = $saveFileName;		// ����Ǵ� ���� �̸�
     	$attc[upName] = $attachFileName;		// ���ε�� ���ϳ���
   
     	return $attc;
 	}  
 
 
 
 
 	## Ȩ������ üũ
 
 	function checkUrl($url){
    	if (!eregi("[a-zA-Z0-9\-\.]+\.[a-zA-Z0-9\-\.]+.*", $url)) {
			return;
    	}
    	/* �ѱ��� ���ԵǾ����� üũ */
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
 
 
 
 	## ���ڿ� �ڸ���
 	function cutLongString($str, $length, $dot=false){
   
   		if (strlen($str) <= $length){
     		return $str;
    	}else{
     		$k=0;
     		for ($i=0; $i<$length*2; $i++) {
     	    	if( ord(substr($str, $i, 1)) > 127) {		## �ѱ�����
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


		// ���� html ���� ������
	
	function sendSimpleMail($mailTo, $mailFrom, $subject, $message) {
				 
		$mailHeader = "from:{$mailFrom}\n";
		$mailHeader .= "Return-Path:{$mailFrom}\n";
		$mailHeader .= "Reply-To:{$mailFrom}\n";
		$mailHeader .= "MIME-Version:1.0\n";
		$mailHeader .= "Content-Type:text/html\n";
	
		$flag = mail($mailTo, $subject, $message, $mailHeader); 
		return flag;
	}

	
	// ���丮���� ���丮�� ���� ����Ʈ ����
	// $arrEntry[dir] : ���丮�迭, $arrEntry[file] : ���Ϲ迭
	function getDirectoryEntry($dir = '') {
		if (empty($dir)) {			// �־��� ���丮�� ������� ���� ���丮
			$dir = '.';
		}
		$dir = ereg_replace("/$", '', $dir);
		$objDir = dir($dir);			// ���丮 �о����
		$arrEntry[dir] = array();		// ���丮����
		$arrEntry[file] = array();		// ��������
		while ($entry = $objDir->read()) {
			if (is_dir("{$dir}/{$entry}") && ($entry != '.' && $entry != '..')) {
				$arrEntry[dir][] = $entry;
			} else {
				$arrEntry[file][] = $entry;
			}
		}
		
		return $arrEntry;
	}

	
	// �ѱ� üũ
	function containsKorean($str) {
		for ($i = 1; $i <= strlen($str); $i++) {
			if ((Ord(substr($str, $i - 1, $i)) & 0x80)) {
	    		return true;
			}
		} 
		return false;
	}


	// �ֹε�Ϲ�ȣ ��ȿ�� �˻�: �ùٸ� ��� true, Ʋ�� ��� false ��ȯ 
	function resnoCheck($resno1, $resno2) { 
		$resno = $resno1 . $resno2; 

		// ���� �˻�: �� 13�ڸ��� ����, 7��°�� 1..4�� ���� ���� 
		if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) 
			return false; 

		// ��¥ ��ȿ�� �˻� 
		$birthYear = ('2' >= $resno[6]) ? '19' : '20'; 
		$birthYear .= substr($resno, 0, 2); 
		$birthMonth = substr($resno, 2, 2); 
		$birthDate = substr($resno, 4, 2); 
		if (!checkdate($birthMonth, $birthDate, $birthYear)) 
			return false; 

		// Checksum �ڵ��� ��ȿ�� �˻� 
		for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i]; 
			$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5); 
		for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]); 
		if ((11 - ($sum % 11)) % 10 != $buf[12]) 
			return false; 

		 // ��� �˻縦 ����ϸ� ��ȿ�� �ֹε�Ϲ�ȣ�� 
		return true; 
	} 


	/**
	* �ֹι�ȣ�� ���� ���.. ���� ����
	*
	*/

	function getAgeFromSocialNum($socialNum, $pattern = '-') {
		$arrS = split($pattern, $socialNum);
		$y = substr($arrS[1], 0, 1);
		
		// 2000�� ���� ���
		if ($y > 2 ) {
			$age = date('Y') - (int) ("20" . substr($arrS[0], 0, 2));
		} else {
			$age = date('Y') - (int) ("19" . substr($arrS[0], 0, 2));
		}
		
		return $age;
	} 


	/**
	* �ֹι�ȣ�� ���� �Ǻ�.. ���� ����
	*
	*/

	function getSexFromSocialNum($socialNum, $pattern = '-') {
		$arrS = split($pattern, $socialNum);
		$s = substr($arrS[1], 0, 1);
		
		if ($s == 1 || $s == 3) {
			$sex = '��';
		} else {
			$sex = '��';
		}
		
		return $sex;
	} 


	// ����ȭ.... ��� ���� ���� �� addSlashes()�� �Ͽ� �ִ´�.
	function serialize(&$mix) {
		$serMix = serialize($mix);
		$serMix = addslashes($serMix);

		return $serMix;
	}

	// ������ȭ.... ��񿡼� �ҷ��ö��� stripslashes() �Ѵ�.
	function unserialize(&$mix) {
		//$stripMix = stripslashes($mix);
		$unserMix = unserialize($mix);

		return $unserMix;
	}


	/**	
	* ȣ���� ���� ���� ������ ���Ȼ��� ������ register_globals �� OFF �� ����
	* �ϰų� �Ǵ� ���Ȼ� register_globals �� OFF �� �����ϰ� ������ ���
	* �ۼ��� : ������
	* @access public
	* @param integer $level 0 Ȥ�� ���� �� POST, GET �� ����, 1�϶� POST, GET , COOKIE, SESSION, SERVER_var �� ��� �����Ѵ�.
	*/
	function parseQueryString($level = 0) {
		
		// php.ini �� register_globals ���� Ȯ���Ѵ�.
		// register_globals = OFF �� ��츸 �۵�.
		if(ini_get("register_globals") && get_magic_quotes_gpc() == 1) return;

		// php ������ 4.1 ���� ���� ��쿡�� �Լ� �ȿ��� trackvar
		// �� ����ϱ� ���� global �� ������ ��� �Ѵ�.
		if (!isset($HTTP_GET_VARS) || isset($HTTP_POST_VARS)) {
			global $HTTP_GET_VARS, $HTTP_POST_VARS;
		}
		if ($level) {
			if (!isset($HTTP_COOKIE_VARS) || !isset($HTTP_SESSION_VARS) || !isset($HTTP_SERVER_VARS)) {
				global $HTTP_COOKIE_VARS, $HTTP_SESSION_VARS, $HTTP_SERVER_VARS;
			}
		}

	/*	kwCho 2002.05.27 �۵����� �ʴ� �����־�  �Ʒ� �ڵ带 ���� �������� ����
		if	(substr(PHP_VERSION, 0, 3) < 4.1) {
				global $HTTP_GET_VARS, $HTTP_POST_VARS;
				if ($level)
					global $HTTP_COOKIE_VARS, $HTTP_SESSION_VARS, $HTTP_SERVER_VARS;
		}
	*/
		// 4.1 ���ʹ� trackvars �� ���� ������ �迭�� ������ �ϱ�
		// ������ is_array() �Լ� ���ٴ� count() �Լ��� �迭�� ����
		// üũ�Ѵ�.
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
	* magic_quotes ������ off �ϰ�� addslashes()�� "\"�� ���δ�.
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
	
	
	
	// ���̺� ���� ���� �����ϳ�...

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
