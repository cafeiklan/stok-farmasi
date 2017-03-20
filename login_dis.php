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
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<b>STOK FARMASI</B>
			</div>
			<!-- /.login-logo -->
			<div class="login-box-body">
				<p class="login-box-msg">Silahkan login untuk memulai</p>
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
						<div class="col-xs-8">         
						</div>
						<!-- /.col -->
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<div class="social-auth-links text-center">					
					<a href="change.php" class="btn btn-block btn-social btn-linkedin btn-flat"><i class="fa fa-lock"></i>Lupa password</a>					
				</div>
				
			</div>
			<!-- /.login-box-body -->
		</div>
		<!-- /.login-box -->
		
		<!-- jQuery 2.2.3 -->
		<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>