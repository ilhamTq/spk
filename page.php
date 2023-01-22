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
	case 'data_ukm':
		$page="include 'includes/p_ukm.php';";
		break;
	case 'update_ukm':
		$page="include 'includes/p_ukm_update.php';";
		break;
	case 'data_kriteria_ukm':
		$page="include 'includes/p_kriteria_ukm.php';";
		break;
	case 'update_kriteria_ukm':
		$page="include 'includes/p_kriteria_ukm_update.php';";
		break;
	case 'nilai_kriteria_ukm':
		$page="include 'includes/p_nilai_kriteria_ukm.php';";
		break;
	case 'nilai_ukm':
		$page="include 'includes/p_nilai_ukm.php';";
		break;
	case 'hasil_ukm':
		$page="include 'includes/p_hasil_ukm.php';";
		break;

	default:
		$page="include 'includes/p_home.php';";
		break;
}
$CONTENT_["main"]=$page;

?>