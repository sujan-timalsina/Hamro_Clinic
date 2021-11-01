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

    <!-- Jquery Datatables  -->
    <link href="bootstrap-4.6.0-dist/css/datatables.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/all.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="css/admin-style.css">

    <title>Patients - Admin | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="images/icon.ico" />

</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Patients</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
        if (isset($_POST['del'])) {
            $id = $_POST['id'];

            $delete_query = "DELETE FROM patient WHERE patient_id=$id";

            $res = mysqli_query($con, $delete_query);

            if ($res) {
                echo "<div class='d-inline-block alert alert-success text-success'>Succesfully deleted</div>";
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to delete</div>";
            }
        }

        if (isset($_POST['send'])) {

            $email = $_POST['email'];
            $id = $_POST['id'];

            $filename = $_FILES["report"]["name"];
            $tempname = $_FILES["report"]["tmp_name"];
            $filesize = $_FILES["report"]["size"];

            $filearr = explode(".", $filename);
            $fileExt = strtolower(end($filearr));

            $new_file_noext = mt_rand(100000, 999999) . time();
            $new_filename = $new_file_noext . '.' . $fileExt;
            $folder = "reports/" . $new_filename;
            $allowedExtn = ["pdf"];
            if (!empty($filename)) {
                if (!in_array($fileExt, $allowedExtn)) {
                    echo "<div class='text-danger'>Invalid File Type</div>";
                } elseif ($filesize > 2000000) {
                    echo "<div class='text-danger'>File is to large(Should be less than 2Mb)</div>";
                } else {
                    if (move_uploaded_file($tempname, $folder)) {
                        $sql = "INSERT INTO report(file,email,patient_id)
                    VALUES('$new_filename','$email',$id)";

                        $res = mysqli_query($con, $sql);

                        if ($res) {
                            //Mail method will be here
                            $to_email = $email;
                            $subject = "Your Report is now available";
                            $body = "Please visit our website(http://localhost/HC/labreport.php) to download your report. Your report code is " . $new_file_noext;
                            $headers = "From: s.timalsina2160@gmail.com";

                            if (mail($to_email, $subject, $body, $headers)) {
                                echo "<div class='text-success'>Email successfully sent to $to_email</div>";
                            } else {
                                echo "<div class='text-danger'>Failed to send Email to $to_email</div>";
                            }
                        } else {
                            echo "<div class='text-danger'>Unable to insert</div>";
                        }
                    } else {
                        echo "<div class='text-danger'>Unable to move_upload_file</div>";
                    }
                }
            } else {
                echo "<div class='text-danger my-2'>Please Upload File</div>";
            }
        }
        ?>
        <div class="container-fluid table-responsive bg-white p-1 p-md-3">
            <table class="table table-hover table-bordered display" id="display-query">
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
                    $select_pat = "SELECT * FROM patient";

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
                                                WHERE patient_id=$patient_id";
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
                                                                $patient_id = $row['patient_id'];
                                                                $select_appointment = "SELECT * FROM appointment AS a
                                                                                    INNER JOIN doctor AS d
                                                                                    ON (a.doctor_id=d.doctor_id)
                                                                                    WHERE patient_id=$patient_id
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

                                    <!-- Start of Send Lab Report Modal -->
                                    <button class="btn btn-info" data-toggle="modal" data-target="#lrModal<?php echo $row['patient_id'] ?>" data-toggle="tooltip" title="Send Lab Report">
                                        <i class="fas fa-upload"></i>
                                    </button>

                                    <!-- Lab Report Modal -->
                                    <div class="modal fade" id="lrModal<?php echo $row['patient_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">Send Lab Report</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="admin-patient.php" method="POST" enctype="multipart/form-data" onsubmit="return(validateForm())" name="myForm">
                                                        <input type="hidden" name="id" value="<?php echo $row['patient_id']; ?>">
                                                        <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                                        <!-- Content will be here..  -->

                                                        <div class="form-group">
                                                            <input type="file" class="form-control" id="report" name="report">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <input type="submit" value="Send" name="send" class="btn btn-success">
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Send Lab Report Modal-->

                                    <!-- Start of Delete Modal -->
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#dModal<?php echo $row['patient_id'] ?>" data-toggle="tooltip" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="dModal<?php echo $row['patient_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="admin-patient.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?php echo $row['patient_id']; ?>">
                                                        Are you sure?

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                            <input type="submit" value="Yes" name="del" class="btn btn-danger">
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Delete Modal-->
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

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="bootstrap-4.6.0-dist/js/datatables.min.js"></script>

    <script src="bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#display-query').DataTable();
        });
    </script>
</body>

</html>