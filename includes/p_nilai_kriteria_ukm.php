<?php
$link_update='?hal=nilai_kriteria_ukm';

$q="select * from kriteria_ukm order by kode_kriteria_ukm";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$kriteria_ukm[]=array($h['id_kriteria_ukm'],$h['kode_kriteria_ukm'],$h['nama_kriteria_ukm']);
}

if(isset($_POST['save'])){
	mysql_query("truncate table nilai_kriteria_ukm"); /* kosongkan tabel nilai_kriteria_ukm */
	for($i=0;$i<count($kriteria_ukm);$i++){
		for($ii=0;$ii<count($kriteria_ukm);$ii++){
			if($i < $ii){
				mysql_query("insert into nilai_kriteria_ukm(id_kriteria_ukm_1,id_kriteria_ukm_2,nilai) values('".$kriteria_ukm[$i][0]."','".$kriteria_ukm[$ii][0]."','".$_POST['nilai_'.$kriteria_ukm[$i][0].'_'.$kriteria_ukm[$ii][0]]."')");
			}
		}
	}
	$success='Nilai perbandingan kriteria ukm berhasil disimpan.';
}
if(isset($_POST['check'])){
	require_once ( 'ahp2.php' );
	for($i=0;$i<count($kriteria_ukm);$i++){
		$id_kriteria_ukm[]=$kriteria_ukm[$i][0];
	}
	
	$matrik_kriteria_ukm = ahp2_get_matrik_kriteria_ukm($id_kriteria_ukm);
	$jumlah_kolom = ahp2_get_jumlah_kolom($matrik_kriteria_ukm);
	$matrik_normalisasi = ahp2_get_normalisasi($matrik_kriteria_ukm, $jumlah_kolom);
	$eigen = ahp2_get_eigen($matrik_normalisasi);
	
	if(ahp2_uji_konsistensi($matrik_kriteria_ukm, $eigen)){
		$success='Nilai perbandingan : KONSISTEN';
	}else{
		$error='Nilai perbandingan : TIDAK KONSISTEN';
	}
	
	
	
}
if(isset($_POST['reset'])){
	mysql_query("truncate table nilai_kriteria_ukm"); /* kosongkan tabel nilai_kriteria */
}

for($i=0;$i<count($kriteria_ukm);$i++){
	for($ii=0;$ii<count($kriteria_ukm);$ii++){
		if($i < $ii){
			$q=mysql_query("select nilai from nilai_kriteria_ukm where id_kriteria_ukm_1='".$kriteria_ukm[$i][0]."' and id_kriteria_ukm_2='".$kriteria_ukm[$ii][0]."'");
			if(mysql_num_rows($q)>0){
				$h=mysql_fetch_array($q);
				$nilai=$h['nilai'];
			}else{
				mysql_query("insert into nilai_kriteria_ukm(id_kriteria_ukm_1,id_kriteria_ukm_2,nilai) values('".$kriteria_ukm[$i][0]."','".$kriteria_ukm[$ii][0]."','1')");
				$nilai=1;
			}
			$row=count($kriteria_ukm)-1;
			$selected[$nilai]=' selected';
			
			$daftar.='
			  <tr>
				<td align="right">'.$kriteria_ukm[$i][1].' - '.$kriteria_ukm[$i][2].'</td>
				<td align="center">
				<input type="text" name="nilai_'.$kriteria_ukm[$i][0].'_'.$kriteria_ukm[$ii][0].'" value='.$nilai.'>
				
				</td>
				<td>'.$kriteria_ukm[$ii][1].' - '.$kriteria_ukm[$ii][2].'</td>
				</td>
				

				
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

<h3 class="p2">Nilai Perbandingan Kriteria ukm</h3>

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
			<th>Nama Kriteria ukm</th>
			<th>Nilai Perbandingan</th>
			<th>Nama Kriteria ukm</th>
			
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
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			
			<th>Pembobotan Normal</th>
			<th>Nilai Pembobotan Normal</th>
			<th></th>
			<th>Pembobotan Kebalikan</th>
			<th>Nilai Pembobotan Kebalikan</th>
			
			
		</tr>
	</thead>
	<tbody><tr>
	<td>Sama penting dengan</td><td>1</td><td></td><td>Mendekati sedikit kurang penting dari</td><td>0.5</td>
	</tr>
	<tr>
	
<td>Mendekati sedikit lebih penting dari</td><td>2</td><td></td><td>Sedikit kurang penting dari</td><td> 0.333</td>
</tr>
	<tr>
<td>Sedikit lebih penting dari</td><td>3</td><td></td><td> Mendekati kurang penting dari </td><td> 0.25</td>
</tr>
	<tr>
	<td>Mendekati lebih penting dari</td><td>4</td><td></td><td>Kurang penting dari </td><td> 0.2</td>
</tr>
	<tr>
	<td>Lebih penting dari</td><td>5</td><td></td><td>Mendekati sangat tidak penting dari </td><td> 0.167</td>
</tr>
	<tr>
	<td>Mendekati sangat penting dari</td><td>6</td><td></td><td>Sangat tidak penting dari </td><td> 0.143</td>
</tr>
	<tr>
	<td>Sangat penting dari</td><td>7</td><td></td><td> Mendekati mutlak tidak penting dari</td><td>0.125</td>
</tr>
	<tr>
	<td>Mendekati mutlak dari</td><td>8</td><td></td><td>Mutlak sangat tidak penting dari</td><td>0.111</td>
</tr>
	<tr>
	<td>Mutlak sangat penting dari<</td><td>9</td><td></td><td></td><td></td>
	</tr>

	</tbody>
	</table>

</form>
