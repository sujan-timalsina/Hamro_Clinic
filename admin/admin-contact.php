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

    <title>Contact - Admin | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="images/icon.ico" />

</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Contact</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error());
        if (isset($_POST['del'])) {
            $id = $_POST['id'];

            $delete_query = "DELETE FROM contact WHERE contact_id=$id";

            $res = mysqli_query($con, $delete_query);

            if ($res) {
                echo "<div class='d-inline-block alert alert-success text-success'>Succesfully deleted</div>";
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to delete</div>";
            }
        }

        if (isset($_POST['reply'])) {
            $id = $_POST['id'];

            //Mail method will be here
            $to_email = $_POST['email'];
            $subject = $_POST['subject'];
            $body = $_POST['body'];
            $headers = "From: s.timalsina2160@gmail.com";

            if (mail($to_email, $subject, $body, $headers)) {
                echo "<div class='d-inline alert alert-success text-success'>Email successfully sent to $to_email</div>";

                $update_query = "UPDATE contact SET status='Replied' WHERE contact_id=$id";
                $res = mysqli_query($con, $update_query);
                if ($res) {
                    echo "<div class='d-inline-block alert alert-success text-success'>Succesfully Updated Status</div>";
                } else {
                    echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to Update Status</div>";
                }
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to send Email to $to_email</div>";
            }
        }
        ?>
        <div class="container-fluid shadow-lg table-responsive bg-white p-1 p-md-3">
            <table class="table table-bordered display" id="display-query">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM contact";
                    $result = mysqli_query($con, $sql);
                    $sn = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo ++$sn; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#rModal<?php echo $row['contact_id'] ?>" href="admin-contact.php?reply=<?php echo $row['contact_id']; ?>" data-toggle="tooltip" title="Reply">
                                        <i class="fas fa-reply"></i>
                                    </button>

                                    <!--Start of Reply Modal -->
                                    <div class="modal fade" id="rModal<?php echo $row['contact_id'] ?>" tabindex="-1" aria-labelledby="rModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rModalLabel">Reply</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div><?php echo "Query: " . $row['query']; ?></div>
                                                    <hr>
                                                    <form name="myForm" action="admin-contact.php" method="POST" enctype="multipart/form-data" onsubmit="return(validateForm())">
                                                        <input type="hidden" name="id" value="<?php echo $row['contact_id']; ?>">
                                                        <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                                                        <div class="form-group">
                                                            <label>Subject</label>
                                                            <input type="text" class="form-control" name="subject">
                                                            <p id="para-subject" class="text-danger"></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Body</label>
                                                            <textarea name="body" class="form-control" rows="10"></textarea>
                                                            <p id="para-body" class="text-danger"></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                            <input type="submit" value="Reply" name="reply" class="btn btn-success">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Reply modal -->

                                    <button class="btn btn-danger" data-toggle="modal" data-target="#dModal<?php echo $row['contact_id'] ?>" data-toggle="tooltip" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade Modal3" id="dModal<?php echo $row['contact_id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="admin-contact.php" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?php echo $row['contact_id']; ?>">
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
                                <td><?php echo $row['status'] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
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
            $('#display-query').DataTable();
        });

        function validateForm() {
            var count = 0;
            var subject = $("input[name='subject']").val();
            var body = $("textarea[name='body']").val();


            if (subject == "") {
                document.getElementById("para-subject").innerHTML = "This field is required";
                count++;
            } else {
                document.getElementById("para-subject").innerHTML = "";
            }

            if (body == "") {
                document.getElementById("para-body").innerHTML = "This field is required";
                count++;
            } else {
                document.getElementById("para-body").innerHTML = "";
            }


            if (count != 0) {
                return false;
            }
        }
    </script>
</body>

</html>