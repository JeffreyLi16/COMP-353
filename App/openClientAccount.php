<?php   
    session_start();
    if(!isset($_SESSION['employeeID'])){
        header("location:employeeLogin.php");
    }

    $ID = $_SESSION["employeeID"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $clientID = $_POST['clientID'];

      $sql = "SELECT * FROM Client, Account WHERE Client.ClientID = '$clientID'";
      
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
    <div class="title"> Create New Account</div>
    <div class="panel panel-default">
      <div class="panel-body new-account-form">
        <form action="" method="post">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>ClientID</label>
              <input type="text" class="form-control" name="clientID">
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
              <select name="account-option" class="form-control">
                <option></option>
                <option value="Student">Student</option>
                <option value="No Fee">No Fee</option>
                <option value="High Saving">High Saving</option>
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