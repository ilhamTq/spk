<?php

require_once ( 'ahp.php' );

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

for($i=0;$i<count($ukm);$i++){
	$nilai=0;
	for($ii=0;$ii<count($kriteria_ukm);$ii++){
		$nilai = $nilai + ( $eigen_ukm[$ii][$i] * $eigen_kriteria_ukm[$ii]);
	}
	$nilai = round( $nilai , 3);
	$nilai_global[$i] = $nilai;
	$nilai_to_sort[] = array($nilai, $ukm[$i][0]);
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
<h3 class="p2">Hasil Seleksi ukm </h3>
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">NILAI PERBANDINGAN</th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>Kriteria</th>
			<?php
			for($i=0;$i<count($kriteria_ukm);$i++){
				echo '<th>'.$kriteria_ukm[$i][1].'</th>';
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($kriteria_ukm);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$kriteria_ukm[$i][1].' - '.$kriteria_ukm[$i][2].'</td>
			';
			
			for($ii=0;$ii<count($kriteria_ukm);$ii++){
				echo '
						<td>'.$matrik_kriteria_ukm[$i][$ii].'</td>
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
			for($i=0;$i<count($kriteria_ukm);$i++){
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
			for($i=0;$i<count($kriteria_ukm);$i++){
				echo '<th>'.$kriteria_ukm[$i][1].'</th>';
			}
			?>
			<th>Eigen</th>
		</tr>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($kriteria_ukm);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$kriteria_ukm[$i][1].' - '.$kriteria_ukm[$i][2].'</td>
			';
			
			for($ii=0;$ii<count($kriteria_ukm);$ii++){
				echo '
						<td>'.$matrik_normalisasi[$i][$ii].'</td>
				';
			}
			echo '
					<td>'.$eigen_kriteria_ukm[$i].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>


<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">EIGEN KRITERIA DAN ukm </th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>ukm</th>
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
					<td><strong>'.$nilai_global[$i].'</strong></td>
					<td>'.$ranking[$ukm[$i][0]].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>
<input type="button" value="Print dan Preview" onClick="popup_print()" />