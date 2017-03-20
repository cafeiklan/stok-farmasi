<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	require_once('../config/database.php');
	require_once('../config/fungsi.php');
	if($_POST){
	$kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';	
	$brg = isset($_POST['brg']) ? $_POST['brg'] : '';
	}
	//$now = date("j F Y");	
	ob_start();
?>
<style type="text/css">

table.list {
	border: 1px solid #000;
	border-collapse: collapse;
	width:80%;
	margin:auto;
}
table.list td {
	border: 1px solid #000;
	padding: 5px;
}
table.list th {
	border: 1px solid #000;
	background-color: #625F5F;
	color: #fff;
	padding: 8px;
	text-align: center;
}

</style>
<page style="font-size:9.5pt;font-family:dejavusanscondensed;">
	<div style="text-align:center;font-weight:bold;font-size:11pt;padding-top:25px;padding-bottom:25px">
		Laporan Stok Bahan<br />Kategori <?php echo $kategori;?> dengan nama barang: <?php echo $brg;?>
	</div>
	<table class="list">
		<thead>
			<tr>
				<th>Urut</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Kategori</th>
				<th>Stok Tersedia</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($_POST['cek'])){
					$cek = isset($_POST['cek']) ? $_POST['cek'] : '';
					$jml = count($cek);
					for($i=0; $i<$jml; $i++){
						$Cbrg = $db->prepare("SELECT far_barang.id_barang, far_barang.kode_barang, far_barang.nama_barang, far_barang.nama_kategori, far_barang.nama_satuan, far_stock.stok_tersedia FROM far_barang LEFT JOIN far_stock ON far_barang.id_barang = far_stock.id_barang WHERE far_barang.id_barang = '".$cek[$i]."' ORDER BY far_barang.nama_barang");
						$Cbrg->execute();
						$Dbrg = $Cbrg->fetchAll();
						
						foreach($Dbrg as $Dbrg){
							$urut = $i+1;
			?>
			<tr>
				<td style="text-align:center"><?php echo $urut ;?></td>
				<td><?php echo $Dbrg['kode_barang'] ;?></td>
				<td><?php echo $Dbrg['nama_barang']; ?></td>
				<td><?php echo $Dbrg['nama_kategori']; ?></td>
				<td><?php echo $Dbrg['stok_tersedia']."&nbsp;".$Dbrg['nama_satuan'];?></td>
			</tr>
			<?php
						}						
					}
				}
			?>
		</tbody>
	</table>
</page>
<?php
$content = ob_get_clean();
// convert to PDF
require_once(dirname(__FILE__).'/html2pdf4/html2pdf.class.php');
try
{
		$html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', array(3, 5, 7, 10));
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
        $html2pdf->Output('Lap_Data-Bahan.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>