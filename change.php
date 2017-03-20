<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Stok Farmasi Mahadhika 4</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">  
		<!-- Theme style -->
		<link rel="stylesheet" href="assets/css/AdminLTE.min.css">  
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
<?php
require('config/database.php');
require('config/fungsi.php');
$return = "<script>alert('Password telah diubah. Silahkan login');document.location='index.php'</script>";
if($_POST){
	$username = antixss(isset($_POST['username']) ? $_POST['username'] : '');
	$sandi = antixss(isset($_POST['sandi']) ? $_POST['sandi'] : '');
	
	$cek = $db->prepare("SELECT COUNT(*) FROM far_user WHERE username = ?");
	$cek->execute(array($username));
	if($cek->fetchColumn() == 0){
		$ErMsg='Error! Username tidak terdaftar';
	}else{
		function rand_string($length) {
				$str="";
				$chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$size = strlen($chars);
				for($i = 0;$i < $length;$i++) {
					$str .= $chars[rand(0,$size-1)];
				}
				return $str; 
		}
		$p_salt = rand_string(20); 
		$site_salt="urangciparieuy"; 
		$salted_hash = hash('sha256', $sandi.$site_salt.$p_salt);
		$asup = $db->prepare("UPDATE far_user set password = ?, psalt = ? WHERE username = ?");
		$asup->bindParam(1, $salted_hash);
		$asup->bindParam(2, $p_salt);
		$asup->bindParam(3, $username);
		if (!$asup->execute()) {
			print_r($asup->errorInfo());
		}else{
			echo $return;
		}
	}
	
}
?>    
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>STOK FARMASI</B>
			</div>
			<!-- /.login-logo -->
			<div class="login-box-body">
				<p class="login-box-msg">Silahkan Ganti Password Anda</p>
				<?php if(isset($errMsg)){ ?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $errMsg; ?>
					</div>
				<?php } ?>
				<form action="" method="post">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" name="username" placeholder="Username" required />
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" name="sandi" placeholder="Password" required />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4">         
						</div>
						<!-- /.col -->
						<div class="col-xs-5 pull-right">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Ganti Password</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<div class="social-auth-links text-center">					
					<a href="index.php" class="btn btn-block btn-social btn-linkedin btn-flat"><i class="fa fa-reply"></i>Batal</a>					
				</div>
				
			</div>
			<!-- /.login-box-body -->
		</div>

    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <!-- jQuery 2.2.3 -->
		<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>