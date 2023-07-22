<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: ../login/loginform.php');
    exit;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POPULATIONPAGE</title>
    <link rel="stylesheet" href="../../pages/population/pop.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="text-right p-2">
        <form class="form-inline" method="post" action="logout.php">
            <button class="btn btn-outline-danger" type="submit">Logout</button>
        </form>
    </div>
    <img class=logo src="https://upload.wikimedia.org/wikipedia/fr/thumb/d/d8/Epita.png/2560px-Epita.png">
    <h1>WELCOME THOMAS</h1>
    <section>

        <header>
            <h2>Student</h2>
        </header>
        <div class="containers">
        <table class="une" border="2" cellspacing="0">
            <tr>
                <TH><STRONG>FIRST NAME</STRONG></TH>
                <TH><STRONG>LAST NAME</STRONG></TH>
                <TH><STRONG>EPITA EMAIL</STRONG></TH>
                <TH><STRONG>PASSES/TOTAL</STRONG></TH>
            </tr>
            <?php
            $year = $_GET['year'];
            $period = $_GET['period'];
            $code = $_GET['code'];

            require_once '../../connectionquery/population1.php';
            $result = get_students_by_population($code, $year, $period);
   

            ?>
            
        </table>
        <br>
        <header>
            <h2>Courses</h2>
        </header>
        <table class="deux" border="2" cellspacing="0">
            <tr>
                <th><STRONG>PROGRAM_ASSIGNMENT</STRONG></th>
                <th><STRONG>SESSION_COURSE_REF</STRONG></th>
                <th><STRONG>SESSION COUNT</STRONG></th>
            </tr>
            <?php
            $l = $_GET['year'];
            $m = $_GET['period'];
            $k = $_GET['code'];

            require_once '../../connectionquery/population2.php';
            $result = get_courses_by_population($k, $l, $m);


            ?>
            

        </table> 
    </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>