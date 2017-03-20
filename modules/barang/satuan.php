<?php

########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################

	if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};
	
	//Simpan satuan 
	if(isset($_POST['satuan'])){
		$nama_satuan = $_POST['nama_satuan'];
		$stmt = $db->prepare("INSERT INTO far_satuan set nama_satuan = ?");
		$stmt->bindParam(1, $nama_satuan);
		if(!$stmt->execute()){
			print_r($stmt->errorInfo());
			}else{
			$Pesan = 'Data satuan baru berhasil disimpan';
		}	
	}
	
	//Edit SATUAN
	if(isset($_POST['edit'])){
		$id_satuan = $_POST['id_satuan'];
		$nama_satuan = $_POST['nama_satuan'];
		$edit = $db->prepare("UPDATE far_satuan SET nama_satuan = '".$nama_satuan."' WHERE id_satuan = '".$id_satuan."'");	
		if(!$edit->execute()){
			print_r($edit->errorInfo());
			}else{
			$Pesan = 'Data satuan berhasil diperbarui';
		}
	}
?>
<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#TambahSatuan"><i class="fa fa-plus fa-fw"></i>Tambah Data Satuan</button>
			</div>
			<div class="box-body">
				<div class="col-md-8">
					<?php if(isset($Pesan)){ ?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $Pesan; ?>
							<script>window.location.replace("?module=barang&file=satuan");</script>
						</div>
						<?php } if(isset($_GET['code']) && $_GET['code'] == 1){ ?>
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Data satuan berhasil dihapus
							<script>window.location.replace("?module=barang&file=satuan");</script>
						</div>
					<?php } ?>
				</div>
				<?php
					$sat = $db->prepare("SELECT id_satuan, nama_satuan FROM far_satuan ORDER BY nama_satuan");
					$sat->execute();
					$satuan = $sat->fetchAll();	
					$urut = 1;
				?>
				<table id="Satuan" style="font-size:13px" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="col-xs-1">Urut</th>
							<th class="col-xs-4">Nama Satuan</th>
							<th class="col-xs-3">Aksi</th>
						</tr>						
					</thead>				
					<tbody>
						<?php foreach($satuan as $satuan){ ?>
							<tr>
								<td><?php echo $urut++ ?></td>
								<td><?php echo $satuan['nama_satuan']?></td>
								<td>
									<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#EditSatuan-<?php echo $satuan['id_satuan'];?>"><i class="fa fa-pencil"></i></a>
									<form method="POST" action="?module=barang&file=del_Satuan&id=<?php echo $satuan['id_satuan']; ?>" accept-charset="UTF-8" style="display:inline">
										<button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#confirmDelete" title="Hapus Data">
											<i class="fa fa-trash-o fa-fw"></i>
										</button>
									</form>
								</td>
							</tr>
							<!--EDIT SATUAN-->
							<div class="modal fade" id="EditSatuan-<?php echo $satuan['id_satuan'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">Edit Data Satuan Barang</h4>
										</div>
										<form method="post" action="">
											<div class="modal-body">
												<div class="form-group">
													<label>ID Satuan</label>						
													<input type="text" name="id_satuan" class="form-control" value="<?php echo $satuan['id_satuan'];?>" readonly />																											
												</div>
												<div class="form-group">
													<label>Nama Satuan</label>						
													<input type="text" name="nama_satuan" class="form-control" value="<?php echo $satuan['nama_satuan'];?>" required />
													<p class="help-text">Contoh: KG, Liter, Gram, Ons, Pcs</p>														
												</div>
											</div>
											<div class="modal-footer">
												<button type="submit" name="edit" class="btn btn-primary">Simpan</button>
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
<!--TAMBAH SATUAN-->
<div class="modal fade" id="TambahSatuan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Data Satuan Barang</h4>
			</div>
			<form method="post" action="">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Satuan</label>						
						<input type="text" name="nama_satuan" class="form-control" required />
						<p class="help-text">Contoh: KG, Liter, Gram, Ons, Pcs</p>						
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="satuan" class="btn btn-primary">Simpan</button>
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
	watermark: ['','cari satuan...'],
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
	col_3: 'select',		
	custom_options: {
	cols:[0],
	texts: [
	[
	'2013', '2014', '2015', '2016'                    
	]
	],
	values: [
	[
	'*2013', '*2014', '*2015', '*2016'                    
	]
	],
	sorts: [false]
	},
	no_results_message: {
	content: '<h3>Tidak ada data</h3>'
	},
	};
	var tf = new TableFilter('Satuan', filtersConfigEs);    
	tf.init();
	</script>												