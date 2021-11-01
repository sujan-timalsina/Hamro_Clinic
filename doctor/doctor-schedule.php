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

    <title>Manage Schedule - Doctor | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
</head>

<body>
    <?php include 'doctor-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Manage Schedule</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
        $session_email = $_SESSION['doctor_email'];
        $find_id = "SELECT * FROM doctor WHERE email='$session_email'";
        $find_id_result = mysqli_query($con, $find_id);
        $one_row = mysqli_fetch_assoc($find_id_result);
        $this_doctor_id = $one_row['doctor_id'];
        if (isset($_POST['insert_schedule'])) {
            $day = $_POST['day'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];

            $insert_sql = "INSERT INTO schedule(day,start_time,end_time,doctor_id)
                        VALUES('$day','$start_time','$end_time',$this_doctor_id)";

            $insert_result = mysqli_query($con, $insert_sql);
            if ($insert_result) {
                echo "<div class='alert alert-success text-success'>Record Inserted</div>";
            } else {
                echo "<div class='alert alert-danger text-danger'>Failed to Insert Record</div>";
            }
        }

        if (isset($_POST['del'])) {
            $id = $_POST['id'];

            $delete_query = "DELETE FROM schedule WHERE schedule_id=$id";

            $res = mysqli_query($con, $delete_query);

            if ($res) {
                echo "<div class='d-inline-block alert alert-success text-success'>Succesfully deleted</div>";
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to delete</div>";
            }
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $start_time = $_POST['st_time'];
            $end_time = $_POST['ed_time'];

            $update = "UPDATE schedule 
            SET start_time='$start_time',
            end_time='$end_time'
            WHERE schedule_id=$id";

            $re = mysqli_query($con, $update);

            if ($re) {
                echo "<div class='d-inline-block alert alert-success text-success'>Succesfully updated</div>";
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to update" . mysqli_error($con) . "</div>";
            }
        }
        ?>
        <div class="container">
            <div class="row my-md-3 bg-white p-md-2 p-1">
                <form action="doctor-schedule.php" method="POST" class="w-100">
                    <div class="row">
                        <div class="form-group col-md-3 col-12">
                            <label>Day</label>
                            <select name="day" class="form-control">
                                <option value="Sunday" selected>Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 col-12">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="start_time">
                        </div>
                        <div class="form-group col-md-3 col-12">
                            <label>End Time</label>
                            <input type="time" class="form-control" name="end_time">
                        </div>
                        <div class="form-group col-md-3 col-12 mt-4">
                            <input type="submit" class="btn btn-success" value="Set" name="insert_schedule">
                            <input type="reset" class="btn btn-danger" value="Reset">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $sn = 0;
        $select_schedule = "SELECT * FROM schedule JOIN doctor
                        ON(doctor.doctor_id=schedule.doctor_id)
                        WHERE doctor.doctor_id=$this_doctor_id
                        ORDER BY FIELD(day,'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')";
        $select_schedule_result = mysqli_query($con, $select_schedule);
        ?>
        <div class="container table-responsive p-md-1 bg-white my-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($select_schedule_result) > 0) {
                        while ($row = mysqli_fetch_assoc($select_schedule_result)) {
                    ?>
                            <tr>
                                <td><?php echo ++$sn; ?></td>
                                <td><?php echo $row['day']; ?></td>
                                <td>
                                    <?php
                                    $stime = strtotime($row['start_time']);
                                    echo date("h:i:s A", $stime);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $etime = strtotime($row['end_time']);
                                    echo date("h:i:s A", $etime);
                                    ?>
                                </td>
                                <td>
                                    <!-- Start of Edit Section  -->
                                    <button class="btn btn-info" data-toggle="modal" data-target="#uModal<?php echo $row['schedule_id'] ?>" data-toggle="tooltip" title="Update">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Start of edit modal  -->
                                    <div class="modal fade" id="uModal<?php echo $row['schedule_id'] ?>" tabindex="-1" aria-labelledby="uModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uModalLabel">Update Your Schedule</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="myForm" action="doctor-schedule.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?php echo $row['schedule_id']; ?>">

                                                        <div class="row my-3">
                                                            <div class="form-group col-12">
                                                                <label>Start Time</label>
                                                                <input type="time" name="st_time" class="form-control" value="<?php echo $row['start_time']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="row my-3">
                                                            <div class="form-group col-12">
                                                                <label>End Time</label>
                                                                <input type="time" name="ed_time" class="form-control" value="<?php echo $row['end_time']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <input type="submit" value="Update" name="update" class="btn btn-success">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of edit modal -->

                                    <!-- Start of Delete Modal -->
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#dModal<?php echo $row['schedule_id'] ?>" data-toggle="tooltip" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="dModal<?php echo $row['schedule_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="doctor-schedule.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?php echo $row['schedule_id']; ?>">
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

    <script src="../admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="../admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>