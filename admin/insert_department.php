<?php

$con = mysqli_connect('localhost', 'root', '', 'hcc_db') or die("Connection error" . mysqli_connect_error());

$sql = "INSERT INTO department(department_id,department_name) VALUES (1,'Accident and emergency (A&E)'),(2,'Anesthetics'),(3,'Cardiology'),(4,'Critical Care'),(5,'Gastroenterology'),(6,'Gynecology'),(7,'Haematology'),(8,'Microbiology') ";
$result = mysqli_query($con, $sql);

if ($result) {
    echo "Record inserted";
} else {
    echo "Record not inserted" . mysqli_error($con);
}

mysqli_close($con);
