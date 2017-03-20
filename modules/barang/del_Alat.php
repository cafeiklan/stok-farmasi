<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	$id = $_GET['id'];
	$hps = "DELETE FROM far_alat WHERE id_alat = ?";
	$hapus = $db->prepare($hps);
	if (!$hapus->execute(array($id))) {
        print_r($hapus->errorInfo());
	}else{
		echo "<script>window.location='index.php?module=barang&file=alat&code=1'</script>";
	}
	
?>