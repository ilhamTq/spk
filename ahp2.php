<?php

function ahp2_get_matrik_kriteria_ukm($id_kriteria_ukm){
	for($i=0;$i<count($id_kriteria_ukm);$i++){
		for($ii=0;$ii<count($id_kriteria_ukm);$ii++){
			if($i==$ii){
				$matrik[$i][$ii]=1;
			}else{
				if($i < $ii){
					$q=mysql_query("select nilai from nilai_kriteria_ukm where id_kriteria_ukm_1='".$id_kriteria_ukm[$i]."' and id_kriteria_ukm_2='".$id_kriteria_ukm[$ii]."'");
					if(mysql_num_rows($q)>0){
						$h=mysql_fetch_array($q);
						$nilai=$h['nilai'];
						$matrik[$i][$ii]=$nilai;
						$matrik[$ii][$i]=round((1/$nilai),3);
					}else{
						$matrik[$i][$ii]=1;
						$matrik[$ii][$i]=1;
					}
				}
			}
		}
	}
	return $matrik;
}
function ahp2_get_matrik_ukm($id_kriteria_ukm, $id_ukm){
	for($i=0;$i<count($id_ukm);$i++){
		for($ii=0;$ii<count($id_ukm);$ii++){
			if($i==$ii){
				$matrik[$i][$ii]=1;
			}else{
				if($i < $ii){
					$q=mysql_query("select nilai from nilai_ukm where id_kriteria_ukm='".$id_ukm."' and id_ukm_1='".$id_ukm[$i]."' and id_ukm_2='".$id_ukm[$ii]."'");
					if(mysql_num_rows($q)>0){
						$h=mysql_fetch_array($q);
						$nilai=$h['nilai'];
						$matrik[$i][$ii]=$nilai;
						$matrik[$ii][$i]=round((1/$nilai),3);
					}else{
						$matrik[$i][$ii]=1;
						$matrik[$ii][$i]=1;
					}
				}
			}
		}
	}
	return $matrik;
}
function ahp2_get_jumlah_kolom($matrik){
	for($i=0;$i<count($matrik);$i++){
		$jumlah_kolom[$i] = 0;
		for($ii=0;$ii<count($matrik);$ii++){
			$jumlah_kolom[$i] = $jumlah_kolom[$i] + $matrik[$ii][$i];
		}
	}
	return $jumlah_kolom;
}
function ahp2_get_normalisasi($matrik, $jumlah_kolom){
	for($i=0;$i<count($matrik);$i++){
		for($ii=0;$ii<count($matrik);$ii++){
			$matrik_normalisasi[$i][$ii] = round( $matrik[$i][$ii] / $jumlah_kolom[$ii] , 3 );
		}
	}
	return $matrik_normalisasi;
}
function ahp2_get_eigen($matrik_normalisasi){
	for($i=0;$i<count($matrik_normalisasi);$i++){
		$eigen[$i] = 0;
		for($ii=0;$ii<count($matrik_normalisasi);$ii++){
			$eigen[$i] = $eigen[$i] + $matrik_normalisasi[$i][$ii];
		}
		$eigen[$i] = round( $eigen[$i] / count($matrik_normalisasi) , 3 );
	}
	return $eigen;
}
function ahp2_uji_konsistensi($matrik, $eigen){
	for($i=0;$i<count($matrik);$i++){
		$nilai=0;
		for($ii=0;$ii<count($matrik);$ii++){
			$nilai = $nilai + ($matrik[$i][$ii] * $eigen[$ii]);
		}
		$matrik_eigen[$i] = $nilai;
	}
	$nilai=0;
	for($i=0;$i<count($matrik);$i++){
		$nilai = $nilai + ($matrik_eigen[$i] / $eigen[$i]);
	}
	$t = $nilai / count($matrik);
	$ci = ($t - count($matrik)) / (count($matrik)-1);
	$ri=array(0,0,0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59);
	$cr = $ci / $ri[count($matrik)];

	if($cr <= 0.1){
		return true;
	}else{
		return false;
	}
}



?>