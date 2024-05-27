<?php
/* It is the page of conclusion of a game. */
require_once ('../includes/session.php');
require_once ('../src/functions.php');
require_once ('../config/connect.php');

check_login();
?>


<?php

    /** GET THE DATA **/
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: home.php');
    }
    $data = explode(";",$_POST['data']);
    $email = $_SESSION[SESSION_EMAIL];
    $played_turns = (int)$data[0];
    $coins = (int)$data[1];
    $id_hero = (int)$data[2];
    $played_time = (int)$data[3];
    $id_skin = (int)$data[4];
    $id_user = getUserIdFromEmail(CONN, $email);
    $version = getLatestVersion(CONN);

    $hero = getHeroById(CONN, $id_hero);
    $index = null;

    for ($i = 0; $i < sizeof($hero['id_skins']) && $index === null; $i++)
    {
        if ($hero['id_skins'][$i] === $id_skin)
        {
            $index = $i;
        }
    }

    // UPDATE USER COINS
    CONN->begin_transaction();
    try
    {
        $userCoins = getCoins(CONN, $email)+$coins;
        updateUserCoins(CONN, $email, $userCoins);
        CONN->commit();
    }
    catch (Exception $e)
    {
        // Rollback on failure
        CONN->rollback();
        $_SESSION[SESSION_WARNING] = ERROR_COULD_NOT_UPDATE_COINS;
        consume_error();
    }

    insertRun(CONN, $id_user, $id_skin, $played_turns, $coins, $played_time, $version['id']);

    $_SESSION[SESSION_HOME_CURR_HERO] = $id_hero;

    //$_SESSION[SESSION_IS_DEAD] = null;

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/colors.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <!-- MDB -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css"
        rel="stylesheet"
    />
    <title>Game end</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body style="background-image: url('assets/images/backgrounds/bgDeath.jpg'); background-repeat: no-repeat; background-size: cover;">
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card text-center">
                            <div class="card-header">You lose</div>
                            <div class="card-body">
                                <h5 class="card-title">Turns: <?=$played_turns;?></h5>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <p class="card-text">Coins: <?=$coins;?></p>
                                    </div>
                                    <div class="col-4">
                                        <img class="img-fluid" src="assets/images/cards/<?=getImgFromID(CONN,$id_skin)?>" alt="Hero image">
                                    </div>
                                    <div class="col-4">
                                        <p class="card-text">Time: <?=$played_time;?>s</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <a href="home.php" class="btn btn-danger" data-mdb-ripple-init>Home</a>
                                    </div>
                                    <div class="col-6">
                                        <form action="game.php" method="post">
                                            <button name="val" type="submit" value="<?php echo $id_hero . ';' . $index?>" class="btn btn-success" data-mdb-ripple-init>Play again</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
