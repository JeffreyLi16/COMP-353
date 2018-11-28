<?php
   include("config.php");
   //include("config.local.php");
   session_start();
   if(isset($_SESSION['cardNumber']) || isset($_SESSION['employeeID'])){
     session_destroy();
     session_start();
   } 
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $mycardNumber = $_POST['cardNumber'];
      $mypassword = $_POST['password'];
      $error = ''; 
      
      $sql = "SELECT * FROM Client, Account WHERE (Client.ClientID = Account.ClientID) AND (CardNumber = '$mycardNumber') AND (Password = '$mypassword')";
      $result = mysqli_query($db,$sql);
      if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION['cardNumber'] = $mycardNumber;
         $_SESSION['clientID'] = $row['ClientID'];
         $_SESSION['FirstName'] = $row['FirstName'];
         $_SESSION['LastName'] = $row['LastName'];
         $_SESSION['birthDate'] = $row['Birthday'];
         $_SESSION['joinDate'] = $row['JoinDate'];
         $_SESSION['address'] = $row['Address'];
         $_SESSION['email'] = $row['Email'];
         $_SESSION['phoneNumber'] = $row['PhoneNumber'];
         $_SESSION['lastTransDate'] = $row['LastTransDate'];
         header("location: homePage.php");
      } else {
         $failMsg = "Your Login Name or Password is invalid";
      }
   }
?>

<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <?php           
      if(isset($failMsg)) {  
          echo("
              <div class=\"alert alert-danger text-center mt-4\" role=\"alert\">
                  <span> " . $failMsg . " </span>
              </div>
          ");
          }
    ?>
    <div class="card my-5">
      <div class="card-body mx-3">
        <h2 class="text-monospace text-center">
          <span> Login </span>
          <a href="employeeLogin.php" class="float-right"><button type="button" class="btn btn-outline-info">Employee Login</button></a>
        </h2>
        <hr>
        <div class="mt-5">
          <form action="" method="post">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label class="col-form-label text-info"><span>Card Number</span></label>
              </div>
              <div class="form-group col-md-10"><input type="text" class="form-control" name="cardNumber" placeholder="Card Number"
                  required /> <br> <br></div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label class="col-form-label text-info"><span>Password</span></label>
              </div>
              <div class="form-group col-md-10"><input type="password" class="form-control" name="password" placeholder="Enter your password"
                  required /><br /><br /></div>
            </div>
            <div class="float-right mx-3 mb-3">
              <button class="btn btn-info mr-2" name="login" type="submit">Login</button>
              <a href="signup.php"><button type="button" class="btn btn-outline-info">Register</button></a>
            </div>
          </form>
        </div>
        </div>
    </div>
  </div>
</body>

</html>