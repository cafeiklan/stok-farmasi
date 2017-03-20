<?php

########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################

if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Error , Contact oetjoe.soerjadi@gmail.com');};

//Simpan kategori 
if(isset($_POST['kategori'])){
	$kode_kategori = $_POST['kode_kategori'];
	$nama_kategori = $_POST['nama_kategori'];
	$stmt = $db->prepare("INSERT INTO far_kategori set kode_kategori = ?, nama_kategori = ?");
	$stmt->bindParam(1, $kode_kategori);
	$stmt->bindParam(2, $nama_kategori);
	if(!$stmt->execute()){
		print_r($stmt->errorInfo());
	}else{
		$Pesan = 'Data kategori baru berhasil disimpan';
	}	
}

//Edit Kategori
if(isset($_POST['edit'])){
	$id_kategori   = $_POST['id_kategori'];
	$kode_kategori = $_POST['kode_kategori'];
	$nama_kategori = $_POST['nama_kategori'];
	$edit = $db->prepare("UPDATE far_kategori SET kode_kategori = '".$kode_kategori."', nama_kategori = '".$nama_kategori."' WHERE id_kategori = '".$id_kategori."'");	
	if(!$edit->execute()){
		print_r($edit->errorInfo());
	}else{
		$Pesan = 'Data kategori berhasil diperbarui';
	}
}
?>
<div class="row">
	<div class="col-md-8">
		<div class="box box-success">
			<div class="box-header with-border">
                  <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#TambahKategori"><i class="fa fa-plus fa-fw"></i>Tambah Data Kategori</button>
            </div>
			<div class="box-body">
				<div class="col-md-8">
					<?php if(isset($Pesan)){ ?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<?php echo $Pesan; ?>
							<script>window.location.replace("?module=barang&file=kategori");</script>
						</div>
						<?php } if(isset($_GET['code']) && $_GET['code'] == 1){ ?>
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Data kategori berhasil dihapus
							<script>window.location.replace("?module=barang&file=kategori");</script>
						</div>
					<?php } ?>
				</div>
				<?php
					$kat = $db->prepare("SELECT id_kategori, kode_kategori, nama_kategori FROM far_kategori ORDER BY nama_kategori");
					$kat->execute();
					$kategori = $kat->fetchAll();	
					$urut = 1;
				?>
					<table id="Kategori" style="font-size:13px" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="col-xs-1">Urut</th>
								<th class="col-xs-3">Kode Kategori</th>
								<th class="col-xs-4">Nama Kategori</th>
								<th class="col-xs-2">Aksi</th>
							</tr>						
						</thead>				
						<tbody>
							<?php foreach($kategori as $kategori){ ?>
							<tr>
								<td><?php echo $urut++ ?></td>
								<td><?php echo $kategori['kode_kategori'];?></td>
								<td><?php echo $kategori['nama_kategori']?></td>
								<td>
									<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#EditKategori-<?php echo $kategori['id_kategori'];?>"><i class="fa fa-pencil"></i></a>
									<form method="POST" action="?module=barang&file=del_Kategori&id=<?php echo $kategori['id_kategori']; ?>" accept-charset="UTF-8" style="display:inline">
											<button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#confirmDelete" title="Hapus Data">
												<i class="fa fa-trash-o fa-fw"></i>
											</button>
									</form>
								</td>
							</tr>
								<!--EDIT SATUAN-->
								<div class="modal fade" id="EditKategori-<?php echo $kategori['id_kategori'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Edit Data Kategori Barang</h4>
											</div>
											<form method="post" action="">
												<div class="modal-body">
													<div class="form-group">
														<label>ID Kategori</label>						
														<input type="text" name="id_kategori" class="form-control" value="<?php echo $kategori['id_kategori'];?>" readonly />																											
													</div>
													<div class="form-group">
														<label>Kode Kategori</label>						
														<input type="text" name="kode_kategori" class="form-control" value="<?php echo $kategori['kode_kategori'];?>" required />																												
													</div>
													<div class="form-group">
														<label>Nama Kategori</label>						
														<input type="text" name="nama_kategori" class="form-control" value="<?php echo $kategori['nama_kategori'];?>" required />																												
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
<div class="modal fade" id="TambahKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Data Kategori Barang</h4>
			</div>
			<form method="post" action="">
				<div class="modal-body">
					<div class="form-group">
						<label>Kode Kategori</label>						
							<input type="text" name="kode_kategori" class="form-control" />													
					</div>
					<div class="form-group">
						<label>Nama Kategori</label>						
							<input type="text" name="nama_kategori" class="form-control" required />													
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="kategori" class="btn btn-primary">Simpan</button>
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
		watermark: ['','','cari kategori...'],
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
	var tf = new TableFilter('Kategori', filtersConfigEs);    
    tf.init();
</script>