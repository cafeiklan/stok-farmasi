<?php
########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################
?>
<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Hapus Data</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin akan menghapus data terpilih?</p>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-danger" id="confirm"><i class="fa fa-trash fa-fw"></i>Hapus</button>
		<button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i>Batal</button>
      </div>
    </div>
  </div>
</div>