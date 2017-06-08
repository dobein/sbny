<?
	// 기본 설정 파일모음
	include "../include/inc_base.php";


	if($_POST['mode'] == "save")
	{

		$user_id=mysql_real_escape_string(htmlentities($_POST['userid'])); 
		$password=mysql_real_escape_string(htmlentities($_POST['password'])); 

		//$security_password = md5($password);

		if($password == "123456")
		{
			$ip = $_SERVER['REMOTE_ADDR'];

			$qry1 = "insert into chan_shop_ip (user_id,ip,wdate) values ('$user_id','$ip',now())";

			$rst1 = mysql_query($qry1);

			if($rst1)
			{
				echo "<meta http-equiv='refresh' content='0; url=./index.php'>";
			}
		}
		else
		{
			echo "<meta http-equiv='refresh' content='0; url=./ip_register.php'>";
		}

	}
?>
		<form class="login-form" action="ip_register.php" method="post">
		<input type=hidden name=mode value="save">
			<h3 class="form-title">Ip Register</h3>
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button>
				<span>Enter any username and password.</span>
			</div>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="userid"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
				</div>
			</div>
			<div class="form-actions">

				<button type="submit" class="btn blue pull-right">
				Login <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>

		</form>