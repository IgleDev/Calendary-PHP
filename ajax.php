<?php 
    require 'mysqli.php';

    $id = $_GET['id'];
    $query = "SELECT id, DATE_FORMAT(date, '%Y-%m-%d') AS date, 
    DATE_FORMAT(date, '%H-%i') AS time, 
    cat, name
    FROM events WHERE id = $id";

    $rsEvent = $mysqli -> query($query) or die ($mysqli -> error);

    echo json_encode($rsEvent -> fetch_assoc());
?>