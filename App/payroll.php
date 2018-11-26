<?php   
    include('config.local.php');
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    if(isset($_SESSION['viewEmployeeID'])){
        $ID = $_SESSION['viewEmployeeID'];
    }
    else{
        $ID = $_SESSION["employeeID"];
    }

    $sql = "SELECT * FROM Payroll WHERE (EmployeeID = '$ID')";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
?>

<html>
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">   
    <link rel="stylesheet" href="css/userInfo.css">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="employeeHomePage.php" class="navbar-brand">Bank of Concordia</a>
                </div>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="myschedule.php"><span class="glyphicon glyphicon-calendar"></span> My Schedule</a></li>
                    <li><a href="employeeSetting.php"><span class="glyphicon glyphicon-edit"></span> Account</a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>

        </nav>
        <div id="main-wrapper"><h2><center>Payroll History</center></h2><br>
            <div><h3><center>
            <table border = 1px>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Hours</th>
                </tr>
                <?php
                    foreach($rows as $row){
                            $date = $row['Date'];
                            $amount = $row['Amount'];
                            $hours = $row['Hours'];
                            echo 
                            "<tr>
                                    <td>$date</td>
                                    <td>$amount</td>
                                    <td>$hours</td>
                            </tr>";
                        }
                ?>
            </table>
            </center></h3></div>

        </div>
    </body>
</html>
