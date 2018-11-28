<?php 
    include('sessionClient.php');

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

        $sql = "SELECT * FROM account WHERE AccountID = '$accountID'";
        $getAccountResult = mysqli_query($db,$sql);
        $getAccount = mysqli_fetch_array($getAccountResult,MYSQLI_ASSOC);

        $myBillBalance = $myBill['balance'];
        $remainingBalance = $myBillBalance - $myBill['paymentAmount'];

        
        if($transactionAmount >= $remainingBalance){
            
            $updatedBalance = $getAccount['Balance'] - $remainingBalance;

            if ($updatedBalance >= 0) {
                $sql = "UPDATE account SET Balance='$updatedBalance' WHERE AccountID='$accountID'";
                $result = mysqli_query($db,$sql);
                
                $sql = "UPDATE billing SET paymentAmount='$myBillBalance', isCompleted = 1 WHERE billingID='$billID'";
                $result = mysqli_query($db,$sql);
        
                $sql = "INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) VALUES ('$remainingBalance', DATE(NOW()), NULL, '$accountID', 'payment')";
                $result = mysqli_query($db,$sql);
                
                $msg = "Successful transaction! The bill has been completed.";
            } else {
                $msg = "You don't have enough funds !";
            }

        } elseif ($transactionAmount > 0) {

            $updatedBalance = $getAccount['Balance'] - $transactionAmount;
            if ($updatedBalance >= 0 ) {
                $sql = "UPDATE account SET Balance='$updatedBalance' WHERE AccountID='$accountID'";
                $result = mysqli_query($db,$sql);


                $totalAmountPaid = $myBill['paymentAmount'] + $transactionAmount;
                $remainingBalance = $myBill['balance'] - $totalAmountPaid;
                $sql = "UPDATE billing SET paymentAmount='$totalAmountPaid' WHERE billingID='$billID'";
                $result = mysqli_query($db,$sql);
        
                $sql = "INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) VALUES ('$transactionAmount', DATE(NOW()), NULL, '$accountID', 'payment')";
                $result = mysqli_query($db,$sql);

                $msg = "Successful transaction! You still have " . $remainingBalance . " $ left to pay."; 
            } else {
                $msg = "You don't have enough funds !";
            }
        
        } else {
            $msg = "Unable to proceed with the transaction. Please contact any employee."; 
        }
    }
?>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
</head>

<body>
    <?php
        include('navbar.php');
    ?>

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