<?php
session_start();

if (!isset($_SESSION['doctor_email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['doctor_email']);
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../admin/bootstrap-4.6.0-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../admin/fontawesome/all.min.css">
    <link rel="stylesheet" href="../admin/fontawesome/fontawesome.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="../admin/css/admin-style.css">

    <title>Dashboard - Doctor | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
</head>

<body>
    <?php include 'doctor-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Dashboard</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");

        $find_id = "SELECT * FROM doctor WHERE email='{$_SESSION['doctor_email']}'";
        $res_id = mysqli_query($con, $find_id);
        $s_row = mysqli_fetch_assoc($res_id);
        $doc_id = $s_row['doctor_id'];

        date_default_timezone_set('Asia/Kathmandu');
        $current_date = date('Y-m-d');

        $today_count = "SELECT COUNT(appointment_id) AS tt FROM appointment WHERE doctor_id=$doc_id AND appointment_date='$current_date'";
        $upcoming_count = "SELECT COUNT(appointment_id) AS ut FROM appointment WHERE doctor_id=$doc_id AND appointment_date>='$current_date'";

        $today_count_result = mysqli_query($con, $today_count);
        $upcoming_count_result = mysqli_query($con, $upcoming_count);

        $trow = mysqli_fetch_assoc($today_count_result);
        $urow = mysqli_fetch_assoc($upcoming_count_result);
        ?>
        <div class="container-fluid dashboard-cards p-md-2">
            <div class="card-1">
                <h3>Today's Appointments</h3>
                <h3><?php echo $trow['tt']; ?></h3>
            </div>
            <div class="card-3">
                <h3>Upcoming Appointments</h3>
                <h3><?php echo $urow['ut']; ?></h3>
            </div>
        </div>
    </div>

    <script src="../admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="../admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>