<?php
   include("config.local.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $mycardNumber = $_POST['cardNumber'];
      $mypassword = $_POST['password']; 
      $mycpassword = $_POST['confirmPassword'];
      if($mypassword == $mycpassword){
        //check if card number exist
        $sql = "SELECT CardNumber FROM Account WHERE (CardNumber = '$mycardNumber')";
        $result = mysqli_query($db, $sql);
        $obj = mysqli_fetch_object($result);         
        //if exist check if card number exist
        if($obj != null){
          $sql = "SELECT Password FROM Client, Account WHERE (Client.ClientID = Account.ClientID) AND (CardNumber = '$mycardNumber')";
          $result = mysqli_query($db, $sql);
          $obj = mysqli_fetch_object($result);         
           //if exist check if user is already registered
          if($obj->Password == null){
            //user is not register, update password
            $sql = "UPDATE Client SET Password = '$mypassword' WHERE Client.ClientID = (SELECT ClientID FROM Account WHERE CardNumber = '$mycardNumber')";
            
            if(mysqli_query($db,$sql)){
              echo '<script type="text/javascript">alert("Registration Succesful")</script>';
              header("location: login.php");
            }
          }
          else{
            echo '<script type="text/javascript">alert("You are already registered for online banking, please login")</script>';
          }
        }
        else{
        echo '<script type="text/javascript">alert("Your card number does not exist, please try again")</script>';
        }
      }
      else{
        echo '<script type="text/javascript">alert("Your confirm password does not match")</script>';
      }
    }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="card my-5">
      <div class="card-body mx-3">
        <h2 class="text-monospace text-center">
          <span> Sign Up </span>
          <a href="login.php" class="float-right"><button type="button" class="btn btn-outline-info">Return to Login</button></a>
        </h2>
        <hr>
        <div class="mt-5">
          <form action="" method="post">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label class="col-form-label text-info"><span>Card Number</span></label>
              </div>
              <div class="form-group col-md-10">
                <input type="text" class="form-control" name="cardNumber" placeholder="Card Number" required /> <br> <br>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label class="col-form-label text-info"><span>Password</span></label>
              </div>
              <div class="form-group col-md-10">
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required /> <br> <br>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
              <label class="col-form-label text-info"><span>Confirm Password</span></label>
              </div>
              <div class="form-group col-md-10">
                <input type="password" class="form-control " name="confirmPassword" placeholder="Re-enter your password" required /> <br> <br>
              </div>
            </div>
            
            <div class="float-right"><button class="btn btn-info" name="register" type="submit">Sign up</button></div>
          </form>
        </div>
      </div>
    </div>
    <div style="font-size:11px; color:#cc0000; margin-top:10px"></div>
  </div>
</body>
</html>