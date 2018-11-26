<?php
   include('config.local.php');
   session_start();
   
   if(!isset($_SESSION['employeeID'])){
      header("location:employeeLogin.php");
   }
?>