<?php
/* It contains the leaderboard of the users. */
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
    <title>home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
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
<div class="container-fluid">
    <?php
        $result = getRuns(CONN);
        if (mysqli_num_rows($result))
        {
            echo '<table class="table table-hover table-striped">';
            /*
            <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First</th>
                  <th scope="col">Last</th>
                  <th scope="col">Handle</th>
                </tr>
            </thead>
            */
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">Position</th>';
            echo '<th scope="col">Image</th>';
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
                echo '<tr>';
                echo '<th scope="row">'.$position.'</th>';
                $img = "assets/images/cards/".$row['img'];
                ?>
                <td style="width: 20%; margin-left: auto; margin-right: auto;">
                    <img style="width: 30%; height: 30%;" src="<?=$img?>" alt="hero img">
                </td>
                <?php
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['username'].'</td>';
                echo '<td>'.$row['turns'].'</td>';
                echo '<td>'.$row['coins'].'</td>';
                echo '<td>'.$row['duration'].'s'.'</td>';
                echo '</tr>';
                $position++;
            }
            echo '</tbody>';
            echo '</table>';
        }
    ?>
</div>
</section>
</body>
