<?php
    include("config.local.php");   
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    $employeeID = $_SESSION["employeeID"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
    $employeeBranchID = $_SESSION['branchID'];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $clientID = $_POST['clientID'];

      // Check if the client exists
      $sql = "SELECT * FROM Client WHERE Client.ClientID = '$clientID'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);

    if ($count == 0){
      echo("Client doesn't exist");
      header("location: openClientAccount.php");
    } else {
      $cardNumber = $_POST['accountNumber'];
      $accountType = $_POST['accountType'];
      $accountOption = $_POST['accountOption'];
      $accountLevel = $_POST['accountLevel'];
      $serviceType = $_POST['serviceType'];

      // Get ServiceID from client
      $sql = "SELECT ID FROM Service WHERE ServiceType = '$serviceType'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $serviceID = $row['ID'];

      $sql = "INSERT INTO account (CardNumber, AccountType, AccountOption, AccountLevel, Balance, BranchID, ClientID, ServiceID)
      VALUES ('$cardNumber', '$accountType', '$accountOption', '$accountLevel', 0.00 , '$employeeBranchID', '$clientID', '$serviceID')";
      $newAccountResult = mysqli_query($db,$sql);
      
      if (!$newAccountResult) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
      } else {
        // Get newly created account information
        $sql = "SELECT * FROM account WHERE CardNumber = '$cardNumber'";
        $result = mysqli_query($db,$sql);
        $clientAccountInfo = mysqli_fetch_array($result,MYSQLI_ASSOC);
        
      }
    }
  }

    

?>
<html>

<head>
  <link rel="stylesheet" href="css/openClientAccount.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">WebSiteName</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="employeeLogin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="container" id="open-client-account">
 
    <!-- Print success message -->
    <?php if(isset($clientAccountInfo)) {  
      echo("
        <div class=\"alert alert-success\" role=\"alert\">
          <p> Account with CardNumber " . $clientAccountInfo['CardNumber'] . " has been created !</p>
        </div>
      ");
    }
    ?>
    
    <div class="title"> Create New Account</div>
    <div class="panel panel-default">
      <div class="panel-body new-account-form">
        <form action="" method="post">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>ClientID</label>
              <input type="text" class="form-control" name="clientID">
            </div>
            <div class="form-group col-md-6">
              <label>AccountNumber</label>
              <input type="text" class="form-control" name="accountNumber">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Select New Account Level:</label>
              <select name="accountLevel" class="form-control">
                <option></option>
                <option value="Personal">Personal</option>
                <option value="Business">Business</option>
                <option value="Corporate">Corporate</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Select Account Type:</label>
              <select name="accountType" class="form-control">
                <option></option>
                <option value="Checking">Checking</option>
                <option value="Credit">Credit</option>
                <option value="Savings">Savings</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Select Account Option:</label>
              <select name="accountOption" class="form-control">
                <option></option>
                <option value="Student">Student</option>
                <option value="No Fee">No Fee</option>
                <option value="High Saving">High Saving</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
                <label>Select Service Type:</label>
                <select name="serviceType" class="form-control">
                  <option></option>
                  <option value="Banking">Banking</option>
                  <option value="Insurance">Insurance</option>
                  <option value="Investment">Investment</option>
                  <option value="Mortgage">Mortgage</option>
                </select>
              </div>
          </div>

          <div class="pull-right"><button type="submit" class="btn btn-info btn-new-account">Submit</button></div>
        </form>
      </div>
    </div>
  </div>



</body>

</html>