<?php
   include('config.php');
   session_start();
   
   if(!isset($_SESSION['employeeID'])){
      header("location:employeeLogin.php");
   }
?>