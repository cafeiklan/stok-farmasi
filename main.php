<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Sistem Informasi Stok Farmasi Mahadhika</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">		
		<!-- DataTables -->
		<link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="assets/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="assets/css/skins/skin-blue.min.css">
		<!-- Date Picker -->
		<link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			body {
				font-size : 17px !important;
			}
		</style>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<a href="index.php" class="logo">					
					<span class="logo-mini"><b>STOK</b></span>					
					<span class="logo-lg"><b>STOKFAR</b></span>
				</a>
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="assets/img/avatar-hijab.png" class="user-image" alt="User Image">
									<span class="hidden-xs"><?= $_SESSION['pengguna']; ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="assets/img/avatar-hijab.png" class="img-circle" alt="User Image">
										
										<p>
											<?= $_SESSION['pengguna']; ?>
											<small>Farmasi Mahadhika 4</small>
										</p>
									</li>									
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">Profile</a>
										</div>
										<div class="pull-right">
											<a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<aside class="main-sidebar">
				<section class="sidebar">
					<div class="user-panel">
						<div class="pull-left image">
							<img src="assets/img/avatar-hijab.png" class="img-circle" alt="User Image">
						</div>
						<div class="pull-left info">
							<p><?= $_SESSION['pengguna']; ?></p>
							<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
						</div>
					</div>
					<?php require_once('component/com-navigation.php'); ?>
				</section>
			</aside>
			<div class="content-wrapper">
				<section class="content">
					<?php 
						if(isset($_GET['file'])){
							include('modules/'.$_GET['module'].'/'.$_GET['file'].'.php');
							} else {
							include('dashboard.php');
						}
					?>
				</section>
			</div>
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.1 Developed by <b><a href="http://ucu.suryadi.my.id" target="_blank">nolbyte</a></b>
				</div>
				<strong>2016-2017 <a href="http://smk4.mahadhika.sch.id" target="_blank">Farmasi Mahadhika 4</a>.</strong>
			</footer>
		</div>
		<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>
		<!-- Bootstrap 3.3.6 -->
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<!-- DataTables -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
		<!-- datepicker -->
		<script src="assets/plugins/datepicker/bootstrap-datepicker.js"></script>		
		<!-- Slimscroll -->
		<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>		
		<!-- AdminLTE App -->
		<script src="assets/js/app.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) 
		<script src="assets/js/pages/dashboard.js"></script>-->
		<!-- AdminLTE for demo purposes -->
		<script src="assets/js/demo.js"></script>
		<!-- Untuk keperluan tambahan -->
		<script src="assets/js/custom.js"></script>
		<script type="text/javascript">
			$(document).ready(function () { 
				window.setTimeout(function() {
					$(".alert").fadeTo(1500, 0).slideUp(300, function(){
						$(this).remove(); 
					});
				}, 2500); 
			});
			//checkall
			$("#checkAll").click(function () {
				$(".check").prop('checked', $(this).prop('checked'));
			});
			//data table
			$(function () {				
				$('#example1').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": false
				});
				$('#example2').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": false
				});
				$('#example3').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": false
				});
				$('#example4').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": false
				});
				$('#example5').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": false
				});
				$('#example6').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": false
				});
			});
		</script>
	</body>
</html>