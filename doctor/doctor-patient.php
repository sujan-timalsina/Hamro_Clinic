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

    <!-- Jquery Datatables  -->
    <link href="../admin/bootstrap-4.6.0-dist/css/datatables.min.css" rel="stylesheet">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="../admin/css/admin-style.css">

    <title>Patient Details - Doctor | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
</head>

<body>
    <?php include 'doctor-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Patient Details</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
        $find_id = "SELECT * FROM doctor WHERE email='{$_SESSION['doctor_email']}'";
        $res_id = mysqli_query($con, $find_id);
        $s_row = mysqli_fetch_assoc($res_id);
        $doc_id = $s_row['doctor_id'];
        ?>
        <div class="container-fluid bg-white p-md-1">
            <table class="table table-hover table-bordered display" id="display-patient">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Total Appointments</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_pat = "SELECT DISTINCT patient.* FROM patient, appointment WHERE patient.patient_id=appointment.patient_id AND doctor_id=$doc_id";

                    $patient_result = mysqli_query($con, $select_pat);
                    if (mysqli_num_rows($patient_result) > 0) {
                        $sn = 0;
                        while ($row = mysqli_fetch_assoc($patient_result)) {
                    ?>
                            <tr>
                                <td><?php echo ++$sn; ?></td>
                                <td><?php echo $row['full_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td class="d-flex justify-content-between">
                                    <span>
                                        <?php
                                        $patient_id = $row['patient_id'];
                                        $count_pd = "SELECT count(appointment_id) AS total_appointment FROM appointment
                                                WHERE patient_id=$patient_id AND doctor_id=$doc_id";
                                        $count_res = mysqli_query($con, $count_pd);
                                        $c_row = mysqli_fetch_assoc($count_res);
                                        echo $c_row['total_appointment'];
                                        ?>
                                    </span>
                                    <!-- Start of View Appointment Table Modal -->
                                    <button class="btn btn-dark" data-toggle="modal" data-target="#vaModal<?php echo $row['patient_id'] ?>" data-toggle="tooltip" title="View Appointments">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- View Appointment Modal -->
                                    <div class="modal fade" id="vaModal<?php echo $row['patient_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">View Appointments</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Content will be here. -->
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <thead>
                                                                        <th>SN</th>
                                                                        <th>Date</th>
                                                                        <th>Time</th>
                                                                        <th>Day</th>
                                                                        <th>Reason</th>
                                                                        <th>Doctor (NMC)</th>
                                                                    </thead>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $select_appointment = "SELECT * FROM appointment AS a
                                                                                    INNER JOIN doctor AS d
                                                                                    ON (a.doctor_id=d.doctor_id)
                                                                                    WHERE patient_id=$patient_id AND a.doctor_id=$doc_id
                                                                                    ORDER BY appointment_date DESC";
                                                                $select_appointment_result = mysqli_query($con, $select_appointment);
                                                                if (mysqli_num_rows($select_appointment_result) > 0) {
                                                                    $asn = 0;
                                                                    while ($arow = mysqli_fetch_assoc($select_appointment_result)) {
                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo ++$asn; ?></td>
                                                                            <td><?php echo $arow['appointment_date']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $atime = strtotime($arow['appointment_time']);
                                                                                echo date("h:i:s A", $atime);
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo $arow['day']; ?></td>
                                                                            <td><?php echo $arow['reason']; ?></td>
                                                                            <td><?php echo "Dr. " . $arow['first_name'] . " " . $arow['last_name'] . " (" . $arow['nmc'] . ")"; ?></td>
                                                                        </tr>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of View Appointment Table Modal-->
                                </td>
                                <td>
                                    <!-- Start of View Profile Modal -->
                                    <button class="btn btn-dark" data-toggle="modal" data-target="#vpModal<?php echo $row['patient_id'] ?>" data-toggle="tooltip" title="View Profile">
                                        <i class="far fa-id-badge"></i>
                                    </button>

                                    <!-- View Profile Modal -->
                                    <div class="modal fade" id="vpModal<?php echo $row['patient_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">View Profile</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Content will be here. -->
                                                    <hr>
                                                    <div>Full Name:<?php echo " " . $row['full_name']; ?></div>
                                                    <hr>
                                                    <div>Gender:<?php echo " " . $row['gender']; ?></div>
                                                    <hr>
                                                    <div>Age:<?php echo " " . $row['age']; ?></div>
                                                    <hr>
                                                    <div>Phone Number:<?php echo " " . $row['phone_number']; ?></div>
                                                    <hr>
                                                    <div>Email:<?php echo " " . $row['email']; ?></div>
                                                    <hr>
                                                    <div>Address:<?php echo " " . $row['address']; ?></div>
                                                    <hr>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of View Profile Modal-->
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="../admin/bootstrap-4.6.0-dist/js/datatables.min.js"></script>
    <script src="../admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#display-patient").DataTable();
        });
    </script>
</body>

</html>