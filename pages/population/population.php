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
        <form class="form-inline" method="post" action="../../connectionquery/logout.php">
            <button class="btn btn-outline-danger" type="submit">Logout</button>
        </form>
    </div>
    <img class=logo src="https://upload.wikimedia.org/wikipedia/fr/thumb/d/d8/Epita.png/2560px-Epita.png">
    <h1>WELCOME THOMAS</h1><br>
    <section>

        <header>
        <?php
            $year = $_GET['year'];
            $period = $_GET['period'];
            $code = $_GET['code'];
        ?>
    <form method="post" id="searchform">
        <input type="text" name="searchstudent" id="searchstudent" value="<?php echo isset($_POST['searchstudent']) ? htmlspecialchars($_POST['searchstudent']) : ''; ?>" placeholder="Search by first name or last name...">
        <button type="submit" name="searchstudentbtn"> Search </button>
        <button type="submit" name="resetstudentbtn" onclick="document.getElementById('searchstudent').value = '' ">Reset </button>
    </form>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">Add Student</button>
    <!-- Add Student Modal -->
<!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form_add" action="../../actions/populationpage/add_student.php?year=<?php echo $year; ?>&period=<?php echo $period; ?>&code=<?php echo $code; ?>">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="epita_email">Epita Email</label>
                            <input type="email" class="form-control" id="epita_email" name="epita_email" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Birthdate (yyyy-mm-dd)</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="yyyy-mm-dd">
                        </div>
                        <button type="submit" class="btn btn-primary" name ="add_btn">Add Student</button>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>


            <h2>Student</h2>
        </header>
        <div class="containers">
        <table class="une" border="2" cellspacing="0">
            <tr>
                <TH><STRONG>FIRST NAME</STRONG></TH>
                <TH><STRONG>LAST NAME</STRONG></TH>
                <TH><STRONG>EPITA EMAIL</STRONG></TH>
                <TH><STRONG>PASSES/TOTAL</STRONG></TH>
                <TH><STRONG>ACTION</STRONG></TH>
            </tr>
            <?php
            $year = $_GET['year'];
            $period = $_GET['period'];
            $code = $_GET['code'];

            require_once '../../connectionquery/population1.php';
            require_once '../../actions/populationpage/search.php';    
            if (isset($_POST['searchstudentbtn'])){
                $result = search(); // Execute search function if search button is clicked
            } else {
                $result = get_students_by_population($code, $year, $period); // Show original data when page is loaded
            }  
            ?>
            
        </table>
        <br>
        <header>
        <?php
            $year = $_GET['year'];
            $period = $_GET['period'];
            $code = $_GET['code'];
        ?>
        <form method="post" id="searchform2">
            <input type="text" name="searchcourse" id="searchcourse" value="<?php echo isset($_POST['searchcourse']) ? htmlspecialchars($_POST['searchcourse']) : ''; ?>" placeholder="Search the course">
            <button type="submit" name="searchcoursebtn"> Search Course </button>
            <button type="submit" name="resetcoursebtn" onclick="document.getElementById('searchcourse').value = '' ">Reset </button>
        </form>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">Add Course</button>

        <!-- Add Course Modal -->
            <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="../../actions/course/add_course.php?year=<?php echo $year; ?>&period=<?php echo $period; ?>&code=<?php echo $code; ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="session_course_ref">Course Code</label>
                                        <input type="text" class="form-control" id="session_course_ref" name="session_course_ref" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="course_name">Course Name</label>
                                        <input type="text" class="form-control" id="course_name" name="course_name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="course_rev">course rev</label>
                                            <input type="number" class="form-control" id="course_rev" name="course_rev">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label for="course_last_rev">Course last Rev</label>
                                            <input type="number" class="form-control" id="course_last_rev" name="course_last_rev">
                                    </div>
                                </div>
         
                                <div class="form-group">
                                    <label for="course_description">Course Description</label>
                                    <input type="text" class="form-control" id="course_description" name="course_description" required>
                                </div>
                                <div class="form-group">
                                    <h4>Teacher Details</h4>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="teacher_name">Teacher Name</label>
                                        <input type="text" class="form-control" id="teacher_name" name="teacher_name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="teacher_email">Teacher's Epita Email</label>
                                        <input type="email" class="form-control" id="teacher_epita_email" name="teacher_epita_email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="session_count">Session Count</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="100" step="1" value="1">
                                </div>
                                <!-- Add any other course details you want to include in the form -->
                                <button type="submit" class="btn btn-primary" name="add_course_btn">Add Course</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <h2>Courses</h2>
        </header>
        <table class="deux" border="2" cellspacing="0">
            <tr>
                <th><STRONG>PROGRAM_ASSIGNMENT</STRONG></th>
                <th><STRONG>SESSION_COURSE_REF</STRONG></th>
                <th><STRONG>SESSION COUNT</STRONG></th>
            </tr>
            <?php
            $k = $_GET['code'];

            require_once '../../connectionquery/population2.php';
            require_once '../../actions/course/search_course.php';    
            if (isset($_POST['searchcoursebtn'])){
                $result = search_course(); // Execute search function if search button is clicked
            } else {
                $result = get_courses_by_population($k); // Show original data when page is loaded
            } 
            ?>

        </table> 
    </div>
    
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>