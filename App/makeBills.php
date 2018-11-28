<?php
    include('sessionEmployee.php');

    date_default_timezone_set('America/New_York');
    $date = date('Y-m-d', time());

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $cardNumber = $_POST['cardNumber'];
        $billBalance = $_POST['billBalance'];
        $selectedDate = $_POST['selectedDate'];

        // Get Account ID
        $sql = "SELECT * FROM Account WHERE CardNumber = '$cardNumber'";
        $getAccountResult = mysqli_query($db,$sql);
        $getAccountRow = mysqli_fetch_array($getAccountResult,MYSQLI_ASSOC);
        $count = mysqli_num_rows($getAccountResult);

        if ($count == 1 ) {

            $accountID = $getAccountRow['AccountID'];

            // Create Bill
            $sql = "INSERT INTO billing (billingType, accountID, balance, paymentAmount, dueDate, automaticTransferDate, isCompleted)
                VALUES ('Single', '$accountID', $billBalance, 0, '$selectedDate', NULL, 0)";
            $makeBillResult = mysqli_query($db,$sql);

            $successMsg = "The bill has been created for the card holder of $cardNumber.";
        } else {
            $failMsg = "The provided card number doesn't exist.";
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
        include('navbar.php');
    ?>

   
    <div class="container">
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
        <div class="card my-5">
            <div class="card-body px-5">
                <div class="text-center"><span class="text-monospace text-center mb-3" style="font-size: 24px;"> Create a Bill </span></div>
                <hr>
                <form action='makeBills.php' method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="text-info">Enter Card Number: </label>
                            <input type="text" class="form-control" name="cardNumber" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="text-info">Bill Amount: </label>
                            <input type="text" class="form-control" name="billBalance" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-info">Due Date: </label>
                            <input required
                                class="form-control"
                                type="date" 
                                min="<?php echo $date ?>"
                                name="selectedDate">
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-outline-info float-right my-4"> Create </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>