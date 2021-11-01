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

  $sql = "CREATE TABLE doctor(
              doctor_id INT(5) PRIMARY KEY AUTO_INCREMENT,
              first_name VARCHAR(50) NOT NULL,
              last_name VARCHAR(50) NOT NULL,
              gender VARCHAR(50) NOT NULL,
              dob DATE,
              phone_number VARCHAR(20) NOT NULL,
              email VARCHAR(50) NOT NULL,
              nmc INT NOT NULL,
              qualification VARCHAR(255) NOT NULL,
              department_id INT(5) NOT NULL,
              image VARCHAR(255) NOT NULL,
              password VARCHAR(255) NOT NULL,

              FOREIGN KEY(department_id) REFERENCES department(department_id)
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