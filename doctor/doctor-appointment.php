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

    <title>Appointments - Doctor | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
</head>

<body>
    <?php include 'doctor-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Appointments</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
        $find_id = "SELECT * FROM doctor WHERE email='{$_SESSION['doctor_email']}'";
        $res_id = mysqli_query($con, $find_id);
        $s_row = mysqli_fetch_assoc($res_id);
        $doc_id = $s_row['doctor_id'];
        ?>
        <div class="container">
            <form class="my-3" method="POST">
                <div class="form-group row">
                    <input type="hidden" id="doctor_id" value="<?php echo $doc_id; ?>">
                    <div class="mx-3">
                        <select name="select_date" id="select_date" class="form-control">
                            <option value="Today">Today</option>
                            <option value="Upcoming">Upcoming</option>
                            <option value="All">All</option>
                        </select>
                    </div>
                    <div class="mx-3">
                        <input type="submit" name="search_date" id="search_date" value="Search" class="btn btn-primary">
                    </div>
                </div>
            </form>
            <div class="container table-responsive bg-white">
                <table class="table table-borderd table-hover">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Reason</th>
                            <th>Patient Details</th>
                        </tr>
                    </thead>
                    <tbody id="show_data">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="../admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script>
        $(document).ready(function() {
            $('#search_date').on('click', function(e) {
                let doctor_id = $("#doctor_id").val();
                let select_date = $("#select_date").val();
                e.preventDefault();
                $.ajax({
                    url: "ajax-doctor-appointment.php",
                    type: 'POST',
                    data: {
                        s_date: select_date,
                        d_id: doctor_id
                    },
                    success: function(result) {
                        $('#show_data').html(result);
                    }
                });
            });
        });
    </script>

    <script src="../admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>