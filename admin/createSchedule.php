<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HCC</title>
</head>

<body>

    <?php

    $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");

    $sql = "CREATE TABLE schedule(
            schedule_id INT(5) PRIMARY KEY AUTO_INCREMENT,
            doctor_id INT(5) NOT NULL,
            day VARCHAR(20) NOT NULL,
            start_time time,              
            end_time time,

            FOREIGN KEY(doctor_id) REFERENCES doctor(doctor_id)
            )";

    // $sql = "DROP TABLE admin";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "Schedule Table Created Successfully";
    } else {
        echo "Error creating table" . mysqli_error($con);
    }

    mysqli_close($con);

    ?>
</body>

</html>