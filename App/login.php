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
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Card Number  :</label><input type = "text" name = "cardNumber" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px">
                    <?php 
                        if($error = null) 
                            echo $error; 
                    ?>
                </div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>

