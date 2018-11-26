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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
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
        <li class="nav-item">
          <a class="nav-link" href="viewTransfer.php">Transfer</a>
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
      <center>Welcome
        <?php echo $firstName;?>
      </center>
    </h2>
    <hr>
  </div>

  <div style="margin:60px !important;">
    <?php 
      echo "<h3>List of Accounts: </h3>";
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
        echo "<table style=\" background-repeat:no-repeat; width:750px; margin:10;\" cellpadding=\"10\" cellspacing=\"10\" border=\"1\">
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
      echo "<h3>List of Transactions: </h3>";

      ?>
  </div>
</body>

</html>