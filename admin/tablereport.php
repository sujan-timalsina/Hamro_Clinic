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

  $sql = "CREATE TABLE report(
              report_id INT(5) PRIMARY KEY AUTO_INCREMENT,
              file VARCHAR(255) NOT NULL,
              email VARCHAR(255) NOT NULL,
              patient_id INT(5),
              FOREIGN KEY(patient_id) REFERENCES patient(patient_id)
            )";

  // $sql="DROP TABLE admin";

  $result = mysqli_query($con, $sql);

  if ($result) {
    echo "Table Created Successfully";
  } else {
    echo "Error creating table" . mysqli_error($con);
  }

  mysqli_close($con);

  ?>
</body>

</html>