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

    <!-- Jquery Datatables  -->
    <link href="bootstrap-4.6.0-dist/css/datatables.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/all.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="css/admin-style.css">

    <title>Doctors - Admin | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="images/icon.ico" />
    <script>
        function validateForm() {
            var fname = document.forms["myForm"]["fname"].value;
            var lname = document.forms["myForm"]["lname"].value;
            var email = document.forms["myForm"]["email"].value;

            // atpos = emailID.indexOf("@");
            // dotpos = emailID.lastIndexOf(".");

            var password = document.forms["myForm"]["password"].value;
            var cpassword = document.forms["myForm"]["cpassword"].value;

            var phone = document.forms["myForm"]["phone"].value;
            var nmc = document.forms["myForm"]["nmc"].value;
            var qualification = document.forms["myForm"]["qualification"].value;
            var image = document.forms["myForm"]["image"].value;
            // var dob = document.forms["myForm"]["dob"].value;

            var count = 0;
            if (fname == "") {
                document.getElementById("para-fname").innerHTML = "First Name must be filled out";
                count++;
            }

            if (lname == "") {
                document.getElementById("para-lname").innerHTML = "Last Name must be filled out";
                count++;
            }

            if (email == "") {
                document.getElementById("para-email").innerHTML = "Email must be filled out";
                count++;
            }

            if (password != cpassword) {
                document.getElementById("para-cpassword").innerHTML = "Both Password area must be same";
                document.getElementById("para-password").innerHTML = "Both Password area must be same";
                count++;

            }

            if (password == "") {
                document.getElementById("para-password").innerHTML = "Password must be filled out";
                count++;

            }

            if (cpassword == "") {
                document.getElementById("para-cpassword").innerHTML = "Password must be filled out";
                count++;

            }

            if (phone.length != 10 || isNaN(phone)) {
                document.getElementById("para-phone").innerHTML = "Please enter your correct phone number";
                count++;
            }

            if (nmc.length < 1 || isNaN(nmc)) {
                document.getElementById("para-nmc").innerHTML = "Please enter your correct NMC number";
                count++;
            }

            if (qualification == "") {
                document.getElementById("para-qualification").innerHTML = "Qualification must be filled out";
                count++;
            }

            if (image == "") {
                document.getElementById("para-image").innerHTML = "Please Upload your photo";
                count++;
            }

            if (count != 0) {
                return false;
            }

        }

        // function validate_updateForm() {
        //     var update_image = document.forms["updateForm"]["image"].value;
        //     if (update_image == "") {
        //         document.getElementsByClassName("para-image-update").innerHTML = "Please Upload your photo";
        //         return false;
        //     }
        // }
    </script>
