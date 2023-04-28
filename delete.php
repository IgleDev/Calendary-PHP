<?php 
require 'mysqli.php';

$id = $_GET['id'];

$query = "SELECT DATE_FORMAT(date, '%m-%Y') AS url FROM events WHERE id = $id";

$rsUrl = $mysqli->query($query) or die ($mysqli->error);

$url = $rsUrl->fetch_object()->url;

$deteleQuery = "DELETE FROM events WHERE id = $id";

$mysqli->query($deteleQuery) or die ($mysqli->error);

$rsUrl->free();
$mysqli->close();

header('Location: index.php?month=' . $url);
?>