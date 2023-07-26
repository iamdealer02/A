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
    <title>GradePage</title>
    <link rel="stylesheet" href="../../pages/course_grades/grade.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="text-right p-2">
        <form class="form-inline" method="post" action="../../connectionquery/logout.php">
            <button class="btn btn-outline-danger" type="submit">Logout</button>
        </form>
    </div>
    <img class=logo src="https://upload.wikimedia.org/wikipedia/fr/thumb/d/d8/Epita.png/2560px-Epita.png">
    <h1>WELCOME THOMAS</h1>
    <section>
        <header>
            <h2>Grades</h2>
        </header>
        <div= class="container">
        <table class="gogo" border="2" cellspacing="0">
            <tr>
                <th><STRONG>EPITA EMAIL</STRONG></th>
                <Th><STRONG>FIRST NAME</STRONG></Th>
                <Th><STRONG>LAST NAME</STRONG></Th>
                <Th><STRONG>GRADES</STRONG></Th>
            </tr>
            <?php
            $course = $_GET['course'];
            $progname = $_GET['program'];
            $yearr = $_GET['year'];
            $speriod = $_GET['period'];

            require_once '../../connectionquery/grade.php';
            $result = get_grades_by_course_and_population ($course, $progname, $yearr, $speriod);

            ?>
            
        </table>
    </div>   
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>