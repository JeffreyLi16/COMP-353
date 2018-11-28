<?php   
    include("sessionEmployee.php");
    if(isset($_SESSION['viewEmployeeID'])){
      unset($_SESSION['viewEmployeeID']);
  }

    // Unset the client's cardnumber session when the employee goes to employee home page
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
    <link rel="stylesheet" href="employee.css">
  </head>
   
  <body>
    <?php
        include('navbar.php');
    ?>
    <div class="container">
      <div class="my-5 w-50" style="margin: auto">
        <h2 class="text-monospace text-center">Hello <?php echo $firstName . " " . $lastName;?></h2>
        <hr>
      </div>

      <div class="card w-50 p-3" style="margin: auto">
        <div class="card-body">
          <form action = "" method = "post">
            <div class="form-row pb-3">
              <label class="text-info">ENTER CLIENT CARD NUMBER: </label>
              <div class="input-group col-md-12">
                <input class="form-control" type="number" name="clientCardNumber" required/> 
                <div class="input-group-append">
                <button class="btn btn-info float-right" name="submit" type="submit" value="viewClient">Submit</button>
              </div>
              </div>
            </div>
          </form>
          <?php 
          if($title == "President" || $title == "General Manager" || $title == "Branch Manager"){
          echo 
          "<form action = \"\" method = \"post\">
            <div class=\"form-row\">
              <label class=\"text-info\">ENTER EMPLOYEE ID: </label>
              <div class=\"input-group col-md-12\"><input class=\"form-control\" type=\"number\" name=\"viewEmployeeID\" required/>
                <div class=\"input-group-append\"><button class=\"btn btn-info float-right\" name=\"submit\" type=\"submit\" value=\"viewEmployee\">Submit</button></div>
              </div>
            </div>
          </form>";
          }
          ?>
        </div>
      </div>
      <br>
    </div>
      
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