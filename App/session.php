<?php
   include('config.php');
   session_start();
   
   if(!isset($_SESSION['clientID'])){
      header("location:login.php");
   }
?>