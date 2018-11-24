<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password'];

      $sql = "SELECT AccountID FROM Account WHERE username = '$myusername'";
      $result = mysqli_query($db,$sql);

      $count = mysqli_num_rows($result);
		
      if($count == 1){
      	$sql = "SELECT ClientID FROM BelongsTo WHERE AccountID = '$myusername'";
      	$result = mysqli_query($db,$sql);
      	$sql = "UPDATE Client SET Password = '$mypassword' WHERE ClientID = '$result'"
      }
      else {
      	$error = "Invalid AccountID";
      }
         
      
?>
<!DOCTYPE html>
<html>
<style>
</style>
<body>

<form action="/login.php" style="border:1px solid #ccc">
  <div class="container">
    <h1>Sign Up</h1>

    <label for="accountID"><b>AccountID</b></label><br>
    <input type="text" placeholder="Enter Account ID" name="accountID" required><br>

    <label for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" required><br>
    
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>

<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>

</body>
</html>

