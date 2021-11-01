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
    <title>FAQ- Admin | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="images/icon.ico" />
</head>

<body>
    <?php include 'admin-nav.php'; ?>
    <div class="main_content p-sm-0 p-md-2">
        <div class="text-current_page">Frequently Asked Questions</div>
        <hr>
        <?php
        $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
        if (isset($_POST['del'])) {
            $id = $_POST['id'];

            $delete_query = "DELETE FROM faqs WHERE id=$id";

            $re = mysqli_query($con, $delete_query);

            if ($re) {
                echo "<div class='d-inline-block alert alert-success text-success'>Succesfully deleted</div>";
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to delete</div>";
            }
        }
        if (isset($_POST['edit'])) {
            $id = $_POST['id'];
            $question = $_POST['question'];
            $answer = $_POST['answer'];

            $update = "UPDATE faqs 
            SET questions='$question',
            answers='$answer'
            WHERE id=$id";

            $re = mysqli_query($con, $update);

            if ($re) {
                echo "<div class='d-inline-block alert alert-success text-success'>Succesfully updated</div>";
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Failed to update" . mysqli_error($con) . "</div>";
            }
        }
        ?>

        <!--Add or create the FAQS-->

        <?php
        if (isset($_POST['create_faq'])) {
            if (!empty($_POST['question']) && !empty($_POST['answer'])) {
                $question = $_POST['question'];
                $answer = $_POST['answer'];
                $sql1 = "INSERT INTO faqs(questions,answers) VALUES ('$question','$answer')";

                $res = mysqli_query($con, $sql1);

                if ($res) {
                    echo "<div class='d-inline-block alert alert-success text-success'>Inserted Succesfully</div>";
                } else {
                    echo "<div class='d-inline-block alert alert-danger text-danger'>Not inserted</div>";
                }
            } else {
                echo "<div class='d-inline-block alert alert-danger text-danger'>Please Fill All The Field</div>";
            }
        }
        ?>
        <div class="container my-5">
            <form action="admin-faqs.php" method="post" class="col-md-6 bg-light mx-auto p-1 p-md-3">
                <div class="form-group">Questions:<input type="text" name="question" class="form-control"></div>
                <div class="form-group">Answer:<input type="text" name="answer" class="form-control"></div>
                <input type="submit" name="create_faq" value="Add New FAQ" class="btn btn-success my-2">
            </form>
        </div>

        <!--Edit FAQs-->
        <div class="table-responsive container-fluid bg-white p-sm-1">
            <table class="table table-bordered">
                <tr>
                    <th>SN</th>
                    <th>Question</th>
                    <th>Answers</th>
                    <th>Action</th>
                </tr>

                <?php
                $sn = 0;

                $sql2 = "SELECT * FROM faqs";
                $res2 = mysqli_query($con, $sql2);
                if (mysqli_num_rows($res2) > 0) {
                    while ($row = mysqli_fetch_assoc($res2)) {
                ?>
                        <tr>
                            <td><?php echo ++$sn; ?></td>
                            <td><?php echo $row['questions']; ?></td>
                            <td><?php echo $row['answers']; ?></td>
                            <td class="action">

                                <!-- Update Button trigger modal -->
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#uModal<?php echo $row['id'] ?>" data-toggle="tooltip" title="Update">
                                    <i class="fas fa-user-edit"></i>
                                </button>

                                <!-- Update Modal -->
                                <div class="modal fade" id="uModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="dModalLabel">Edit</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="admin-faqs.php" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    Questions:<input type="text" name="question" class="form-control" value="<?php echo $row['questions']; ?>">
                                                    Answer: <input type="text" name="answer" class="form-control" value="<?php echo $row['answers']; ?>">

                                                    <div class=" modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                        <input type="submit" value="Update" name="edit" class="btn btn-primary">
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dModal<?php echo $row['id'] ?>" data-toggle="tooltip" title="Delete">
                                    <i class="far fa-trash-alt"></i>
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="dModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="dModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="dModalLabel">Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="admin-faqs.php" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
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

                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
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

</body>

</html>