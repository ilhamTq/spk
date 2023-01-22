<?php

require_once ( 'ahp.php' );

$q="select * from kriteria_produk order by kode_kriteria_produk";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$kriteria_produk[]=array($h['id_kriteria_produk'],$h['kode_kriteria_produk'],$h['nama_kriteria_produk']);
}
$q="select * from produk order by kode_produk";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$produk[]=array($h['id_produk'],$h['kode_produk'],$h['nama_produk']);
}

for($i=0;$i<count($kriteria_produk);$i++){
	$id_kriteria_produk[]=$kriteria_produk[$i][0];
}
$matrik_kriteria_produk = ahp_get_matrik_kriteria_produk($id_kriteria_produk);
$jumlah_kolom = ahp_get_jumlah_kolom($matrik_kriteria_produk);
$matrik_normalisasi = ahp_get_normalisasi($matrik_kriteria_produk, $jumlah_kolom);
$eigen_kriteria_produk = ahp_get_eigen($matrik_normalisasi);

for($i=0;$i<count($produk);$i++){
	$id_produk[]=$produk[$i][0];
}
for($i=0;$i<count($kriteria_produk);$i++){
	$matrik_produk = ahp_get_matrik_produk($kriteria_produk[$i][0], $id_produk);
	$jumlah_kolom_produk = ahp_get_jumlah_kolom($matrik_produk);
	$matrik_normalisasi_produk = ahp_get_normalisasi($matrik_produk, $jumlah_kolom_produk);
	$eigen_produk[$i] = ahp_get_eigen($matrik_normalisasi_produk);
}

$nilai_to_sort = array();

for($i=0;$i<count($produk);$i++){
	$nilai=0;
	for($ii=0;$ii<count($kriteria_produk);$ii++){
		$nilai = $nilai + ( $eigen_produk[$ii][$i] * $eigen_kriteria_produk[$ii]);
	}
	$nilai = round( $nilai , 3);
	$nilai_global[$i] = $nilai;
	$nilai_to_sort[] = array($nilai, $produk[$i][0]);
}

sort($nilai_to_sort);
for($i=0;$i<count($nilai_to_sort);$i++){
	$ranking[$nilai_to_sort[$i][1]]=(count($nilai_to_sort) - $i);
}


?>
<script type="text/javascript">
var s5_taf_parent = window.location;
function popup_print(){
window.open('includes/lap_cetak.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=1200,height=900,left=50,top=50,titlebar=yes')
}
</script>
<h3 class="p2">Hasil Seleksi produk </h3>
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">NILAI PERBANDINGAN</th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>Kriteria</th>
			<?php
			for($i=0;$i<count($kriteria_produk);$i++){
				echo '<th>'.$kriteria_produk[$i][1].'</th>';
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($kriteria_produk);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$kriteria_produk[$i][1].' - '.$kriteria_produk[$i][2].'</td>
			';
			
			for($ii=0;$ii<count($kriteria_produk);$ii++){
				echo '
						<td>'.$matrik_kriteria_produk[$i][$ii].'</td>
				';
			}
			echo '
				</tr>
			';
		}
		?>
		<tr>
			<td></td>
			<td>Jumlah Kolom</td>
			<?php
			for($i=0;$i<count($kriteria_produk);$i++){
				echo '<td>'.$jumlah_kolom[$i].'</td>';
			}
			?>
		</tr>
	</tbody>
</table>

<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">NORMALISASI</th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>Kriteria</th>
			<?php
			for($i=0;$i<count($kriteria_produk);$i++){
				echo '<th>'.$kriteria_produk[$i][1].'</th>';
			}
			?>
			<th>Eigen</th>
		</tr>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($kriteria_produk);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$kriteria_produk[$i][1].' - '.$kriteria_produk[$i][2].'</td>
			';
			
			for($ii=0;$ii<count($kriteria_produk);$ii++){
				echo '
						<td>'.$matrik_normalisasi[$i][$ii].'</td>
				';
			}
			echo '
					<td>'.$eigen_kriteria_produk[$i].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>


<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">EIGEN KRITERIA DAN produk </th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>produk</th>
			<?php
			for($i=0;$i<count($kriteria_produk);$i++){
				echo '<th>'.$kriteria_produk[$i][1].'</th>';
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
			for($i=0;$i<count($kriteria_produk);$i++){
				echo '<td>'.$eigen_kriteria_produk[$i].'</td>';
			}
			?>
			<td></td>
			<td></td>
		</tr>
		<?php
		for($i=0;$i<count($produk);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$produk[$i][1].' - '.$produk[$i][2].'</td>
			';
			for($ii=0;$ii<count($kriteria_produk);$ii++){
				echo '
						<td>'.$eigen_produk[$ii][$i].'</td>
				';
				
			}
			echo '
					<td><strong>'.$nilai_global[$i].'</strong></td>
					<td>'.$ranking[$produk[$i][0]].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>
<input type="button" value="Print dan Preview" onClick="popup_print()" />