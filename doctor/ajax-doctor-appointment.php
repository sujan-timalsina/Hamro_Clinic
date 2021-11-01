<?php
$conn = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');
$current_time = date("H:i:s");
$condition = $_POST['s_date'];
$doctor_id = $_POST['d_id'];

//Check Select Condition
if ($condition == 'Today') {
    $dis_sql = "SELECT * FROM appointment WHERE doctor_id=$doctor_id AND appointment_date='$current_date'";
} else if ($condition == 'Upcoming') {
    $dis_sql = "SELECT * FROM appointment WHERE doctor_id=$doctor_id AND appointment_date>='$current_date'";
} else if ($condition == 'All') {
    $dis_sql = "SELECT * FROM appointment WHERE doctor_id=$doctor_id";
}
//End of checking select condition

$dis_res = mysqli_query($conn, $dis_sql);
if (mysqli_num_rows($dis_res) > 0) {
    $sn = 0;
    while ($dis_row = mysqli_fetch_assoc($dis_res)) {
?>
        <tr>
            <td><?php echo ++$sn; ?></td>
            <td><?php echo $dis_row['appointment_date']; ?></td>
            <td><?php echo $dis_row['day']; ?></td>
            <td>
                <?php
                $dis_time =  date("h:i A", strtotime($dis_row['appointment_time']));
                echo $dis_time;
                ?>
            </td>
            <td><?php echo $dis_row['reason']; ?></td>
            <td>
                <?php
                $p_id = $dis_row['patient_id'];
                $display_patient = "SELECT * FROM patient WHERE patient_id=$p_id";
                $display_patient_result = mysqli_query($conn, $display_patient);
                $row = mysqli_fetch_assoc($display_patient_result);
                ?>
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