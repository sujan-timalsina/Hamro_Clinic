<?php
$con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");


$sql = "CREATE TABLE faqs(
            id INT AUTO_INCREMENT PRIMARY KEY,
            questions VARCHAR(255) NOT NULL,
            answers VARCHAR(255) NOT NULL
    )";
$result = mysqli_query($con, $sql);
if ($result) {
    echo "Table created successfully";
} else {
    echo "Table not created";
}
