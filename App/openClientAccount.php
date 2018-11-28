<?php
  include('sessionEmployee.php');

  $employeeID = $_SESSION["employeeID"];
  $firstName = $_SESSION['FirstName'];
  $lastName = $_SESSION['LastName'];
  $employeeBranchID = $_SESSION['branchID'];

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cardNumber = $_SESSION['cardNumber'];

    $sql = "SELECT * FROM client, account WHERE account.CardNumber = '$cardNumber'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $clientID = $row['ClientID'];

    $cardNumber = $_POST['cardNumber'];
    $accountType = $_POST['accountType'];
    $accountOption = $_POST['accountOption'];
    $accountLevel = $_POST['accountLevel'];
    $serviceType = $_POST['serviceType'];

    // Get ServiceID from client
    $sql = "SELECT ServiceID FROM Service WHERE ServiceType = '$serviceType'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $serviceID = $row['ServiceID'];

    // Get all accounts from the clients
    if ($accountType = "Credit") {
      $sql = "SELECT * FROM Account WHERE ClientID = '$clientID'";
      $getAllAccountsResult = mysqli_query($db,$sql);
      $arrayAccounts = array();
      $count = 0;

      if (isset($getAllAccountsResult)) {
        while($row = $getAllAccountsResult->fetch_assoc()) {
          $fromAccountID = $row['AccountID'];
          $sql = "SELECT * FROM transaction WHERE (fromAccountID = '$fromAccountID' AND (Date between now() - Interval 6 Month and now()));";
          $getAllTransactions = mysqli_query($db,$sql);

          if(isset($getAllTransactions)){
            while($row2 = $getAllTransactions->fetch_assoc()){
                $count++;
            }
          }

        }
      }
      
      if ($count >= 3) {
        $sql = "INSERT INTO Account (CardNumber, AccountType, AccountOption, AccountLevel, Balance, BranchID, ClientID, ServiceID)
        VALUES ('$cardNumber', '$accountType', '$accountOption', '$accountLevel', 0.00 , '$employeeBranchID', '$clientID', '$serviceID')";
        $newAccountResult = mysqli_query($db,$sql);
        
        if (!$newAccountResult) {
          $alertMessageChanged = "Error: Card Number already exists.";
          $url = "openClientAccount.php";
          myAlert($alertMessageChanged, $url);
        } else {
          // Get newly created account information
          $sql = "SELECT * FROM Account WHERE CardNumber = '$cardNumber'";
          $result = mysqli_query($db,$sql);
          $clientAccountInfo = mysqli_fetch_array($result,MYSQLI_ASSOC);
          
        }
      } else {
          $alertMessageChanged = "Error: Unsatisfactory amount of transactions in the last 6 months.";
          $url = "openClientAccount.php";
          myAlert($alertMessageChanged, $url);
      }
    } else {
      $sql = "INSERT INTO Account (CardNumber, AccountType, AccountOption, AccountLevel, Balance, BranchID, ClientID, ServiceID)
        VALUES ('$cardNumber', '$accountType', '$accountOption', '$accountLevel', 0.00 , '$employeeBranchID', '$clientID', '$serviceID')";
        $newAccountResult = mysqli_query($db,$sql);
        
        if (!$newAccountResult) {
          $alertMessageChanged = "Error: Card Number already exists.";
          $url = "openClientAccount.php";
          myAlert($alertMessageChanged, $url);
        } else {
          // Get newly created account information
          $sql = "SELECT * FROM Account WHERE CardNumber = '$cardNumber'";
          $result = mysqli_query($db,$sql);
          $clientAccountInfo = mysqli_fetch_array($result,MYSQLI_ASSOC);
          
        }
    }
  }
  function myAlert($alertMessageChanged, $url){
    echo '<script type="text/javascript">alert("'. $alertMessageChanged .'")</script>';
    echo "<script>document.location = '$url'</script>";
}
?>
<html>

<head>
  <link rel="stylesheet" href="openClientAccount.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
</head>

<body>
  <?php
        include('navbar.php');
    ?>

  <div class="container" id="open-client-account">
 
    <!-- Print success message -->
    <?php if(isset($clientAccountInfo)) {  
      echo("
        <div class=\"alert alert-success my-5 text-center\" role=\"alert\">
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
            <div class="form-group col-md-12">
              <label>Card Number</label>
              <input type="text" class="form-control" name="cardNumber">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Select New Account Level:</label>
              <select name="accountLevel" class="form-control">
                <option></option>
                <option value="personal">Personal</option>
                <option value="business">Business</option>
                <option value="corporate">Corporate</option>
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
                <option value="student">Student</option>
                <option value="no fee">No Fee</option>
                <option value="high-savings">High Saving</option>
                <option value="car">Car</option>
                <option value="home">Home</option>
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

          <div class="pull-right"><button type="submit" class="btn btn-info btn-new-account">Submit</button>
          <a href="userInfo.php"><button type="button" class="btn btn-danger back_btn">Cancel</button></a></div>
        </form>
      </div>
    </div>
  </div>



</body>

</html>