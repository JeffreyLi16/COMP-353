<?php   
    session_start();
    include('config.local.php');
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    $ID = $_SESSION["employeeID"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];

    $title = $_SESSION['title'];
    $address = $_SESSION['address'];
    $startDate = $_SESSION['startDate'];
    $salary = $_SESSION['salary'];
    $email = $_SESSION['email'];
    $phoneNumber = $_SESSION['phoneNumber'];
    $branchID = $_SESSION['branchID'];

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
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    <li><a href="myschedule.php"><span class=""></span>My schedule</a></li>
                </ul>
            </div>
        </nav>

        Schedule History
        <table border = 1px>
            <tr>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Hours</th>
            </tr>
            <?php
                foreach($rows as $row){
                    if($row['isSick'] == 0 && $row['isHoliday'] == 0){
                        $date = $row['Date'];
                        $startTime = $row['StartTime'];
                        $endTime = $row['EndTime'];
                        $hour = HourDiff($startTime, $endTime);
                        echo 
                        "<tr>
                            <th>$date</th>
                            <th>$startTime</th>
                            <th>$endTime</th>
                            <th>$hour</th> 
                        </tr>";
                    }
                }
            ?>
        </table>
        </br>
        Holidays and sick leave
        <table border = 1px>
            <tr>
                <th>Date</th>
                <th>Reason</th>
            </tr>
            <?php
                foreach($rows as $row){
                    if($row['isSick'] == 1 || $row['isHoliday'] == 1){
                        if($row['isSick'] === 1){
                            $reason = 'Sick Day';
                        }
                        else{
                            $reason = 'Holiday';
                        }
                        echo 
                        "<tr>
                            <th>$row[Date]</th>
                            <th>$reason</th>
                        </tr>";
                    }
                }
            ?>
        </table>
    </body>
</html>