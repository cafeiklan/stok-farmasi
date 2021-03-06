<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	require_once('../config/database.php');
	require_once('../config/fungsi.php');
	if($_POST){
	$bln = isset($_POST['bln']) ? $_POST['bln'] : '';
	$thn = isset($_POST['thn']) ? $_POST['thn'] : '';
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
	border: 1px solid #fff;
	background-color: #625F5F;
	color: #fff;
	padding: 8px;
	text-align: center;
}

</style>
<page style="font-size:9.5pt;font-family:dejavusanscondensed;">
	<div style="text-align:center;font-weight:bold;font-size:11pt;padding-top:25px;padding-bottom:25px">Laporan Transaksi Bahan Masuk <br />
		<?php 
			if($bln=="/01/"){echo "Januari";}elseif($bln=="/02/"){echo "Februari";}elseif($bln=="/03/"){echo "Maret";}
			elseif($bln=="/04/"){echo "April";}elseif($bln=="/05/"){echo "Mei";}elseif($bln=="/06/"){echo "Juni";}
			elseif($bln=="/07/"){echo "Juli";}elseif($bln=="/08/"){echo "Agustus";}elseif($bln="/09/"){echo "September";}
			elseif($bln=="/10/"){echo "Oktober";}elseif($bln="/11/"){echo "November";}elseif($bln=="/12/"){echo "Desember";}
		?>&nbsp;tahun <?php echo $thn;?> dengan nama barang: <?php echo $brg;?>
	</div>
	<table class="list">
		<thead>
			<tr>
				<th>No. Urut</th>
				<th>Tgl Transaksi</th>
				<th>Nama Bahan</th>
				<th>Jml Transaksi</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if(isset($_POST['cek'])){
				$cek = isset($_POST['cek']) ? $_POST['cek'] : '';
				$jml = count($cek);
				for($i=0; $i<$jml; $i++){
					$query = $db->prepare("SELECT far_masuk.id_masuk, far_masuk.tgl, far_masuk.id_barang, far_masuk.jml, far_barang.nama_barang, far_barang.nama_satuan FROM far_masuk
					LEFT JOIN far_barang ON far_masuk.id_barang=far_barang.id_barang WHERE far_masuk.id_masuk = '".$cek[$i]."' GROUP BY far_masuk.id_masuk DESC");
					$query->execute();
					$in = $query->fetchAll();
					
					foreach($in as $in){
					$urut = $i+1;
		?>
			<tr>
				<td><?php echo $urut;?></td>
				<td><?php echo tgl_lengkap($in['tgl']);?></td>
				<td><?php echo $in['nama_barang'];?></td>
				<td><?php echo $in['jml'] ."&nbsp;". $in['nama_satuan'];?></td>
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
        $html2pdf->Output('Lap_Transaksi-Masuk.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>