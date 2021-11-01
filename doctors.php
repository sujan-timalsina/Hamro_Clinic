<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="admin/bootstrap-4.6.0-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="admin/css/style.css">

    <!-- Font Awesome CSS  -->
    <link rel="stylesheet" href="admin/fontawesome/all.min.css">
    <link rel="stylesheet" href="admin/fontawesome/fontawesome.min.css">

    <title>Doctors | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="admin/images/icon.ico" />

</head>

<body>

    <div class="container-fluid px-0 d-flex flex-column justify-content-between" style="min-height:100vh;">
        <div class="except-footer">
            <?php $page = 'doctor';
            include 'nav.php'; ?>

            <?php
            $con = mysqli_connect("localhost", "root", "", "hcc_db")
                or die("Unable to connect" . mysqli_connect_error());
            ?>

            <?php
            $sql = "SELECT * FROM doctor
                    LEFT JOIN department
                    ON (doctor.department_id=department.department_id)";

            $result = mysqli_query($con, $sql);
            ?>

            <div class="d-flex flex-wrap justify-content-center m-md-5">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="card m-5 doctor-cards" style="min-width:300px;max-width:300px;">
                            <?php
                            $image = $row['image'];
                            echo "<img class='card-img-top' src='admin/images/$image' height='200px' width='300px'>"
                            ?>
                            <div class="card-body">
                                <h5 class="card-title text-center">
                                    <?php echo "Dr. " . $row['first_name'] . " " . $row['last_name']; ?>
                                </h5>
                                <p class="card-text">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        NMC Number:
                                        <?php echo $row['nmc']; ?>
                                    </li>
                                    <li class="list-group-item">
                                        Department:
                                        <?php echo $row['department_name']; ?>
                                    </li>
                                    <li class="list-group-item">
                                        Qualification:
                                        <?php echo $row['qualification']; ?>
                                    </li>
                                    <li class="list-group-item font-weight-normal d-flex justify-content-center">

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#dModal<?php echo $row['doctor_id'] ?>" data-toggle="tooltip" title="Schedule">
                                            <i class="fas fa-eye"><span class="font-weight-normal ml-2">Schedule</span></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="dModal<?php echo $row['doctor_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="dModalLabel">Schedule</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $this_doc = $row['doctor_id'];
                                                        $dis_schedule = "SELECT * FROM schedule 
                                                                        WHERE doctor_id=$this_doc
                                                                        ORDER BY FIELD(day,'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')";
                                                        $dis_schedule_res = mysqli_query($con, $dis_schedule);
                                                        ?>
                                                        <div class="container table-responsive p-md-1 bg-white my-5">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Day</th>
                                                                        <th>Start Time</th>
                                                                        <th>End Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (mysqli_num_rows($dis_schedule_res) > 0) {
                                                                        $sn = 0;
                                                                        while ($nrow = mysqli_fetch_assoc($dis_schedule_res)) {
                                                                    ?>
                                                                            <tr>
                                                                                <td><?php echo ++$sn; ?></td>
                                                                                <td><?php echo $nrow['day']; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    $stime = strtotime($nrow['start_time']);
                                                                                    echo date("h:i A", $stime);
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $etime = strtotime($nrow['end_time']);
                                                                                    echo date("h:i A", $etime);
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <div class='text-center h5'>No Schedule Found</div>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Schedule Modal ends  -->

                                    </li>
                                </ul>
                                </p>
                            </div>
                        </div>

                <?php
                    }
                }
                ?>

                <?php mysqli_close($con); ?>

            </div>



        </div>

        <div class="footer-part">
            <?php include 'footer.php'; ?>
        </div>

    </div>

    <script src="admin/bootstrap-4.6.0-dist/js/jquery.js"></script>
    <script src="admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>