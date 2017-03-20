<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
?>
<div class="row">
	<div class="col-md-10">
		<div class="box box-success">
			<div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-bars fa-fw"></i>Laporan Data Bahan</h3>
            </div>
			<div class="box-body">
				<div class="row">
					<form action="" method="post">
						<div class="col-xs-3">
							<select name="kategori" class="form-control">
								<option value="">Pilih Kategori:</option>
								<?php 
									$stmt=$db->prepare("SELECT * FROM far_kategori ORDER BY id_kategori");
									$stmt->execute();
									while($kat=$stmt->fetch()){
										echo "<option value=\"".$kat['nama_kategori']."\">".$kat['nama_kategori']."</option>";
									}
								?>
							</select>
						</div>
						<div class="col-xs-4">
							<input type="text" name="nm_brg" class="form-control" placeholder="Nama bahan..." />
						</div>
						<div class="col-xs-2">
							<button type="submit" name="cari" class="btn btn-success"><i class="fa fa-search fa-fw"></i>Tampilkan</button>
						</div>
					</form>
				</div>
				<?php
					if(isset($_POST['cari'])){
						$kategori = $_POST['kategori'];
						$nm_brg = $_POST['nm_brg'];
						$query = $db->prepare("SELECT far_barang.id_barang, far_barang.kode_barang, far_barang.nama_barang, far_barang.nama_kategori,
						far_barang.nama_satuan, far_stock.stok_tersedia FROM far_barang LEFT JOIN far_stock ON far_barang.id_barang = far_stock.id_barang
						WHERE far_barang.nama_barang LIKE '%".$nm_brg."%' AND far_barang.nama_kategori LIKE '%".$kategori."%' GROUP BY far_barang.nama_barang");
						$query->execute();
						$num = $query->rowCount();
						if($num == 0){
							echo "
								<div style=\"margin-top:10px\" class=\"alert alert-danger fade in\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
									<h4><strong><i class=\"fa fa-frown-o fa-fw\"></i></strong> Data yang anda cari tidak ditemukan.</h4>
								</div>
							";
						}else{
				?>
					<form name="cek" method="post" action="cetak/CtkBahan.php" target="_blank">
						<div style="padding-top:7px" class="row">
							<div class="col-xs-2" style="padding-bottom:10px">
								<input type="hidden" name="kategori" value="<?php echo $kategori = $_POST['kategori'] ;?>" />								
								<input type="hidden" name="brg" value="<?php echo $nm_brg = $_POST['nm_brg'] ;?>" />
								<button type="submit" class="btn btn-success"><i class="fa fa-print fa-fw"></i>Cetak Data</button>
							</div>
						</div>
						<div class="row">
							<div class="text-center" style="margin-left:10px">Laporan Data Bahan untuk kategori <b><?php echo $kategori;?></b> dengan nama barang: <b><?php echo $nm_brg;?></b>
							</div>
						</div>
						<table style="font-size:13px" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center"><input style="margin-bottom:7px" type="checkbox" name="checkall" class="check" id="checkAll" /><br><small class="label bg-blue">Pilih Semua</small></th>
									<th class="text-center">Urut</th>
									<th class="text-center">Kode Bahan</th>
									<th class="text-center">Nama Bahan</th>
									<th class="text-center">Kategori</th>
									<th class="text-center">Stok</th>
									<th class="text-center">Satuan</th>	
								</tr>
							</thead>
							<tbody>
								<?php 
									$urut=1;
									while($bhn=$query->fetch(PDO::FETCH_ASSOC)){
								?>
								<tr>
									<td class="text-center"><input type="checkbox" class="check" name="cek[]" value="<?php echo $bhn['id_barang'];?>"></td>
									<td class="text-center"><?php echo $urut++;?></td>
									<td><?php echo $bhn['kode_barang'];?></td>
									<td><?php echo $bhn['nama_barang'];?></td>
									<td><?php echo $bhn['nama_kategori'];?></td>
									<td>
										<?php 
										if($bhn['stok_tersedia'] == 0){
											echo "<p class=\"text-red\"><b>0</b></p>";
										}else{
											echo $bhn['stok_tersedia'];
										}?>
									</td>
									<td><?php echo $bhn['nama_satuan'];?></td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</form>
				<?php
						}
					}
				?>
			</div>
		</div>
	</div>
</div>