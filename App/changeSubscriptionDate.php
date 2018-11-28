<?php 
    include('sessionClient.php');

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
    $getBillID = trim($billID," ");
    $transactionID = "Bill$getBillID";

    $sql = "DROP EVENT IF EXISTS $transactionID";
    $result = mysqli_query($db,$sql);

    $sql = " CREATE EVENT $transactionID
    ON SCHEDULE AT '$selectedDate 19:45:00'

    DO
    BEGIN
        DECLARE myBalance double;
        SELECT Balance INTO myBalance FROM account WHERE AccountID = '$accountID';
        IF myBalance >= $billBalance THEN
            INSERT INTO transaction (Amount, DATE, ToAccountID, FromAccountID, TransactionType) 
            VALUES ('$billBalance', DATE(NOW()), NULL , '$accountID', 'payment');

            UPDATE billing SET paymentAmount='$billBalance', isCompleted = 1 WHERE billingID='$billID';

            UPDATE account SET Balance='$newAccountBalance' WHERE AccountID='$accountID';
        END IF;
    END; ";

    $result = mysqli_query($db,$sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
    
    header("location:subscription.php");
    
?>