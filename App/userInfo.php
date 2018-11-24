<?php   
    include('session.php');
    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];


    $sql = "SELECT Client.* FROM Client, Account WHERE (Client.ClientID = Account.ClientID) AND (CardNumber = '$card')";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $address = $row["Address"];
    $phoneNumber = $row["PhoneNumber"];
    $email = $row["Email"];

    // echo "First Name: " . $row["FirstName"] . "</br>
    //         Last Name: " . $row["LastName"] . " </br>
    //         Birthday: " . $row["Birthday"]. " </br>
    //         Password: " . $row["Password"]. " </br>
    //         Join Date: " . $row["JoinDate"]. " </br>
    //         Address: " . $row["Address"]. " </br>
    //         Email: " . $row["Email"]. " </br>
    //         Phone Number: " .$row["PhoneNumber"]. "</br>";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $mynewpassword = $_POST['newPassword']; 
        $mynewaddress = $_POST['newAddress']; 
        $mynewemail = $_POST['newEmail']; 
        $mynewphonenumber = $_POST['newPhoneNumber']; 

        if ($mynewpassword == null){
            // $alertMessage = "password remained the same";
        }
        else {
            $sql = "UPDATE Client SET Password = '$mynewpassword' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "PASSWORD ";
        }

        if ($mynewaddress === $address){
            // $alertMessage = "address remained the same " . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET Address = '$mynewaddress' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "ADDRESS " . $alertMessageChanged;
        }

        if ($mynewemail === $email){
            // $alertMessage = "email remained the same" . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET Email = '$mynewemail' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "E-MAIL " . $alertMessageChanged;
        }

        if ($mynewphonenumber === $phoneNumber){
            // $alertMessage = "Phone Number" . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET  PhoneNumber = '$mynewphonenumber' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "PHONE NUMBER " . $alertMessageChanged;
        }

        echo $alertMessageChanged = "Your " . $alertMessageChanged . "has been updated.";
        $url = "homePage.php";

        function myAlert($alertMessageChanged, $url){
            echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
            echo "<script>document.location = '$url'</script>";
        }
        myAlert($alertMessageChanged, $url);

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
                    <!-- <a class="navbar-brand" href="#">My Account Setting</a> -->


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-brand" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>My Account</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <!-- <h6 class="dropdown-header">My Account Info:</h6> -->
                            <a class="dropdown-item" href="#">My Account</a>
                            <a class="dropdown-item" href="#">Change Password</a>
                            <div class="dropdown-divider"></div>

                        </div>
                    </li>
                </div>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>

        </nav>
        <div id="main-wrapper"><h2><center>Update your Account Information</center></h2><br>
            <div><h3><center>
                <form action = "" method = "post">
                    <!-- <table >
                        <tr>
                            <td><label><strong>First Name : </strong></label></td>
                            <td><input type="text" value = "<?php echo $row["FirstName"];?>" disabled/></td>
                        </tr>
                        <tr>
                            <td><label><strong>Last Name : </strong></label></td>
                            <td><input type="text" value = "<?php echo $row["LastName"];?>" disabled/></td>
                        </tr>
                        <tr>
                            <td><label><strong>Joined Date : </strong></label></td>
                            <td><input type="text" value = "<?php echo $row["JoinDate"];?>" disabled/></td>
                        </tr>
                        <tr>
                            <td><label><strong>Password : </strong></label></td>
                            <td><input type = "password" name = "newPassword" placeholder="Enter your new password"/></td>
                        </tr>
                        <tr>
                            <td><label><strong>Address : </strong></label></td>
                            <td><input type = "text" name = "newAddress" value="<?php echo $row["Address"];?>"/></td>
                        </tr>
                        <tr>
                            <td><label><strong>E-Mail : </strong></label></td>
                            <td><input type = "text" name = "newEmail" value="<?php echo $row["Email"];?>"/></td>
                        </tr>
                        <tr>
                            <td><label><strong>Phone Number : </strong></label></td>
                            <td><input type = "text" name = "newPhoneNumber" value="<?php echo $row["PhoneNumber"];?>"/></td>
                        </tr>

                    </table> -->
                    <label><strong>First Name :</strong></label> 
                    <input type="text" value = "<?php echo $row["FirstName"];?>" disabled/><br><br>

                    <label><strong>Last Name :</strong></label>
                    <input type="text" value = "<?php echo $row["LastName"];?>" disabled/><br><br>
                    
                    <label><strong>Joined Date :</strong></label>
                    <input type="text" value = "<?php echo $row["JoinDate"];?>" disabled/><br><br>

                    <label><strong>Password :</strong></label>
                    <input type = "password" name = "newPassword" placeholder="Enter your new password"/><br/><br />
                    
                    <label><strong>Address :</strong></label>
                    <input type = "text" name = "newAddress" value="<?php echo $row["Address"];?>"/> <br> <br>

                    <label><strong>Email :</strong></label>
                    <input type = "text" name = "newEmail" value="<?php echo $row["Email"];?>"/> <br> <br>

                    <label><strong>Phone Number :</strong></label>
                    <input type = "text" name = "newPhoneNumber" value="<?php echo $row["PhoneNumber"];?>"/> <br> <br>
                    

                    <button class="save_btn" name="save" type="submit">Update</button>
                    <a href="homePage.php"><button type="button" class="back_btn">Cancel</button></a>
                </form>
            </center></h3></div>

        </div>
    </body>
</html>

