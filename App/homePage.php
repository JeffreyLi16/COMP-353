<?php   
    include('session.php');
    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
    $birthDate = $_SESSION['birthDate'];
    $joinDate = $_SESSION['joinDate'];
    $address = $_SESSION['address'];
    $email = $_SESSION['email'];
    $phoneNumber = $_SESSION['phoneNumber'];
    $lasTransDate = $_SESSION['lastTransDate'];
?>

<html>
<head>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">   
</head>
   <body>
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
      <div id="main-wrapper">
        <h2>
          <center>Welcome <?php echo $firstName;?></center>
        </h2>
        <div>
          <?php 
            echo "<b>Client Information</b></br>
                  Card number: " . $card . "</br>
                  First name : " . $firstName . "</br>
                  Last Name : " . $lastName . "</br> 
                  Birth Date : " . $birthDate . "</br> 
                  Address : " . $address . "</br>
                  Join Date : " . $joinDate . "</br>
                  phoneNumber : " . $phoneNumber . "</br>
                  Email : " . $email . "</br>"
          ?>
        </div>  
      </div>
   </body>
</html>

