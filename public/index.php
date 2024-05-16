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
    <title>Login!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/colors.css" rel="stylesheet" type="text/css">
    <link href="css/fonts.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('assets/images/backgrounds/bglogin.jpg'); background-repeat: no-repeat; background-size: cover;">
<section class="vh-100 bg-image">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card background-color-1" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 style="color: #080A0B" class="font-Cybergame text-uppercase text-center mb-5">Login!</h2>
                            <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);// Another way to embed php code into a value for a html value parameter.?>" method="post">
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
                                <p style="font-weight: bold;"text-color-2 class="text-center mt-5 mb-0">you don't have an account? <a  class="text-color-1" style="text-decoration: none !important;" href="register.php">register there</a></p>
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
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email === null || $email === '' || $password === null || $password === '')
    {
        $_SESSION[SESSION_WARNING] = ERROR_INVALID_DATA;
    }


    if (checkCredentials(CONN, $email,$password)){
        updateSession($email, $password);
        header("Location: home.php");
    }else{
        $_SESSION[SESSION_WARNING] = ERROR_LOGIN_FAILED;

    }

    CONN->close();
}
?>