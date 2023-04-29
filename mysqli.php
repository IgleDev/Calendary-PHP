<?php 
$server = 'containers-us-west-192.railway.app';
$user = 'root';
$pass = 'UwQ19MbIASGMsUvFlsVl';
$dataBase = 'railway';

$mysqli = mysqli_connect($server, $user, $pass, $dataBase) or die(mysqli_connect_error());
?>
