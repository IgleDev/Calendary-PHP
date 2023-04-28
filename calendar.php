<?php 
    require 'mysqli.php';
    $query = "SELECT * FROM categories";
    $typeCat = $mysqli->query($query) or die($mysqli->error);
    $categories = array();
    while($row = $typeCat->fetch_object()){
        $categories[] = $row;
    }

    $typeCat->free();

    $pattern = "/[0-9]{2}-[0-9]{4}/";
    if(isset($_GET['month']) && preg_match($pattern, $_GET['month'])){
        $dateArray = explode('-',$_GET['month']);
        $month = $dateArray[0];
        $year = $dateArray[1];
    }else{
        $month = date('m');
	    $year = date('Y');
    }

    $monthDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    $firstDate = strtotime($year . '-' . $month . '-1');
    $monthName = date('F',$firstDate);
	$firstWeekDay = date('w', $firstDate);

    $lastDate = strtotime($year . '-' . $month . '-' . $monthDays);
    $from = date('Y-m-d', $firstDate);
    $to = date('Y-m-d', $lastDate);

    if($month === 1){
        $prevMonth = 12;
        $prevYear = $year - 1;
    }else{
        $prevMonth = $month -1;
        $prevYear = $year;
    }

    if($month === 12){
        $nextMonth = 1;
        $nextYear = $year + 1;
    }else{
        $nextMonth = $month + 1;
        $nextYear = $year;
    }

    $prevMothDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    $startWeekDay = $prevMothDays - $firstWeekDay +1;
    $weekCount = 1;
    $dayCount = 1;
    $nextDay = 1;

    $eventsQuery = "SELECT events.id, DATE_FORMAT(date, '%d%m%Y') AS arr_index, 
        events.name, categories.name AS category, icon, date
        FROM events, categories 
        WHERE categories.id = cat AND date BETWEEN '$from' AND '$to'
        ORDER BY date";

    $rsEvents = $mysqli -> query($eventsQuery) or die ($mysqli->error);
    $events = array();

    while($row = $rsEvents->fetch_object()){
        $events[$row -> arr_index][] = $row;
    }

    $mysqli->close();
?>