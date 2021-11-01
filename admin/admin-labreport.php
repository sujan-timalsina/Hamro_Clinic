<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="bootstrap-4.6.0-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/all.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="css/admin-style.css">

    <script>
        function validateForm() {
            var report = document.forms["myForm"]["report"].value;
            var email = document.forms["myForm"]["email"].value;

            var count = 0;
            if (report == "") {
                document.getElementById("para-report").innerHTML = "Please Upload First";
                count++;
            }
            if (email == "") {
                document.getElementById("para-email").innerHTML = "Email must be filled out";
                count++;
            }
            if (count != 0) {
                return false;
            }
        }
    </script>

    <title>Upload Lab Report - Admin | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="images/icon.ico" />
</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Upload Lab Report</div>
        <hr>

        <!-- start of upload section -->
        <div class="container shadow-lg p-md-5 bg-white">
            <form method="POST" name="myForm" enctype="multipart/form-data" onsubmit="return(validateForm())">

                <div class="row my-1">
                    <div class="col-6 m-auto">
                        <label for="report">Lab Report:</label>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 m-auto">
                        <div class="input-group">
                            <input type="file" class="form-control" id="report" name="report">
                        </div>
                        <p id="para-report" class="text-danger"></p>
                    </div>
                </div>

                <div class="row my-5">
                    <div class="form-group col-md-6 m-auto">
                        <label for="email">Send Code To:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Here...">
                        <p id="para-email" class="text-danger"></p>
                    </div>
                </div>

                <div class="row my-5">
                    <div class="form-group col-auto m-auto">
                        <input type="submit" name="upload" id="upload" value="Upload" class="btn btn-primary">
                    </div>
                </div>

            </form>

            <?php
            $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error());
            if (isset($_POST['upload'])) {

                $email = $_POST['email'];

                $filename = $_FILES["report"]["name"];
                $tempname = $_FILES["report"]["tmp_name"];
                $filesize = $_FILES["report"]["size"];

                $filearr = explode(".", $filename);
                $fileExt = strtolower(end($filearr));

                $new_file_noext = mt_rand(100000, 999999) . time();
                $new_filename = $new_file_noext . '.' . $fileExt;
                $folder = "reports/" . $new_filename;
                $allowedExtn = ["pdf"];

                if (!in_array($fileExt, $allowedExtn)) {
                    echo "<div class='text-danger'>Invalid File Type</div>";
                } elseif ($filesize > 2000000) {
                    echo "<div class='text-danger'>File is to large(Should be less than 2Mb)</div>";
                } else {
                    if (move_uploaded_file($tempname, $folder)) {
                        $sql = "INSERT INTO report(file,email)
                    VALUES('$new_filename','$email')";

                        $res = mysqli_query($con, $sql);

                        if ($res) {
                            //Mail method will be here
                            $to_email = $email;
                            $subject = "Your Report is now available";
                            $body = "Please visit our website(http://localhost/HC/labreport.php) to download your report. Your report code is " . $new_file_noext;
                            $headers = "From: s.timalsina2160@gmail.com";

                            if (mail($to_email, $subject, $body, $headers)) {
                                echo "<div class='text-success'>Email successfully sent to $to_email</div>";
                            } else {
                                echo "<div class='text-danger'>Failed to send Email to $to_email</div>";
                            }
                        } else {
                            echo "<div class='text-danger'>Unable to insert</div";
                        }
                    } else {
                        echo "<div class='text-danger'>Unable to move_upload_file</div";
                    }
                }
            }
            ?>
        </div>
        <!-- end of upload section -->
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>