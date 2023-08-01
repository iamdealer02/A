<?php
//can only open the page if the user is logged in

session_start();

if(!isset($_SESSION['id'])){
    /*
     we set the session id when we successfully login. Hence, if the value to session
     id does not exists(user is not logged in), we redirect user to the login window
     to login and access the page    
    */
    header('Location: ../login/loginform.php');
    exit;
}
$course = $_GET['course'];
$progname = $_GET['program'];
$yearr = $_GET['year'];
$speriod = $_GET['period'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GradePage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./grade.css">
</head>
<body>
<div class="head">
        <div class="action">
            <form class="form" method="post" action="../../connectionquery/logout.php">
                <button class="btn animated-button" type="submit"><img src="https://cdn-icons-png.flaticon.com/128/10313/10313030.png"></button>
                <button type="button" class="btn animated-button" id="goTowelcomepage"><img src="https://cdn-icons-png.flaticon.com/128/9385/9385212.png"></button>
                <a href="../population/population.php?<?php echo"year=".$yearr."&period=".$speriod."&code=".$progname."" ?>">    <button type= "button" class ="btn animated-button" ><img src="https://cdn-icons-png.flaticon.com/128/318/318477.png"></button></a>
            </form>   
        </div>
        <div class="logo-wrapper"> <!-- Wrapper for the logo -->
            <img class="logo" src="https://upload.wikimedia.org/wikipedia/fr/d/d8/Epita.png">
        </div>
    </div>   
    </div>
    <h1>WELCOME <?php echo $_SESSION["name"];  ?></h1><br>
    <section>
        <header>
            <h2>Grades</h2>
        </header>
        <div= class="container">
        <table class="table table-striped table-blue grade"  border="1px solid black" style="font-size: 18px;">
            <tr>
                <th><STRONG>EPITA EMAIL</STRONG></th>
                <Th><STRONG>FIRST NAME</STRONG></Th>
                <Th><STRONG>LAST NAME</STRONG></Th>
                <Th><STRONG>GRADES</STRONG></Th>
                <Th><STRONG>ACTIONS</STRONG></Th>
            </tr>
            <?php
        

            /*
            To get the required arguments passed in the url so that it can be fetched
            */

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
<script>
    document.getElementById('goTowelcomepage').addEventListener('click', function() {
        // Navigate to index.php
        
        window.location.href = '../welcome/welcometemplate.php';
    });

</script>
