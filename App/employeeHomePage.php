<?php   
    include("config.local.php");
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }
    if(isset($_SESSION['viewEmployeeID'])){
      unset($_SESSION['viewEmployeeID']);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/employee.css">
  </head>
   
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand">Bank Of Concordia</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="employeeSetting.php"><span class="glyphicon glyphicon-edit"></span> Account</a></li>
          <li><a href="myschedule.php"><span class="glyphicon glyphicon-calendar"></span> My Schedule</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </nav>
    <h2><center>Hello <?php echo $firstName . $lastName;?></center></h2>
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