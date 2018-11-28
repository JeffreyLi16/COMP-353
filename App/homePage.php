<?php   
    include('session.php');
    $clientID = $_SESSION["clientID"];
    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
    $birthDate = $_SESSION['birthDate'];
    $joinDate = $_SESSION['joinDate'];
    $address = $_SESSION['address'];
    $email = $_SESSION['email'];
    $phoneNumber = $_SESSION['phoneNumber'];
    $lasTransDate = $_SESSION['lastTransDate'];
    
    $sql = "SELECT * FROM Transaction, Account WHERE (AccountID IN  (SELECT AccountID FROM Account WHERE Account.ClientID = '$clientID')) AND (AccountID = ToAccountID OR AccountID = FromAccountID) ORDER BY Date ASC;";
      $result = mysqli_query($db, $sql);
      
      while($row = mysqli_fetch_assoc($result)){
          $rows[] = $row;
      }

?>

<html>
  <head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">      
  </head>
   <body>

    <?php
        include('navbar.php');
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

  <table style=" background-repeat:no-repeat; width:750px; margin:10;" >
                <tr>
                    <th>Date</th>
                    <th>Card Number</th>
                    <th>Amount</th>
                    <th>Transaction Type</th>
                </tr>
                <?php
                    foreach($rows as $row){
                            $date = $row['Date'];
                            $cardNumber = $row['CardNumber'];
                            $amount = $row['Amount'];
                            $transactionType = $row['TransactionType'];
                            $minus="";
                            if($row['FromAccountID'] == $row['AccountID']){
                              $minus = '-';
                            }
                            echo 
                            "<tr>
                                <form action=\"\" method=\"post\">
                                    <td>$date</td>
                                    <td>$cardNumber</td>
                                    <td>$minus$amount</td>
                                    <td>$transactionType</td>
                                </form>
                            </tr>";
                        
                    }
                ?>
            </table>
      </div>
   </body>
</html>

