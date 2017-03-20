<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	require_once('../config/database.php');
	require_once('../config/fungsi.php');
	if($_POST){	
	$alat = isset($_POST['alat']) ? $_POST['alat'] : '';
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
		Laporan Stok Alat<br />Dengan nama alat: <?php echo $alat;?>
	</div>
	<table class="list">
		<thead>
			<tr>
				<th class="text-center">Urut</th>
				<th class="text-center">Nama Alat</th>
				<th class="text-center">Ukuran</th>
				<th class="text-center">Spesifikasi</th>
				<th class="text-center">Jumlah</th>
				<th class="text-center">Kondisi</th>
				<th class="text-center">Sumber Dana</th>
				<th class="text-center">Last Update</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(isset($_POST['cek'])){
					$cek = isset($_POST['cek']) ? $_POST['cek'] : '';
					$jml = count($cek);
					for($i=0; $i<$jml; $i++){
						$alat = $db->prepare("SELECT * FROM far_alat a LEFT OUTER JOIN far_dana d ON a.id_dana=d.id_dana WHERE id_alat = '".$cek[$i]."' ORDER BY nama_alat");
						$alat->execute();
						foreach($alatna = $alat->fetchAll() as $row){
							$urut = $i+1;
			?>
			<tr>
				<td><?php echo $urut;?></td>
				<td><?php echo $row['nama_alat'];?></td>
				<td><?php echo $row['ukuran'];?></td>
				<td><?php echo nl2br($row['spesifikasi']);?></td>
				<td><?php echo $row['jumlah'];?></td>
				<td><?php echo wordwrap($row['kondisi'],20,"<br>\n");?></td>
				<td><?= $row['sumberdana'];?></td>
				<td><?= wordwrap($row['last_update'],15,"<br>\n");?></td>
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
        $html2pdf->Output('Lap_Data-Alat.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>