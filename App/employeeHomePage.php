<?php   
    include("config.local.php");
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }
    if(isset($_SESSION['viewEmployeeID'])){
      unset($_SESSION['viewEmployeeID']);
  }

    if (isset($_SESSION['cardNumber']))
    {
        unset($_SESSION['cardNumber']);
    }

    $ID = $_SESSION["employeeID"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];

    // for telephone banking, employee enters the client's card number
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if($_POST['submit'] == 'viewClient'){
        $clientCardNumber = $_POST['clientCardNumber'];

        $sql = "SELECT * FROM Account WHERE(CardNumber = '$clientCardNumber')";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $validCardNumber = $row['CardNumber'];
        if($clientCardNumber === $validCardNumber){
          $_SESSION["cardNumber"] = $clientCardNumber;
          $_SESSION['clientID'] = $row['ClientID'];
          header("location: userInfo.php");
        }
        else{
          echo '<script type="text/javascript">alert("The card number is invalid. Please try again.")</script>';
        }
      }
      else if($_POST['submit'] == 'viewEmployee'){
        $viewEmployeeID = $_POST['viewEmployeeID'];

        $sql = "SELECT * FROM Employee WHERE(EmployeeID = '$viewEmployeeID')";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $validEmployeeID = $row['EmployeeID'];
        if($viewEmployeeID === $validEmployeeID){
          $_SESSION["viewEmployeeID"] = $viewEmployeeID;
          header("location: employeeSetting.php");
        }
        else{
          echo '<script type="text/javascript">alert("The employee ID is invalid. Please try again.")</script>';
        }
      }
    }

    $title = $_SESSION['title'];
    $address = $_SESSION['address'];
    $startDate = $_SESSION['startDate'];
    $salary = $_SESSION['salary'];
    $email = $_SESSION['email'];
    $phoneNumber = $_SESSION['phoneNumber'];
    $branchID = $_SESSION['branchID'];
?>

<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">    
    <link rel="stylesheet" href="css/employee.css">
  </head>
   
  <body>
    <?php
        include('Components/navbar.php');
    ?>
    <h2><center>Hello <?php echo $firstName . " " . $lastName;?></center></h2>
    <div id="main-wrapper">

      <form action = "" method = "post">
        <label>ENTER CLIENT CARD NUMBER: </label>
        <input class="form-control" type="number" name="clientCardNumber" style="width: 250px; margin-bottom: 10px;" required/>
        <button class="btn btn-info submit_btn" name="submit" type="submit" value="viewClient">Submit</button>
      </form>
      <?php 
      if($title == "President" || $title == "General Manager" || $title == "Branch Manager"){
      echo 
      "<form action = \"\" method = \"post\">
        <label>ENTER EMPLOYEE ID: </label>
        <input class=\"form-control\" type=\"number\" name=\"viewEmployeeID\" style=\"width: 250px; margin-bottom: 10px;\" required/>
        <button class=\"btn btn-info submit_btn\" name=\"submit\" type=\"submit\" value=\"viewEmployee\">Submit</button>
      </form>";
      }
      ?>
    </div>
    <br>
      
    <!-- <div id="main-wrapper">
      <div>
       <?php 
          echo "<b>Employee Information</b></br>
                ID: " . $ID . "</br>
                Title : " . $title . "</br> 
                First name : " . $firstName . "</br>
                Last Name : " . $lastName . "</br>
                Address : " . $address . "</br>
                Start Date : " . $startDate . "</br>
                Salary : " . $salary . "</br>
                Email : " . $email . "</br>
                Phone number : " . $phoneNumber . "</br>
                Branch ID : " . $branchID . "</br>"
        ?>
      </div>
    </div> -->

  </body>
</html>