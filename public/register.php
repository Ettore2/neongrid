<?php
require_once ('../config/connect.php');
require_once ('../src/functions.php');
require_once ('../includes/const.php');
require_once ('../includes/session.php');
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>register!</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="css/colors.css" rel="stylesheet" type="text/css">
        <link href="css/fonts.css" rel="stylesheet" type="text/css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jacquard+12&family=Jersey+10&display=swap" rel="stylesheet">
    </head>
<body style="background-image: url('assets/images/backgrounds/bgRegister.jpg'); background-repeat: no-repeat; background-size: cover;">
<section class="vh-100 bg-image">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card background-color-1" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 style="color: #080A0B" class="font-Cybergame text-uppercase text-center mb-5">register!</h2>
                            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                                <div class="form-outline mb-4">
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" maxlength="100" placeholder="Username" required/>
                                    <label class="form-label" for="username">Username</label>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" maxlength="100" placeholder="Email" required/>
                                    <label class="form-label" for="email">Email</label>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" required/>
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-lg background-color-7">Enter!</button>
                                </div>
                                <p class="text-color-2 text-center mt-5 mb-0" style="font-weight: bold;">you already have an account? <a class="text-color-1" style="text-decoration: none !important;" href="index.php">login there</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</section>
<?php
//echo(password_hash("pp", PASSWORD_DEFAULT)."<br>");
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($username === null || $username === '' || $email === null || $email === '' || $password === null || $password === '')
    {
        $_SESSION[SESSION_WARNING] = ERROR_INVALID_DATA;
    }

    CONN->begin_transaction();
    try {

        if (!checkIfUserExists(CONN, $email)){
            insertUser(CONN,$username,password_hash($password, PASSWORD_DEFAULT), $email);
            updateSession($email, $password);
            header('location:home.php');
            exit();
        }else{
            $_SESSION[SESSION_WARNING] = ERROR_EMAIL_ALREADY_USED;
            consume_error();
        }

        // Commit transaction
        CONN->commit();
        //echo "Transaction successfully completed.";
    } catch (Exception $e) {
        // Rollback on failure
        CONN->rollback();

        $_SESSION[SESSION_WARNING] = ERROR_GENERIC;
    }

    CONN->close();
}
?>