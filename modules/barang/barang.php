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

//Simpan barang 
if(isset($_POST['barang'])){
	$kode_barang = $_POST['kode_barang'];
	$nama_barang = $_POST['nama_barang'];
	$kategori    = $_POST['kategori'];
	$satuan      = $_POST['satuan'];
	$exp_date    = $_POST['exp_date'];
	$stmt = $db->prepare("INSERT INTO far_barang set kode_barang = ?, nama_barang = ?, nama_kategori = ?, nama_satuan = ?, exp_date = ?");
	$stmt->bindParam(1, $kode_barang);
	$stmt->bindParam(2, $nama_barang);
	$stmt->bindParam(3, $kategori);
	$stmt->bindParam(4, $satuan);
	$stmt->bindParam(5, $exp_date);
	if(!$stmt->execute()){
		print_r($stmt->errorInfo());
	}else{		
		$Pesan = 'Data bahan berhasil disimpan';
	}	
}

//Edit Barang
if(isset($_POST['edit'])){
	$id_barang   = $_POST['id_barang'];
	$kode_barang = $_POST['kode_barang'];
	$nama_barang = $_POST['nama_barang'];
	$kategori    = $_POST['kategori'];
	$satuan      = $_POST['satuan'];
	$exp_date    = $_POST['exp_date'];
	$edit = $db->prepare("UPDATE far_barang SET kode_barang = ?, nama_barang = ?, nama_kategori = ?, nama_satuan = ?, exp_date = ? WHERE id_barang = ?");
	$edit->bindParam(1, $kode_barang);
	$edit->bindParam(2, $nama_barang);
	$edit->bindParam(3, $kategori);
	$edit->bindParam(4, $satuan);
	$edit->bindParam(5, $exp_date);
	$edit->bindParam(6, $id_barang);
	if(!$edit->execute()){
		print_r($edit->errorInfo());
	}else{
		$Pesan = 'Data bahan berhasil diperbarui';
	}
}

