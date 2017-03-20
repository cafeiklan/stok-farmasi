<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
?>
<div class="row">
	<div class="col-md-10">
		<div class="box box-success">
			<div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-bars fa-fw"></i>Laporan Stok Alat</h3>
            </div>
			<div class="box-body">
				<div class="row">
					<form action="" method="post">						
						<div class="col-xs-4">
							<input type="text" name="nama_alat" class="form-control" placeholder="Nama Alat..." />							
						</div>
						<div class="col-xs-3">
							<select name="sumberdana" class="form-control">
								<?php 
									$dana = $db->prepare("SELECT id_dana, sumberdana FROM far_dana ORDER BY id_dana");
									$dana->execute();
									$sdana = $dana->fetchAll();
								?>
								<option value="">-Pilih Sumber Dana-</option>
								<?php foreach ($sdana as $sdana){ ?>
								<option value="<?= $sdana['sumberdana'];?>"><?= $sdana['sumberdana'];?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-xs-2">
							<button type="submit" name="cari" class="btn btn-success"><i class="fa fa-search fa-fw"></i>Tampilkan</button>
						</div>
					</form>
				</div>
				<div class="row"><div class="col-md-6">
					<p class="help-text text-red">Kosongkan isian untuk menampilkan seluruh data</p>
				</div></div>
				<?php
					if(isset($_POST['cari'])){
						$nama_alat = $_POST['nama_alat'];
						$sumberdana = $_POST['sumberdana'];
						$alat = $db->prepare("SELECT * FROM far_alat a LEFT OUTER JOIN far_dana d ON a.id_dana=d.id_dana WHERE nama_alat LIKE '%".$nama_alat."%' AND sumberdana LIKE '%".$sumberdana."%' ORDER BY nama_alat");
						if(!$alat->execute()){
							$print_r($alat->errorInfo());
						}else{
							
						$num = $alat->rowCount();
						if($num == 0){
							echo "
								<div style=\"margin-top:10px\" class=\"alert alert-danger fade in\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
									<h4><strong><i class=\"fa fa-frown-o fa-fw\"></i></strong> Data yang anda cari tidak ditemukan.</h4>
								</div>
							";
						}else{
				?>
					<form name="cek" method="post" action="cetak/CtkAlat.php" target="_blank">						
						<div class="row" style="padding-bottom:10px">
							<div class="col-md-2">
								<input type="hidden" name="alat" value="<?php echo $nama_alat = $_POST['nama_alat'] ;?>" />
								<button type="submit" class="btn btn-success"><i class="fa fa-print fa-fw"></i>Cetak Data</button>
							</div>
							<div class="col-md-10" style="float:right">
								Jumlah Data : <b><?= $num ;?></b>, Untuk nama alat : <b><?= $nama_alat ;?></b>, dengan Sumber Dana : <b><?= $sumberdana ;?></b>.
							</div>
						</div>
						<table style="font-size:13px" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center"><input style="margin-bottom:7px" type="checkbox" name="checkall" class="check" id="checkAll" /><br><small class="label bg-blue">Pilih Semua</small></th>
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
									//$alatna = $alat->fetchAll();
									$urut = 1;
									foreach($alatna = $alat->fetchAll() as $row){
								?>
								<tr>
									<td class="text-center"><input type="checkbox" class="check" name="cek[]" value="<?php echo $row['id_alat'];?>"></td>
									<td class="text-center"><?php echo $urut++;?></td>
									<td><?php echo $row['nama_alat'];?></td>
									<td><?php echo $row['ukuran'];?></td>
									<td><?php echo nl2br($row['spesifikasi']);?></td>
									<td><?php echo $row['jumlah'];?></td>
									<td><?php echo nl2br($row['kondisi']);?></td>
									<td><?= $row['sumberdana'];?></td>
									<td><?php echo $row['last_update'];?></td>
								</tr>
								<?php
									}
								?>
						</table>
					</form>
				<?php
						}
						}
					}
				?>
			</div>
		</div>
	</div>
</div>