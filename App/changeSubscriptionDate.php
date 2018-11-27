<?php 
    include('Components/sessionClient.php');

    $selectedDate = $_POST['selectedDate'];
    $billID = $_POST['billID'];
   
    // Get a bill subscription 
    $sql = "UPDATE billing SET automaticTransferDate = '$selectedDate' WHERE billingID='$billID'";
    $result = mysqli_query($db,$sql);

    $accountID = $_POST['accountID'];

    

    // Get the bill balance
    $sql = "SELECT * FROM billing WHERE billingID = '$billID'";
    $myBillResult = mysqli_query($db,$sql);
    $myBillRow = mysqli_fetch_array($myBillResult,MYSQLI_ASSOC);
    $billBalance = $myBillRow['balance'];

    // Get account balance 
    $sql = "SELECT * FROM account WHERE AccountID = '$accountID'";
    $myAccountResult = mysqli_query($db,$sql);
    $myAccountRow = mysqli_fetch_array($myAccountResult,MYSQLI_ASSOC);
    $accountBalance = $myAccountRow['Balance'];

    $newAccountBalance = $accountBalance - $billBalance;

    $sql = "DELIMITER |
    CREATE EVENT SUBSCRIPTIONTRANSACTION
    ON SCHEDULE
        EVERY 1 MINUTE
        STARTS '2018-11-27 17:46:00'
    DO
    BEGIN
        INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) 
        VALUES ('$billBalance', DATE(NOW()), NULL , '$accountID', 'payment');
    END |
    
    DELIMITER ;";

    $result = mysqli_query($db,$sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
    
    // header("location:subscription.php");
    
?>