</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Doctors</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error());
        ?>

        <!-- Start of add new doctor section -->
        <div class="insert-div">

            <!--Insert Modal -->
            <div class="modal fade Modal1" id="insertModal" role="dialog">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add New Doctor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="myForm" id="addform" method="POST" enctype="multipart/form-data" onsubmit="return(validateForm())">

                                <div class="row my-3">
                                    <div class="form-group col-sm-6">
                                        <label for="fname">First Name:</label>
                                        <input type="text" class="form-control" placeholder="" name="fname" id="fname">
                                        <p id="para-fname" class="text-danger"></p>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="lastname">Last Name:</label>
                                        <input type="text" class="form-control" id="lname" placeholder="" name="lname">
                                        <p id="para-lname" class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="form-group col-auto">
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
                                        <input type="date" class="form-control" id="dob" name="dob">
                                        <p id="para-dob" class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col-12 form-group">
                                        <label for="phone">Phone Number:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="">
                                        <p id="para-phone" class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="form-group col-12">
                                        <label for="dept">Departments</label>
                                        <select name="dept_id" id="dept" class="form-control">
                                            <option>Choose Department</option>


                                            <?php
                                            $select_idept = "SELECT * FROM department";
                                            $select_idept_result = mysqli_query($con, $select_idept);
                                            if (mysqli_num_rows($select_idept_result) > 0) {
                                                while ($row_idept = mysqli_fetch_assoc($select_idept_result)) {
                                            ?>
                                                    <option value="<?php echo $row_idept['department_id']; ?>"><?php echo $row_idept['department_name']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col-12 form-group">
                                        <label for="nmc">NMC Number:</label>
                                        <input type="text" class="form-control" id="nmc" name="nmc" placeholder="">
                                        <p id="para-nmc" class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="form-group col-12">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" placeholder="" name="email">
                                        <p id="para-email" class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="form-group col-sm-6">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" id="password" placeholder="" name="password">
                                        <p id="para-password" class="text-danger"></p>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="cpassword">Confirm Password:</label>
                                        <input type="password" class="form-control" id="cpassword" placeholder="" name="cpassword">
                                        <p id="para-cpassword" class="text-danger"></p>
                                    </div>
                                </div>

                                <div class="input-group mt-3">
                                    <span class="input-group-text">Qualification</span>
                                    <textarea class="form-control" aria-label="With textarea" id="qualification" name="qualification"></textarea>
                                </div>
                                <p id="para-qualification" class="text-danger"></p>

                                <div class="row mb-3 mt-4">
                                    <div class="col-12 form-group">
                                        <label for="image">Upload Photo:</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        <p id="para-image" class="text-danger"></p>
                                    </div>
                                </div>



                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <!-- <button type="submit" class="btn btn-success" id="addButton">Add</button> -->
                                    <input type="submit" class="btn btn-success" name="btn-insert" id="btn-insert" value="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Insert Modal Ends -->

            </div>

            <?php
            // If Add button is clicked ...
            if (isset($_POST['btn-insert'])) {
                $first_name = $_POST['fname'];
                $last_name = $_POST['lname'];
                $gender = $_POST['gender'];
                $dob = $_POST['dob'];
                $phone_number = $_POST['phone'];
                $email = $_POST['email'];
                $nmc = $_POST['nmc'];
                $qualification = $_POST['qualification'];
                $department_id = $_POST['dept_id'];
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $filename = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];

                $imgarr = explode(".", $filename);
                $imgExt = strtolower(end($imgarr));

                // $new_imgname=md5(time().$filename.'.'.$imgExt);
                $new_imgname = time() . '.' . $imgExt;
                $allowedExtn = ["jpg", "png", "gif", "jpeg"];

                if (in_array($imgExt, $allowedExtn)) {
                    $folder = "images/" . $new_imgname;
                    move_uploaded_file($tempname, $folder);

                    $password = md5($password); //encrypt the password before saving in the database

                    $sql = "INSERT INTO doctor (first_name,last_name,gender,dob,phone_number,email,nmc,qualification,department_id,image,password)
                    VALUES ('$first_name','$last_name','$gender','$dob',$phone_number,'$email',$nmc,'$qualification',$department_id,'$new_imgname','$password')";

                    // Execute query
                    $result = mysqli_query($con, $sql);

                    if ($result) {
            ?> <div class="text-success"><?php echo "Listed Successfully"; ?></div>
                    <?php
                    } else {
                    ?> <div class="text-danger"><?php echo "Unable to Insert" . mysqli_error($db); ?></div>
                    <?php
                    }
                } else {
                    ?> <div class="text-danger"><?php echo "Invalid file type/extension"; ?></div>
            <?php
                }
            }
            ?>
        </div>
        <!-- End of add new doctor section -->

        <!-- Start of show doctor table part -->
        <div class="display-div">
            <?php
            $sql = "SELECT * FROM doctor
                    LEFT JOIN department
                    ON (doctor.department_id=department.department_id)";

            $result = mysqli_query($con, $sql);
            ?>

            <!-- code to update each records -->
            <?php
            if (isset($_POST['update'])) {
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

                // $filename = $_FILES["image"]["name"];
                // $new_imgname = time() . $filename;
                // $tempname = $_FILES["image"]["tmp_name"];
                // $folder = "images/" . $new_imgname;

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
                    echo "<div class='text-success'>Succesfully updated</div>";
                    // move_uploaded_file($tempname, $folder);
                } else {
                    echo "<div class='text-danger'>Failed to update</div>";
                }
            }
            ?>

            <!-- code to delete selected record -->
            <?php
            if (isset($_POST['del'])) {
                $id = $_POST['id'];

                $delete_query = "DELETE FROM doctor
                                    WHERE doctor_id=$id";

                $res = mysqli_query($con, $delete_query);

                if ($res) {
                    echo "<div class='text-success'>Succesfully deleted</div>";
                } else {
                    echo "<div class='text-danger'>Failed to delete</div>";
                }
            }
            ?>

            <div class="table-responsive container-fluid shadow-lg p-md-1 bg-white table-div">
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#insertModal">
                    <span><i class="fas fa-plus-square"></i></span>
                    Add Doctor
                </button>
                <table class="table table-bordered table-hover display" id="display-doctor">
                    <thead class="">
                        <tr>
                            <th scope="col">SN</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <?php
                    $sn = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                            <tr>
                                <td scope="row">
                                    <?php $sn++;
                                    echo $sn; ?>
                                </td>
                                <td>
                                    <?php echo $row['first_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['last_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target=".view-modal-lg<?php echo $row['doctor_id'] ?>" data-toggle="tooltip" title="View Profile">
                                        <i class="far fa-eye"></i>
                                    </button>

                                    <!-- Start of view profile modal -->
                                    <div class="modal fade view-modal-lg<?php echo $row['doctor_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uModalLabel">Profile</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <hr>
                                                            <?php
                                                            $image = $row['image'];
                                                            echo "<img src='images/$image' height='200px' width='250px'>";
                                                            ?>
                                                            <hr>
                                                            <p>Full Name:<?php echo " Dr. " . $row['first_name'] . " " . $row['last_name']; ?></p>
                                                            <hr>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <hr>
                                                            <p>Department: <?php echo $row['department_name']; ?></p>
                                                            <hr>
                                                            <p>Gender: <?php echo $row['gender']; ?></p>
                                                            <hr>
                                                            <p>Date of Birth: <?php echo $row['dob']; ?></p>
                                                            <hr>
                                                            <p>Phone: <?php echo $row['phone_number']; ?></p>
                                                            <hr>
                                                            <p>Email: <?php echo $row['email']; ?></p>
                                                            <hr>
                                                            <p>NMC Number: <?php echo $row['nmc']; ?></p>
                                                            <hr>
                                                            <p>Qualification: <?php echo $row['qualification']; ?></p>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of view profile modal -->

                                    <a class="btn btn-warning" data-toggle="modal" data-target="#uModal<?php echo $row['doctor_id'] ?>" href="admin-doctors.php?edit=<?php echo $row['doctor_id']; ?>" data-toggle="tooltip" title="Update">
                                        <i class="fas fa-user-edit"></i>
                                    </a>

                                    <!--Start of Update Modal -->
                                    <div class="modal fade Modal2" id="uModal<?php echo $row['doctor_id'] ?>" tabindex="-1" aria-labelledby="uModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uModalLabel">Update</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form name="updateForm" action="admin-doctors.php" method="POST" enctype="multipart/form-data" onsubmit="return(validate_updateForm())">

                                                        <input type="hidden" name="id" value="<?php echo $row['doctor_id']; ?>">

                                                        <div class="row my-3">
                                                            <div class="form-group col-sm-6">
                                                                <label for="fname">First Name:</label>
                                                                <input type="text" class="form-control" value="<?php echo $row['first_name']; ?>" name="fname" id="fname">
                                                            </div>
                                                            <div class="form-group col-sm-6">
                                                                <label for="lastname">Last Name:</label>
                                                                <input type="text" class="form-control" id="lname" value="<?php echo $row['last_name']; ?>" name="lname">
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
                                                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['dob']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="row my-3">
                                                            <div class="form-group col-12">
                                                                <label for="phone">Phone Number:</label>
                                                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone_number']; ?>">
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
                                                                            if ($row['department_name'] == $row_dept['department_name']) {
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
                                                                <input type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" name="email">
                                                            </div>
                                                        </div>

                                                        <div class="row my-3">
                                                            <div class="form-group col-12">
                                                                <label for="nmc">NMC Number:</label>
                                                                <input type="text" class="form-control" id="nmc" name="nmc" value="<?php echo $row['nmc']; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="input-group mt-3">
                                                            <span class="input-group-text">Qualification</span>
                                                            <textarea class="form-control" aria-label="With textarea" id="qualification" name="qualification"><?php echo $row['qualification']; ?></textarea>
                                                        </div>

                                                        <!-- <div class="row mb-3 mt-4">
                                                            <div class="form-group col-12">
                                                                <label for="photo">Upload Photo:</label>
                                                                <input type="file" class="form-control" id="image" name="image">
                                                                <p class="para-image-update" class="text-danger"></p>
                                                            </div>
                                                        </div> -->



                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <input type="submit" value="Update" name="update" class="btn btn-success">
                                                            <!-- <button type="button" class="btn btn-primary" name="update">Update</button> -->
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of update modal -->

                                    <!-- Delete Modal -->
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#dModal<?php echo $row['doctor_id'] ?>" data-toggle="tooltip" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>

                                    <div class="modal fade Modal3" id="dModal<?php echo $row['doctor_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="admin-doctors.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?php echo $row['doctor_id']; ?>">
                                                        Are you sure?
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                            <input type="submit" value="Yes" name="del" class="btn btn-primary">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End of Delete Modal -->
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <?php mysqli_close($con); ?>
        </div>

    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="bootstrap-4.6.0-dist/js/jquery.js"></script>
    <script src="bootstrap-4.6.0-dist/js/datatables.min.js"></script>

    <script src="bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#display-doctor').DataTable();
        });
    </script>
</body>

</html>