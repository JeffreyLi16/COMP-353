<?php
   //include("config.php");
   include("config.local.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $mycardNumber = $_POST['cardNumber'];
      $mypassword = $_POST['password']; 
      
      $sql = "SELECT FirstName FROM Client, Account WHERE Client.ClientID = Account.ClientID and CardNumber = $mycardNumber and Password = $mypassword";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 2) {
         session_register("cardNumber");
         $_SESSION['login_user'] = $mycardNumber;
         
         header("location: welcome.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>

<html>
   <head>   
      <title>Login</title>
      <link rel="stylesheet" href="css/login.css"
   </head>
   <body>
      <div id="main-wrapper"><h2><center>Login</center></h2>

         <div style = "margin:30px">
               
            <form action = "" method = "post">
               <label><strong>Card Number :</strong></label>
               <input type = "text" name = "cardNumber" placeholder="Card Number" required/> <br> <br>
               
               <label><strong>Password :</strong></label>
               <input type = "password" name = "password" placeholder="Enter your password" required/><br/><br />
               
               <button class="login_button" name="login" type="submit">Login</button>
               <a href="signup.php"><button type="button" class="register_btn">Register</button></a>
            </form>
               					
         </div>

      </div>
      
      <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>

   </body>
</html>