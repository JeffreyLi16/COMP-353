<?php   
    include("config.local.php");
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

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Bank of Concordia</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="employeeHomePage.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="openClientAccount.php">Open Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="myschedule.php">My Schedule</a>
        </li>
      </ul>
      <div class="navbar-nav ml-4">
        <a class="nav-item nav-link" href="employeeSetting.php"> Account </a>
        <a class="nav-item nav-link" href="logout.php"> Logout </a>
      </div>
    </div>
  </nav>
  <div id="main-wrapper">
    <h2>
      <center>Hello
        <?php echo $firstName . $lastName;?>
      </center>
    </h2>

    <form action="" method="post">
      <label>ENTER CLIENT CARD NUMBER: </label>
      <input class="form-control" type="number" name="clientCardNumber" style="width: 250px; margin-bottom: 10px;"
        required />
      <button class="btn btn-info submit_btn" name="submit" type="submit">Submit</button>
    </form>

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