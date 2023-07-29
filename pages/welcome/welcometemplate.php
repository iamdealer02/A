
<?php
session_start();
//only logged in user can access the page

if(!isset($_SESSION['id'])){
    /*
     we set the session id when we successfully login. Hence, if the value to session
     id does not exists(user is not logged in), we redirect user to the login window
     to login and access the page    
    */
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <script>
        //script to display the visit date
        function updateVisitDate() {
            const dateElement = document.getElementById('visitDate');
            const now = new Date();
            dateElement.textContent = now.toLocaleString();
        }
    </script>
</head>
<body onload="updateVisitDate()">
    <div class="logo-wrapper"> <!-- Wrapper for the logo -->
        <img class="logo" src="https://upload.wikimedia.org/wikipedia/fr/d/d8/Epita.png">
    </div>
    <div class="text-right p-2">
        <form class="form-inline" method="post" action="../../connectionquery/logout.php">
            <div class="heading">
                <button class="btn animated-button" type="submit"><img src="https://cdn-icons-png.flaticon.com/128/10313/10313030.png"></button>
            </div>
            <!-- <div class="contain">
                <h1>WELCOME THOMAS</h1>
            </div> -->
        </form>
    </div>
    
    <div class="container"> 
        <div class="wrapper">
            <div class="col-md-6"> <!-- Use col-md-6 to create a two-column layout -->
                <section class="population">
                    <ul>
                        <h2><img src="https://cdn-icons-png.flaticon.com/128/33/33308.png">Population</h2>
                        <table id="populationtable" class="table table-striped table-blue">
                            <?php
                            /*
                            Using the query for the population from the folder connectionquery and fetching the result by running the function 
                            as the 'require_once' make the file available/accessible in the current page
                            */
                            require_once '../../connectionquery/welcomm1.php';
                            $result = get_population_data();
                            ?>
                        </table>
                    </ul>
                    <div id="chartContainer">
                        <canvas id="piechart" width="400" height="400"></canvas>
                    </div>
                </section>
            </div>
            <div class="col-md-6"> <!-- Use col-md-6 to create a two-column layout -->
                <section class="attendance">
                    <ul>
                        <h2><img src="https://cdn-icons-png.flaticon.com/128/9955/9955162.png">Attendance</h2>
                        <table id="coursetable" class="table table-striped table-blue">
                            <?php
                             /*
                            Using the query for the attendance from the folder connectionquery and fetching the result by running the function 
                            as the 'require_once' make the file available/accessible in the current page
                            */
                            require_once '../../connectionquery/welcomm2.php';
                            $result = get_attendances();
                            ?>
                        </table>
                    </ul>
                    <div id="BarchartContainer">
                        <canvas id="bargraph" width="400" height="400"></canvas>
                    </div>
               
                </section>
            </div>
        </div>
    </div>

    <footer>
        Last visited: <span id="visitDate"></span>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Extract data and generate pie chart
    function generatePieChart() {
        const table = document.getElementById('populationtable');
        const elementNames = [];
        const elementData = [];

        // Loop through each row in the table (excluding the header row)
        for (let i = 0; i < table.rows.length; i++) {
            const row = table.rows[i];
            const elementName = row.cells[0].innerText +" " + row.cells[1].innerText +" " + row.cells[2].innerText;
            const data = parseInt(row.cells[3].innerText); // Assuming 'POPULATION_COUNT' is in the 4th column (index 3)

            elementNames.push(elementName);
            elementData.push(data);
        }

        const data = {
            labels: elementNames,
            datasets: [{
                data: elementData,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'], // You can customize the colors here
                borderWidth: 1
            }]
        };

        const ctx = document.getElementById('piechart').getContext('2d');

        // Create the pie chart
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Dynamic Table Data in Pie Chart'
                }
            }
        });
    }

    // Call the function to generate the pie chart when the page is loaded
    document.addEventListener('DOMContentLoaded', generatePieChart);

    //------------------------------------------------------------------------------------------------------------------------------------

    function generateBarGraph() {
        const table = document.getElementById('coursetable');
        const elementNames = [];
        const elementData = [];

        // Loop through each row in the table (excluding the header row)
        for (let i = 0; i < table.rows.length; i++) {
            const row = table.rows[i];
            const elementName = row.cells[0].innerText +" " + row.cells[1].innerText ;
            const data = parseInt(row.cells[2].innerText); 

            elementNames.push(elementName);
            elementData.push(data);
        }

        const data = {
            labels: elementNames,
            datasets: [{
                data: elementData,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'], // You can customize the colors here
                borderWidth: 1
            }]
        };

        const ctx = document.getElementById('bargraph').getContext('2d');

        // Create the pie chart
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Dynamic Table Data in Bar Graph'
                }
            }
        });
    }

    // Call the function to generate the pie chart when the page is loaded
    document.addEventListener('DOMContentLoaded', generateBarGraph);
</script>
</body>
</html>