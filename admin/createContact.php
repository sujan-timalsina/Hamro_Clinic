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

  $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error());

  $sql = "CREATE TABLE contact(
            contact_id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL,
            name VARCHAR(50) NOT NULL,
            query VARCHAR(70) NOT NULL,
            status VARCHAR(20) NOT NULL
            )";
  $result = mysqli_query($con, $sql);

  if ($result) {
    echo "Table Created Successfully";
  } else {
    echo "Error creating table" . mysqli_error($con);
  }

  // mysqli_close($con);

  ?>
</body>

</html>