<?php 
    include('Components/sessionClient.php');

    $selectedDate = $_POST['selectedDate'];
    $billID = $_POST['billID'];
   
    // Get a bill subscription 
    $sql = "UPDATE billing SET automaticTransferDate = '$selectedDate' WHERE billingID='$billID'";
    $result = mysqli_query($db,$sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
    
    header("location:subscription.php");
    
?>