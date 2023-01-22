<?php
$link_list='?hal=data_ukm';
$link_update='?hal=update_ukm';

if(isset($_POST['save'])){
	$id=$_POST['id'];
	$action=$_POST['action'];
	$kode_ukm=$_POST['kode_ukm'];
	$nama_ukm=$_POST['nama_ukm'];
	
	if(empty($kode_ukm) or empty($nama_ukm)){
		$error='Masih ada beberapa kesalahan. Silahkan periksa lagi form di bawah ini.';
	}else{
		if($action=='add'){
			if(mysql_num_rows(mysql_query("select * from ukm where kode_ukm='".$kode_ukm."'"))>0){
				$error='kode sudah terdaftar. Silahkan gunakan npwp yang lain.';
			}else{
				$q="insert into ukm(kode_ukm, nama_ukm) values('".$kode_ukm."', '".$nama_ukm."')";
				mysql_query($q);
				exit("<script>location.href='".$link_list."';</script>");
			}
		}
		if($action=='edit'){
			$q=mysql_query("select * from ukm where id_ukm='".$id."'");
			$h=mysql_fetch_array($q);
			$kode_ukm_tmp=$h['kode_ukm'];
			if(mysql_num_rows(mysql_query("select * from ukm where kode_ukm='".$kode_ukm."' and kode_ukm<>'".$kode_ukm_tmp."'"))>0){
				$error='kode sudah terdaftar. Silahkan gunakan kode yang lain.';
			}else{
				$q="update ukm set kode_ukm='".$kode_ukm."', nama_ukm='".$nama_ukm."' where id_ukm='".$id."'";
				mysql_query($q);
				exit("<script>location.href='".$link_list."';</script>");
			}
		}
		
	}
}else{
	if(empty($_GET['action'])){$action='add';}else{$action=$_GET['action'];}
	if($action=='edit'){
		$id=$_GET['id'];
		$q=mysql_query("select * from ukm where id_ukm='".$id."'");
		$h=mysql_fetch_array($q);
		$npwp=$h['kode_ukm'];
		$nama=$h['mer_ukm'];
	}
	if($action=='delete'){
		$id=$_GET['id'];
		mysql_query("delete from ukm where id_ukm='".$id."'");
		exit("<script>location.href='".$link_list."';</script>");
	}
}


?>

<h3 class="p2">Update Data ukm </h3>

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
	<td width="120">Kode ukm <span class="required">*</span> </td>
	<td><input name="kode_ukm" type="text" size="40" value="<?php echo $kode_ukm;?>" class="m-wrap large"></td>
  </tr>
  <tr>
	<td>Nama ukm <span class="required">*</span> </td>
	<td><input name="nama_ukm" type="text" size="40" value="<?php echo $nama_ukm;?>" class="m-wrap large"></td>
  </tr>
 
  <tr>
	<td></td>
	<td><button type="submit" name="save" class="btn blue"><i class="icon-ok"></i> Simpan</button> 
	<button type="button" name="cancel" class="btn" onclick="location.href='<?php echo $link_list;?>'">Batal</button></td>
  </tr>
</table>
</form>
