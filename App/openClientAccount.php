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
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">   
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

    <div class="container">
    <form action="" method="post">
      <div class="form-group">
        <label>Select New Account Type:</label>
          <select name="accountType" class="form-control">
            <option value="Checking">Checking</option>
            <option value="Savings">Savings</option>
          </select>
      </div>
        <div class="form-group">
          <label>ClientID</label>
          <input type="text" class="form-control" name="clientID">
        </div>
            <button type="submit" class="btn btn-secondary">Submit</button>
    </form>
    </div>


      
   </body>
</html>