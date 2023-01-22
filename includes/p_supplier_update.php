<?php
$link_list='?hal=data_supplier';
$link_update='?hal=update_supplier';

if(isset($_POST['save'])){
	$id=$_POST['id'];
	$action=$_POST['action'];
	$npwp=$_POST['npwp'];
	$nama=$_POST['nama'];
	$alamat=$_POST['alamat'];
	$no_telp=$_POST['no_telp'];
	$jns_fasilitas=$_POST['jns_fasilitas'];
	$lokasi_fasilitas=$_POST['lokasi_fasilitas'];
	
	if(empty($npwp) or empty($nama)){
		$error='Masih ada beberapa kesalahan. Silahkan periksa lagi form di bawah ini.';
	}else{
		if($action=='add'){
			if(mysql_num_rows(mysql_query("select * from supplier where npwp='".$npwp."'"))>0){
				$error='npwp sudah terdaftar. Silahkan gunakan npwp yang lain.';
			}else{
				$q="insert into supplier(npwp, nama, alamat, no_telp,jns_fasilitas,lokasi_fasilitas) values('".$npwp."', '".$nama."', '".$alamat."', '".$no_telp."', '".$jns_fasilitas."', '".$lokasi_fasilitas."')";
				mysql_query($q);
				exit("<script>location.href='".$link_list."';</script>");
			}
		}
		if($action=='edit'){
			$q=mysql_query("select * from supplier where id_supplier='".$id."'");
			$h=mysql_fetch_array($q);
			$npwp_tmp=$h['npwp'];
			if(mysql_num_rows(mysql_query("select * from supplier where npwp='".$npwp."' and npwp<>'".$npwp_tmp."'"))>0){
				$error='npwp sudah terdaftar. Silahkan gunakan npwp yang lain.';
			}else{
				$q="update supplier set npwp='".$npwp."', nama='".$nama."', alamat='".$alamat."', no_telp='".$no_telp."' where id_supplier='".$id."'";
				mysql_query($q);
				exit("<script>location.href='".$link_list."';</script>");
			}
		}
		
	}
}else{
	if(empty($_GET['action'])){$action='add';}else{$action=$_GET['action'];}
	if($action=='edit'){
		$id=$_GET['id'];
		$q=mysql_query("select * from supplier where id_supplier='".$id."'");
		$h=mysql_fetch_array($q);
		$npwp=$h['npwp'];
		$nama=$h['nama'];
		$alamat=$h['alamat'];
		$no_telp=$h['no_telp'];
		$jns_fasilitas=$h['jns_fasilitas'];
		$lokasi_fasilitas=$h['lokasi_fasilitas'];
	}
	if($action=='delete'){
		$id=$_GET['id'];
		mysql_query("delete from supplier where id_supplier='".$id."'");
		exit("<script>location.href='".$link_list."';</script>");
	}
}


?>

<h3 class="p2">Update Data Supplier</h3>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<input name="id" type="hidden" value="<?php echo $id;?>">
<input name="action" type="hidden" value="<?php echo $action;?>">
<?php
if(!empty($error)){
	echo '
	   <div class="alert alert-error ">
		  '.$error.'
	   </div>
	';
}
?>

<table width="100%" border="0" cellspacing="4" cellpadding="4" class="tabel_reg">
  <tr>
	<td width="120">NPWP<span class="required">*</span> </td>
	<td><input name="npwp" type="text" size="40" value="<?php echo $npwp;?>" class="m-wrap large"></td>
  </tr>
  <tr>
	<td>Nama Supplier<span class="required">*</span> </td>
	<td><input name="nama" type="text" size="40" value="<?php echo $nama;?>" class="m-wrap large"></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td><input name="alamat" type="text" class="m-wrap large" id="alamat" value="<?php echo $alamat;?>" size="40" /></td>
  </tr>
  <tr>
    <td>No Telepon</td>
    <td><input name="no_telp" type="text" class="m-wrap large" id="no_telp" value="<?php echo $no_telp;?>" size="40" /></td>
  </tr>
   <tr>
    <td>Jenis Usaha</td>
    <td><input name="jns_fasilitas" type="text" class="m-wrap large" id="jns_fasilitas" value="<?php echo $jns_fasilitas;?>" size="40" /></td>
  </tr>
   <tr>
    <td>Lokasi Usaha</td>
    <td><input name="lokasi_fasilitas" type="text" class="m-wrap large" id="lokasi_fasilitas" value="<?php echo $lokasi_fasilitas;?>" size="40" /></td>
  </tr>
  <tr>
	<td></td>
	<td><button type="submit" name="save" class="btn blue"><i class="icon-ok"></i> Simpan</button> 
	<button type="button" name="cancel" class="btn" onclick="location.href='<?php echo $link_list;?>'">Batal</button></td>
  </tr>
</table>
</form>
