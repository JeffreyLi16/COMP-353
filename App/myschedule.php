<?php   
    include('sessionEmployee.php');

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
        $url = "myschedule.php";
        if($_POST['submit'] == "workday"){
            $newDate = $_POST['newDate'];
            $newStart = Date("G:i:s", strtotime($_POST['newStart']));
            $newEnd = Date("G:i:s", strtotime($_POST['newEnd']));

            if(validDate($newDate, $rows) && validTime($_POST['newStart'], $_POST['newEnd'])){
                $sql = "INSERT INTO Schedule (EmployeeID, Date, StartTime, EndTime, isHoliday, isSick) VALUES
                    ('$ID', '$newDate', '$newStart', '$newEnd', '0', '0');";
                $result = mysqli_query($db, $sql);
            }
            else{
                if(!validDate($newDate, $rows)){
                    $alertMessageChanged = "Invalid date: Date already exist";
                    myAlert($alertMessageChanged, $url);
                }
                else{
                    $alertMessageChanged = "Invalid time: Start time must be before end time";
                    myAlert($alertMessageChanged, $url);
                }
            }
        }
        else if($_POST['submit'] == "leave"){
            $newDate = $_POST['newLeaveDate'];
            $newReason = $_POST['newReason'];

            if(validDate($newDate, $rows)){
                if($newReason === 'isSick'){
                    $sql = "INSERT INTO Schedule (EmployeeID, Date, isHoliday, isSick) VALUES
                    ('$ID', '$newDate', '0', '1');";
                }
                else{
                    $sql = "INSERT INTO Schedule (EmployeeID, Date, isHoliday, isSick) VALUES
                    ('$ID', '$newDate', '1', '0');";
                }
                $result = mysqli_query($db, $sql);
            }
            else{
                $alertMessageChanged = "Invalid date or reason";
                myAlert($alertMessageChanged, $url);
            }
        }

        else if($_POST['submit'] == "editWorkday"){
            $scheduleID = $_POST['scheduleID'];
            $editDate = $_POST['editDate'];
            $editStart = Date("G:i:s", strtotime($_POST['editStart']));
            $editEnd = Date("G:i:s", strtotime($_POST['editEnd']));

            if(validEditDate($editDate, $rows, $scheduleID) && validTime($editStart, $editEnd)){
                $sql = "UPDATE Schedule SET Date = '$editDate' , StartTime = '$editStart' , EndTime = '$editEnd'
                        WHERE ScheduleID = $scheduleID;";
                $result = mysqli_query($db, $sql);
            }
            else{
                if(!validEditDate($editDate, $rows, $scheduleID)){
                    $alertMessageChanged = "Invalid date: Date already exist";
                    myAlert($alertMessageChanged, $url);
                }
                else if(!validTime($editStart, $editEnd)){
                    $alertMessageChanged = "Invalid time: Start time must be before end time $editStart, $editEnd";
                    myAlert($alertMessageChanged, $url);
                }
                else{
                    $alertMessageChanged = "something went wrong $scheduleID $editDate $editStart $editEnd";
                    myAlert($alertMessageChanged, $url);
                }
            }
        }
        else if($_POST['submit'] == "editLeave"){
            $scheduleID = $_POST['scheduleID'];
            $editDate = $_POST['editDate'];
            $editReason = $_POST['editReason'];

            if(validEditDate($editDate, $rows, $scheduleID)){
                if($editReason === 'isSick'){
                    $sql = "UPDATE Schedule SET Date = '$editDate' , isSick = '1' , isHoliday = '0'
                    WHERE ScheduleID = $scheduleID;";
                }
                else if($editReason === 'isHoliday'){
                    $sql = "UPDATE Schedule SET Date = '$editDate' , isSick = '0' , isHoliday = '1'
                    WHERE ScheduleID = $scheduleID;";
                }
                else{//no change to reason, only date
                    $sql = "UPDATE Schedule SET Date = '$editDate'
                    WHERE ScheduleID = $scheduleID;";
                }
                $result = mysqli_query($db, $sql);
            }
            else{
                    $alertMessageChanged = "Invalid date: Date already exist";
                    myAlert($alertMessageChanged, $url);
            }
        }
        else if($_POST['submit'] == "deleteFromSchedule"){
            $scheduleID = $_POST['scheduleID'];
            $sql = "DELETE FROM Schedule WHERE ScheduleID = $scheduleID;";
            $result = mysqli_query($db, $sql);
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
    function validTime($startTime,$endTime){
        $startTimeStamp = strtotime($startTime);
        $endTimeStamp = strtotime($endTime);
        if($startTimeStamp<$endTimeStamp){
            return true;
        }
        else{
            return false;
        }
    }
    function validDate($date, $rows){
        foreach($rows as $row){
            if($date==$row['Date']){
                return false;
            }
        }
        return true;
    }
    function validEditDate($date, $rows, $ID){
        foreach($rows as $row){
            if($date==$row['Date'] && $ID!=$row['ScheduleID']){
                return false;
            }
        }
        return true;
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">    
    </head>
    <body>
        <?php
            include('navbar.php');
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
                                <input type=\"\" name=\"scheduleID\" value=$scheduleID hidden>
                                    <td><input type=\"date\" name=\"editDate\" value=\"$date\"></td>
                                    <td>$startTime</br><input type=\"time\" name=\"editStart\" ></td>
                                    <td>$endTime</br><input type=\"time\" name=\"editEnd\" ></td>
                                    <td>$hour</td>
                                    <td><button class=\"\" name=\"submit\" type=\"submit\" value=\"editWorkday\">Edit</button></td>
                                    <td><button class=\"\" name=\"submit\" type=\"submit\" value=\"deleteFromSchedule\">Delete</button></td>
                                </form>
                            </tr>";
                        }
                    }
                ?>
                <tr>
                    <form action="" method = "post">
                        <td><input type="date" name="newDate" required/></td>
                        <td><input type="text" id="time2" name="newStart" placeholder="Time" disabled style="width:50%;"}><a id="link2" class="icon">Click to choose</a></td>
                        <td><input type="text" id="time" name="newEnd" placeholder="Time" disabled style="width:50%;"}><a id="link" class="icon">Click to choose</a></td>
                        <td></td>
                        <td><button class="" name="submit" type="submit" value="workday">Add</button><td>
                    </form>
                </tr>
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
                                <input type=\"\" name=\"scheduleID\" value=$scheduleID hidden>
                                <td><input type=\"date\" name=\"editDate\" value=\"$row[Date]\"></td>
                                <td><select name=\"editReason\">
                                    <option value=\"\" disabled selected>$reason</option>
                                    <option value = \"isSick\">Sick leave</option>
                                    <option value = \"isHoliday\">Holiday</option>    
                                </td>
                                <td><button class=\"\" name=\"submit\" type=\"submit\" value=\"editLeave\">Edit</button></td>
                                <td><button class=\"\" name=\"submit\" type=\"submit\" value=\"deleteFromSchedule\">Delete</button></td>
                            </form>
                            </tr>";
                        }
                    }
                ?>
                <tr>
                    <form action="" method = "post">
                        <td>Date: <input type="date" name="newLeaveDate" required/></td>
                        <td>Reason: <select name="newReason">
                            <option value = "isSick">Sick leave</option>
                            <option value = "isHoliday">Holiday</option>    
                        </td>
                        <td><button class="" name="submit" type="submit" value="leave">Add</button></td>
                    </form>
                </tr>
            </table>
        </div>
    </body>

    <script src="//cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <style>
        ._jw-tpk-container{
            height: 200px;
        }
    </style>
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
