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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
   <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Bank of Concordia</a>
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
          </ul>
          <div class="navbar-nav ml-4">
            <a class="nav-item nav-link" href="userInfo.php"> Account </a>
            <a class="nav-item nav-link" href="logout.php"> Logout </a>
          </div>
        </div>
      </nav>
      <div id="main-wrapper">
        <h2>
          <center>Welcome <?php echo $firstName;?></center>
        </h2>
        <div>
          <?php 
          //   echo "<b>Client Information</b></br>
          //         Card number: " . $card . "</br>
          //         First name : " . $firstName . "</br>
          //         Last Name : " . $lastName . "</br> 
          //         Birth Date : " . $birthDate . "</br> 
          //         Address : " . $address . "</br>
          //         Join Date : " . $joinDate . "</br>
          //         phoneNumber : " . $phoneNumber . "</br>
          //         Email : " . $email . "</br>"
          // ?>
        </div>  
      </div>
   </body>
</html>

