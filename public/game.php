<?php
/* It is responsible for manage the game. */
require_once ('../includes/session.php');
require_once ('../src/functions.php');
require_once ('../config/connect.php');
check_login();

//echo ($_POST["hero_id"]." game.php");

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
    <link href="css/game.css" rel="stylesheet">
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
<body style="background-image: url('assets/images/backgrounds/bggame.jpg'); background-repeat: no-repeat; background-size: cover;">
    <script type="module">
        import {Type,Effect, GameInstance, GameObject} from "./js/gameClasses.js";
        sessionStorage.setItem('curr_hero_id', <?=$_POST["hero_id"]?>);

        const game = GameInstance.getInstance();
        game.DT_START = Date.now();

        game.coins = 0;
        //console.log("game.EFFECTS");
        game.initializeTypes(<?php echo (json_encode(getTypes(CONN))); ?>);
        game.initializeEffects(<?php echo (json_encode(getEffects(CONN))); ?>);
        game.initializeHeroes(<?php echo (json_encode(getHeroes(CONN, $_SESSION[SESSION_EMAIL]))); ?>);
        game.initializeObjects(<?php echo (json_encode(getObjects(CONN))); ?>);

        //console.log(game.EFFECTS);
        //console.log("-----------------------------------");
    </script>

<section class="vh-100 bg-image">

    <div id="container-game" class="container-fluid row">
        <div id="card-user-info" class="col-2">
            <!--turns, weapon,btn active-->
            <div id="div-turns" class="container text-center">
                    <p id="turns-text">9999</p>

                </div>
            <div id="weapon-card" class="card">
                    <p id="weapon-name-text" style="margin: 0 auto" class="card-name">normie</p>
                    <img id="weapon-name-img"  src="assets/images/cards/toxic_knife.jpeg" class="card-img-top" alt="Object image"/>
                    <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                        <p id="weapon-damage-text" style="margin-bottom: 0;" class="card-health">hp: 7</p>
                        <p id="weapon-uses-text" class="card-effect-uses">uses: 2</p>
                    </div>
                </div>
            <button id="active-btn" class="card">
                <p id="active-name-text" style="margin: 0 auto" class="card-name">active</p>
                <img id="active-name-img"  src="assets/images/cards/toxic_knife.jpeg" class="card-img-top" alt="Object image"/>
                <p id="weapon-cd-text" style="margin: 0 auto;text-align: center;" class="card-health">7</p>
            </button>
        </div>
        <div id="wrapper-game" class="col-7 container">
            <br>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card game-card">
                        <p style="margin: 0 auto" class="card-name">normie</p>
                        <img src="assets/images/cards/normie.jpeg" class="card-img-top" alt="Object image"/>
                        <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                            <p style="margin-bottom: 0;" class="card-health">hp: 7</p>
                            <p class="card-effect-uses">uses: 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>

        </div>
        <div id="card-object-info" class="col-3 container">
            <div id="div-coins" class="container text-center">
                <p id="coins-text">99999</p>
                <img id="coin" src="assets/images/icons/coin_icon.png" alt="coins">
            </div>
            <div id="hover-card" class="card">
                <p id="hover-name-text" style="margin: 0 auto" class="card-name">normie</p>
                <img id="hover-img"  src="assets/images/cards/toxic_knife.jpeg" class="card-img-top" alt="Object image"/>
                <div style="padding-top: 0; padding-bottom: 0;" class="card-body">
                    <p id="hover-health-text" style="margin-bottom: 0;" class="card-health">hp: 7</p>
                    <p id="hover-uses-text" class="card-effect-uses">uses: 2</p>
                    <p id="hover-active-name-text" class="card-ability-name">active: xxxx</p>
                    <p id="hover-active-descr-text" class="card-ability-descr">xxxxxxxxxxxx</p>
                    <p id="hover-passive-name-text" class="card-ability-name">passive: xxxx</p>
                    <p id="hover-passive-descr-text" class="card-ability-descr">xxxxxxxxxxxx</p>
                </div>
            </div>
        </div>

    </div>
    <div class="col-2">
        <button id="quit-btn" class="btn btn-danger btn-lg" name="quit-btn">Quit</button>
    </div>
</section>
<script type="module" src="js/game.js"></script>
</body>
