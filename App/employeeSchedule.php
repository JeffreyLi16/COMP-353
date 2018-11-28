<?php   
    include('Components/sessionEmployee.php');
    
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">    
        <link rel="stylesheet" href="css/employee.css"> 
    </head>
    <body>
        <?php
        include('Components/navbar.php');
        ?>

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