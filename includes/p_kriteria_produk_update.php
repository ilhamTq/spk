<?php
$link_list='?hal=data_kriteria_produk';
$link_update='?hal=update_kriteria_produk';

if(isset($_POST['save'])){
	$id=$_POST['id'];
	$action=$_POST['action'];
	$kode_kriteria_produk=$_POST['kode_kriteria_produk'];
	$nama_kriteria_produk=$_POST['nama_kriteria_produk'];
	
	if(empty($kode_kriteria_produk) or empty($nama_kriteria_produk)){
		$error='Masih ada beberapa kesalahan. Silahkan periksa lagi form di bawah ini.';
	}else{
		if($action=='add'){
			if(mysql_num_rows(mysql_query("select * from kriteria_produk where kode_kriteria_produk='".$kode_kriteria_produk."'"))>0){
				$error='kode sudah terdaftar. Silahkan gunakan kode yang lain.';
			}else{
				$q="insert into kriteria_produk(kode_kriteria_produk, nama_kriteria_produk) values('".$kode_kriteria_produk."', '".$nama_kriteria_produk."')";
				mysql_query($q);
				exit("<script>location.href='".$link_list."';</script>");
			}
		}
		if($action=='edit'){
			$q=mysql_query("select * from kriteria_produk where id_kriteria_produk='".$id."'");
			$h=mysql_fetch_array($q);
			$kode_kriteria_produk_tmp=$h['kode_kriteria_produk'];
			if(mysql_num_rows(mysql_query("select * from kriteria_produk where kode_kriteria_produk='".$kode_kriteria_produk."' and kode_kriteria_produk<>'".$kode_kriteria_produk_tmp."'"))>0){
				$error='kode sudah terdaftar. Silahkan gunakan kode yang lain.';
			}else{
				$q="update kriteria_produk set kode_kriteria_produk='".$kode_kriteria_produk."', nama_kriteria_produk='".$nama_kriteria_produk."' where id_kriteria_produk='".$id."'";
				mysql_query($q);
				exit("<script>location.href='".$link_list."';</script>");
			}
		}
		
	}
}else{
	if(empty($_GET['action'])){$action='add';}else{$action=$_GET['action'];}
	if($action=='edit'){
		$id=$_GET['id'];
		$q=mysql_query("select * from kriteria_produk where id_kriteria_produk='".$id."'");
		$h=mysql_fetch_array($q);
		$kode_kriteria_produk=$h['kode_kriteria_produk'];
		$nama_kriteria_produk=$h['nama_kriteria_produk'];
	}
	if($action=='delete'){
		$id=$_GET['id'];
		mysql_query("delete from kriteria_produk where id_kriteria_produk='".$id."'");
		exit("<script>location.href='".$link_list."';</script>");
	}
}


?>

<h3 class="p2">Update Data Kriteria</h3>

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
	<td width="120">kode<span class="required">*</span> </td>
	<td><input name="kode_kriteria_produk" type="text" size="40" value="<?php echo $kode_kriteria_produk;?>" class="m-wrap large"></td>
  </tr>
  <tr>
	<td>Nama Kriteria<span class="required">*</span> </td>
	<td><input name="nama_kriteria_produk" type="text" size="40" value="<?php echo $nama_kriteria_produk;?>" class="m-wrap large"></td>
  </tr>
  <tr>
	<td></td>
	<td><button type="submit" name="save" class="btn blue"><i class="icon-ok"></i> Simpan</button> 
	<button type="button" name="cancel" class="btn" onclick="location.href='<?php echo $link_list;?>'">Batal</button></td>
  </tr>
</table>
</form>
