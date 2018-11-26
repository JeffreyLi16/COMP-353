<?php 
    include('session.php');

    $selectedDate = $_POST['selectedDate'];
    $billID = $_POST['billID'];
   
    // Get a bill subscription 
    $sql = "UPDATE billing SET automaticTransferDate = '$selectedDate' WHERE id='$billID'";
    $result = mysqli_query($db,$sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      }
    
    header("location:subscription.php");
    
?>