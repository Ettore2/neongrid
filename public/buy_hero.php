<?php
/*Page for buy a hero.*/
require_once ('../includes/session.php');
require_once ('../src/functions.php');
require_once ('../config/connect.php');
check_login();

$skin = getSkinById(CONN,$_POST["val"]);
$hero = getHeroById(CONN,$skin["id_object"]);
$index = null;
for ($i = 0; $i < sizeof($hero['id_skins']) && $index === null; $i++)
{
    if ($hero['id_skins'][$i] === $skin["id"])
    {
        $index = $i;
    }
}

$_SESSION[SESSION_HOME_CURR_HERO] = $skin["id_object"];
$_SESSION[SESSION_HOME_HERO_SKIN] = $index;

if(!purchaseSkin(CONN,$_SESSION[SESSION_EMAIL],$_POST['val'])){
    $_SESSION[SESSION_WARNING] = ERROR_COULD_NOT_BUY_ITEM;
}


CONN->close();
//echo ($_SESSION[SESSION_HOME_CURR_HERO]);
//echo ($_SESSION[SESSION_HOME_HERO_SKIN]);
header("Location: home.php");