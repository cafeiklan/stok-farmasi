<?php

########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################

if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};

//Simpan Sumber Dana Baru
if(isset($_POST['danabaru'])){
	$sumberdana = $_POST['sumberdana'];
	$keterangan = $_POST['keterangan'];
	$query1 = $db->prepare("INSERT INTO far_dana SET sumberdana = ?, keterangan = ?");
	$query1->bindParam(1, $sumberdana);
	$query1->bindParam(2, $keterangan);
	if(!$query1->execute()){
		print_r($query1->errorInfo());
	}else{
		$Pesan = 'Data sumber dana berhasil disimpan';
	}
}
//Simpan Perubahan Sumber Dana
if(isset($_POST['edit'])){
	$id_dana    = $_POST['id_dana'];
	$sumberdana = $_POST['sumberdana'];
	$keterangan = $_POST['keterangan'];
	$query2 = $db->prepare("UPDATE far_dana SET sumberdana = ?, keterangan = ? WHERE id_dana = ?");
	$query2->bindParam(1, $sumberdana);
	$query2->bindParam(2, $keterangan);
	$query2->bindParam(3, $id_dana);
	if(!$query2->execute()){
		print_r($query2->errorInfo());
	}else{
		$Pesan = 'Data Sumber Dana berhasil diperbarui';
	}
}

?>
<div class="row">
	<div class="col-md-8">
		<div class="box box-success">
			<div class="box-header with-border">
                  <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#TambahDana"><i class="fa fa-plus fa-fw"></i>Tambah Sumber Dana</button>
            </div>
			<div class="box-body">
				<div class="col-md-8">
					<?php if(isset($Pesan)){ ?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $Pesan; ?>
							<script>window.location.replace("?module=barang&file=sumberdana");</script>
						</div>
						<?php } if(isset($_GET['code']) && $_GET['code'] == 1){ ?>
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Data sumber dana berhasil dihapus
							<script>window.location.replace("?module=barang&file=sumberdana");</script>
						</div>
					<?php } ?>
				</div>
				<?php
					$queryD = $db->prepare("SELECT id_dana, sumberdana, keterangan FROM far_dana ORDER BY sumberdana");
					$queryD->execute();
					$dana = $queryD->fetchAll();	
					$urut = 1;
				?>
					<table id="Dana" style="font-size:13px" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="col-xs-1">Urut</th>
								<th class="col-xs-3">Sumber Dana</th>
								<th class="col-xs-4">Keterangan</th>
								<th class="col-xs-2">Aksi</th>
							</tr>						
						</thead>				
						<tbody>
							<?php foreach($dana as $dana){ ?>
							<tr>
								<td><?php echo $urut++ ?></td>
								<td><?= $dana['sumberdana'];?></td>
								<td><?= $dana['keterangan']?></td>
								<td>
									<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#EditDana-<?= $dana['id_dana'];?>"><i class="fa fa-pencil"></i></a>
									<form method="POST" action="?module=barang&file=delDana&id=<?= $dana['id_dana']; ?>" accept-charset="UTF-8" style="display:inline">
											<button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#confirmDelete" title="Hapus Data">
												<i class="fa fa-trash-o fa-fw"></i>
											</button>
									</form>
								</td>
							</tr>
								<!--EDIT SATUAN-->
								<div class="modal fade" id="EditDana-<?= $dana['id_dana'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Edit Sumber Dana</h4>
											</div>
											<form method="post" action="">
												<div class="modal-body">
													<div class="form-group">
														<label>ID Sumber Dana</label>						
														<input type="text" name="id_dana" class="form-control" value="<?= $dana['id_dana'];?>" readonly />																											
													</div>
													<div class="form-group">
														<label>Sumber Dana</label>						
														<input type="text" name="sumberdana" class="form-control" value="<?= $dana['sumberdana'];?>" required />																												
													</div>
													<div class="form-group">
														<label>Keterangan</label>						
														<input type="text" name="keterangan" class="form-control" value="<?= $dana['keterangan'];?>" required />																												
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
<!--TAMBAH KATGEORI-->
<div class="modal fade" id="TambahDana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Sumber Dana</h4>
			</div>
			<form method="post" action="">
				<div class="modal-body">
					<div class="form-group">
						<label>Sumber Dana</label>						
							<input type="text" name="sumberdana" class="form-control" required />													
					</div>
					<div class="form-group">
						<label>Keterangan</label>						
							<textarea name="keterangan" class="form-control" rows="3"></textarea>													
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="danabaru" class="btn btn-primary">Simpan</button>
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
		watermark: ['','cari sumber dana...',''],
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
		col_1: 'none',
		col_3: 'none',		
		custom_options: {
            cols:[4],
            texts: [
                [
                    'na', '0 - 5', '5 - 20',
                    '20 - 50', '50 - 100', '100 - 150',
                    '150 - 200', '200 - 250'
                ]
            ],
            values: [
                [
                    'na', '>0 && <=5', '>5 && <=20',
                    '>20 && <=50', '>50 && <=100',
                    '>100 && <=150', '>150 && <=200', '>200 && <=250'
                ]
            ],
            sorts: [false]
        },
		no_results_message: {
			content: '<h3>Tidak ada data</h3>'
		},
    };
	var tf = new TableFilter('Dana', filtersConfigEs);    
    tf.init();
</script>