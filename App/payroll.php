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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
            crossorigin="anonymous">    
        <link rel="stylesheet" href="css/employee.css"> 
    </head>
    <body>
       <?php
       include('Components/navbar.php')
       ?>
        <div id="main-wrapper"><h2><center>Payroll History</center></h2><br>
            <div>
                <table width=450px;>
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
            </div>
        </div>
    </body>
</html>
