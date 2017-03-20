<?php
########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################

	if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	include_once('config/excel_reader.php');
	
	//Simpan Alat
	if(isset($_POST['alat_simpan'])){
		$nama_alat   = $_POST['nama_alat'];
		$ukuran      = $_POST['ukuran'];
		$spesifikasi = $_POST['spesifikasi'];
		$jumlah      = $_POST['jumlah'];
		$kondisi     = $_POST['kondisi'];
		$id_dana  = $_POST['id_dana'];
		$now = date("F j, Y - H:i:s");
		$alat_simpan = $db->prepare("INSERT INTO far_alat SET nama_alat = ?, ukuran = ?, spesifikasi = ?, jumlah = ?, kondisi = ?, id_dana = ?, last_update = ?");
		$alat_simpan->bindParam(1, $nama_alat);
		$alat_simpan->bindParam(2, $ukuran);
		$alat_simpan->bindParam(3, $spesifikasi);
		$alat_simpan->bindParam(4, $jumlah);
		$alat_simpan->bindParam(5, $kondisi);
		$alat_simpan->bindParam(6, $id_dana);
		$alat_simpan->bindParam(7, $now);
		if(!$alat_simpan->execute()){
			print_r($alat_simpan->errorInfo());
			}else{
			$Pesan ='Alat Baru berhasil disimpan';
		}
	}
	
	//Edit Alat
	if(isset($_POST['edit_alat'])){
		$id_alat     = $_POST['id_alat'];
		$nama_alat   = $_POST['nama_alat'];
		$ukuran      = $_POST['ukuran'];
		$spesifikasi = $_POST['spesifikasi'];
		$jumlah      = $_POST['jumlah'];
		$kondisi     = $_POST['kondisi'];
		$id_dana     = $_POST['id_dana'];
		$now         = date("F j, Y - H:i:s");
		$alat_edit = $db->prepare("UPDATE far_alat SET nama_alat = ?, ukuran = ?, spesifikasi = ?, jumlah = ?, kondisi = ?, id_dana = ?, last_update = ? WHERE id_alat = ?");
		$alat_edit->bindParam(1, $nama_alat);
		$alat_edit->bindParam(2, $ukuran);
		$alat_edit->bindParam(3, $spesifikasi);
		$alat_edit->bindParam(4, $jumlah);
		$alat_edit->bindParam(5, $kondisi);
		$alat_edit->bindParam(6, $id_dana);
		$alat_edit->bindParam(7, $now);
		$alat_edit->bindParam(8, $id_alat);
		if(!$alat_edit->execute()){
			print_r($alat_edit->errorInfo());
			}else{
			$Pesan ='Data alat berhasil diperbarui';
		}
	}
	
	//Import Alat
	if(isset($_POST['import_alat'])){
		$target = basename($_FILES['Pengadaan']['name']) ;
		move_uploaded_file($_FILES['Pengadaan']['tmp_name'], $target);
		
		$data = new Spreadsheet_Excel_Reader($_FILES['Pengadaan']['name'],false);    
		
		$baris = $data->rowcount($sheet_index=0);       
		
		for ($i=2; $i<=$baris; $i++){
			$nama_alat   = $data->val($i, 1);
			$ukuran      = $data->val($i, 2);
			$spesifikasi = $data->val($i, 3);
			$jumlah      = $data->val($i, 4);
			$kondisi     = $data->val($i, 5);
			$now         = date("F j, Y - H:i:s");
			$import = $db->prepare("INSERT INTO far_alat SET nama_alat = ?, ukuran = ?, spesifikasi = ?, jumlah = ?, kondisi = ?, last_update = ?");
			$import->bindParam(1, $nama_alat);
			$import->bindParam(2, $ukuran);
			$import->bindParam(3, $spesifikasi);
			$import->bindParam(4, $jumlah);
			$import->bindParam(5, $kondisi);
			$import->bindParam(6, $now);
			if(!$import->execute()){
				print_r($import->errorInfo());
				}else{
				echo "<script>window.location='index.php?module=barang&file=alat'</script>";
			}
		}
		unlink($_FILES['Pengadaan']['name']);
	}
?>
<style>
	.datepicker{ z-index:1100 !important; }
