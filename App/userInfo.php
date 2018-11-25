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
    $firstName = $row["FirstName"];
    $lastName = $row["LastName"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if (isset($_SESSION["employeeID"])){
            $mynewpassword = null;
            $mynewfirstname = $_POST['newFirstName']; 
            $mynewlastname = $_POST['newLastName']; 
        } 
        else{
            $mynewpassword = $_POST['newPassword']; 
        }
        $mynewaddress = $_POST['newAddress']; 
        $mynewemail = $_POST['newEmail']; 
        $mynewphonenumber = $_POST['newPhoneNumber']; 
        $alertMessageChanged = "";

        if($mynewfirstname === $firstName){

        }
        else{
            $sql = "UPDATE Client SET FirstName = '$mynewfirstname' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "First Name - ";
        }
        if($mynewlastname === $lastName){

        }
        else{
            $sql = "UPDATE Client SET LastName = '$mynewlastname' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "Last Name - " . $alertMessageChanged;
        }

        if ($mynewpassword == null){
            // $alertMessage = "password remained the same";
        }
        else {
            $sql = "UPDATE Client SET Password = '$mynewpassword' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "PASSWORD - ";
        }

        if ($mynewaddress === $address){
            // $alertMessage = "address remained the same " . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET Address = '$mynewaddress' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "ADDRESS - " . $alertMessageChanged;
        }

        if ($mynewemail === $email){
            // $alertMessage = "email remained the same" . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET Email = '$mynewemail' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "E-MAIL - " . $alertMessageChanged;
        }

        if ($mynewphonenumber === $phoneNumber){
            // $alertMessage = "Phone Number" . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET  PhoneNumber = '$mynewphonenumber' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
            $alertMessageChanged = "PHONE NUMBER - " . $alertMessageChanged;
        }

        echo $alertMessageChanged = "Your " . $alertMessageChanged . "has been updated.";
        $url = "";
        
        if (isset($_SESSION["employeeID"])){
            $url = "employeeHomePage.php";
            function myAlert($alertMessageChanged, $url){
                echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
                echo "<script>document.location = '$url'</script>";
            }
            myAlert($alertMessageChanged, $url);
        } 
        else{
            function myAlert($alertMessageChanged, $url){
                $url = "homePage.php";
                echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
                echo "<script>document.location = '$url'</script>";
            }
            myAlert($alertMessageChanged, $url);
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
                    <a class="navbar-brand">My Account</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>

        </nav>
        <div id="main-wrapper"><h2><center>Update your Account Information</center></h2><br>
            <div><h3><center>
                <form action = "" method = "post">

                    <?php
                        if (isset($_SESSION["employeeID"])){
                            echo "<label><strong>First Name :</strong></label> 
                            <input type=\"text\" name= \"newFirstName\" value = \"$firstName\" /><br><br>";
    
                            echo "<label><strong>Last Name :</strong></label>
                            <input type=\"text\" name= \"newLastName\"value = \"$lastName\" /><br><br>";
                        } 
                        else{
                            echo "<label><strong>First Name :</strong></label> 
                            <input type=\"text\" value = \"$firstName\" disabled/><br><br>";
    
                            echo "<label><strong>Last Name :</strong></label>
                            <input type=\"text\" value = \"$lastName\" disabled/><br><br>";
                        }
                    ?>
                    
                    <label><strong>Joined Date :</strong></label>
                    <input type="text" value = "<?php echo $row["JoinDate"];?>" disabled/><br><br>
                    <?php
                    if (isset($_SESSION["employeeID"])){

                    }                    
                    else{
                    echo "<label><strong>Password :</strong></label>
                    <input type = \"password\" name = \"newPassword\" placeholder=\"Enter your new password\"/><br/><br />";
                    }
                    ?>
                    
                    <label><strong>Address :</strong></label>
                    <input type = "text" name = "newAddress" value="<?php echo $row["Address"];?>"/> <br> <br>

                    <label><strong>Email :</strong></label>
                    <input type = "text" name = "newEmail" value="<?php echo $row["Email"];?>"/> <br> <br>

                    <label><strong>Phone Number :</strong></label>
                    <input type = "text" name = "newPhoneNumber" value="<?php echo $row["PhoneNumber"];?>"/> <br> <br>
                    

                    <button class="save_btn" name="save" type="submit">Update</button>
                    <?php
                        if (isset($_SESSION["employeeID"])){
                            echo "<a href=\"employeeHomePage.php\"><button type=\"button\" class=\"back_btn\">Cancel</button></a>";
                        }
                        else{
                            echo "<a href=\"homePage.php\"><button type=\"button\" class=\"back_btn\">Cancel</button></a>";
                        } 
                    ?>
                </form>
            </center></h3></div>

        </div>
    </body>
</html>