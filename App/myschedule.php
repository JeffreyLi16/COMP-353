<?php   
    session_start();
    include('config.local.php');
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }
    

    //fetch schedule history
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
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $alertMessageChanged = "";
        if($_POST['submit'] == "workday"){
            $newDate = $_POST['newDate'];
            $newStart = Date("G:i:s", strtotime($_POST['newStart']));
            $newEnd = Date("G:i:s", strtotime($_POST['newEnd']));

            $sql = "INSERT INTO Schedule (EmployeeID, Date, StartTime, EndTime, isHoliday, isSick) VALUES
                ('$ID', '$newDate', '$newStart', '$newEnd', '0', '0');";
            $result = mysqli_query($db, $sql);
        }
        else{

        }
        $alertMessageChanged = "Your schedule has been updated.";
        $url = "myschedule.php";
        myAlert($alertMessageChanged, $url);
    }
    //alert/confirm schedule change
    function myAlert($alertMessageChanged, $url){
                echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
                echo "<script>document.location = '$url'</script>";
            }
    //calculate daily work hours
    function HourDiff($startTime,$endTime){
        $startTimeStamp = strtotime($startTime);
        $endTimeStamp = strtotime($endTime);
        $difference = (abs($endTimeStamp - $startTimeStamp)/3600);
        return $difference;
    }
?>

<html>
    <head>
        
        <link rel="stylesheet" href="css/timepicker.css">
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
                            <td>$date</td>
                            <td>$startTime</td>
                            <td>$endTime</td>
                            <td>$hour</td> 
                        </tr>";
                    }
                }
            ?>
            <tr>
                <form action="" method = "post">
                    <td><input type="date" name="newDate" required/></td>
                    <td><input type="text" id="time2" name="newStart" placeholder="Time" disabled style="width:50%;"}><a id="link2" class="icon">Click to choose</a></td>
                    <td><input type="text" id="time" name="newEnd" placeholder="Time" disabled style="width:50%;"}><a id="link" class="icon">Click to choose</a></td>
                    <button class="" name="submit" type="submit" value="workday">Add</button>
                </form>
            </tr>
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
                            <td>$row[Date]</td>
                            <td>$reason</td>
                        </tr>";
                    }
                }
            ?>
            <tr>
                <form action="" method = "post">
                    <td>Date: <input type="date" name="newDate" required/></td>
                    <td>Reason: <select name="newReason">
                        <option value = "isSick">Sick leave</option>
                        <option value = "isHoliday">Holiday</option>    
                    </td>
                    <button class="" name="submit" type="submit" value="leave">Add</button>
                </form>
            </tr>
        </table>
    </body>
    <script src="timepicker.js"></script>
    <script type="text/javascript">
        var time2 = document.getElementById('time2');
        var time = document.getElementById('time');
        var timepicker = new TimePicker(['link', 'link2'], {
            lang: 'en',
            theme: 'blue-grey',
        });
        timepicker.on('change', function (evt) {
            var value = (evt.hour || '00') + ':' + (evt.minute || '00');

            if (evt.element.id === 'link') {
                time.value = value;
                document.getElementById('time').removeAttribute('disabled');
            } else {
                time2.value = value;
                document.getElementById('time2').removeAttribute('disabled');
            }
        });
        </script>
</html>
