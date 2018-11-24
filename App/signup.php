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
  <link rel="stylesheet" href="css/login.css">

  <body>
    <div id="main-wrapper"><h2><center>Sign Up</center></h2>
      <div style = "margin:30px">

        <form action = "" method = "post">
          <label><strong>Card Number :</strong></label>
          <input type = "text" name = "cardNumber" placeholder="Card Number" required/> <br> <br>
          
          <label><strong>Password :</strong></label>
          <input type = "password" name = "password" placeholder="Enter your password" required/><br/><br />
          
          <label><strong>Confirm Password :</strong></label>
          <input type = "password" name = "confirmPassword" placeholder="Re-enter your password" required/><br/><br />

          <button class="sign_up_btn" name="register" type="submit">Sign up</button>
          <a href="login.php"><button type="button" class="back_btn">Return to Login</button></a>
      </form>
      </div>
      <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
    </div>
  </body>
</html>