//Import Barang
if(isset($_POST['import'])){
	$target = basename($_FILES['Pengadaan']['name']) ;
    move_uploaded_file($_FILES['Pengadaan']['tmp_name'], $target);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['Pengadaan']['name'],false);    

    $baris = $data->rowcount($sheet_index=0);       

    for ($i=2; $i<=$baris; $i++)
    {
		$kode_barang   	= $data->val($i, 1);
		$nama_barang	= $data->val($i, 2);
		$nama_kategori	= $data->val($i, 3);
		$nama_satuan	= $data->val($i, 4);
		$exp_date		= $data->val($i, 5);
		
		$import = $db->prepare("INSERT INTO far_barang set kode_barang = ?, nama_barang = ?, nama_kategori = ?, nama_satuan = ?, exp_date = ?");
		$import->bindParam(1, $kode_barang);
		$import->bindParam(2, $nama_barang);
		$import->bindParam(3, $nama_kategori);
		$import->bindParam(4, $nama_satuan);
		$import->bindParam(5, $exp_date);
		if(!$import->execute()){
			print_r($import->errorInfo());
		}else{		
			echo "<script>window.location='index.php?module=barang&file=barang'</script>";
			//echo "<script>$(document).ready(function(){var unique_id = $.gritter.add({title:'Welcome to Dashgum!',text:'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for',image:'assets/img/ui-sam.jpg',sticky: true,time: '',class_name:'my-sticky-class'});return false;});</script>";
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
                  <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#TambahBarang"><i class="fa fa-plus fa-fw"></i>Tambah Data Bahan</button>&nbsp;&nbsp;
				  <!--<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#ImportBarang"><i class="fa fa-upload fa-fw"></i>Import Data Barang</button>-->
            </div>
			<div class="box-body">
				
					<div class="col-md-6">
						<?php if(isset($Pesan)){ ?>
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $Pesan; ?>
								<script>window.location.replace("?module=barang&file=barang");</script>
							</div>
							<?php } if(isset($_GET['code']) && $_GET['code'] == 1){ ?>
							<div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								Data bahan berhasil dihapus
								<script>window.location.replace("?module=barang&file=barang");</script>
							</div>
						<?php } ?>
					</div>
				
				<?php
					$brg = $db->prepare("SELECT far_barang.id_barang, far_barang.kode_barang, far_barang.nama_barang, far_barang.nama_kategori, far_barang.nama_satuan, far_barang.exp_date, far_stock.stok_tersedia FROM far_barang LEFT JOIN far_stock ON far_barang.id_barang = far_stock.id_barang GROUP BY far_barang.nama_barang");
					$brg->execute();
					$barang = $brg->fetchAll();	
					$urut = 1;
				?>
					<table id="Barang" style="font-size:13px" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="col-xs-1">Urut</th>
								<th>Kode Barang</th>
								<th>Nama Barang</th>
								<th>Kategori</th>
								<th>Stok</th>
								<th>Satuan</th>
								<th>Tgl Expire</th>
								<th>Aksi</th>
							</tr>						
						</thead>				
						<tbody>
							<?php foreach($barang as $barang){ ?>
							<tr>
								<td><?php echo $urut++ ?></td>
								<td><?php echo $barang['kode_barang'];?></td>
								<td><?php echo $barang['nama_barang'];?></td>
								<td><?php echo $barang['nama_kategori']?></td>
								<td><?php 
										if($barang['stok_tersedia'] == 0){
											echo "0";
										}else{
											echo $barang['stok_tersedia'];
										}?>
								</td>
								<td><?php echo $barang['nama_satuan'];?></td>
								<td><?php echo tgl_lengkap($barang['exp_date']);?></td>
								<td>
									<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#EditBarang-<?php echo $barang['id_barang'];?>"><i class="fa fa-pencil"></i></a>
									<form method="POST" action="?module=barang&file=del_Barang&id=<?php echo $barang['id_barang']; ?>" accept-charset="UTF-8" style="display:inline">
											<button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#confirmDelete" title="Hapus Data">
												<i class="fa fa-trash-o fa-fw"></i>
											</button>
									</form>
								</td>
							</tr>
								<!--EDIT BARANG-->
								<div class="modal fade" id="EditBarang-<?php echo $barang['id_barang'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Edit Data Barang</h4>
											</div>
											<form method="post" action="">
												<div class="modal-body">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>ID Barang</label>
																<div class="row">
																	<div class="col-xs-5">
																		<input type="text" name="id_barang" class="form-control" value="<?php echo $barang['id_barang'];?>" readonly />																											
																	</div>
																</div>
															</div>
															<div class="form-group">
																<label>Kode Barang</label>
																<div class="row">
																	<div class="col-xs-5">
																		<input type="text" name="kode_barang" class="form-control" value="<?php echo $barang['kode_barang'];?>" required />																												
																	</div>	
																</div>
															</div>
															<div class="form-group">
																<label>Nama Barang</label>						
																<input type="text" name="nama_barang" class="form-control" value="<?php echo $barang['nama_barang'];?>" required />																												
															</div>
														</div>
														<div class="col-sm-5">
															<div class="form-group">
																<label>Kategori</label>
																<select name="kategori" class="form-control" required>
																	<option selected><?php echo $barang['nama_kategori'];?></option>
																		<?php
																			$kat=$db->prepare("SELECT nama_kategori FROM far_kategori ORDER BY nama_kategori");
																			$kat->execute();
																			while($k=$kat->fetch()){
																				echo "<option>".$k['nama_kategori']."</option>";
																			}
																		?>
																	</select>
															</div>
															<div class="form-group">
																<label>Satuan</label>						
																<select name="satuan" class="form-control" required>
																	<option selected><?php echo $barang['nama_satuan'];?></option>
																	<?php
																		$s=$db->prepare("SELECT nama_satuan FROM far_satuan ORDER BY nama_satuan");
																		$s->execute();
																		while($sat=$s->fetch()){
																			echo "<option>".$sat['nama_satuan']."</option>";
																		}
																	?>
																</select>
															</div>
															<div class="form-group">
																<label>Tanggal Expire</label>
																<input id="barang_edit" name="exp_date" type="text" class="form-control" value="<?php echo $barang['exp_date'];?>" />																
															</div>
														</div>
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
<!--TAMBAH BARANG-->
<div class="modal fade" id="TambahBarang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Tambah Data Barang</h4>
			</div>
			<form method="post" action="">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Kode Barang</label>
								<div class="row">
								<div class="col-xs-5">
									<input type="text" name="kode_barang" class="form-control" required />
								</div>
								</div>
							</div>
							<div class="form-group">
								<label>Nama Barang</label>						
								<input type="text" name="nama_barang" class="form-control" required />													
							</div>
							<div class="form-group">
								<label>Kategori</label>						
								<select name="kategori" class="form-control" required>
									<option value="">Pilih Kategori:</option>
									<?php
										$kat=$db->prepare("SELECT nama_kategori FROM far_kategori ORDER BY nama_kategori");
										$kat->execute();
										while($k=$kat->fetch()){
											echo "<option value=\"".$k['nama_kategori']."\">".$k['nama_kategori']."</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label>Satuan</label>						
									<select name="satuan" class="form-control" required>
										<option value="">Pilih Satuan:</option>
										<?php
											$s=$db->prepare("SELECT nama_satuan FROM far_satuan ORDER BY nama_satuan");
											$s->execute();
											while($sat=$s->fetch()){
												echo "<option value=\"".$sat['nama_satuan']."\">".$sat['nama_satuan']."</option>";
											}
										?>
									</select>
							</div>
							<div class="form-group">
								<label>Expire Date</label>
								<input id="barang_tmbh" type="text" name="exp_date" class="form-control" />
							</div>
						</div>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="submit" name="barang" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--IMPORT BARANG-->
<div class="modal fade" id="ImportBarang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Import Data Barang</h4>
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
					<button type="submit" name="import" class="btn btn-primary">Simpan</button>
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
		watermark: ['','','cari barang...'],
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
		col_3: 'select',
		col_4: 'select',
		col_5: 'select',
		col_6: 'none',
		col_7: 'none',
		custom_options: {
            cols:[4],
            texts: [
                [
                    'na', '0 - 5', '5 - 20',
                    '20 - 50', '50 - 100', '100 - 150',
                    '150 - 200', '200 - 250', 'not na'
                ]
            ],
            values: [
                [
                    'na', '>0 && <=5', '>5 && <=20',
                    '>20 && <=50', '>50 && <=100',
                    '>100 && <=150', '>150 && <=200', '>200 && <=250', '!na'
                ]
            ],
            sorts: [false]
        },
		no_results_message: {
			content: '<h3>Tidak ada data</h3>'
		},
    };
	var tf = new TableFilter('Barang', filtersConfigEs);    
    tf.init();
</script>