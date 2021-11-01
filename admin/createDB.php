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
        $con=mysqli_connect("localhost","root","") or die("Unable to connect".mysqli_connect_error());

        $sql="CREATE DATABASE hcc_db";

        $result=mysqli_query($con,$sql);

        if($result){
          echo "Database Created Succesfully";
        }
        else{
          echo "Error Creating Database".mysqli_error($con);
        }

        mysqli_close($con);

      ?>
  </body>
</html>