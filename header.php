<?php
session_start();
?>

<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="menu.css">
   <script src="jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js"></script>
   <title>Menu Utama</title>
</head>
<body>


<?php if ($_SESSION['level_id']=='entry'){ ?>
<div id='cssmenu'>
<ul>
   <li><a href='./'><span>Home</span></a></li>
   <li class='active has-sub'><a href='#'><span>Data Master</span></a>
      <ul>
		 <li class='has-sub'><a href='?hal=data_produk'><span>Data UKM </span></a></li>
		 <li class='has-sub'><a href='?hal=data_kriteria_produk'><span>Kriteria UKM </span></a></li>
      </ul>
    <li class='last'><a href='logout.php'><span>Keluar</span></a></li>
	</div>
<?php } 
if ($_SESSION['level_id']=='pimpinan'){ ?>
<div id='cssmenu'>

<ul>
<li><a href='./'><span>Home</span></a></li>
   <li><a href='?hal=nilai_kriteria_produk'><span>Kriteria UKM </span></a></li>
   <li><a href='?hal=nilai_produk'><span>Penilaian UKM </span></a></li>
   <li><a href='?hal=hasil_produk'><span>Ranking UKM </span></a></li>
    <li class="last"><a href="logout.php">Sign Out</a></li>
</ul></div>
<?php } ?>


</body>
<html>
