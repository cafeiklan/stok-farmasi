<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
?>
<div class="row">
	<div class="col-md-10">
		<div class="box box-success">
			<div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-bars fa-fw"></i>Laporan Data Transaksi Bahan Masuk</h3>
            </div>
			<div class="box-body">
				<div class="row">
					<form action="" method="post">						
						<div class="col-xs-2">
							<select name="bulan" class="form-control" required>
								<option value="">Pilih Bulan :</option>
								<option value="/01/">Januari</option>
								<option value="/02/">Febuari</option>
								<option value="/03/">Maret</option>
								<option value="/04/">April</option>
								<option value="/05/">Mei</option>
								<option value="/06/">Juni</option>
								<option value="/07/">Juli</option>
								<option value="/08/">Agustus</option>
								<option value="/09/">September</option>
								<option value="/10/">Oktober</option>
								<option value="/11/">November</option>
								<option value="/12/">Desember</option>
							</select>
						</div>
						<div class="col-xs-2">
							<select name="tahun" class="form-control" required>
								<option value="">Pilih Tahun :</option>
									<?php
										$b = date('Y') - 2015;
										for($a=0; $a<=$b; $a++){
											$thn = 2015 + $a;
											echo "<option value='".$thn."'>".$thn."</option>";
										}
									?>
							</select>
						</div>
						<div class="col-xs-3">
							<input type="text" name="nm_brg" class="form-control" placeholder="Nama bahan..." />
						</div>
						<div class="col-xs-2">
							<button type="submit" name="cari" class="btn btn-success"><i class="fa fa-search fa-fw"></i>Tampilkan</button>
						</div>
					</form>
				</div>
				<?php
					if(isset($_POST['cari'])){
						$bulan = $_POST['bulan'];
						$tahun = $_POST['tahun'];
						$nm_brg = $_POST['nm_brg'];
						
						$query = $db->prepare("SELECT far_masuk.id_masuk, far_masuk.tgl, far_masuk.id_barang, far_masuk.jml, far_barang.nama_barang, far_barang.nama_satuan FROM far_masuk
						LEFT JOIN far_barang ON far_masuk.id_barang=far_barang.id_barang WHERE far_masuk.tgl LIKE '%".$bulan."%' AND far_masuk.tgl LIKE '%".$tahun."%'
						AND far_barang.nama_barang LIKE '%".$nm_brg."%' GROUP BY far_masuk.id_masuk ASC");
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
					<form name="cek" method="post" action="cetak/CtkIn.php" target="_blank">
						<div style="padding-top:7px" class="row">
							<div class="col-xs-2" style="padding-bottom:10px">
								<input type="hidden" name="bln" value="<?php echo $bulan = $_POST['bulan'] ;?>" />
								<input type="hidden" name="thn" value="<?php echo $tahun = $_POST['tahun'] ;?>" />
								<input type="hidden" name="brg" value="<?php echo $nm_brg = $_POST['nm_brg'] ;?>" />
								<button type="submit" class="btn btn-success"><i class="fa fa-print fa-fw"></i>Cetak Data</button>
							</div>
						</div>
						<div class="row">
							<div style="margin-left:10px">Hasil pencarian untuk Transaksi Bahan Masuk bulan
								<?php 
									if($bulan=="/01/"){echo "Januari";}elseif($bulan=="/02/"){echo "Februari";}elseif($bulan=="/03/"){echo "Maret";}
									elseif($bulan=="/04/"){echo "April";}elseif($bulan=="/05/"){echo "Mei";}elseif($bulan=="/06/"){echo "Juni";}
									elseif($bulan=="/07/"){echo "Juli";}elseif($bulan=="/08/"){echo "Agustus";}elseif($bulan="/09/"){echo "September";}
									elseif($bulan=="/10/"){echo "Oktober";}elseif($bulan="/11/"){echo "November";}elseif($bulan=="/12/"){echo "Desember";}
								?>&nbsp;tahun <?php echo $tahun;?> dengan nama barang: <?php echo $nm_brg;?>
							</div>
						</div>
						<table style="font-size:13px" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center"><input style="margin-bottom:7px" type="checkbox" name="checkall" class="check" id="checkAll" /><br><small class="label bg-blue">Pilih Semua</small></th>
									<th>Urut</th>
									<th>Tanggal Transaksi</th>
									<th>Nama Bahan</th>
									<th>Jumlah Transaksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$urut=1;
									while($cr=$query->fetch(PDO::FETCH_ASSOC)){
								?>
									<tr>
										<td class="text-center"><input type="checkbox" class="check" name="cek[]" value="<?php echo $cr['id_masuk'];?>"></td>
										<td><?php echo $urut++;?></td>
										<td><?php echo tgl_lengkap($cr['tgl']);?></td>
										<td><?php echo $cr['nama_barang'];?></td>
										<td><?php echo $cr['jml'] . "&nbsp;" . $cr['nama_satuan'];?></td>
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