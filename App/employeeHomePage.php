<?php   
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    $ID = $_SESSION["employeeID"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];

    // for telephone banking, employee enters the client's card number
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $clientCardNumber = $_POST['clientCardNumber'];
      $_SESSION["cardNumber"] = $clientCardNumber;
      header("location: userInfo.php");
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
</head>
   <body>
   <nav class="navbar navbar-inverse">
    <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Bank Of Concordia</a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="employeeSetting.php"><span class="glyphicon glyphicon-edit"></span> Account</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
      <div id="main-wrapper"><h2><center>Hello <?php echo $firstName . $lastName;?></center></h2>

      <form action = "" method = "post">
        <label>ENTER CLIENT CARD NUMBER: </label>
        <input class="form-control" type="number" name="clientCardNumber" style="width: 250px; margin-bottom: 10px;" required/>
        <button class="btn btn-info submit_btn" name="submit" type="submit">Submit</button>
      </form>

      <div><a href="openClientAccount.php">Create client account</a></div>
      
      <div id="main-wrapper">
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


      </div>
   </body>
</html>