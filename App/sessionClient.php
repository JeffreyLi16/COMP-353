<?php
   include('config.php');
   session_start();
   
   if(!isset($_SESSION['cardNumber'])){
      header("location:login.php");
   }
?>