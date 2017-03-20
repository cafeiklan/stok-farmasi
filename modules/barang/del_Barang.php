<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	$id = $_GET['id'];
	$hps = $db->prepare("DELETE FROM far_barang WHERE id_barang = ?");
	if(!$hps->execute(array($id))){
		print_r($hps->errorInfo());
	}else{
		echo "<script>window.location='index.php?module=barang&file=barang&code=1'</script>";
	}
	$hps2 = $db->prepare("DELETE FROM far_masuk WHERE id_barang = ?");
	if(!$hps2->execute(array($id))){
		print_r($hps2->errorInfo());
	}else{
		echo "<script>window.location='index.php?module=barang&file=barang&code=1'</script>";
	}
	$hps3 = $db->prepare("DELETE FROM far_keluar WHERE id_barang = ?");
	if(!$hps3->execute(array($id))){
		print_r($hps3->errorInfo());
	}else{
		echo "<script>window.location='index.php?module=barang&file=barang&code=1'</script>";
	}
	$hps4 = $db->prepare("DELETE FROM far_stock WHERE id_barang = ?");
	if(!$hps4->execute(array($id))){
		print_r($hps4->errorInfo());
	}else{
		echo "<script>window.location='index.php?module=barang&file=barang&code=1'</script>";
	}
?>