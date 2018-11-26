<?php
    include('session.php');

    // Query the client's account
    $clientID = $_SESSION['clientID'];
    $sql = "SELECT * FROM account WHERE ClientID = '$clientID'";
    $getFromAccountsResult = mysqli_query($db,$sql);

    $sql = "SELECT * FROM account WHERE ClientID = '$clientID'";
    $getToAccountsResult = mysqli_query($db,$sql);
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
       <div class="card my-5">
            <div class="card-body">
                <div class="text-center"><span class="text-monospace" style="font-size: 24px;"> Transfer Funds </span></div>
                <hr>
                <form action="transferFunds.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="text-info">From Account: </label>
                            <select name="fromAccount" class="form-control">
                            <?php
                                if (isset($getFromAccountsResult)) {
                                    while($fromAccount = $getFromAccountsResult->fetch_assoc()) {
                                        echo("
                                            <option value=\" " . $fromAccount['AccountID'] . " \">CardNumber: " . $fromAccount['CardNumber'] . "&emsp;Balance: " . $fromAccount['Balance'] . " </option>
                                        ");
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="text-info">To Account: </label>
                            <select name="toAccount" class="form-control">
                            <?php
                                if (isset($getToAccountsResult)) {
                                    while($toAccount = $getToAccountsResult->fetch_assoc()) {
                                        echo("
                                            <option value=\" " . $toAccount['AccountID'] . " \">CardNumber: " . $toAccount['CardNumber'] . "&emsp;Balance: " . $toAccount['Balance'] . " </option>
                                        ");
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="text-info">Amount: </label>
                            <input type="text" class="form-control" name="transferAmount">
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-outline-info float-right my-4"> Transfer Funds </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-center"><span class="text-monospace text-center" style="font-size: 24px;"> eTransfer </span></div>
                <hr>
                <form action='eTransfer.php' method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="text-info">Pay via </label>
                            <select name="transferType" class="form-control">
                                <option value="Email">Email</option>
                                <option value="PhoneNumber">Phone Number</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                        <label class="text-info">Input: </label>
                            <input type="text" class="form-control" name="inputValue">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="hidden" name="accountID" value="">
                            <button class="btn btn-outline-info float-right my-4"> eTransfer </button>
                        </div>
                    </div>               
                </form>
            </div>
       </div>
    </div>
</body>

</html>