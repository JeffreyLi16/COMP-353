<?php 
    include('session.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $fromAccountID = $_POST['fromAccount'];
        $toAccountID = $_POST['toAccount'];
        $amount = $_POST['transferAmount'];

        
        if ($amount > 0) {
            // Get both accounts' balance
            $sql = "SELECT * FROM account WHERE AccountID='$fromAccountID'";
            $fromAccountResult = mysqli_query($db,$sql);
            $fromAccountRow = mysqli_fetch_array($fromAccountResult,MYSQLI_ASSOC);

            $fromAccountBalance = $fromAccountRow['Balance'];

            $sql = "SELECT * FROM account WHERE AccountID='$toAccountID'";
            $toAccountResult = mysqli_query($db,$sql);
            $toAccountRow = mysqli_fetch_array($toAccountResult,MYSQLI_ASSOC);

            $toAccountBalance = $toAccountRow['Balance'];

            $fromAccountNewBalance = $fromAccountBalance - $amount;
            $toAccountNewBalance = $toAccountBalance + $amount;

            if ($fromAccountNewBalance >= 0) {
                $sql = "UPDATE account SET Balance = '$fromAccountNewBalance' WHERE AccountID = '$fromAccountID'";
                $fromAccountNewResult = mysqli_query($db,$sql);

                $sql = "UPDATE account SET Balance = '$toAccountNewBalance' WHERE AccountID = '$toAccountID'";
                $toAccountNewResult = mysqli_query($db,$sql);

                $sql = "INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) VALUES ('$amount', DATE(NOW()), '$toAccountID', '$fromAccountID', 'transfer')";
                $result = mysqli_query($db,$sql);

                $successMsg = "The fund has been transfered.";

            } {
                $failMsg = "You don't have enough funds! "; 
            }
        } else {
            $failMsg = "Unable to proceed with the transfer. Please contact any employee."; 
        }

    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Billing and Transactions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="homePage.php">Bank of Concordia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
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
    <div class="container">
        <!-- Print success message -->
            <?php if(isset($successMsg)) {  
                echo("
                    <div class=\"alert alert-success text-center mt-4\" role=\"alert\">
                    <span> " . $successMsg . " </span>
                    </div>
                ");
                }
                if(isset($failMsg)) {  
                    echo("
                        <div class=\"alert alert-warning text-center mt-4\" role=\"alert\">
                            <span> " . $failMsg . " </span>
                        </div>
                    ");
                    }
            ?>
    
    </div>
</body>

</html>