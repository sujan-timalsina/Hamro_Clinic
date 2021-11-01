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

  $sql = "CREATE TABLE admin(
              admin_id INT(5) PRIMARY KEY AUTO_INCREMENT,
              first_name VARCHAR(50) NOT NULL,
              last_name VARCHAR(50) NOT NULL,
              gender VARCHAR(50) NOT NULL,
              dob DATE,
              phone_number VARCHAR(20) NOT NULL,
              email VARCHAR(50) NOT NULL,
              password VARCHAR(255) NOT NULL,
              image VARCHAR(50) NOT NULL,
              role VARCHAR(20) NOT NULL
            )";

  // $sql = "DROP TABLE admin";

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