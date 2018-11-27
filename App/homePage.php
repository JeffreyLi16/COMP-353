<?php   
    include('session.php');
    $clientID = $_SESSION["ClientID"];
    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
    $birthDate = $_SESSION['birthDate'];
    $joinDate = $_SESSION['joinDate'];
    $address = $_SESSION['address'];
    $email = $_SESSION['email'];
    $phoneNumber = $_SESSION['phoneNumber'];
    $lasTransDate = $_SESSION['lastTransDate'];
    
    $sql = "SELECT * FROM Transaction, Account WHERE (AccountID IN  (SELECT AccountID FROM Account WHERE Account.ClientID = '$clientID')) AND (AccountID = ToAccountID OR AccountID = FromAccountID) ORDER BY Date DESC;";
      $result = mysqli_query($db, $sql);
      
      while($row = mysqli_fetch_assoc($result)){
          $rows[] = $row;
      }
      

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
          <li><a href="userInfo.php"><span class="glyphicon glyphicon-edit"></span> Account</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
    </div>
   
  </nav>
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

<table border = 1px>
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

