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
            
            if($mynewfirstname === $firstName){

            }
            else{
                $sql = "UPDATE Client SET FirstName = '$mynewfirstname' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
                $result = mysqli_query($db, $sql);
     
            }
            if($mynewlastname === $lastName){
    
            }
            else{
                $sql = "UPDATE Client SET LastName = '$mynewlastname' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
                $result = mysqli_query($db, $sql);
            }
        } 
        else{
            $mynewpassword = $_POST['newPassword']; 
        }
        $mynewaddress = $_POST['newAddress']; 
        $mynewemail = $_POST['newEmail']; 
        $mynewphonenumber = $_POST['newPhoneNumber']; 


        if ($mynewpassword == null){
            // $alertMessage = "password remained the same";
        }
        else {
            $sql = "UPDATE Client SET Password = '$mynewpassword' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
        }

        if ($mynewaddress === $address){
            // $alertMessage = "address remained the same " . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET Address = '$mynewaddress' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
        }

        if ($mynewemail === $email){
            // $alertMessage = "email remained the same" . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET Email = '$mynewemail' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
        }

        if ($mynewphonenumber === $phoneNumber){
            // $alertMessage = "Phone Number" . $alertMessage;
        }
        else {
            $sql = "UPDATE Client SET  PhoneNumber = '$mynewphonenumber' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
            $result = mysqli_query($db, $sql);
        }

        $alertMessageChanged = "Your changes has been saved.";
        $url = "";
        
        if (isset($_SESSION["employeeID"])){
            $url = "userInfo.php";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">   
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
                        <a class="nav-link" href="homePage.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="viewBills.php">View Bills</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="viewTransfer.php">Transfer</a>
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
                    

                    <button class="btn btn-success save_btn" name="save" type="submit">Update</button>
                    <?php
                        if (isset($_SESSION["employeeID"])){
                            echo "<a href=\"openClientAccount.php\"><button type=\"button\" class=\"btn btn-info\">Create new account</button></a>";
                            echo "<a href=\"employeeHomePage.php\"><button type=\"button\" class=\"btn btn-danger back_btn\">Leave</button></a>";
                        }
                        else{
                            echo "<a href=\"homePage.php\"><button type=\"button\" class=\"btn btn-danger back_btn\">Cancel</button></a>";
                        } 
                    ?>
                </form>
            </center></h3></div>

        </div>
    </body>
</html>