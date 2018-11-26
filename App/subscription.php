<?php
    include('session.php');

    date_default_timezone_set('America/New_York');
    $date = date('Y-m-d', time());
    $clientCardNumber = $_SESSION['cardNumber'];

    // Get client account information
    $clientID = $_SESSION['clientID'];
    $sql = "SELECT * FROM account WHERE clientID = '$clientID'";
    $getAllAccountsResult = mysqli_query($db,$sql);
    $arrayAccounts = array();
    while($row = $getAllAccountsResult->fetch_assoc()) {
        $arrayAccounts[] = $row;
    }

    $len = count($arrayAccounts);


    // Get client's account from session
    $sql = "SELECT * FROM account WHERE cardNumber = '$clientCardNumber'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    $accountID = $row['ID'];

    // Get all bills from that specific account
    $sql = "SELECT * FROM billing WHERE accountID = '$accountID' AND (billingType = 'Monthly')";
    $getAllBillsResult = mysqli_query($db,$sql);

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
    <div class=" text-center my-5">
            <span class="text-monospace" style="font-size: 24px;"> Subscription </span>
            
        </div>
        <hr>
        <table class="table table-hover text-center my-5 px-5">
            <thead>
                <tr>
                    <th scope="col"># Ref</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Total Payment Amount</th>
                    <th scope="col">Transaction Date</th>
                    <th scope="col">Select New Date</th>
                    <th scope="col">Select Card</th>
                    <th scope="col"></th>
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($getAllBillsResult)) {
                        while($myBill = $getAllBillsResult->fetch_assoc()) {
                            echo("
                                
                                    <tr>
                                        <th scope=\"row\">" . $myBill['billingID'] . "</th>
                                        <td>" .  $myBill['dueDate'] . "</td>
                                        <td>" .  $myBill['balance'] . "</td>
                                        <td>" . $myBill['paymentAmount'] . "</td>
                                        <td>" . $myBill['automaticTransferDate'] . "</td>
                                        <form action=\"changeSubscriptionDate.php\" method=\"POST\">
                                            <td>
                                                <div class=\"form-row\">
                                                <div class=\"form-group col-md-12 px-5\">
                                                    <input 
                                                        type=\"date\" 
                                                        min=\"" . $date . "\"
                                                        name=\"selectedDate\">
                                                </div>
                                                </div>
                                            </td>
                                            <td>
                                                <select name=\"accountID\" class=\"form-control\"> ");
                                                    if (isset($getAllAccountsResult)) {
                                                        for($x = 0; $x < $len; $x++) {
                                                            $row = $arrayAccounts[$x];
                                                            echo("
                                                                <option value=\" " . $row['ID'] . " \">CardNumber: " . $row['CardNumber'] . "&emsp;Balance: " . $row['Balance'] . " </option>
                                                            ");
                                                        }
                                                    }
                                                echo("</select>
                                            </td>                                        
                                            <td> 
                                                <input type=\"hidden\" name=\"billID\" value=\" " . $myBill['billingID'] . " \">
                                                <button type=\"submit\" class=\"btn btn-outline-info\"> Update Date </button>
                                            </td>
                                        </form>
                                        <td>
                                            <form action=\"removeSubscription.php\" method=\"POST\">
                                                <input type=\"hidden\" name=\"billID\" value=\" " . $myBill['billingID'] . " \">
                                                <button type=\"submit\" class=\"btn btn-outline-info\"> Remove Subscription </button>
                                            </form>
                                        </td>
                                        <!--
                                        <td>
                                            <input type=\"hidden\" name=\"billID\" value=\" " . $myBill['billingID'] . " \">
                                            <button type=\"submit\" class=\"btn btn-outline-info\"> Pay Now </button>
                                        </td>
                                        -->
                                    </tr>
                            ");
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>