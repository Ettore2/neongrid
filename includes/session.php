<?php
require_once ('const.php');
require_once('../config/connect.php');
require_once ('../src/functions.php');

session_start();

//"consume" che error
consume_error();

function consume_error(): void{
    if(isset($_SESSION[SESSION_WARNING])){
        echo('<script type="module"> alert("'.$_SESSION[SESSION_WARNING].'")</script>');
    }
    $_SESSION[SESSION_WARNING] = null;
}
function check_login(): void
{
    if(!isset($_SESSION[SESSION_EMAIL]) || !isset($_SESSION[SESSION_PASSWORD])){
        header("Location: ../public/index.php");
        exit;
    }

    if (!checkCredentials(CONN,$_SESSION[SESSION_EMAIL],$_SESSION[SESSION_PASSWORD])) {
        header("Location: ../public/index.php");
        exit;
    }
}

function updateSession($email,$password): void
{
    session_regenerate_id(true);
    $_SESSION[SESSION_EMAIL] = $email;
    $_SESSION[SESSION_PASSWORD] = $password;
}

