<?php

$link_list='?hal=data_supplier';
$link_update='?hal=update_supplier';

$q="select * from supplier order by nama";
$q=mysql_query($q);
if(mysql_num_rows($q) > 0){
	while($h=mysql_fetch_array($q)){
		$no++;
		$id=$h['id_supplier'];
		$allow_del=true;
		if(mysql_num_rows(mysql_query("select * from nilai_supplier where id_supplier_1='".$h['id_supplier']."' limit 0,1"))>0){$allow_del=false;}
		if(mysql_num_rows(mysql_query("select * from nilai_supplier where id_supplier_2='".$h['id_supplier']."' limit 0,1"))>0){$allow_del=false;}
		if($allow_del){$disabled='';}else{$disabled='disabled';}
		$daftar.='
		  <tr>
			<td valign="top">'.$no.'</td>
			<td valign="top">'.$h['npwp'].'</td>
			<td valign="top">'.$h['nama'].'</td>
			<td valign="top">'.$h['alamat'].'</td>
			<td valign="top">'.$h['no_telp'].'</td>
			<td align="center" valign="top"><a href="'.$link_update.'&amp;id='.$id.'&amp;action=edit" class="btn"><i class="icon-edit"></i></a> <a href="#" onclick="DeleteConfirm(\''.$link_update.'&amp;id='.$id.'&amp;action=delete\');return(false);" class="btn '.$disabled.'"><i class="icon-trash"></i></a></td>
		  </tr>
		';
	}
}


?>
<script language="javascript">
function DeleteConfirm(url){
	if (confirm("Anda yakin akan menghapus data ini ?")){
		window.location.href=url;
	}
}
</script>

<h3 class="p2">Data Supplier</h3>
<a href="<?php echo $link_update;?>" class="btn blue" style="float:right"><i class="icon-plus"></i> Tambah Data Supplier</a><br /><br />
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th width="40">No</th>
			<th width="160">npwp</th>
			<th>Nama Supplier</th>
            <th>Alamat</th>
            <th>No Telp</th>
			<th width="90" align="right">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $daftar;?>
	</tbody>
</table>
