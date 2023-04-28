<?php 
    require 'mysqli.php';

    $date = $mysqli -> escape_string(strip_tags($_POST['date']));
    $time = $mysqli -> escape_string(strip_tags($_POST['time']));
    $category = $mysqli -> escape_string(strip_tags($_POST['category']));
    $name = $mysqli -> escape_string(strip_tags($_POST['name']));
    $id = $mysqli -> escape_string(strip_tags($_POST['id']));
    

    $dateTime = date('Y-m-d h:i', strtotime($date . ' ' . $time));

    $query = "UPDATE events SET name = '$name', date = '$dateTime', cat = $category WHERE id = $id";
    
    $mysqli->query($query);

    $url = date('m-Y', strtotime($date . ' ' . $time));
    header('Location: index.php?month=' . $url);
?>