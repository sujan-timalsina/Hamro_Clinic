<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
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
    <link href="bootstrap-4.6.0-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/all.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="css/admin-style.css">

    <title>Dashboard - Admin | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="images/icon.ico" />
</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Dashboard</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");

        $total = "SELECT count(doctor_id ) AS total from doctor";
        $total_male = "SELECT count(gender) AS total_male from doctor where gender='male'";
        $total_female = "SELECT count(gender) AS total_female from doctor where gender='female'";


        $result = mysqli_query($con, $total);
        $result_male = mysqli_query($con, $total_male);
        $result_female = mysqli_query($con, $total_female);

        $row = mysqli_fetch_assoc($result);
        $row_male = mysqli_fetch_assoc($result_male);
        $row_female = mysqli_fetch_assoc($result_female);
        ?>
        <div class="container-fluid dashboard-cards p-md-2">
            <div class="dashboard-doctor">
                <h3>Total Doctors:<?php echo " " . $row['total']; ?></h3>
                <h5><?php echo $row_male['total_male'] . " "; ?>Male Doctors</h5>
                <h5><?php echo $row_female['total_female'] . " "; ?>Female Doctors</h5>
            </div>
        </div>
    </div>

    <script src="bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>