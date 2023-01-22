<?php
$page=$_GET['hal'];
switch($page){
	case 'data_supplier':
		$page="include 'includes/p_supplier.php';";
		break;
	case 'update_supplier':
		$page="include 'includes/p_supplier_update.php';";
		break;
	case 'data_kriteria':
		$page="include 'includes/p_kriteria.php';";
		break;
	case 'update_kriteria':
		$page="include 'includes/p_kriteria_update.php';";
		break;
	case 'ubah_password':
		$page="include 'includes/p_ubah_password.php';";
		break;
	case 'nilai_kriteria':
		$page="include 'includes/p_nilai_kriteria.php';";
		break;
	case 'nilai_supplier':
		$page="include 'includes/p_nilai_supplier.php';";
		break;
	case 'hasil_supplier':
		$page="include 'includes/p_hasil_supplier.php';";
		break;
	case 'data_produk':
		$page="include 'includes/p_produk.php';";
		break;
	case 'update_produk':
		$page="include 'includes/p_produk_update.php';";
		break;
	case 'data_kriteria_produk':
		$page="include 'includes/p_kriteria_produk.php';";
		break;
	case 'update_kriteria_produk':
		$page="include 'includes/p_kriteria_produk_update.php';";
		break;
	case 'nilai_kriteria_produk':
		$page="include 'includes/p_nilai_kriteria_produk.php';";
		break;
	case 'nilai_produk':
		$page="include 'includes/p_nilai_produk.php';";
		break;
	case 'hasil_produk':
		$page="include 'includes/p_hasil_produk.php';";
		break;

	default:
		$page="include 'includes/p_home.php';";
		break;
}
$CONTENT_["main"]=$page;

?>