<?php
	include "../../include/inc_base.php";

	/**
	* 접근권한 설정
	**/
	include "../../include/inc_admin_session.php";



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
		function resize_image3($destination, $departure, $size, $quality='150', $ratio='false'){ 

			if($size[2] == 1)    //-- GIF 
				$src = imageCreateFromGIF($departure); 
			elseif($size[2] == 2) //-- JPG 
				$src = imageCreateFromJPEG($departure); 
			else    //-- $size[2] == 3, PNG 
				$src = imageCreateFromPNG($departure); 

			$dst = imagecreatetruecolor($size['w'], $size['h']); 


			$dstX = 0; 
			$dstY = 0; 
			$dstW = $size['w']; 
			$dstH = $size['h']; 

			if($ratio != 'false' && $size['w']/$size['h'] <= $size[0]/$size[1]){ 
				$srcX = ceil(($size[0]-$size[1]*($size['w']/$size['h']))/2); 
				$srcY = 0; 
				$srcW = $size[1]*($size['w']/$size['h']); 
				$srcH = $size[1]; 
			}elseif($ratio != 'false'){ 
				$srcX = 0; 
				$srcY = ceil(($size[1]-$size[0]*($size['h']/$size['w']))/2); 
				$srcW = $size[0]; 
				$srcH = $size[0]*($size['h']/$size['w']); 
			}else{ 
				$srcX = 0; 
				$srcY = 0; 
				$srcW = $size[0]; 
				$srcH = $size[1]; 
			} 

			@imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH); 
			@imagejpeg($dst, $destination, $quality); 
			@imagedestroy($src); 
			@imagedestroy($dst); 

			return TRUE; 
		} 
		function resize_image2($destination, $departure, $size, $quality='150', $ratio='false'){ 

			if($size[2] == 1)    //-- GIF 
				$src = imageCreateFromGIF($departure); 
			elseif($size[2] == 2) //-- JPG 
				$src = imageCreateFromJPEG($departure); 
			else    //-- $size[2] == 3, PNG 
				$src = imageCreateFromPNG($departure); 

			$dst = imagecreatetruecolor($size['w'], $size['h']); 


			$dstX = 0; 
			$dstY = 0; 
			$dstW = $size['w']; 
			$dstH = $size['h']; 

			if($ratio != 'false' && $size['w']/$size['h'] <= $size[0]/$size[1]){ 
				$srcX = ceil(($size[0]-$size[1]*($size['w']/$size['h']))/2); 
				$srcY = 0; 
				$srcW = $size[1]*($size['w']/$size['h']); 
				$srcH = $size[1]; 
			}elseif($ratio != 'false'){ 
				$srcX = 0; 
				$srcY = ceil(($size[1]-$size[0]*($size['h']/$size['w']))/2); 
				$srcW = $size[0]; 
				$srcH = $size[0]*($size['h']/$size['w']); 
			}else{ 
				$srcX = 0; 
				$srcY = 0; 
				$srcW = $size[0]; 
				$srcH = $size[1]; 
			} 

			@imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH); 
			@imagejpeg($dst, $destination, $quality); 
			@imagedestroy($src); 
			@imagedestroy($dst); 

			return TRUE; 
		} 
		function resize_image($destination, $departure, $size, $quality='150', $ratio='false'){ 

			if($size[2] == 1)    //-- GIF 
				$src = imageCreateFromGIF($departure); 
			elseif($size[2] == 2) //-- JPG 
				$src = imageCreateFromJPEG($departure); 
			else    //-- $size[2] == 3, PNG 
				$src = imageCreateFromPNG($departure); 

			$dst = imagecreatetruecolor($size['w'], $size['h']); 


			$dstX = 0; 
			$dstY = 0; 
			$dstW = $size['w']; 
			$dstH = $size['h']; 

			if($ratio != 'false' && $size['w']/$size['h'] <= $size[0]/$size[1]){ 
				$srcX = ceil(($size[0]-$size[1]*($size['w']/$size['h']))/2); 
				$srcY = 0; 
				$srcW = $size[1]*($size['w']/$size['h']); 
				$srcH = $size[1]; 
			}elseif($ratio != 'false'){ 
				$srcX = 0; 
				$srcY = ceil(($size[1]-$size[0]*($size['h']/$size['w']))/2); 
				$srcW = $size[0]; 
				$srcH = $size[0]*($size['h']/$size['w']); 
			}else{ 
				$srcX = 0; 
				$srcY = 0; 
				$srcW = $size[0]; 
				$srcH = $size[1]; 
			} 

			@imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH); 
			@imagejpeg($dst, $destination, $quality); 
			@imagedestroy($src); 
			@imagedestroy($dst); 

			return TRUE; 
		} 

		// $img : 원본이미지 
		// $m : 목표크기 pixel 
		// $ratio : 비율 강제설정 
		function _getimagesize($img, $m, $ratio='false'){ 

			$v = @getImageSize($img); 

			if($v === FALSE || $v[2] < 1 || $v[2] > 3) 
				return FALSE; 

			$m = intval($m); 

			if($m > $v[0] && $m > $v[1]) 
				return array_merge($v, array("w"=>$v[0], "h"=>$v[1])); 

			if($ratio != 'false'){ 
				$xy = explode(':',$ratio); 
				return array_merge($v, array("w"=>$m, "h"=>ceil($m*intval(trim($xy[1]))/intval(trim($xy[0]))))); 
			}elseif($v[0] > $v[1]){ 
				$t = $v[0]/$m; 
				$s = floor($v[1]/$t); 
				$m = ($m > 0) ? $m : 1; 
				$s = ($s > 0) ? $s : 1; 
				return array_merge($v, array("w"=>$m, "h"=>$s)); 
			} else { 
				$t = $v[1]/intval($m); 
				$s = floor($v[0]/$t); 
				$m = ($m > 0) ? $m : 1; 
				$s = ($s > 0) ? $s : 1; 
				return array_merge($v, array("w"=>$s, "h"=>$m)); 
			} 
		} 


