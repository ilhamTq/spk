<?php
$link_update='?hal=nilai_produk';

$q="select * from produk order by kode_produk";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$produk[]=array($h['id_produk'],$h['kode_produk'],$h['nama_produk']);
}

$id_kriteria_produk=$_POST['kriteria_produk'];

if(isset($_POST['save'])){
	$id_kriteria_produk=$_POST['kriteria_produk'];
	mysql_query("delete from nilai_produk where id_kriteria_produk='".$id_kriteria_produk."'"); /* kosongkan tabel nilai_supplier berdasarkan kriteria */
	for($i=0;$i<count($produk);$i++){
		for($ii=0;$ii<count($produk);$ii++){
			if($i < $ii){
				mysql_query("insert into nilai_produk(id_kriteria_produk,id_produk_1,id_produk_2,nilai) values('".$id_kriteria_produk."','".$produk[$i][0]."','".$produk[$ii][0]."','".$_POST['nilai_'.$produk[$i][0].'_'.$produk[$ii][0]]."')");
			}
		}
	}
	$success='Penilaian produk berhasil disimpan.';
}
if(isset($_POST['reset'])){
	$id_kriteria_produk=$_POST['kriteria_produk'];
	mysql_query("delete from nilai_produk where id_kriteria_produk='".$id_kriteria_produk."'"); /* kosongkan tabel nilai_produk berdasarkan kriteria */
}

for($i=0;$i<count($produk);$i++){
	for($ii=0;$ii<count($produk);$ii++){
		if($i < $ii){
			$q=mysql_query("select nilai from nilai_produk where id_kriteria_produk='".$id_kriteria_produk."' and id_produk_1='".$produk[$i][0]."' and id_produk_2='".$produk[$ii][0]."'");
			if(mysql_num_rows($q)>0){
				$h=mysql_fetch_array($q);
				$nilai=$h['nilai'];
			}else{
				mysql_query("insert into nilai_produk(id_kriteria_produk,id_produk_1,id_produk_2,nilai) values('".$id_kriteria_produk."','".$produk[$i][0]."','".$produk[$ii][0]."','1')");
				$nilai=1;
			}
			$selected[$nilai]=' selected';
			
			$daftar.='
			  <tr>
				<td align="right">'.$produk[$i][1].' - '.$produk[$i][2].'</td>
				<td align="center">
				<input type="text" name="nilai_'.$produk[$i][0].'_'.$produk[$ii][0].'" value='.$nilai.'>
				</td>
				<td>'.$produk[$ii][1].' - '.$produk[$ii][2].'</td>
			  </tr>
			';
			$selected[$nilai]='';
		}
	}
}

$q="select * from kriteria_produk order by kode_kriteria_produk";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	if($h['id_kriteria_produk']==$id_kriteria_produk){$s=' selected';}else{$s='';}
	$list_kriteria_produk.='<option value="'.$h['id_kriteria_produk'].'"'.$s.'>'.$h['kode_kriteria_produk'].' - '.$h['nama_kriteria_produk'].'</option>';
}

?>
<script language="javascript">
function ResetConfirm(){
	if (confirm("Anda yakin akan mengatur ulang semua Penilaian supplier ini ?")){
		return true;
	}else{
		return false;
	}
}
</script>

<h3 class="p2">Penilaian produk</h3>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<table class="table table-striped table-hover table-bordered">
	<tbody>
		<tr>
			<td width="100">Kriteria produk</td>
			<td><select name="kriteria_produk" class="medium m-wrap" onchange="submit()"><?php echo $list_kriteria_produk;?></select></td>
		</tr>
	</tbody>
</table>
</form>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<input name="kriteria_produk" type="hidden" value="<?php echo $id_kriteria_produk;?>" />
<?php
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
			<th>nama produk</th>
			<th>Nilai Perbandingan</th>
			<th>nama produk</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $daftar;?>
	  <tr>
		<td align="center" colspan="3"><button type="submit" name="save" class="btn blue"><i class="icon-ok"></i> Simpan</button>
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
