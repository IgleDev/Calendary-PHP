<?php include_once('calendar.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/fontello.css">
    <link rel="stylesheet" href="./css/bootstrap-datepicker.css">
    <title>Calendar Events</title>
</head>

<body>
    <div class="container">
        <h3><i class="icon-calendar"></i>Calendar Events</h3>
        <div class="row">
            <div class="col-md-4">
                <form class="form-group" action="index.php" method="get">
                    <div class="input-group">
                        <input name="month" type="text" class="form-control datepicker">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm"><i class="icon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <h4 class="float-right"><?= "$monthName $year" ?></h4>
        </div>
        <table class="table">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
            <tr>
                <?php
                //* LAST MONTH
                while ($firstWeekDay > 0) {
                    echo '<td class="text-muted">' . $startWeekDay++ . '</td>';
                    $firstWeekDay--;
                    $weekCount++;
                }

                //* ACTUAL MONTH
                while ($dayCount <= $monthDays) {
                    echo '<td><button data-date="' . $year . '-' . $month . '-' . $dayCount . ' "class="btn btn-sm btn-dark">';
                    echo $dayCount;
                    echo '</button>';
                    $index = str_pad($dayCount, 2, '0', STR_PAD_LEFT) . $month . $year;
                    if (isset($events[$index])) {
                        echo '<small>';
                        echo '<span class="badge badge-dark float-right">' . count($events[$index]) . ' Events </span>';
                        echo '</small>';
                        echo '<ul>';
                        foreach ($events[$index] as $event) {
                            echo '<li>';
                            echo '<a title="' . $event->category . '" href="#" data-id="' . $event->id . '" class="btn-event">';
                            echo '<i class="' . $event->icon . '"></i>';
                            echo $event->name;
                            echo '</a></li>';
                        }
                        echo '</ul>';
                    }
                    echo '</td>';

                    $dayCount++;
                    $weekCount++;

                    if ($weekCount > 7) {
                        echo '<tr></tr>';
                        $weekCount = 1;
                    }
                }

                //* NEXT MONTH
                while ($weekCount >= 1 && $weekCount <= 7) {
                    echo '<td class="text-muted">' . $nextDay++ . '</td>';
                    $weekCount++;
                }
                ?>
            </tr>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="addTask.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="icon-calendar"></i> Add New Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control input-date" type="text" name="date" placeholder="Date">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="time" name="time" placeholder="Time">
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <?php if (count($categories) > 0) : ?>
                                <select class="form-control" name="category">
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php else : ?>
                                <div class="alert alert-warning">No more categories</div>
                            <?php endif ?>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="name" placeholder="Event Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //* Modal Edit-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="editTask.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="icon-calendar"></i> Edit Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control input-date" type="text" name="date" placeholder="Date">
                        </div>
                        <div class="form-group">
                            <input class="form-control input-time" type="time" name="time" placeholder="Time">
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <?php if (count($categories) > 0) : ?>
                                <select class="form-control select-categories" name="category">
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php else : ?>
                                <div class="alert alert-warning">No more categories</div>
                            <?php endif ?>
                        </div>
                        <div class="form-group">
                            <input class="form-control input-name" type="text" name="name" placeholder="Event Name">
                        </div>
                        <input class="input-id" name="id" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-remove" data-dismiss="modal">DELETE</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="icon-calendar"></i> Remove Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure? You want to remove this event?</p>
                    </div> 
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-danger btn-delete">YES</a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="./js/bootstrap.js"></script>
    <script src="./js/bootstrap-datepicker.js"></script>
    <script src="./js/actionjs/calendarFuntion.js"></script>
    <script src="./js/actionjs/alert.js"></script>
</body>

</html>