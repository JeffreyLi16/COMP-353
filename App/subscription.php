<?php
    include('Components/sessionClient.php');

    date_default_timezone_set('America/New_York');
    $date = date('Y-m-d', time());
    $clientCardNumber = $_SESSION['cardNumber'];

    $sql = "SELECT * FROM account WHERE CardNumber = '$clientCardNumber'";
    $getClientIDResult = mysqli_query($db,$sql);
    $getClientIDRow = mysqli_fetch_array($getClientIDResult,MYSQLI_ASSOC);

    // Get client account information
    $clientID = $getClientIDRow['ClientID'];
    $sql = "SELECT * FROM account WHERE ClientID = '$clientID'";
    $getAllAccountsResult = mysqli_query($db,$sql);
    $arrayAccounts = array();
    while($row = $getAllAccountsResult->fetch_assoc()) {
        $arrayAccounts[] = $row;
    }

    $len = count($arrayAccounts);


    // Get client's account from session
    $sql = "SELECT * FROM account WHERE CardNumber = '$clientCardNumber'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    $accountID = $row['AccountID'];

    // Get all bills from that specific account
    $sql = "SELECT * FROM billing WHERE AccountID = '$accountID' AND (billingType = 'Monthly') AND isCompleted = 0";
    $getAllBillsResult = mysqli_query($db,$sql);

   
    // $sql = "DELIMITER |

    // CREATE EVENT subscrptionTransaction
    // ON SCHEDULE
    //     EVERY 1 MINUTE
    //     STARTS '2018-11-27 17:31:00'
    // DO
    // BEGIN
    //     INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) 
    //     VALUES (20, DATE(NOW()), 2, 1, 'payment');
    // END |
    
    // DELIMITER;";

    // $result = mysqli_query($db,$sql);

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
    <div class=" text-center my-5">
            <span class="text-monospace" style="font-size: 24px;"> Payment Schedule </span>
            
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
                                                        class=\"form-control\"
                                                        type=\"date\" 
                                                        min=\"" . $date . "\"
                                                        name=\"selectedDate\"
                                                        required>
                                                </div>
                                                </div>
                                            </td>
                                            <td>
                                                <select name=\"accountID\" class=\"form-control\" required> 
                                                    <option></option>
                                                ");
                                                    
                                                    if (isset($getAllAccountsResult)) {
                                                        for($x = 0; $x < $len; $x++) {
                                                            $row = $arrayAccounts[$x];
                                                            echo("
                                                                <option value=\" " . $row['AccountID'] . " \">CardNumber: " . $row['CardNumber'] . "&emsp;Balance: " . $row['Balance'] . " </option>
                                                            ");
                                                        }
                                                    }
                                                echo("</select>
                                            </td>                                        
                                            <td> 
                                                <input type=\"hidden\" name=\"billID\" value=\"".$myBill['billingID']."\">
                                                <button type=\"submit\" class=\"btn btn-outline-info\"> <small>Update Date</small> </button>
                                            </td>
                                        </form>
                                        <td>
                                            <form action=\"removeSubscription.php\" method=\"POST\">
                                                <input type=\"hidden\" name=\"billID\" value=\" " . $myBill['billingID'] . " \">
                                                <button type=\"submit\" class=\"btn btn-outline-info\"><small>Remove Schedule</small></button>
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