</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#TambahAlat"><i class="fa fa-plus fa-fw"></i>Tambah Data Alat</button>&nbsp;&nbsp;
				<!--<button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#ImportAlat"><i class="fa fa-upload fa-fw"></i>Import Data Alat</button>-->
			</div>
			<div class="box-body">
				
				<div class="col-md-6">
					<?php if(isset($Pesan)){ ?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $Pesan; ?>
							<script>window.location.replace("?module=barang&file=alat");</script>
						</div>
						<?php } if(isset($_GET['code']) && $_GET['code'] == 1){ ?>
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Data alat berhasil dihapus
							<script>window.location.replace("?module=barang&file=alat");</script>
						</div>
					<?php } ?>
				</div>
				
				<?php
					$stmt = $db->prepare("SELECT id_alat, nama_alat, ukuran, spesifikasi, jumlah, kondisi, id_dana, sumberdana, last_update FROM far_alat INNER JOIN far_dana USING(id_dana) ORDER BY nama_alat");
					$stmt->execute();
					$alat = $stmt->fetchAll();
					$urut = 1;					
				?>
				<table id="Alat" style="font-size:10pt" class="table table-striped table-bordered">
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
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($alat as $alat){
							?>
							<tr>
								<td class="text-center"><?php echo $urut++;?></td>
								<td><?php echo $alat['nama_alat'];?></td>
								<td class="text-center"><?php echo $alat['ukuran'];?></td>
								<td><?php echo nl2br($alat['spesifikasi']);?></td>
								<td class="text-center"><?php echo $alat['jumlah'];?></td>
								<td><?php echo wordwrap($alat['kondisi'],15,"<br>\n");?></td>
								<td class="text-center"><?php echo $alat['sumberdana'];?></td>
								<td class="text-center"><?php echo $alat['last_update'];?></td>
								<td class="text-center">
									<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#EditAlat-<?php echo $alat['id_alat'];?>"><i class="fa fa-pencil"></i></a>
									<form method="POST" action="?module=barang&file=del_Alat&id=<?php echo $alat['id_alat']; ?>" accept-charset="UTF-8" style="display:inline">
										<button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#confirmDelete" title="Hapus Data">
											<i class="fa fa-trash-o fa-fw"></i>
										</button>
									</form>
								</td>
							</tr>
							<!--EDIT Alat-->
							<div class="modal fade" id="EditAlat-<?php echo $alat['id_alat'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">Edit Data Alat</h4>
										</div>
										<form method="post" action="">
											<div class="modal-body">
												<div class="form-group">
													<label>Nama Alat</label>
													<input type="hidden" name="id_alat" value="<?php echo $alat['id_alat'];?>" />
													<input type="text" name="nama_alat" class="form-control" value="<?php echo $alat['nama_alat'];?>" />
												</div>
												<div class="form-group">
													<label>Ukuran</label>
													<div class="row">
														<div class="col-xs-3">
															<input type="text" name="ukuran" class="form-control" value="<?php echo $alat['ukuran'];?>" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Spesifikasi</label>
													<textarea name="spesifikasi" class="form-control" rows="3"><?php echo $alat['spesifikasi'];?></textarea>
												</div>
												<div class="form-group">
													<label>Jumlah</label>
													<div class="row">
														<div class="col-xs-3">
															<input type="text" name="jumlah" class="form-control" value="<?php echo $alat['jumlah'];?>" />
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Kondisi</label>
													<textarea name="kondisi" class="form-control" rows="3"><?php echo $alat['kondisi'];?></textarea>
												</div>
												<div class="form-group">
													<label>Sumber Pembelian</label>
													<select name="id_dana" class="form-control">
														<option value="<?= $alat['id_dana'];?>" selected><?= $alat['sumberdana'];?></option>
														<?php
															$dana2 = $db->prepare("SELECT id_dana, sumberdana FROM far_dana ORDER BY id_dana");
															$dana2->execute();
															$sbdana2 = $dana2->fetchAll();
														?>														
														<?php foreach($sbdana2 as $sbdana2){ ?>
															<option value="<?= $sbdana2['id_dana'];?>"><?= $sbdana2['sumberdana'];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="modal-footer">
												<button type="submit" name="edit_alat" class="btn btn-primary">Simpan</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!--TAMBAH ALAT-->
<div class="modal fade" id="TambahAlat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Data Alat</h4>
			</div>
			<form method="post" action="">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Alat</label>
						<input type="text" name="nama_alat" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Ukuran</label>
						<div class="row">
							<div class="col-xs-3">
								<input type="text" name="ukuran" class="form-control" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Spesifikasi</label>
						<textarea name="spesifikasi" class="form-control" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label>Jumlah</label>
						<div class="row">
							<div class="col-xs-3">
								<input type="text" name="jumlah" class="form-control" required />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Kondisi</label>
						<textarea name="kondisi" class="form-control" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label>Sumber Pembelian</label>
						<select name="id_dana" class="form-control">
							<?php
								$dana = $db->prepare("SELECT id_dana, sumberdana FROM far_dana ORDER BY id_dana");
								$dana->execute();
								$sbdana = $dana->fetchAll();
							?>
							<option name="">--Pilih Sumber Dana--</option>
							<?php foreach($sbdana as $sbdana){ ?>
								<option value="<?= $sbdana['id_dana'];?>"><?= $sbdana['sumberdana'];?></option>
							<?php } ?>							
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="alat_simpan" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--IMPORT ALAT-->
<div class="modal fade" id="ImportAlat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Import Data Alat</h4>
			</div>
			<form method="post" action="" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label>Upload File Excel</label>
						<input type="file" id="Pengadaan" name="Pengadaan" class="form-control" />
						<p id="file_error1" class="help-block" style="display:none; color:#FF0000;">Form ini hanya mendukung format Excel 2003 (xls). Save as file excel anda dengan type "Excel 1997-2003 Workbook".</p>
						<p id="file_error2" class="help-block" style="display:none; color:#FF0000;">Maksimal ukuran file 500KB.</p>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="submit" name="import_alat" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--TABLE FILTER-->
<script src="assets/plugins/tablefilter/tablefilter.js"></script>
<script data-config>
	var filtersConfigEs = {
		base_path: 'assets/plugins/tablefilter/',
		watermark: ['','cari alat...'],
		enable_default_theme: true,
		paging: true,		
		results_per_page: ['Records: ', [10,25,50,100]],
		remember_grid_values: true,
		remember_page_number: true,
		remember_page_length: true,		
		rows_counter: true,
		btn_reset: true,
		btn_reset_text: 'Clear',
		col_0: 'none',
		col_2: 'none',
		col_3: 'none',
		col_4: 'none',
		col_5: 'none',
		col_6: 'select',
		col_7: 'none',	
		col_8: 'none',
		no_results_message: {
			content: '<h3>Tidak ada data</h3>'
		},
	};
	var tf = new TableFilter('Alat', filtersConfigEs);    
	tf.init();
</script>																	