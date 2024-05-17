<?php
/*Page for buy a hero.*/
require_once ('../includes/session.php');
require_once ('../src/functions.php');
require_once ('../config/connect.php');
check_login();

$_SESSION[SESSION_HOME_CURR_HERO] = $_POST['hero_id'];

if(!purchaseHero(CONN,$_SESSION[SESSION_EMAIL],$_POST['hero_id'])){
    $_SESSION[SESSION_WARNING] = ERROR_COULD_NOT_BUY_ITEM;
}


CONN->close();
header("Location: home.php");