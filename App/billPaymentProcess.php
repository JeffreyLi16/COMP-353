<?php 
    include('session.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $accountID = $_POST['accountID'];
        $billID = $_POST['billID'];

        // amount to be paid
        $transactionAmount = $_POST['transactionAmount'];

        $sql = "SELECT * FROM billing WHERE billingID = '$billID'";
        $getAllBillsResult = mysqli_query($db,$sql);


        if (!$getAllBillsResult) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        } else {
            $myBill = mysqli_fetch_array($getAllBillsResult,MYSQLI_ASSOC);
        }

        $sql = "SELECT * FROM account WHERE ID = '$accountID'";
        $getAccountResult = mysqli_query($db,$sql);
        $getAccount = mysqli_fetch_array($getAccountResult,MYSQLI_ASSOC);

        $myBillBalance = $myBill['balance'];
        $remainingBalance = $myBillBalance - $myBill['paymentAmount'];

        if($transactionAmount >= $remainingBalance){

            $sql = "UPDATE billing SET paymentAmount='$myBillBalance', isCompleted = 1 WHERE billingID='$billID'";
            $result = mysqli_query($db,$sql);
    
            $sql = "INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) VALUES ('$remainingBalance', DATE(NOW()), NULL, '$accountID', 'payment')";
            $result = mysqli_query($db,$sql);

            $updatedBalance = $getAccount['Balance'] - $remainingBalance;
            $sql = "UPDATE account SET Balance='$updatedBalance' WHERE ID='$accountID'";
            $result = mysqli_query($db,$sql);

            $msg = "Successful transaction! The bill has been completed.";

        } elseif ($transactionAmount > 0) {
            $totalAmountPaid = $myBill['paymentAmount'] + $transactionAmount;
            $remainingBalance = $myBill['balance'] - $totalAmountPaid;
            $sql = "UPDATE billing SET paymentAmount='$totalAmountPaid' WHERE billingID='$billID'";
            $result = mysqli_query($db,$sql);
    
            $sql = "INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) VALUES ('$transactionAmount', DATE(NOW()), NULL, '$accountID', 'payment')";
            $result = mysqli_query($db,$sql);

            $updatedBalance = $getAccount['Balance'] - $transactionAmount;
            $sql = "UPDATE account SET Balance='$updatedBalance' WHERE ID='$accountID'";
            $result = mysqli_query($db,$sql);

            $msg = "Successful transaction! You still have " . $remainingBalance . " $ left to pay."; 
        } else {
            $msg = "Unable to proceed with the transaction. Please contact any employee."; 
        }
    }
?>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Transaction Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
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

    <div class="container">
        <div class="card my-5">
            <div class="card-body text-center py-3">
                <?php 
                    echo $msg;
                ?>
            </div>
        </div>
    </div>
       
</body>

</html>