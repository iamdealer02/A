<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../login/loginform.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOMEPAGE</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function updateVisitDate() {
            const dateElement = document.getElementById('visitDate');
            const now = new Date();
            dateElement.textContent = now.toLocaleString();
        }
    </script>
</head>
<body onload="updateVisitDate()">
    <div class="text-right p-2">
        <form class="form-inline" method="post" action="../../connectionquery/logout.php">
            <button class="btn btn-outline-danger" type="submit">Logout</button>
        </form>
    </div>

    <img class="logo" src="https://upload.wikimedia.org/wikipedia/fr/thumb/d/d8/Epita.png/2560px-Epita.png">
    <h1>WELCOME THOMAS</h1>

    <section class="population">

        <ul>
            <h2>Population</h2>
            <table>
            <?php

            require_once '../../connectionquery/welcomm1.php';
            $result = get_population_data();
            
            ?>
            </table>

        </ul>
        <img src="%piechart%">
    </section>

    <section class="attendance">

        <ul>
            <h2>Attendance</h2>

                        <table>
            <?php
            
            require_once '../../connectionquery/welcomm2.php';
            $result = get_attendances();

            ?>
            </table>
        </ul>
        <img src="%bargraph%">
    </section>
    <footer class="blue">
        Your last visit was on: <span id="visitDate"></span>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
