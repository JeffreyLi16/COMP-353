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
          <a class="navbar-brand">Bank Of Concordia</a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <!-- <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->
          <li><a href="userInfo.php"><span class="glyphicon glyphicon-edit"></span> Account</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
<<<<<<< HEAD

=======
   
>>>>>>> master
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

      <hr>
<?php 
echo "List of Accounts: ";
$sql = "SELECT Account.* FROM Account WHERE Account.ClientID =  (SELECT ClientID FROM Account WHERE CardNumber = '$card')";
$result = mysqli_query($db, $sql);

// CardNumber VARCHAR(16) NOT NULL UNIQUE,
//     AccountType VARCHAR(20) NOT NULL,
//     AccountOption VARCHAR(20) NOT NULL,
//     AccountLevel VARCHAR(20) NOT NULL,
//     Balance DECIMAL(20,2) NOT NULL,
//     BranchID INT NOT NULL,
//     ClientID INT NOT NULL,
//     ServiceID 
while ($row = mysqli_fetch_assoc($result)){
  echo "<table style=\" background-repeat:no-repeat; width:450px;margin:10;\" cellpadding=\"10\" cellspacing=\"10\" border=\"1\">
          <tr>
          <th>Card Number</th>
          <th>Account Type</th>
          <th>Account Option</th>
          <th>Account Level</th>
          <th>Balance</th>
          </tr>
          ";
  echo  "<td>" . $row["CardNumber"] . "</td>";        
  echo  "<td>" . $row["AccountType"] . "</td>";
  echo  "<td>" . $row["AccountOption"] . "</td>";
  echo  "<td>" . $row["AccountLevel"] . "</td>";
  echo  "<td>" . $row["Balance"] . "</td>";
  echo "</table> </br>";
       
}

echo "<hr>";
echo "List of Transactions: ";

?>


   </body>
</html>