// Define a destination
$targetFolder = '/eshop/upload'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('GIF','JPG','jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {


		function RandomString($length=35) 	
		{ 	
			$randstr=''; 	srand((double)microtime()*1000000); 	
			$chars = array ( 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','1','2','3','4','5','6','7','8','9','0'); 	
			for ($rand = 0; $rand <= $length; $rand++) 		
				{ 		
				$random = rand(0, count($chars) -1); 		
				$randstr .= $chars[$random]; 		
				} 		
			return $randstr; 
		} 
		
		$newname = "ppc";
		$randomteil = RandomString(8);
		$timestamp = time();
		$name = $newname."_".$timestamp.$randomteil;

		$tempFile = $_FILES['Filedata']['tmp_name'];    
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/';	
		$targetPath =  str_replace('//','/',$targetPath);	
		$targetFile =  $targetPath . $_FILES['Filedata']['name'];		
		$extension = end(explode('.', $targetFile));	
		$extension = strtolower($extension);		
		$newFileName = $name.".".$extension; 
		$targetFile =  str_replace('//','/',$targetPath) . $newFileName;



		move_uploaded_file($tempFile,$targetFile);

		$src = '../../upload/'.$newFileName;        //-- 원본 
		$dst = '../../upload/thum_'.$newFileName;     //-- 저장 

		$quality = '150';    //-- jpg 퀄리티 
		$size = '234';    //-- 줄일 크기 pixel (너비, 또는 높이에 적용) 
		//$ratio = '1:2';        //-- 이미지를 4:3 비율로 잘라냄 
		$ratio = 'false';        //-- 원본 이미지비율을 유지 

		$get_size = _getimagesize($src, $size, $ratio); 
		$result = resize_image($dst, $src, $get_size, $quality, $ratio); 


		$src = '../../upload/'.$newFileName;        //-- 원본 
		$dst2 = '../../upload/main_'.$newFileName;     //-- 저장 

		$quality = '150';    //-- jpg 퀄리티 
		$size2 = '350';    //-- 줄일 크기 pixel (너비, 또는 높이에 적용) 
		//$ratio = '1:2';        //-- 이미지를 4:3 비율로 잘라냄 
		$ratio = 'false';        //-- 원본 이미지비율을 유지 

		$get_size2 = _getimagesize($src, $size2, $ratio); 
		$result = resize_image2($dst2, $src, $get_size2, $quality, $ratio); 


		echo $newFileName;
	} else {
		echo 'Invalid file type.';
	}
}
?>