<?php
    include('Components/sessionClient.php');
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $billingType = $_POST['billingType'];
        $billID = $_POST['billID'];
        if ($billingType == 'Single') {
            // Get all bills from that specific account
            $sql = "SELECT * FROM billing WHERE billingID = '$billID'";
            $getAllBillsResult = mysqli_query($db,$sql);
            $myBill = mysqli_fetch_array($getAllBillsResult,MYSQLI_ASSOC);

            // Query the client's account
            $clientID = $_SESSION['clientID'];
            $sql = "SELECT * FROM account WHERE ClientID = '$clientID'";
            $getAllAccountsResult = mysqli_query($db,$sql);
        } elseif ($billingType == 'Monthly') {
            $sql = "UPDATE billing SET billingType = 'Monthly' WHERE billingID = '$billID'";
            $result = mysqli_query($db,$sql);

            header("location:subscription.php");
        }
    }
?>

<!DOCTYPE html>
<html>

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
        include('Components/navbar.php');
    ?>
    <div class="container">
       <form action="billPaymentProcess.php" method="POST">
            <div class="card my-5">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <span class="text-info">Balance: </span>
                            <span ><?php echo($myBill['balance']); ?></span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-info">Total amount paid: </span>
                            <span><?php echo($myBill['paymentAmount']); ?></span>
                        </div>
                    </div>
                    <hr>
                    <!-- Add accountType -->
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Select Account</label>
                            <select name="accountID" class="form-control">
                            <?php
                                if (isset($getAllAccountsResult)) {
                                    while($row = $getAllAccountsResult->fetch_assoc()) {
                                        echo("
                                            <option value=\" " . $row['AccountID'] . " \">CardNumber: " . $row['CardNumber'] . "&emsp;Balance: " . $row['Balance'] . " </option>
                                        ");
                                    }
                                }
                            ?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <label>Select Amount</label>
                            <input type="text" class="form-control" name="transactionAmount" value="">
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="billID" value= " <?php echo($myBill['billingID']); ?> " >
                    <button type="submit" class="btn btn-outline-info float-right m-4"> Pay Now </button>
                </div>
            </div>
       </form>
    </div>
</body>

</html>