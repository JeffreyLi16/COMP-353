<?php   
    include('config.local.php');
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    if(isset($_SESSION['viewEmployeeID'])){
        $ID = $_SESSION['viewEmployeeID'];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST["submit"] == 'deleteEmployee'){
                $viewEmployeeID = $_SESSION['viewEmployeeID'];
                $sql = "DELETE FROM Employee WHERE EmployeeID = '$ID';";
                $result = mysqli_query($db, $sql);
                header("location:employeeHomePage.php");
            }
        }
    }
    else{
        $ID = $_SESSION["employeeID"];
    }

    $sql = "SELECT * FROM Employee WHERE (EmployeeID = '$ID')";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['FirstName'];
    $lastName = $row['LastName'];
    $startDate = $row['StartDate'];
    $salary = $row['Salary'];
    $address = $row["Address"];
    $phoneNumber = $row["PhoneNumber"];
    $email = $row["Email"];
    $password = $row["Password"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST["submit"] == 'update'){
            $mynewpassword = $_POST['newPassword'];
            $mynewaddress = $_POST['newAddress']; 
            $mynewemail = $_POST['newEmail']; 
            $mynewphonenumber = $_POST['newPhoneNumber'];
            $alertMessageChanged = "";

            if(isset($_SESSION['viewEmployeeID'])){
                $mynewpassword = null;
                $mynewfirstname = $_POST['newFirstName']; 
                $mynewlastname = $_POST['newLastName']; 
                $mynewsalary = $_POST['newSalary']; 
                if($mynewfirstname === $firstName){

                }
                else{
                    $sql = "UPDATE Employee SET FirstName = '$mynewfirstname' WHERE EmployeeID = '$ID'";
                    $result = mysqli_query($db, $sql);
        
                }
                if($mynewlastname === $lastName){
        
                }
                else{
                    $sql = "UPDATE Employee SET LastName = '$mynewlastname' WHERE EmployeeID = '$ID'";
                    $result = mysqli_query($db, $sql);
                }
                if($mynewsalary === $salary){

                }
                else{
                    $sql = "UPDATE Employee SET salary = '$mynewsalary' WHERE EmployeeID = '$ID'";
                    $result = mysqli_query($db, $sql);
                }
            }
        
            if ($mynewpassword == null){
                // $alertMessage = "password remained the same";
            }
            else {
                $sql = "UPDATE Employee SET Password = '$mynewpassword' WHERE EmployeeID = '$ID'";
                $result = mysqli_query($db, $sql);
            }

            if ($mynewaddress === $address){
                // $alertMessage = "address remained the same " . $alertMessage;
            }
            else {
                $sql = "UPDATE Employee SET Address = '$mynewaddress' WHERE EmployeeID = '$ID'";
                $result = mysqli_query($db, $sql);
            }

            if ($mynewemail === $email){
                // $alertMessage = "email remained the same" . $alertMessage;
            }
            else {
                $sql = "UPDATE Employee SET Email = '$mynewemail' WHERE EmployeeID = '$ID'";
                $result = mysqli_query($db, $sql);
            }

            if ($mynewphonenumber === $phoneNumber){
                // $alertMessage = "Phone Number" . $alertMessage;
            }
            else {
                $sql = "UPDATE Employee SET  PhoneNumber = '$mynewphonenumber' WHERE EmployeeID = '$ID'";
                $result = mysqli_query($db, $sql);
            }

            echo $alertMessageChanged = "Your changes has been saved.";
            
            if (isset($_SESSION["viewEmployeeID"])){
                $url = "employeeSetting.php";
                function myAlert($alertMessageChanged, $url){
                    echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
                    echo "<script>document.location = '$url'</script>";
                }
                myAlert($alertMessageChanged, $url);
            } 
            else{
                function myAlert($alertMessageChanged, $url){
                    $url = "employeeHomePage.php";
                    echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
                    echo "<script>document.location = '$url'</script>";
                }
                myAlert($alertMessageChanged, $url);
            }   
        }
    };

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
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>

        </nav>
        <div id="main-wrapper"><h2><center>Update your Account Information</center></h2><br>
            <div><h3><center>
                <form action = "" method = "post">

                    <?php
                        if(isset($_SESSION['viewEmployeeID'])){
                            echo "<label><strong>First Name :</strong></label> 
                            <input type=\"text\" name= \"newFirstName\" value = \"$firstName\" /><br><br>";
    
                            echo "<label><strong>Last Name :</strong></label>
                            <input type=\"text\" name= \"newLastName\"value = \"$lastName\" /><br><br>";

                            echo "<label><strong>Salary :</strong></label>
                            <input type=\"text\" name= \"newSalary\"value = \"$salary\" /><br><br>";
                        } 
                        else{
                            echo "<label><strong>First Name :</strong></label> 
                            <input type=\"text\" value = \"$firstName\" disabled/><br><br>";
    
                            echo "<label><strong>Last Name :</strong></label>
                            <input type=\"text\" value = \"$lastName\" disabled/><br><br>";

                            echo "<label><strong>Salary :</strong></label>
                            <input type=\"text\" value = \"$salary\" disabled/><br><br>";

                            echo "<label><strong>Password :</strong></label>
                            <input type = \"password\" name = \"newPassword\" placeholder=\"Enter your new password\"/><br/><br />";
                        }
                    ?>
                    
                    <label><strong>Start Date :</strong></label>
                    <input type="text" value = "<?php echo $startDate;?>" disabled/><br><br>

                    <label><strong>Address :</strong></label>
                    <input type = "text" name = "newAddress" value="<?php echo $address;?>"/> <br> <br>

                    <label><strong>Email :</strong></label>
                    <input type = "text" name = "newEmail" value="<?php echo $email;?>"/> <br> <br>

                    <label><strong>Phone Number :</strong></label>
                    <input type = "text" name = "newPhoneNumber" value="<?php echo $phoneNumber;?>"/> <br> <br>
                    

                    <button class="save_btn btn btn-success" name="submit" type="submit" value="update">Update</button>
                    <a href="EmployeeHomePage.php"><button type="button" class="btn btn-warning back_btn">Cancel</button></a>
                    <?php
                        if(isset($_SESSION['viewEmployeeID']) && $ID !== $_SESSION['employeeID']){
                            echo "<a href=\"employeeSchedule.php\"><button type=\"button\" class=\"btn btn-info back_btn\">view Schedule</button></a>";
                            echo "<button class=\"btn btn-danger back_btn\" name=\"submit\" type=\"submit\" value=\"deleteEmployee\">DELETE EMPLOYEE</button>";
                        }
                    ?>
                </form>
            </center></h3></div>

        </div>
    </body>
</html>