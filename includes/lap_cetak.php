<?php

require_once ( '../ahp.php' );
require_once '../config.php';



$q="select * from kriteria_ukm order by kode_kriteria_ukm";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$kriteria_ukm[]=array($h['id_kriteria_ukm'],$h['kode_kriteria_ukm'],$h['nama_kriteria_ukm']);
}
$q="select * from ukm order by kode_ukm";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$ukm[]=array($h['id_ukm'],$h['kode_ukm'],$h['nama_ukm']);
}


for($i=0;$i<count($kriteria_ukm);$i++){
	$id_kriteria_ukm[]=$kriteria_ukm[$i][0];
}
$matrik_kriteria_ukm = ahp_get_matrik_kriteria_ukm($id_kriteria_ukm);
$jumlah_kolom = ahp_get_jumlah_kolom($matrik_kriteria_ukm);
$matrik_normalisasi = ahp_get_normalisasi($matrik_kriteria_ukm, $jumlah_kolom);
$eigen_kriteria_ukm = ahp_get_eigen($matrik_normalisasi);

for($i=0;$i<count($ukm);$i++){
	$id_ukm[]=$ukm[$i][0];
}
for($i=0;$i<count($kriteria_ukm);$i++){
	$matrik_ukm = ahp_get_matrik_ukm($kriteria_ukm[$i][0], $id_ukm);
	$jumlah_kolom_ukm = ahp_get_jumlah_kolom($matrik_ukm);
	$matrik_normalisasi_ukm = ahp_get_normalisasi($matrik_ukm, $jumlah_kolom_ukm);
	$eigen_ukm[$i] = ahp_get_eigen($matrik_normalisasi_ukm);
}


$nilai_to_sort = array();



sort($nilai_to_sort);
for($i=0;$i<count($nilai_to_sort);$i++){
	$ranking[$nilai_to_sort[$i][1]]=(count($nilai_to_sort) - $i);
}

$nilai_to_sort = array();

for($i=0;$i<count($ukm);$i++){
	$nilai1=0;
	for($ii=0;$ii<count($kriteria_ukm);$ii++){
		$nilai1 = $nilai1 + ( $eigen_ukm[$ii][$i] * $eigen_kriteria_ukm[$ii]);
	}
	$nilai1 = round( $nilai1 , 3);
	$nilai_global1[$i] = $nilai1;
	$nilai_to_sort[] = array($nilai1, $ukm[$i][0]);
}

sort($nilai_to_sort);
for($i=0;$i<count($nilai_to_sort);$i++){
	$ranking1[$nilai_to_sort[$i][1]]=(count($nilai_to_sort) - $i);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hasil Seleksi ukm</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen">
    <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="../css/grid.css" type="text/css" media="screen">   
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" media="screen">   
    <script src="../js/jquery-1.6.2.min.js" type="text/javascript"></script>     
	<!--[if lt IE 7]>
        <div style=' clear: both; text-align:center; position: relative;'>
            <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0"  alt="" /></a>
        </div>
	<![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src="js/html5.js"></script>
        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
	<![endif]-->
</head>


<body onLoad="window.print()" id="page2">
<h3 class="p2">Laporan Hasil Seleksi ukm Pada Bulan <?php $tanggal=date('F');
	echo $tanggal;
	?><br></h3>



<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">Hasil Seleksi ukm </th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>ukm </th>
			<?php
			for($i=0;$i<count($kriteria_ukm);$i++){
				echo '<th>'.$kriteria_ukm[$i][1].'</th>';
			}
			?>
			<th>Nilai</th>
			<th>Rank</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td>Vektor Eigen</td>
			<?php
			for($i=0;$i<count($kriteria_ukm);$i++){
				echo '<td>'.$eigen_kriteria_ukm[$i].'</td>';
			}
			?>
			<td></td>
			<td></td>
		</tr>
		<?php
		for($i=0;$i<count($ukm);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$ukm[$i][1].' - '.$ukm[$i][2].'</td>
			';
			for($ii=0;$ii<count($kriteria_ukm);$ii++){
				echo '
						<td>'.$eigen_ukm[$ii][$i].'</td>
				';
				
			}
			echo '
					<td><strong>'.$nilai_global1[$i].'</strong></td>
					<td>'.$ranking1[$ukm[$i][0]].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>
<table width="100%" border="1" cellpadding="2" cellspacing="1">
  <tr>
    <td width="78%" height="100">&nbsp;</td>
    <td width="22%"><p>Cirebon, <?php $tanggal=date('d  F  Y');
	echo $tanggal;
	?></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
