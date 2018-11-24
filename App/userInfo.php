<?php   
    include('session.php');
    $card = $_SESSION["cardNumber"];
    $firstName = $_SESSION['FirstName'];
    $lastName = $_SESSION['LastName'];
?>

<html>
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">   
    <link rel="stylesheet" href="css/userInfo.css"
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <!-- <a class="navbar-brand" href="#">My Account Setting</a> -->


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbar-brand" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>My Account</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <!-- <h6 class="dropdown-header">My Account Info:</h6> -->
                            <a class="dropdown-item" href="#">My Account</a>
                            <a class="dropdown-item" href="#">Change Password</a>
                            <div class="dropdown-divider"></div>

                        </div>
                    </li>
                </div>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                </ul>
            </div>

        </nav>

        <div>

        </div>

        

        <div id="main-wrapper"><h2><center>welcome <?php echo $firstName;?></center></h2>

        </div>
    </body>
</html>

