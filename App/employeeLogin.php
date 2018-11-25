<?php
   //include("config.php");
   include("config.local.php");
   session_start();
   if(isset($_SESSION['cardNumber']) || isset($_SESSION['employeeID'])){
    session_destroy();
    session_start();
      } 
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $employeeID = $_POST['employeeID'];
      $mypassword = $_POST['password'];
      $error = ''; 
      
      $sql = "SELECT * FROM Employee WHERE (EmployeeID = '$employeeID') AND (Password = '$mypassword')";
      $result = mysqli_query($db,$sql);
      if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION['employeeID'] = $employeeID;
         $_SESSION['FirstName'] = $row['FirstName'];
         $_SESSION['LastName'] = $row['LastName'];
         $_SESSION['title'] = $row['Title'];
         $_SESSION['address'] = $row['Address'];
         $_SESSION['startDate'] = $row['StartDate'];
         $_SESSION['salary'] = $row['Salary'];
         $_SESSION['email'] = $row['Email'];
         $_SESSION['phoneNumber'] = $row['PhoneNumber'];
         $_SESSION['branchID'] = $row['BranchID'];
         header("location: employeeHomePage.php");
      }else {
         $error = "Your Login Name or Password is invalid";
         echo $error;
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
               <label><strong>Employee ID :</strong></label>
               <input type = "text" name = "employeeID" placeholder="EmployeeID" required/> <br> <br>
               
               <label><strong>Password :</strong></label>
               <input type = "password" name = "password" placeholder="Enter your password" required/><br/><br />
               
               <button class="login_button" name="login" type="submit">Login</button>
            </form>
               					
         </div>

      </div>
      <a href="login.php"><button type="button" class="ClientLogin_btn">Client Login</button></a>
   </body>
</html>