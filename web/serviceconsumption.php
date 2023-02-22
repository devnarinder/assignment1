<?php
session_start();
if (!(isset($_SESSION["loggedin"]))) {
    header("location: login.php");
    exit;
}

// connect to the database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "assessment_database";

$conn = new mysqli($host, $username, $password, $dbname);
// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Service Consumption Table</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Service Consumption Table</h1>
        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">From Date</label>
                                <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {echo $_GET['from_date'];} else {} ?>" class="form-control" placeholder="From Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">To Date</label>
                                <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {echo $_GET['to_date'];} else {} ?>" class="form-control" placeholder="To  Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Filter </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <table id="table_id">
            <thead>
                <tr>
                    <th>UserID</th>
                    <?php
                    $query = "SELECT DISTINCT servicename FROM `assdt_service_consumption_table`;";
                    $result = mysqli_query($conn, $query);
                    $servicelist = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $servicelist[] = $row['servicename'];
                        echo '<th>' . $row['servicename'] . '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <?php
            $query = "SELECT DISTINCT user_id FROM `assdt_service_consumption_table`;";
            $result = mysqli_query($conn, $query);
            $user_list = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $user_list[] = $row['user_id'];
            }
            ?>
            <tbody>

                <?php
                if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                    $from_date = $_GET['from_date'];
                    $to_date = $_GET['to_date'];
                }
                foreach ($user_list as $user) {
                    echo '<tr>';
                    echo '<td>' . $user . '</td>';
                    foreach ($servicelist as $servicename) {
                        $query = "SELECT IFNULL(SUM(transamt),'NA') as 'servicetotal' FROM `assdt_service_consumption_table` WHERE user_id = '" . $user . "' AND servicename = '" . $servicename . "' AND req_dt BETWEEN '" . $from_date . "' AND '" . $to_date . "';";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<td>' . $row['servicetotal'] . '</td>';
                        }
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#table_id").dataTable();
        });
    </script>
</body>

</html>