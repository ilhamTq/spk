<?php

require_once ( 'ahp.php' );

$q="select * from kriteria order by kode";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$kriteria[]=array($h['id_kriteria'],$h['kode'],$h['nama']);
}
$q="select * from supplier order by npwp";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$supplier[]=array($h['id_supplier'],$h['npwp'],$h['nama']);
}

for($i=0;$i<count($kriteria);$i++){
	$id_kriteria[]=$kriteria[$i][0];
}
$matrik_kriteria = ahp_get_matrik_kriteria($id_kriteria);
$jumlah_kolom = ahp_get_jumlah_kolom($matrik_kriteria);
$matrik_normalisasi = ahp_get_normalisasi($matrik_kriteria, $jumlah_kolom);
$eigen_kriteria = ahp_get_eigen($matrik_normalisasi);

for($i=0;$i<count($supplier);$i++){
	$id_supplier[]=$supplier[$i][0];
}
for($i=0;$i<count($kriteria);$i++){
	$matrik_supplier = ahp_get_matrik_supplier($kriteria[$i][0], $id_supplier);
	$jumlah_kolom_supplier = ahp_get_jumlah_kolom($matrik_supplier);
	$matrik_normalisasi_supplier = ahp_get_normalisasi($matrik_supplier, $jumlah_kolom_supplier);
	$eigen_supplier[$i] = ahp_get_eigen($matrik_normalisasi_supplier);
}

$nilai_to_sort = array();

for($i=0;$i<count($supplier);$i++){
	$nilai=0;
	for($ii=0;$ii<count($kriteria);$ii++){
		$nilai = $nilai + ( $eigen_supplier[$ii][$i] * $eigen_kriteria[$ii]);
	}
	$nilai = round( $nilai , 3);
	$nilai_global[$i] = $nilai;
	$nilai_to_sort[] = array($nilai, $supplier[$i][0]);
}

sort($nilai_to_sort);
for($i=0;$i<count($nilai_to_sort);$i++){
	$ranking[$nilai_to_sort[$i][1]]=(count($nilai_to_sort) - $i);
}


?>

</script>
<h3 class="p2">Hasil Seleksi Supplier</h3>
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">NILAI PERBANDINGAN</th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>Kriteria</th>
			<?php
			for($i=0;$i<count($kriteria);$i++){
				echo '<th>'.$kriteria[$i][1].'</th>';
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($kriteria);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$kriteria[$i][1].' - '.$kriteria[$i][2].'</td>
			';
			
			for($ii=0;$ii<count($kriteria);$ii++){
				echo '
						<td>'.$matrik_kriteria[$i][$ii].'</td>
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
			for($i=0;$i<count($kriteria);$i++){
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
			for($i=0;$i<count($kriteria);$i++){
				echo '<th>'.$kriteria[$i][1].'</th>';
			}
			?>
			<th>Eigen</th>
		</tr>
	</thead>
	<tbody>
		<?php
		for($i=0;$i<count($kriteria);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$kriteria[$i][1].' - '.$kriteria[$i][2].'</td>
			';
			
			for($ii=0;$ii<count($kriteria);$ii++){
				echo '
						<td>'.$matrik_normalisasi[$i][$ii].'</td>
				';
			}
			echo '
					<td>'.$eigen_kriteria[$i].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>


<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th colspan="50">EIGEN KRITERIA DAN SUPPLIER</th>
		</tr>
		<tr>
			<th width="40">No</th>
			<th>Supplier</th>
			<?php
			for($i=0;$i<count($kriteria);$i++){
				echo '<th>'.$kriteria[$i][1].'</th>';
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
			for($i=0;$i<count($kriteria);$i++){
				echo '<td>'.$eigen_kriteria[$i].'</td>';
			}
			?>
			<td></td>
			<td></td>
		</tr>
		<?php
		for($i=0;$i<count($supplier);$i++){
			echo '
				<tr>
					<td>'.($i+1).'</td>
					<td>'.$supplier[$i][1].' - '.$supplier[$i][2].'</td>
			';
			for($ii=0;$ii<count($kriteria);$ii++){
				echo '
						<td>'.$eigen_supplier[$ii][$i].'</td>
				';
				
			}
			echo '
					<td><strong>'.$nilai_global[$i].'</strong></td>
					<td>'.$ranking[$supplier[$i][0]].'</td>
				</tr>
			';
		}
		?>
	</tbody>
</table>