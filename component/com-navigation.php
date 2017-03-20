<?php
########################################################
#	Sistem Informasi Stok Farmasi Versi 1.1 (Maret 2017)
#	Dikembangkan untuk digunakan di SMK Farmasi Mahadhika 4 
#	Tidak untuk diperjualbelikan
#	Dikembangkan oleh : Ucu Suryadi (oetjoe.soerjadi@gmail.com) - http://ucu.suryadi.my.id
# 	Hak Cipta hanya milik Allah SWT
########################################################
?>
<ul class="sidebar-menu">
	<li class="header">NAVIGASI UTAMA</li>
	<li><a href="index.php"><i class="fa fa-home"></i> <span>Beranda</span></a></li>
	<li class="treeview">
		<a href="#">
            <i class="fa fa-dashboard"></i> <span>Data Master</span>
            <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
            <li><a href="?module=barang&file=satuan"><i class="fa fa-list"></i> Data Satuan</a></li>
			<li><a href="?module=barang&file=kategori"><i class="fa fa-list-alt"></i> Data Kategori</a></li>
			<li><a href="?module=barang&file=barang"><i class="fa fa-fire"></i> Data Bahan</a></li>
			<li><a href="?module=barang&file=alat"><i class="fa fa-flask"></i> Data Alat</a></li>
			<li><a href="?module=barang&file=sumberdana"><i class="fa fa-usd"></i> Sumber Dana</a></li>
		</ul>
	</li>
	<li class="treeview">
		<a href="#">
            <i class="fa fa-usd"></i> <span>Transaksi</span>
            <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
            <li><a href="?module=transaksi&file=masuk"><i class="fa fa-hand-o-right"></i> Bahan Masuk</a></li>
			<li><a href="?module=transaksi&file=keluar"><i class="fa fa-hand-o-left"></i> Bahan Keluar</a></li>
		</ul>
	</li>
	<li class="treeview">
		<a href="#">
            <i class="fa fa-briefcase"></i> <span>Laporan</span>
            <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
            <li><a href="?module=laporan&file=Bahan"><i class="fa fa-database"></i> Stok Bahan</a></li>
			<li><a href="?module=laporan&file=Alat"><i class="fa fa-flask"></i> Stok Alat</a></li>
			<li><a href="?module=laporan&file=In"><i class="fa fa-caret-square-o-right"></i> Bahan Masuk</a></li>
			<li><a href="?module=laporan&file=Out"><i class="fa fa-caret-square-o-left"></i> Bahan Keluar</a></li>            
		</ul>
	</li>
	<li class="treeview">
		<a href="#">
            <i class="fa fa-user-md"></i> <span>Pengguna</span>
            <span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
            <li><a href="?module=laboran&file=staff"><i class="fa fa-key"></i> Ganti Password</a></li>
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>            
		</ul>
	</li>
</ul>