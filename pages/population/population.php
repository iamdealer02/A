<?php
session_start();

if (!isset($_SESSION['id'])) {
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./pop.css">
</head>

<body>
    <div class="head">
        <div class="action">
            <form class="form" method="post" action="../../connectionquery/logout.php">
                <button class="btn animated-button" type="submit"><img src="https://cdn-icons-png.flaticon.com/128/10313/10313030.png"></button>
                <button type="button" class="btn animated-button" id="goTowelcomepage"><img src="https://cdn-icons-png.flaticon.com/128/9385/9385212.png"></button>
            </form>   
        </div>
        <div class="logo-wrapper"> <!-- Wrapper for the logo -->
            <img class="logo" src="https://upload.wikimedia.org/wikipedia/fr/d/d8/Epita.png">
        </div>
    </div>   

    <h1>WELCOME <?php echo $_SESSION["name"];  ?></h1><br>
    <div class="wrapper">
        <section class="students">
            <div class="col-md-6"> <!-- First table container -->
                <ul>
                    <h2>Student</h2>
                    <?php
                    $year = $_GET['year'];
                    $period = $_GET['period'];
                    $code = $_GET['code'];
                    ?>
                    <div class="search-wrapper">
                        <form method="post" id="searchform">
                            <div class="search-input-wrapper">
                                <input type="text" name="searchstudent" id="searchstudent" value="<?php echo isset($_POST['searchstudent']) ? htmlspecialchars($_POST['searchstudent']) : ''; ?>" placeholder="Search by first name or last name..." class="form-control search-input">
                                <button class="btn  search-btn" type="submit" name="searchstudentbtn" >
                                    <img src="https://cdn-icons-png.flaticon.com/128/151/151773.png" alt="Search" class="search-icon">
                                </button>
                            </div>
                    
                        </form>
                        <form method="post" id="searchform">
                            <div>
                                <button type='submit' name="resetstudentbtn" onclick="document.getElementById('searchstudent').value = '' " class="btn btn-secondary reset">Reset</button> 
                            </div>
                        </form>

                        <button class="btn  add-btn" data-toggle="modal" data-target="#addStudentModal">
                            <img src="https://cdn-icons-png.flaticon.com/128/7218/7218044.png" alt="Add Student">
                        </button>
                        
                    </div>
                        <div class="containers">
                        <table class="table table-striped table-blue student"  border="1px solid black" style="font-size: 18px;"  >
                            <tr>
                            <th><strong>FIRST NAME</strong></th>
                            <th><strong>LAST NAME</strong></th>
                            <th><strong>EPITA EMAIL</strong></th>
                            <th><strong>PASSES/TOTAL</strong></th>
                            <th><strong>ACTION</strong></th>
                            </tr>
                            <?php
                            /*
                            Using the GET function to fetch the variable that were passed in the URL, so that it can be easily utilized 
                            as arguments for running the next query
                            */
                            $year = $_GET['year'];
                            $period = $_GET['period'];
                            $code = $_GET['code'];

                                require_once '../../connectionquery/population1.php';
                                require_once '../../actions/populationpage/search.php';
                                /*
                                The code below checks if we are searching or extracting normal data. If we are searching, we run a different Query,i.e,
                                to search particular firstname/lastname. Otherwise, we extract the normal query for the population in that Course
                                */
                                if (isset($_POST['searchstudentbtn'])) {
                                    $result = search(); // Execute search function if search button is clicked.
                                    
                                } else {
                                    $result = get_students_by_population($code, $year, $period); // Show original data when page is loaded
                                }
                                ?>
                        </table>
                    </div>
                </ul>
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

        </section>

        <br>

        <section class="courses">
            <div class="col-md-6"> <!-- Second table container -->
                <ul>
                    <h2>Courses</h2>
                    <?php
                    $year = $_GET['year'];
                    $period = $_GET['period'];
                    $code = $_GET['code'];
                    ?>
            <div class="search-wrapper">
                <form method="post" id="searchform2">
                    <div class="search-input-wrapper">
                        <input type="text" name="searchcourse" id="searchcourse" value="<?php echo isset($_POST['searchcourse']) ? htmlspecialchars($_POST['searchcourse']) : ''; ?>" placeholder="Search the course" class="form-control search-input">
                        <button class="btn  search-btn" type="submit" name="searchcoursebtn">
                            <img src="https://cdn-icons-png.flaticon.com/128/151/151773.png" alt="Search" class="search-icon">
                        </button>
                    </div>
                </form>
                <form method="post" id="searchform2">
                    <button type="submit" name="resetcoursebtn"  onclick="document.getElementById('searchcourse').value = '' " class="btn btn-secondary reset" >Reset</button>
                </form>
                <button class="btn" data-toggle="modal" data-target="#addCourseModal">
                    <img src="https://cdn-icons-png.flaticon.com/128/2311/2311991.png" width="40px" style="margin-bottom: 20px; margin-left:20px;" >
                </button>
            </div>
                    <div class="containers">
                        <table class="table table-striped table-blue coursegrade" border="1px solid black" style="font-size: 18px;">
                            
                        <th><strong>PROGRAM_ASSIGNMENT</strong></th>
                        <th><strong>SESSION_COURSE_REF</strong></th>
                        <th><strong>SESSION COUNT</strong></th>

                            
                            <?php
                            /*
                            Similar to the code above, refining code on the basis of method we want to use.
                            */
                            $k = $_GET['code'];

                            require_once '../../connectionquery/population2.php';
                            require_once '../../actions/course/search_course.php';
                            if (isset($_POST['searchcoursebtn'])) {
                                $result = search_course(); // Execute search function if search button is clicked
                            } else {
                                $result = get_courses_by_population($k); // Show original data when page is loaded
                            }
                            ?>
                        </table>
                    </div>
                </ul>
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
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
    document.getElementById('goTowelcomepage').addEventListener('click', function() {
        // Navigate to index.php
        
        window.location.href = '../welcome/welcometemplate.php';
    });
</script>

</body>

</html>