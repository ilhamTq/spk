<?php
$link_update='?hal=nilai_supplier';

$q="select * from supplier order by npwp";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	$supplier[]=array($h['id_supplier'],$h['npwp'],$h['nama']);
}

$id_kriteria=$_POST['kriteria'];

if(isset($_POST['save'])){
	$id_kriteria=$_POST['kriteria'];
	mysql_query("delete from nilai_supplier where id_kriteria='".$id_kriteria."'"); /* kosongkan tabel nilai_supplier berdasarkan kriteria */
	for($i=0;$i<count($supplier);$i++){
		for($ii=0;$ii<count($supplier);$ii++){
			if($i < $ii){
				mysql_query("insert into nilai_supplier(id_kriteria,id_supplier_1,id_supplier_2,nilai) values('".$id_kriteria."','".$supplier[$i][0]."','".$supplier[$ii][0]."','".$_POST['nilai_'.$supplier[$i][0].'_'.$supplier[$ii][0]]."')");
			}
		}
	}
	$success='Penilaian supplier berhasil disimpan.';
}
if(isset($_POST['reset'])){
	$id_kriteria=$_POST['kriteria'];
	mysql_query("delete from nilai_supplier where id_kriteria='".$id_kriteria."'"); /* kosongkan tabel nilai_supplier berdasarkan kriteria */
}

for($i=0;$i<count($supplier);$i++){
	for($ii=0;$ii<count($supplier);$ii++){
		if($i < $ii){
			$q=mysql_query("select nilai from nilai_supplier where id_kriteria='".$id_kriteria."' and id_supplier_1='".$supplier[$i][0]."' and id_supplier_2='".$supplier[$ii][0]."'");
			if(mysql_num_rows($q)>0){
				$h=mysql_fetch_array($q);
				$nilai=$h['nilai'];
			}else{
				mysql_query("insert into nilai_supplier(id_kriteria,id_supplier_1,id_supplier_2,nilai) values('".$id_kriteria."','".$supplier[$i][0]."','".$supplier[$ii][0]."','1')");
				$nilai=1;
			}
			$selected[$nilai]=' selected';
			
			$daftar.='
			  <tr>
				<td align="right">'.$supplier[$i][1].' - '.$supplier[$i][2].'</td>
				<td align="center"><select name="nilai_'.$supplier[$i][0].'_'.$supplier[$ii][0].'">
				<option value="1"'.$selected[1].'>1. Sama penting dengan</option>
				<option value="2"'.$selected[2].'>2. Mendekati sedikit lebih penting dari</option>
				<option value="3"'.$selected[3].'>3. Sedikit lebih penting dari</option>
				<option value="4"'.$selected[4].'>4. Mendekati lebih penting dari</option>
				<option value="5"'.$selected[5].'>5. Lebih penting dari</option>
				<option value="6"'.$selected[6].'>6. Mendekati sangat penting dari</option>
				<option value="7"'.$selected[7].'>7. Sangat penting dari</option>
				<option value="8"'.$selected[8].'>8. Mendekati mutlak dari</option>
				<option value="9"'.$selected[9].'>9. Mutlak sangat penting dari</option>
				</select></td>
				<td>'.$supplier[$ii][1].' - '.$supplier[$ii][2].'</td>
			  </tr>
			';
			$selected[$nilai]='';
		}
	}
}

$q="select * from kriteria order by kode";
$q=mysql_query($q);
while($h=mysql_fetch_array($q)){
	if($h['id_kriteria']==$id_kriteria){$s=' selected';}else{$s='';}
	$list_kriteria.='<option value="'.$h['id_kriteria'].'"'.$s.'>'.$h['kode'].' - '.$h['nama'].'</option>';
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

<h3 class="p2">Penilaian Supplier</h3>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<table class="table table-striped table-hover table-bordered">
	<tbody>
		<tr>
			<td width="100">Kriteria</td>
			<td><select name="kriteria" class="medium m-wrap" onchange="submit()"><?php echo $list_kriteria;?></select></td>
		</tr>
	</tbody>
</table>
</form>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<input name="kriteria" type="hidden" value="<?php echo $id_kriteria;?>" />
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
			<th>Nama Supplier</th>
			<th>Nilai Perbandingan</th>
			<th>Nama Supplier</th>
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
</form>
