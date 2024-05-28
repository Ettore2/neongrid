<?php
/*Page for start a run. Is a link for the other pages.*/
require_once ('../includes/session.php');
require_once ('../src/functions.php');
require_once ('../config/connect.php');
check_login();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="icon" href="assets/images/icons/logo.jpeg" >
    <link href="css/colors.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
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
    <title>home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body style="background-image: url('assets/images/backgrounds/bghome.jpg'); background-repeat: no-repeat; background-size: cover; overflow: hidden;">
<script type="module">
    import {GameInstance} from "./js/gameClasses.js";


    const game = GameInstance.getInstance();

    //get coins

    game.coins = <?=getCoins(CONN, $_SESSION[SESSION_EMAIL])?>;
    game.initializeSkins(<?php echo (json_encode(getSkins(CONN, $_SESSION[SESSION_EMAIL]))); ?>)
    game.initializeTypes(<?php echo (json_encode(getTypes(CONN))); ?>)
    game.initializeEffects(<?php echo (json_encode(getEffects(CONN))); ?>)
    game.initializeHeroes(<?php echo (json_encode(getHeroes(CONN))); ?>);
    //console.log(game.SKINS);
    //console.log(game.HEROES);

    sessionStorage.setItem('curr_hero_id', <?php
        $hero_id = 0;
        if (isset($_SESSION[SESSION_HOME_CURR_HERO]))
        {
            $hero_id = $_SESSION[SESSION_HOME_CURR_HERO];
        }
        else
        {
            $hero_id = 1;
        }
        echo($hero_id);
        $_SESSION[SESSION_HOME_CURR_HERO] = null;
        ?>);
    sessionStorage.setItem('curr_skin_id', <?php
        if (isset($_SESSION[SESSION_HOME_HERO_SKIN]))
        {
            echo $_SESSION[SESSION_HOME_HERO_SKIN];
        }
        else
        {
            $hero = getHeroById(CONN, $hero_id);
            $val = -1;
            for($i = 0; $i < sizeof($hero["id_skins"]) && $val === -1; $i++){
                if($hero["id_skins"][$i] === $hero["id_curr_img"]){
                    $val = $i;
                }
            }
            echo($val);
        }
        $_SESSION[SESSION_HOME_HERO_SKIN] = null;
        ?>);

</script>
<section class="vh-100 bg-image">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button
                    data-mdb-collapse-init
                    class="navbar-toggler"
                    type="button"
                    data-mdb-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="leaderboard.php">Leaderboard</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li>
                            <a class="dropdown-item" href="php/logout.php">
                                Logout
                            </a>
                        </li>
                </ul>
            </div>
    </nav>
    <!-- coins -->
    <div id="div-coins" class="container text-center">

        <p id="coins-text">99999</p>
        <img id="coin" src="assets/images/icons/coin_icon.png" alt="coins">

    </div>
    <div id="div-btns-skins" style="margin-left: auto;margin-right: auto; display: flex">
        <button id="btn-prev-skin" style="margin-left: auto;margin-right: 0.5%;width: 3%;"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
        <button id="btn-next-skin" style="margin-left: 0.5%;margin-right: auto;width: 3%;"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
    </div>

    <div style="width: 60%; margin: 0.4% auto 0;" class="container-fluid text-center position-relative row">

        <div style="padding: 0;" class="col-1">
            <div style="width: 100%; height: 30%;"></div>
            <button id="btn_previous" style="width: 100%; height: 40%;"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
            <div style="width: 100%; height: 30%;"></div>
        </div>
        <!-- heroes -->
        <?php
        $types = getTypes(CONN);
        $color_bg = $types[0]["color_bg"];
        $color_bd = $types[0]["color_bd"];
        ?>
        <div class="col-10">
            <div class="row" style="margin: auto">
                <div id="hero-card-1" style="scale: 80%;opacity: 0.6;background-color: <?=$color_bg?>;border-color: <?=$color_bd?>" class="card-hero card">
                    <p class="card-name">normie</p>
                    <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Palm Springs Road"/>
                    <div class="card-body">
                        <p class="card-health">hp: 7</p>
                        <p class="card-effect-name">active:</p>
                        <p class="card-effect-descr">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
                        <p class="card-effect-name">passive:</p>
                        <p class="card-effect-descr">pppppppppppppppppppppppppppppppppppppppppppppppp</p>
                    </div>
                </div>
                <div id="hero-card-2" style="scale: 100%;background-color: <?=$color_bg?>;border-color: <?=$color_bd?>" class="card-hero card">
                    <p class="card-name">normie</p>
                    <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Palm Springs Road"/>
                    <div class="card-body">
                        <p class="card-health">hp: 7</p>
                        <p class="card-effect-name">active:</p>
                        <p class="card-effect-descr">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
                        <p class="card-effect-name">passive:</p>
                        <p class="card-effect-descr">pppppppppppppppppppppppppppppppppppppppppppppppp</p>
                    </div>
                </div>
                <div id="hero-card-3" style="scale: 80%;opacity: 0.6;background-color: <?=$color_bg?>;border-color: <?=$color_bd?>" class="card-hero card">
                    <p class="card-name">normie</p>
                    <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Palm Springs Road"/>
                    <div class="card-body">
                        <p class="card-health">hp: 7</p>
                        <p class="card-effect-name">active:</p>
                        <p class="card-effect-descr">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
                        <p class="card-effect-name">passive:</p>
                        <p class="card-effect-descr">pppppppppppppppppppppppppppppppppppppppppppppppp</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 0;" class="col-1">
            <div style="width: 100%; height: 30%;"></div>
            <button id="btn_next" style="width: 100%; height: 40%;">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </button>
            <div style="width: 100%; height: 30%;"></div>
        </div>
    </div>

    <div class="container">
        <form id="form-btn" method="post" action="">
            <button id="btn-play" type="submit" name="val">
                <b style="width: 55%;color: white;margin: auto; font-size: 180%">500</b>
                <img style="width: 30%; height: 30%;padding-left: 2%; margin: auto 0 auto 0;" src="assets/images/icons/coin_icon.png" alt="coins">
            </button>
        </form>
    </div>
</section>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

<script type="module" src="js/home.js"></script>
</body>