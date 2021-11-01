<?php

$conn = mysqli_connect('localhost', 'root', '', 'hcc_db') or die("Unable to connect" . mysqli_connect_error());

date_default_timezone_set('Asia/Kathmandu');
$date = $_POST['date'];
$appointment_date = date('Y/m/d', strtotime($date));
$doctor_id = $_POST['doctor_id'];
$appointment_day = date("l", strtotime($appointment_date));

$sql = "SELECT * FROM schedule JOIN doctor
        ON(schedule.doctor_id=doctor.doctor_id)
    	WHERE schedule.doctor_id=$doctor_id AND day = '$appointment_day'";

$res = mysqli_query($conn, $sql);
?>

<div class="col-md-6 col-12 form-group">
    <label for="">Time</label>
    <?php
    $time_taken = "SELECT appointment_time FROM appointment WHERE appointment_date='$appointment_date' AND doctor_id=$doctor_id";
    $time_taken_res = mysqli_query($conn, $time_taken);
    $all_row[] = "";
    while ($row1 = mysqli_fetch_array($time_taken_res)) {
        $all_row[] = strtotime($row1['appointment_time']);
    }
    // print_r($all_row);
    ?>
    <select name="appointment_time" class="form-control">
        <?php
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $start_time = $row['start_time'];
            $end_time = $row['end_time'];
            $range = range(strtotime($start_time), strtotime($end_time), 30 * 60);

            foreach ($range as $time) {
                if (!in_array($time, $all_row)) {
        ?>
                    <option value="<?php echo date("H:i:s", $time); ?>">
                        <?php echo date("h:i A", $time); ?>
                    </option>
                <?php
                } else {
                ?>
                    <option value="<?php echo date("H:i:s", $time); ?>" disabled>
                        <?php echo date("h:i A", $time); ?>
                    </option>
            <?php
                }
            }
            ?>
    </select>
    <small id="para-time" class="text-danger"></small>
</div>
<div class="col-md-6 col-12 form-group">
    <label for="">Day</label>
    <input type="text" name="appointment_day" class="form-control" value="<?php echo $appointment_day; ?>" disabled>
</div>
<div class="table-reponsive col-12 col-md-6">
    <table class="table table-bordered">
        <tr>
            <td><?php echo $appointment_day; ?></td>
            <td><?php echo date("h:i A", strtotime($start_time));; ?></td>
            <td><?php echo date("h:i A", strtotime($end_time));; ?></td>
        </tr>
    </table>
<?php
        }
?>
</div>