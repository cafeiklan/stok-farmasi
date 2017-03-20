<?php

session_start();

require('config/database.php');
require('config/fungsi.php');

$username = antixss(isset($_POST['username']) ? $_POST['username'] : '');
$sandi = antixss(isset($_POST['sandi']) ? $_POST['sandi'] : '');

if(isset($_POST) && $username!='' && $sandi!=''){

	$sql=$db->prepare("SELECT id_user, username, nama_user, password, psalt FROM far_user WHERE username=?");
	$sql->execute(array($username));
	
	while($r=$sql->fetch(PDO::FETCH_ASSOC)){
		$p = $r['password'];
		$psalt = $r['psalt'];
		$id = $r['id_user'];
		$user = $r['username'];
		$nama_user = $r['nama_user'];		
	}	
	$site_salt="urangciparieuy";/*Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user.*/
	$salted_hash = hash('sha256',$sandi.$site_salt.$psalt);
	if($p == $salted_hash){
		$_SESSION['id_user'] = $id;
		$_SESSION['username'] = $user;
		$_SESSION['pengguna'] = $nama_user;
		$timeout = 3000;
		$_SESSION['udahan'] = time() + $timeout;
		header("Location:index.php");
	}else{
			$errMsg='Error! Username atau Password tidak ditemukan.';
		}
}

include('login_dis.php');

?>