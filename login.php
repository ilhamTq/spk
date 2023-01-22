<?php
error_reporting(0);
session_start();
require_once 'config.php';

if(isset($_POST['login'])){
	if(empty($_POST['username']) || empty($_POST['password']))	{
		exit("<script>window.alert('Masukkan username dan password anda');window.history.back();</script>");
	}
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$q=mysql_query("SELECT * FROM admin WHERE username='".$username."' AND password='".$password."'");
	if(mysql_num_rows($q)==0){
		exit("<script>window.alert('Username dan password tidak cocok');window.history.back();</script>");
	}
	$h=mysql_fetch_array($q);
	$id_admin=$h['id_admin'];
	$level=$h['level'];
	
	$_SESSION['LOGIN_ID']=$id_admin;
	$_SESSION['level_id']=$level;
	exit("<script>window.location='".$web_host."';</script>");
}

?>