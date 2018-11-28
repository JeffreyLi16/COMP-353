<?php 

if (isset($_SESSION['employeeID'])){ 
    if (isset($_SESSION['cardNumber'])) {?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="employeeHomePage.php">Bank of Concordia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="viewBills.php">View Bills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewTransfer.php">Transfer</a>
                    </li>
                </ul>
                <div class="navbar-nav ml-4">
                    <a class="nav-item nav-link" href="userInfo.php"> Account </a>
                    <a class="nav-item nav-link" href="logout.php"> Logout </a>
                </div>
            </div>
        </nav> 

        <?php } else if(isset($_SESSION['viewEmployeeID'])) {?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="employeeHomePage.php">Bank of Concordia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="makeBills.php">Create Bills</a>
                    </li>
                </ul>
                <div class="navbar-nav ml-4">
                    <a class="nav-item nav-link" href="employeeSetting.php"> Account </a>
                    <a class="nav-item nav-link" href="logout.php"> Logout </a>
                </div>
            </div>
            </nav>
            </nav>
    <?php } else { ?>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="employeeHomePage.php">Bank of Concordia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="makeBills.php">Create Bills</a>
                    </li>
                </ul>
                <div class="navbar-nav ml-4">
                    <a class="nav-link" href="myschedule.php">My Schedule</a>
                    <a class="nav-link" href="payroll.php">My Payroll</a>
                    <a class="nav-item nav-link" href="employeeSetting.php"> Account </a>
                    <a class="nav-item nav-link" href="logout.php"> Logout </a>
                </div>
            </div>
        </nav>
        </nav>
    <?php } ?>

<?php } else { ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="homePage.php">Bank of Concordia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="viewBills.php">View Bills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="viewTransfer.php">Transfer</a>
                </li>
            </ul>
            <div class="navbar-nav ml-4">
                <a class="nav-item nav-link" href="userInfo.php"> Account </a>
                <a class="nav-item nav-link" href="logout.php"> Logout </a>
            </div>
        </div>
    </nav>
<?php }
?>
