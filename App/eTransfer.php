<?php 
    include('Components/sessionClient.php');
    
    // Query the client's account
    $clientID = $_SESSION['clientID'];
    $sql = "SELECT * FROM account WHERE ClientID = '$clientID'";
    $getFromAccountsResult = mysqli_query($db,$sql);    
    

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $inputValue = $_POST['inputValue'];
        $getTransferType = $_POST['transferType'];
      

        if (!$inputValue == NULL) {
            if ($getTransferType == 'Email') {
                $sql = "SELECT * FROM client WHERE Email = '$inputValue'";
                $getToClientResult = mysqli_query($db,$sql);    
                $getToClientRow = mysqli_fetch_array($getToClientResult,MYSQLI_ASSOC);

                // Check if the email exists
                $count = mysqli_num_rows($getToClientResult);
                if ($count == 1 ) {
                    $toClientID = $getToClientRow['ClientID'];
                    $sql = "SELECT * FROM account WHERE ClientID = '$toClientID'";
                    $getToAccountsResult = mysqli_query($db,$sql);   
                } else {
                    $alertMessageChanged = "Error: The email is invalid.";
                    $url = "viewTransfer.php";
                    myAlert($alertMessageChanged, $url);
                }

            } elseif ($getTransferType == 'PhoneNumber') {
                $sql = "SELECT * FROM client WHERE PhoneNumber = '$inputValue'";
                $getToClientResult = mysqli_query($db,$sql);    
                $getToClientRow = mysqli_fetch_array($getToClientResult,MYSQLI_ASSOC);

                // Check if the phone number exists
                $count = mysqli_num_rows($getToClientResult);
                if ($count == 1 ) {
                    $toClientID = $getToClientRow['ClientID'];
                    $sql = "SELECT * FROM account WHERE ClientID = '$toClientID'";
                    $getToAccountsResult = mysqli_query($db,$sql);    
                } else { 
                    $alertMessageChanged = "Error: The phone number is invalid.";
                    $url = "viewTransfer.php";
                    myAlert($alertMessageChanged, $url);
                }
            }

        }
    }

    function myAlert($alertMessageChanged, $url){
        echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
        echo "<script>document.location = '$url'</script>";
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

        <div class="card my-5">
            <div class="card-body">
                <div class="text-center"><span class="text-monospace text-center" style="font-size: 24px;"> eTransfer </span></div>
                <hr>
                <form action='eTransferProcess.php' method="POST">
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
                                            <option value=\" " . $toAccount['AccountID'] . " \">CardNumber: " . $toAccount['CardNumber'] . "&emsp; </option>
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
    </div>
</body>

</html>