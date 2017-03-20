<?php
########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$now = time();
if(!isset($_SESSION['username'])){
	header('location:login.php');
}else{
	if($now > $_SESSION['udahan']){
		session_destroy();
		echo "<script>document.location='logout.php'</script>";
	}else{	
		require('config/database.php');
		require_once('config/fungsi.php');
		require_once('component/com-deletion.php');
		include('config/app.php');

		if(!empty($_GET['report'])) {

			include('report.php');
		} else {

			include('main.php');
		}
	}
}
?>