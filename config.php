<?php
$db_host = 'localhost';
$db_user = 'root';
$db_name = 'spk';
$db_password='';

$web_host='http://localhost:8056/spk/';

$link=mysql_connect($db_host,$db_user,$db_password);
mysql_select_db($db_name,$link);

?>