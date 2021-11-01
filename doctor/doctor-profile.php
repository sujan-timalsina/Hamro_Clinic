<?php
session_start();

if (!isset($_SESSION['doctor_email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['doctor_email']);
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
    <link href="../admin/bootstrap-4.6.0-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../admin/fontawesome/all.min.css">
    <link rel="stylesheet" href="../admin/fontawesome/fontawesome.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="../admin/css/admin-style.css">

    <title>Patient Details - Doctor | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
</head>

<body>
    <?php
    $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error());

    if (isset($_POST['update_photo'])) {
        $id = $_POST['id'];

        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $filesize = $_FILES["image"]["size"];

        $filearr = explode(".", $filename);
        $fileExt = strtolower(end($filearr));

        $new_filename = time() . 'profile.' . $fileExt;
        $folder = "../admin/images/" . $new_filename;
        $allowedExtn = ["png", "jpg", "jpeg", "gif"];

        if (!in_array($fileExt, $allowedExtn)) {
            echo "<div class='text-danger alert alert-danger' style='position:absolute;top:10px;right:10px;z-index:101;'>Unable to recognize Image<br>Only(png,jpg,jpeg,gif) are Allowed</div>";
        } elseif ($filesize > 1000000) {
            echo "<div class='text-danger alert alert-danger' style='position:absolute;top:10px;right:10px;z-index:101;'>Image is to large(Should be less than 1MB)</div>";
        } else {
            if (move_uploaded_file($tempname, $folder)) {
                $update_query = "UPDATE doctor SET image='$new_filename' WHERE doctor_id=$id";

                $res = mysqli_query($con, $update_query);

                if ($res) {
                    echo "<div class='text-success alert alert-success' style='position:absolute;top:10px;right:10px;z-index:101;'>Succesfully updated</div>";
                } else {
                    echo "<div class='text-danger alert alert-danger' style='position:absolute;top:10px;right:10px;z-index:101;'>Failed to update</div>";
                }
            }
        }
    }

    if (isset($_POST['update_password'])) {
        $id = $_POST['id'];
        $old_password = $_POST['old_password'];
        $old_passwordmd5 = md5($old_password);

        $new_password = $_POST['new_password'];
        $new_cpassword = $_POST['new_cpassword'];

        $check = "SELECT * FROM doctor WHERE doctor_id=$id";

        $result = mysqli_query($con, $check);

        $row = mysqli_fetch_assoc($result);

        if ($row['password'] == $old_passwordmd5 && $new_cpassword == $new_password && $new_password != "") {
            $new_password = md5($new_password);
            $update_query = "UPDATE doctor SET password='$new_password' WHERE doctor_id=$id";

            $res = mysqli_query($con, $update_query);

            if ($res) {
                echo "<div class='text-success alert alert-success' style='position:absolute;top:10px;right:10px;z-index:101;'>Succesfully changed</div>";
            } else {
                echo "<div class='text-danger alert alert-danger' style='position:absolute;top:10px;right:10px;z-index:101;'>Unable to change password</div>";
            }
        } else {
            echo "<div class='text-danger alert alert-danger' style='position:absolute;top:10px;right:10px;z-index:101;'>Unable to change password</div>";
        }
    }

    if (isset($_POST['update_all'])) {
        $id = $_POST['id'];
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $phone_number = $_POST['phone'];
        $email = $_POST['email'];
        $nmc = $_POST['nmc'];
        $qualification = $_POST['qualification'];
        $department_id = $_POST['dept_id'];

        $update_query = "UPDATE doctor
                                    SET first_name='$first_name',
                                        last_name='$last_name',
                                        gender='$gender',
                                        dob='$dob',
                                        phone_number='$phone_number',
                                        email='$email',
                                        nmc=$nmc,
                                        qualification='$qualification',
                                        department_id=$department_id
                                    WHERE doctor_id=$id";

        $res = mysqli_query($con, $update_query);

        if ($res) {
            echo "<div class='text-success alert alert-success' style='position:absolute;top:10px;right:10px;z-index:101;'>Succesfully Updated</div>";
        } else {
            echo "<div class='text-danger alert alert-danger' style='position:absolute;top:10px;right:10px;z-index:101;'>Unable to Update</div>";
        }
    }
    $email = $_SESSION['doctor_email'];

    $sql1 = "SELECT * FROM doctor AS d INNER JOIN department AS de ON(d.department_id=de.department_id) WHERE email='$email'";

    $res1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($res1);

    ?>
    <?php include 'doctor-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Doctor Profile</div>
        <hr>
        <div class="container shadow-lg text-justify profile-div p-md-5 bg-white">
            <div class="row">
                <div class="col-sm-12 col-md-6 d-flex flex-wrap flex-column align-content-center justify-content-center">
                    <?php
                    $image = $row1['image'];
                    echo "<img src='../admin/images/$image' height='200px' width='200px' style='border-radius:50%;'>";
                    ?>
                    <button class="btn my-2 btn-dark button-photo" data-toggle="modal" data-target="#uModal<?php echo $row1['doctor_id'] ?>">Upload Photo</button>

                    <!--Start of Photo Update Modal -->
                    <div class="modal fade modal-photo" id="uModal<?php echo $row1['doctor_id'] ?>" tabindex="-1" aria-labelledby="uModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uModalLabel">Update Your Photo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form name="myForm" action="doctor-profile.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $row1['doctor_id']; ?>">

                                        <div class="row mb-3 mt-4">
                                            <div class="form-group col-12">
                                                <label for="photo">Upload Photo:</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <input type="submit" value="Update" name="update_photo" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of photo update modal -->

                    <button class="btn my-2 btn-dark" data-toggle="modal" data-target="#upModal<?php echo $row1['doctor_id'] ?>">Change Password</button>
                </div>

                <!-- Start of Password Update Modal -->
                <div class="modal fade Modal3" id="upModal<?php echo $row1['doctor_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="upModalLabel">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="doctor-profile.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row1['doctor_id']; ?>">
                                    <div class="form-group">
                                        <label>Old Password:</label>
                                        <input type="password" class="form-control" name="old_password">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password:</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm New Password:</label>
                                        <input type="password" class="form-control" name="new_cpassword">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        <input type="submit" value="Change" name="update_password" class="btn btn-success">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Password Update Modal -->

                <div class="col-sm-12 col-md-6">
                    <hr>
                    <div>
                        Full Name : <?php echo "Dr. " . $row1['first_name'] . " " . $row1['last_name']; ?>
                    </div>
                    <hr>
                    <div>
                        Gender : <?php echo $row1['gender']; ?>
                    </div>
                    <hr>
                    <div>
                        NMC Number : <?php echo $row1['nmc']; ?>
                    </div>
                    <hr>
                    <div>
                        Department : <?php echo $row1['department_name']; ?>
                    </div>
                    <hr>
                    <div>
                        Email : <?php echo $row1['email']; ?>
                    </div>
                    <hr>
                    <div>
                        Date of Birth : <?php echo $row1['dob']; ?>
                    </div>
                    <hr>

                    <div>
                        Mobile : <?php echo $row1['phone_number']; ?>
                    </div>
                    <hr>
                    <div>
                        Qualification : <?php echo $row1['qualification']; ?>
                    </div>
                    <hr>
                    <div>
                        <a class="btn btn-info mx-auto" data-toggle="modal" data-target="#updModal<?php echo $row1['doctor_id'] ?>" href="doctor-profile.php?edit=<?php echo $row1['doctor_id']; ?>" data-toggle="tooltip" title="Update">
                            <i class="fas fa-user-edit"></i>
                        </a>

                        <!--Start of Update Modal -->
                        <div class="modal fade" id="updModal<?php echo $row1['doctor_id'] ?>" tabindex="-1" aria-labelledby="uModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uModalLabel">Update</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form name="updateForm" action="doctor-profile.php" method="POST" enctype="multipart/form-data" onsubmit="return(validate_updateForm())">

                                            <input type="hidden" name="id" value="<?php echo $row1['doctor_id']; ?>">

                                            <div class="row my-3">
                                                <div class="form-group col-sm-6">
                                                    <label for="fname">First Name:</label>
                                                    <input type="text" class="form-control" value="<?php echo $row1['first_name']; ?>" name="fname" id="fname">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="lastname">Last Name:</label>
                                                    <input type="text" class="form-control" id="lname" value="<?php echo $row1['last_name']; ?>" name="lname">
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="form-group col-12">
                                                    <label for="">Gender:</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input ms-1" type="radio" value="Male" id="male" name="gender" checked="checked">
                                                        <label class="form-check-label" for="male">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input ms-1" type="radio" value="Female" id="female" name="gender">
                                                        <label class="form-check-label" for="female">Female</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input ms-1" type="radio" value="Others" id="others" name="gender">
                                                        <label class="form-check-label" for="others">Others</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="form-group col-12">
                                                    <label for="dob">Date of Birth:</label>
                                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row1['dob']; ?>">
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="form-group col-12">
                                                    <label for="phone">Phone Number:</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row1['phone_number']; ?>">
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="form-group col-12">
                                                    <label for="dept">Departments</label>
                                                    <select name="dept_id" id="dept" class="form-control">
                                                        <option>Choose Department</option>


                                                        <?php
                                                        $select_udept = "SELECT * FROM department";
                                                        $select_udept_result = mysqli_query($con, $select_udept);
                                                        if (mysqli_num_rows($select_udept_result) > 0) {
                                                            while ($row_dept = mysqli_fetch_assoc($select_udept_result)) {
                                                                if ($row1['department_name'] == $row_dept['department_name']) {
                                                        ?>
                                                                    <option value="<?php echo $row_dept['department_id']; ?>" selected><?php echo $row_dept['department_name']; ?></option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="<?php echo $row_dept['department_id']; ?>"><?php echo $row_dept['department_name']; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="form-group col-12">
                                                    <label for="email">Email:</label>
                                                    <input type="email" class="form-control" id="email" value="<?php echo $row1['email']; ?>" name="email">
                                                </div>
                                            </div>

                                            <div class="row my-3">
                                                <div class="form-group col-12">
                                                    <label for="nmc">NMC Number:</label>
                                                    <input type="text" class="form-control" id="nmc" name="nmc" value="<?php echo $row1['nmc']; ?>">
                                                </div>
                                            </div>

                                            <div class="input-group mt-3">
                                                <span class="input-group-text">Qualification</span>
                                                <textarea class="form-control" aria-label="With textarea" id="qualification" name="qualification"><?php echo $row1['qualification']; ?></textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <input type="submit" value="Update" name="update_all" class="btn btn-success">
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of update modal -->
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="../admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script src="../admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>