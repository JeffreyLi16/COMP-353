<?php
   include('config.local.php');
   session_start();
   
   if(!isset($_SESSION['clientID'])){
      header("location:login.php");
   }
?>