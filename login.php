<!DOCTYPE html>
<html>
<head>
    <title>Banking</title>
    <?php require 'assets/autoloader.php'; ?>
    <?php require 'assets/function.php'; ?>
    <?php
    $con = new mysqli('localhost', 'root', '', 'mybank');
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    // Define constant for bank name
    define('BANK_NAME', 'Guru Nanak Bank');

    $error = "";
    
    // Function to handle login
    function handleLogin($con, $email, $password, $table, $redirect, $sessionKey) {
        global $error;

        // Using prepared statements to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM $table WHERE email = ? AND password = ?");
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            session_start();
            $data = $result->fetch_assoc();
            $_SESSION[$sessionKey] = $data['id'];
            header("Location: $redirect");
        } else {
            $error = "<div class='alert alert-warning text-center rounded-0'>Username or password wrong, try again!</div>";
        }
        
        $stmt->close();
    }

    if (isset($_POST['userLogin'])) {
        handleLogin($con, $_POST['email'], $_POST['password'], 'userAccounts', 'index.php', 'userId');
    }

    if (isset($_POST['cashierLogin'])) {
        handleLogin($con, $_POST['email'], $_POST['password'], 'login', 'cindex.php', 'cashId');
    }

    if (isset($_POST['managerLogin'])) {
        handleLogin($con, $_POST['email'], $_POST['password'], 'login', 'mindex.php', 'managerId');
    }

    ?>
</head>
<body style="background: url(images/bg-login2.jpg); background-size: 100%">
<h1 class="alert alert-success rounded-0"><?php echo BANK_NAME; ?><small class="float-right text-muted" style="font-size: 12pt;"><kbd>Presented by: CSE Students</kbd></small></h1>
<br>
<?php echo $error ?>
<br>
<div id="accordion" role="tablist" class="w-25 float-right shadowBlack" style="margin-right: 222px">
    <br><h4 class="text-center text-white">Select Your Session</h4>
    <div class="card rounded-0">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a style="text-decoration: none;" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <button class="btn btn-outline-success btn-block">User Login</button>
                </a>
            </h5>
        </div>
        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <form method="POST">
                    <input type="email" name="email" class="form-control" required placeholder="Enter Email">
                    <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1" name="userLogin">Enter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card rounded-0">
        <div class="card-header" role="tab" id="headingTwo">
            <h5 class="mb-0">
                <a class="collapsed btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Manager Login
                </a>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <form method="POST">
                    <input type="email" name="email" class="form-control" required placeholder="Enter Email">
                    <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1" name="managerLogin">Enter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card rounded-0">
        <div class="card-header" role="tab" id="headingThree">
            <h5 class="mb-0">
                <a class="collapsed btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Cashier Login
                </a>
            </h5>
        </div>
        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <form method="POST">
                    <input type="email" name="email" class="form-control" required placeholder="Enter Email">
                    <input type="password" name="password" class="form-control" required placeholder="Enter Password">
                    <button type="submit" class="btn btn-primary btn-block btn-sm my-1" name="cashierLogin">Enter</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
