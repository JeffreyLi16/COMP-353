<?php   
    include('Components/sessionClient.php');

    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];


    $sql = "SELECT Client.* FROM Client, Account WHERE (Client.ClientID = Account.ClientID) AND (CardNumber = '$card')";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $address = $row["Address"];
    $phoneNumber = $row["PhoneNumber"];
    $email = $row["Email"];
    $firstName = $row["FirstName"];
    $lastName = $row["LastName"];

?>

<html>
  <head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">      
  </head>
   <body>

    <?php
        include('Components/navbar.php');
    ?>
    <div id="main-wrapper">
      <h2>
        <center>Welcome <?php echo $firstName;?></center>
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

