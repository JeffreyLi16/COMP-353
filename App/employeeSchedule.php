<?php   
    session_start();
    include('config.local.php');
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }
    

    //fetch schedule history
    $ID = $_SESSION["viewEmployeeID"];

    $sql = "SELECT * FROM Schedule, Employee WHERE (Employee.EmployeeID = Schedule.EmployeeID) AND Employee.EmployeeID = '$ID'";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    function HourDiff($startTime,$endTime){
        $startTimeStamp = strtotime($startTime);
        $endTimeStamp = strtotime($endTime);
        $difference = (abs($endTimeStamp - $startTimeStamp)/3600);
        return $difference;
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">   
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="employeeHomePage.php" class="navbar-brand">Bank Of Concordia</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="employeeSetting.php"><span class="glyphicon glyphicon-edit"></span> Account</a></li>
                    <<li><a href="payroll.php"><span class=""></span> My Payrolls</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>
        </nav>

        <div style="margin: 40px;">
            <h2>Schedule History</h2>
            <table border = 1px>
                <tr>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Hours</th>
                </tr>
                <?php
                    foreach($rows as $row){
                        if($row['isSick'] == 0 && $row['isHoliday'] == 0){ //Work schedule
                            $date = $row['Date'];
                            $startTime = $row['StartTime'];
                            $endTime = $row['EndTime'];
                            $hour = HourDiff($startTime, $endTime);
                            $scheduleID = $row['ScheduleID'];
                            echo 
                            "<tr>
                                <form action=\"\" method=\"post\">
                                    <td>$date</td>
                                    <td>$startTime</td>
                                    <td>$endTime</td>
                                    <td>$hour</td>
                                </form>
                            </tr>";
                        }
                    }
                ?>
            </table>
            </br>
            <h3>Holidays and sick leave</h3>
            <table border = 1px>
                <tr>
                    <th>Date</th>
                    <th>Reason</th>
                </tr>
                <?php
                    foreach($rows as $row){
                        $scheduleID = $row['ScheduleID'];
                        if($row['isSick'] == 1 || $row['isHoliday'] == 1){ //sickday/holiday schedule
                            if($row['isSick'] == 1){
                                $reason = 'Sick leave';
                            }
                            else{
                                $reason = 'Holiday';
                            }
                            echo 
                            "<tr>
                            <form action=\"\" method=\"post\">
                                <td>$row[Date]</td>
                                <td>$reason</td>
                            </form>
                            </tr>";
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>