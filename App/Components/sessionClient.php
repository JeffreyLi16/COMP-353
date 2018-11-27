<?php
   include('config.local.php');
   session_start();
   
   if(!isset($_SESSION['cardNumber'])){
      header("location:login.php");
   }
?>