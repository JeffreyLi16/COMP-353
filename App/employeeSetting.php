<?php   
    include('config.local.php');
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    $ID = $_SESSION["employeeID"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
    $startDate = $_SESSION['startDate'];
    $salary = $_SESSION['salary'];

    $sql = "SELECT * FROM Employee WHERE (EmployeeID = '$ID')";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $address = $row["Address"];
    $phoneNumber = $row["PhoneNumber"];
    $email = $row["Email"];
    $password = $row["Password"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $mynewpassword = $_POST['newPassword'];
        $mynewaddress = $_POST['newAddress']; 
        $mynewemail = $_POST['newEmail']; 
        $mynewphonenumber = $_POST['newPhoneNumber']; 
        $alertMessageChanged = "";

        if ($mynewpassword == null){
            // $alertMessage = "password remained the same";
        }
        else {
            $sql = "UPDATE Employee SET Password = '$mynewpassword' WHERE EmployeeID = '$ID'";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "PASSWORD - ";
        }

        if ($mynewaddress === $address){
            // $alertMessage = "address remained the same " . $alertMessage;
        }
        else {
            $sql = "UPDATE Employee SET Address = '$mynewaddress' WHERE EmployeeID = '$ID'";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "ADDRESS - " . $alertMessageChanged;
        }

        if ($mynewemail === $email){
            // $alertMessage = "email remained the same" . $alertMessage;
        }
        else {
            $sql = "UPDATE Employee SET Email = '$mynewemail' WHERE EmployeeID = '$ID'";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "E-MAIL - " . $alertMessageChanged;
        }

        if ($mynewphonenumber === $phoneNumber){
            // $alertMessage = "Phone Number" . $alertMessage;
        }
        else {
            $sql = "UPDATE Employee SET  PhoneNumber = '$mynewphonenumber' WHERE EmployeeID = '$ID'";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "PHONE NUMBER - " . $alertMessageChanged;
        }

        echo $alertMessageChanged = "Your " . $alertMessageChanged . "has been updated.";
        $url = "employeeHomePage.php";
        
        function myAlert($alertMessageChanged, $url){
            echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
            echo "<script>document.location = '$url'</script>";
        }
        myAlert($alertMessageChanged, $url);
      

    };



?>


<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/userInfo.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">My Account</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="employeeHomePage.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="openClientAccount.php">Open Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myschedule.php">My Schedule</a>
                    </li>
                </ul>
                <div class="navbar-nav ml-4">
                    <a class="nav-item nav-link" href="logout.php"> Logout </a>
                </div>
            </div>
        </nav>
        
        <div id="main-wrapper"><h2><center>Update your Account Information</center></h2><br>
            <div><h3><center>
                <form action = "" method = "post">
                    <label><strong>First Name :</strong></label> 
                    <input type="text" value = "<?php echo $firstName;?>" disabled/><br><br>

                    <label><strong>Last Name :</strong></label>
                    <input type="text" value = "<?php echo $lastName;?>" disabled/><br><br>
                    
                    <label><strong>Start Date :</strong></label>
                    <input type="text" value = "<?php echo $startDate;?>" disabled/><br><br>

                    <label><strong>Salary :</strong></label>
                    <input type="text" value = "<?php echo $salary;?>" disabled/><br><br>
                    
                    <label><strong>Password :</strong></label>
                    <input type = "password" name = "newPassword" placeholder="Enter a new password"/> <br> <br>

                    <label><strong>Address :</strong></label>
                    <input type = "text" name = "newAddress" value="<?php echo $address;?>"/> <br> <br>

                    <label><strong>Email :</strong></label>
                    <input type = "text" name = "newEmail" value="<?php echo $email;?>"/> <br> <br>

                    <label><strong>Phone Number :</strong></label>
                    <input type = "text" name = "newPhoneNumber" value="<?php echo $phoneNumber;?>"/> <br> <br>
                    

                    <button class="save_btn btn btn-success" name="save" type="submit">Update</button>
                    <a href="EmployeeHomePage.php"><button type="button" class="btn btn-danger back_btn">Cancel</button></a>
                </form>
            </center></h3></div>

        </div>
    </body>
</html>