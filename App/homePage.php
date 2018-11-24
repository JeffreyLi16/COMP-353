<?php   
    session_start();
    if(!isset($_SESSION['cardNumber'])){
        header("location:login.php");
    }

    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
    echo($card);
?>
