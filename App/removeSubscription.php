<?php 
    include('session.php');


    $billID = $_POST['billID'];
   
    // Get a bill subscription 
    $sql = "UPDATE billing SET billingType = 'Single' WHERE billingID='$billID'";
    $result = mysqli_query($db,$sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }
    
    header("location:viewBills.php");
    
?>