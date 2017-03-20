<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	$id = $_GET['id'];
	$hps = "DELETE FROM far_satuan WHERE id_satuan = ".$id."";
	$hapus = $db->prepare($hps);
	if (!$hapus->execute()) {
        print_r($hapus->errorInfo());
	}else{
		echo "<script>window.location='index.php?module=barang&file=satuan&code=1'</script>";
	}
	
?>