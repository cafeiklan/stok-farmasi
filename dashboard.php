<?php
	
	if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	//SESSION 
	$now = time();
	if($now > $_SESSION['udahan']){
		session_destroy();
		echo "<script>window.location='logout.php'</script>";
		}else{
	?>
	
    <div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<?php
					$query1 = $db->prepare("SELECT far_barang.id_barang, far_barang.nama_kategori, sum(far_stock.stok_tersedia) AS stokP FROM far_barang JOIN far_stock ON far_barang.id_barang=far_stock.id_barang WHERE nama_kategori='Padat'");
					$query1->execute();
					$tPadat = $query1->fetch(PDO::FETCH_ASSOC);
					$jmlP = $tPadat['stokP'];
				?>
				<div class="inner">
					<h3><?= $jmlP ;?></h3>					
					<p>Stok Bahan Padat</p>
				</div>
				<div class="icon" style="padding-top:18px">
					<i class="fa fa-bomb"></i>
				</div>
				<a href="?module=laporan&file=Bahan" class="small-box-footer">Laporan <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<?php
					$query2 = $db->prepare("SELECT far_barang.id_barang, far_barang.nama_kategori, sum(far_stock.stok_tersedia) AS stokC FROM far_barang JOIN far_stock ON far_barang.id_barang=far_stock.id_barang WHERE nama_kategori='Cairan'");
					$query2->execute();
					$tCair = $query2->fetch(PDO::FETCH_ASSOC);
					$jmlC = $tCair['stokC']
				?>
				<div class="inner">
					<h3><?= $jmlC ;?></h3>					
					<p>Stok Bahan Cairan</p>
				</div>
				<div class="icon" style="padding-top:18px">
					<i class="fa fa-filter"></i>
				</div>
				<a href="?module=laporan&file=Bahan" class="small-box-footer">Laporan <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<?php
					$query3 = $db->prepare("SELECT far_barang.id_barang, far_barang.nama_kategori, sum(far_stock.stok_tersedia) AS stok FROM far_barang JOIN far_stock ON far_barang.id_barang=far_stock.id_barang WHERE nama_kategori='Tablet'");
					$query3->execute();
					$tTablet = $query3->fetch(PDO::FETCH_ASSOC);
					$jmlT = $tTablet['stok'];
				?>
				<div class="inner">
					<h3><?= $jmlT ;?></h3>					
					<p>Stok Bahan Tablet</p>
				</div>
				<div class="icon" style="padding-top:18px">
					<i class="fa fa-heartbeat"></i>
				</div>
				<a href="?module=laporan&file=Bahan" class="small-box-footer">Laporan <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<?php
					$query3 = $db->prepare("SELECT far_barang.id_barang, far_barang.nama_kategori, sum(far_stock.stok_tersedia) AS stokU FROM far_barang JOIN far_stock ON far_barang.id_barang=far_stock.id_barang WHERE nama_kategori='Umum'");
					$query3->execute();
					$tUmum = $query3->fetch(PDO::FETCH_ASSOC);
					$jmlU = $tUmum['stokU'];
				?>
				<div class="inner">
					<h3><?= $jmlU ;?></h3>					
					<p>Stok Bahan Umum</p>
				</div>
				<div class="icon" style="padding-top:18px">
					<i class="fa fa-gears"></i>
				</div>
				<a href="?module=laporan&file=Bahan" class="small-box-footer">Laporan <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Bahan <b>Tablet</b> dengan stok minimum</h3>
				</div>
				<div class="box-body">
					<?php
						$query5 = $db->prepare("SELECT * FROM far_barang b LEFT OUTER JOIN far_stock s ON b.id_barang=s.id_barang WHERE nama_kategori='Tablet' AND stok_tersedia<=1 ORDER BY nama_barang");
						$query5->execute();							
						$STablet = $query5->fetchAll();
					?>
					<table id="example1" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-center">Urut</th>
								<th class="text-center">Nama Bahan</th>
								<th class="text-center">Jumlah Stok</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$urut=1;
								foreach($STablet as $STablet){
								?>
								<tr>
									<td class="text-center"><?= $urut++ ;?></td>
									<td class="text-center"><?= $STablet['nama_barang'];?></td>
									<td class="text-center"><?= $STablet['stok_tersedia']."&nbsp;".$STablet['nama_satuan'];?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<a class="pull-right btn btn-warning" href="?module=transaksi&file=masuk">Kelola Bahan Farmasi <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Bahan <b>Cair</b> dengan stok minimum</h3>
				</div>
				<div class="box-body">
					<?php
						$query5 = $db->prepare("SELECT * FROM far_barang b LEFT OUTER JOIN far_stock s ON b.id_barang=s.id_barang WHERE nama_kategori='Cairan' AND stok_tersedia<=1 ORDER BY nama_barang");
						$query5->execute();							
						$STablet = $query5->fetchAll();
					?>
					<table id="example2" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-center">Urut</th>
								<th class="text-center">Nama Bahan</th>
								<th class="text-center">Jumlah Stok</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$urut=1;
								foreach($STablet as $STablet){
								?>
								<tr>
									<td class="text-center"><?= $urut++ ;?></td>
									<td class="text-center"><?= $STablet['nama_barang'];?></td>
									<td class="text-center"><?= $STablet['stok_tersedia']."&nbsp;".$STablet['nama_satuan'];?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<a class="pull-right btn btn-warning" href="?module=transaksi&file=masuk">Kelola Bahan Farmasi <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Bahan <b>Padat</b> dengan stok minimum</h3>
				</div>
				<div class="box-body">
					<?php
						$query5 = $db->prepare("SELECT * FROM far_barang b LEFT OUTER JOIN far_stock s ON b.id_barang=s.id_barang WHERE nama_kategori='Padat' AND stok_tersedia<=1 ORDER BY nama_barang");
						$query5->execute();							
						$STablet = $query5->fetchAll();
					?>
					<table id="example3" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-center">Urut</th>
								<th class="text-center">Nama Bahan</th>
								<th class="text-center">Jumlah Stok</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$urut=1;
								foreach($STablet as $STablet){
								?>
								<tr>
									<td class="text-center"><?= $urut++ ;?></td>
									<td class="text-center"><?= $STablet['nama_barang'];?></td>
									<td class="text-center"><?= $STablet['stok_tersedia']."&nbsp;".$STablet['nama_satuan'];?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix">
					<a class="pull-right btn btn-warning" href="?module=transaksi&file=masuk">Kelola Bahan Farmasi <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">10 Transaksi Bahan Masuk Terakhir</h3>
				</div>
				<div class="box-body no-padding">
					<?php
						$query6 = $db->prepare("SELECT m.id_masuk, m.tgl, m.id_barang, m.jml, b.nama_barang, b.nama_kategori, b.nama_satuan FROM far_masuk m JOIN far_barang b ON m.id_barang=b.id_barang ORDER BY m.id_masuk DESC LIMIT 10");
						$query6->execute();
						$qMasuk = $query6->fetchAll();
					?>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Nama Bahan</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Tanggal</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$urut = 1;
								foreach($qMasuk as $qMasuk){
							?>
							<tr>
								<td class="text-center"><?= $urut++;?></td>
								<td><?= $qMasuk['nama_barang']." <span class=\"pull-right label label-danger\">".$qMasuk['nama_kategori']."</span>";?></td>
								<td class="text-center"><?= $qMasuk['jml']." ".$qMasuk['nama_satuan'];?></td>
								<td class="text-center"><?= tgl_lengkap($qMasuk['tgl']);?></td>
							</tr>
							<?php	
								}
							?>
					</table>
				</div>
				<div class="box-footer clearfix text-center">
					<a class="text-center btn btn-info" href="?module=transaksi&file=masuk">Tambah Bahan Masuk <i class="fa fa-reply"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">10 Transaksi Bahan Keluar Terakhir</h3>
				</div>
				<div class="box-body">
					<?php
						$query7 = $db->prepare("SELECT k.id_keluar, k.tgl, k.id_barang, k.jml, b.nama_barang, b.nama_kategori, b.nama_satuan FROM far_keluar k JOIN far_barang b ON k.id_barang=b.id_barang ORDER BY k.id_keluar DESC LIMIT 10");
						$query7->execute();
						$qOut = $query7->fetchAll();
					?>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Nama Bahan</th>
								<th class="text-center">Qty</th>
								<th class="text-center">Tanggal</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$urut = 1;
								foreach($qOut as $qOut){
							?>
							<tr>
								<td class="text-center"><?= $urut++;?></td>
								<td><?= $qOut['nama_barang']." <span class=\"pull-right label label-danger\">".$qOut['nama_kategori']."</span>";?></td>
								<td class="text-center"><?= $qOut['jml']." ".$qOut['nama_satuan'];?></td>
								<td class="text-center"><?= tgl_lengkap($qOut['tgl']);?></td>
							</tr>
							<?php	
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="box-footer clearfix text-center">
					<a class="text-center btn btn-info" href="?module=transaksi&file=keluar">Tambah Bahan Keluar <i class="fa fa-share"></i></a>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	}
?>