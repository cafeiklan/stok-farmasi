<?php
function blnRomawi($bln){
	switch($bln){
		case 01:
			$rmw = "I";
		break;
		case 02:
			$rmw = "II";
		break;
		case 03:
			$rmw = "III";
		break;
		case 04:
			$rmw = "IV";
		break;
		case 05:
			$rmw = "V";
		break;
		case 06:
			$rmw = "VI";
		break;
		case 07:
			$rmw = "VII";
		break;
		case 08:
			$rmw = "VIII";
		break;
		case 09:
			$rmw = "IX";
		break;
		case 10:
			$rmw = "X";
		break;
		case 11:
			$rmw = "XI";
		break;
		case 12:
			$rmw = "XII";
		break;
	}
	return $rmw;
}

function selisih_tgl($tgl1, $tgl2){
	$hari1	= substr($tgl1,0,2);
	$bulan1	= substr($tgl1,3,2);
	$tahun1	= substr($tgl1,6,4);
	$hari2	= substr($tgl2,0,2);
	$bulan2	= substr($tgl2,3,2);
	$tahun2	= substr($tgl2,6,4);
	$tanggal1 = @gregoriantojd($bulan1, $hari1, $tahun1);
	$tanggal2 = @gregoriantojd($bulan2, $hari2, $tahun2);
	$selisih = $tanggal2 - $tanggal1;
	return $selisih;
}

function tgl_lengkap($tgl){
	$hari	= substr($tgl,0,2);
	$bulan	= getBulan(substr($tgl,3,2));
	$tahun	= substr($tgl,6,4);
	return $hari.' '.$bulan.' '.$tahun;
}

function getBulan($bln){
	switch ($bln){
		case 1:
			return "Januari";
		break;
		case 2:
			return "Februari";
		break;
		case 3:
			return "Maret";
		break;
		case 4:
			return "April";
		break;
		case 5:
			return "Mei";
		break;
		case 6:
			return "Juni";
		break;
		case 7:
			return "Juli";
		break;
		case 8:
			return "Agustus";
		break;
		case 9:
			return "September";
		break;
		case 10:
			return "Oktober";
		break;
		case 11:
			return "November";
		break;
		case 12:
			return "Desember";
		break;
	}
}
function acakHuruf() {
	$panjangacak = 6;
	$base='ABCDEFGHKLMNOPQRSTWXYZ123456789';
	$max=strlen($base)-1;
	$acak='';
	mt_srand((double)microtime()*1000000);
	
	while (strlen($acak)<$panjangacak) {
		$acak.=$base{mt_rand(0,$max)};
	}
	return $acak;
}
function antixss($data)
		{
		$xss = htmlspecialchars(trim($data));
		return $xss;
	}
function getFilter($url){
	echo "<select class=\"form-control\" onchange='document.location=this.value' onBlur=\"unfokus('filter')\" onFocus=\"panggil('filter')\" >"
		."<option value='$url'>Semua Unit</option>";

	$q = "SELECT nama, login FROM user WHERE statususer='client' ORDER BY login";
	$s = $db->prepare($q);
	$s->execute();
	while($row = $s->fetchAll()){
		if($_GET[by] == $row[nama]) $pilih = 'selected'; else $pilih = '';
		echo "<option value='$url&by=$row[nama]' $pilih>- $row[login]</option>";
	}

	if($_GET[by] == 'Yayasan') $y = 'selected';
	echo "<option value='$url&by=Yayasan' $y>- Yayasan Mahadhika</option>";
	echo "</select><br/><br/>";
}

?>