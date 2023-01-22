<?php
$link_update='?hal=nilai_kriteria';

$q="select * from kriteria order by kode";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$kriteria[]=array($h['id_kriteria'],$h['kode'],$h['nama']);
}

if(isset($_POST['save'])){
	mysql_query("truncate table nilai_kriteria"); /* kosongkan tabel nilai_kriteria */
	for($i=0;$i<count($kriteria);$i++){
		for($ii=0;$ii<count($kriteria);$ii++){
			if($i < $ii){
				mysql_query("insert into nilai_kriteria(id_kriteria_1,id_kriteria_2,nilai) values('".$kriteria[$i][0]."','".$kriteria[$ii][0]."','".$_POST['nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0]]."')");
			}
		}
	}
	$success='Nilai perbandingan kriteria berhasil disimpan.';
}
if(isset($_POST['check'])){
	require_once ( 'ahp.php' );
	for($i=0;$i<count($kriteria);$i++){
		$id_kriteria[]=$kriteria[$i][0];
	}
	
	$matrik_kriteria = ahp_get_matrik_kriteria($id_kriteria);
	$jumlah_kolom = ahp_get_jumlah_kolom($matrik_kriteria);
	$matrik_normalisasi = ahp_get_normalisasi($matrik_kriteria, $jumlah_kolom);
	$eigen = ahp_get_eigen($matrik_normalisasi);
	
	if(ahp_uji_konsistensi($matrik_kriteria, $eigen)){
		$success='Nilai perbandingan : KONSISTEN';
	}else{
		$error='Nilai perbandingan : TIDAK KONSISTEN';
	}
	
	
	
}
if(isset($_POST['reset'])){
	mysql_query("truncate table nilai_kriteria"); /* kosongkan tabel nilai_kriteria */
}

for($i=0;$i<count($kriteria);$i++){
	for($ii=0;$ii<count($kriteria);$ii++){
		if($i < $ii){
			$q=mysql_query("select nilai from nilai_kriteria where id_kriteria_1='".$kriteria[$i][0]."' and id_kriteria_2='".$kriteria[$ii][0]."'");
			if(mysql_num_rows($q)>0){
				$h=mysql_fetch_array($q);
				$nilai=$h['nilai'];
			}else{
				mysql_query("insert into nilai_kriteria(id_kriteria_1,id_kriteria_2,nilai) values('".$kriteria[$i][0]."','".$kriteria[$ii][0]."','1')");
				$nilai=1;
			}
			if($nilai=1){
			$select=' selected';
			}elseif($nilai=2){
			$select=' selected';
			}elseif($nilai=3){
$select=' selected';
			}elseif($nilai=4){
$select=' selected';
			}elseif($nilai=5){
$select=' selected';
			}elseif($nilai=6){
$select=' selected';
			}elseif($nilai=7){
$select=' selected';
			}elseif($nilai=8){
$select=' selected';
			}elseif($nilai=9){
$select=' selected';
			}elseif($nilai=0.5){
$select=' selected';
			}elseif($nilai=0.333){
$select=' selected';
			}elseif($nilai=0.25){
$select=' selected';
			}elseif($nilai=0.2){
$select=' selected';
			}elseif($nilai=0.167){
$select=' selected';
			}elseif($nilai=0.143){
$select=' selected';
			}elseif($nilai=0.125){	
$select=' selected';
			}elseif($nilai=0.111){	
$select=' selected';
			}
			
			$daftar.='
			  <tr>
				<td align="right">'.$kriteria[$i][1].' - '.$kriteria[$i][2].'</td>
				<td align="center">
				<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="1" '.$select.' > 1 &nbsp;	
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="2" '.$select.' > 2 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="3" '.$select.' > 3 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="4" '.$select.' > 4 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="5" '.$select.' > 5 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="6" '.$select.' > 6 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="7" '.$select.' > 7 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="8" '.$select.' > 8 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="9" '.$select.' > 9 &nbsp;	
---
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="1" '.$select.' > 1 &nbsp;	
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.5" '.$select.' > 2 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.333" '.$select.' > 3 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.25" '.$select.' > 4 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.2" '.$select.' > 5 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.167" '.$select.' > 6 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.143" '.$select.' > 7 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.125" '.$select.' > 8 &nbsp;
<input type="radio" name="nilai_'.$kriteria[$i][0].'_'.$kriteria[$ii][0].'" value="0.111" '.$select.' > 9 &nbsp;	

				</td>
				<td>'.$kriteria[$ii][1].' - '.$kriteria[$ii][2].'</td>
			  </tr>
			';
			$selected[$nilai]='';
		}
	}
}


?>
<script language="javascript">
function ResetConfirm(){
	if (confirm("Anda yakin akan mengatur ulang semua nilai perbandingan kriteria ini ?")){
		return true;
	}else{
		return false;
	}
}
</script>

<h3 class="p2">Nilai Perbandingan Kriteria</h3>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<?php
if(!empty($error)){
	echo '
	   <div class="alert alert-error ">
		  '.$error.'
	   </div>
	';
}
if(!empty($success)){
	echo '
	   <div class="alert alert-success ">
		  '.$success.'
	   </div>
	';
}
?>

<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>Nama Kriteria</th>
			<th>Nilai Perbandingan</th>
			<th>Nama Kriteria</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $daftar;?>
	  <tr>
		<td align="center" colspan="3"><button type="submit" name="save" class="btn blue"><i class="icon-ok"></i> Simpan</button>
		<button type="submit" name="check" class="btn">Cek Konsistensi</button>
		<button type="submit" name="reset" class="btn" onclick="return(ResetConfirm());">Reset Nilai</button></td>
	  </tr>
	</tbody>
</table>
</form>
