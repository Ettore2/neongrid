<?php
/* It contains the leaderboard of the users. */
require_once ('../includes/session.php');
require_once ('../src/functions.php');
require_once ('../config/connect.php');
check_login();
$id_user = getUserIdFromEmail(CONN, $_SESSION[SESSION_EMAIL]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leaderboard</title>
    <link rel="icon" href="assets/images/icons/logo.jpeg" >
    <link href="css/colors.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/leaderboard.css" rel="stylesheet">
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

<body style="background-image: url('assets/images/backgrounds/bgLeaderboard.jpg'); background-repeat: no-repeat; background-size: cover;">
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
                        <a class="nav-link" href="home.php">Home</a>
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

    <div style="display: flex;">
        <div style="width: 50%;">
            <div class="container-fluid col-9" style="margin-left: 3%; margin-top: 3%;padding: 0;overflow-y:auto; height: 50%;">
                <?php
                $result = getRuns(CONN);
                if (mysqli_num_rows($result))
                {
                    echo '<table class="table table-hover table-striped">';
                    echo '<thead style="position: sticky;top: 0;">';
                    echo '<tr>';
                    echo '<th scope="col">N°</th>';
                    echo '<th scope="col">Skin</th>';
                    echo '<th scope="col">Hero</th>';
                    echo '<th scope="col">ID User</th>';
                    echo '<th scope="col">Username</th>';
                    echo '<th scope="col">Turns</th>';
                    echo '<th scope="col">Coins</th>';
                    echo '<th scope="col">Duration</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    $position = 1;
                    while ($row = $result->fetch_assoc())
                    {
                        if ($row['id'] === $id_user)
                        {
                            echo '<th class="user-row" style="width: 8%;" scope="row">' .$position.'</th>';
                            $img = "assets/images/cards/".$row['img'];
                            ?>
                            <td class="user-row" style="width: 8%; margin-left: auto; margin-right: auto;">
                                <img style="width: 100%; height: 100%;" src="<?=$img?>" alt="hero img">
                            </td>
                            <?php
                            echo '<td class="user-row">'.$row['name'].'</td>';
                            echo '<td class="user-row">'.$row['id'].'</td>';
                            echo '<td class="user-row">'.$row['username'].'</td>';
                            echo '<td class="user-row">'.$row['turns'].'</td>';
                            echo '<td class="user-row">'.$row['coins'].'</td>';
                            echo '<td class="user-row">'.$row['duration'].'s'.'</td>';
                            echo '</tr>';
                        }
                        else
                        {
                            echo '<th class="non-user-row" style="width: 8%" scope="row">'.$position.'</th>';
                            $img = "assets/images/cards/".$row['img'];
                            ?>
                            <td class="non-user-row" style="width: 8%; margin-left: auto; margin-right: auto;">
                                <img style="width: 100%; height: 100%;" src="<?=$img?>" alt="hero img">
                            </td>
                            <?php
                            echo '<td class="non-user-row">'.$row['name'].'</td>';
                            echo '<td class="non-user-row">'.$row['id'].'</td>';
                            echo '<td class="non-user-row">'.$row['username'].'</td>';
                            echo '<td class="non-user-row">'.$row['turns'].'</td>';
                            echo '<td class="non-user-row">'.$row['coins'].'</td>';
                            echo '<td class="non-user-row">'.$row['duration'].'s'.'</td>';
                            echo '</tr>';
                        }


                        $position++;
                    }
                    echo '</tbody>';
                    echo '</table>';
                }
                ?>
            </div>
        </div>

        <div style="width: 50%;">
            <div class="container-fluid col-10" style="margin-left: 3%; margin-top: 3%;padding-top: 5%">
                <?php
                $result = getBestRunView(CONN, $id_user, getLatestVersion(CONN)['id']);
                if ($result !== NULL)
                {
                    echo '<table class="table table-hover table-striped">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th scope="col">N°</th>';
                    echo '<th scope="col">Skin</th>';
                    echo '<th scope="col">Hero</th>';
                    echo '<th scope="col">ID User</th>';
                    echo '<th scope="col">Username</th>';
                    echo '<th scope="col">Turns</th>';
                    echo '<th scope="col">Coins</th>';
                    echo '<th scope="col">Duration</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<th style="width: 8%" scope="row">'.getPositionRun(CONN, $result['turns']).'</th>';
                    $img = "assets/images/cards/".$result['img'];
                    ?>
                    <td style="width: 8%; margin-left: auto; margin-right: auto;">
                        <img style="width: 100%; height: 100%;" src="<?=$img?>" alt="hero img">
                    </td>
                    <?php
                    echo '<td>'.$result['name'].'</td>';
                    echo '<td>'.$result['id'].'</td>';
                    echo '<td>'.$result['username'].'</td>';
                    echo '<td>'.$result['turns'].'</td>';
                    echo '<td>'.$result['coins'].'</td>';
                    echo '<td>'.$result['duration'].'s'.'</td>';
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                }
                ?>
            </div>
        </div>
    </div>

</section>
</body>
