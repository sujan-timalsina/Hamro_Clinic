<?php include "doctor_server.php"; ?>
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
    <!-- <link rel="stylesheet" href="../admin/css/admin-style.css"> -->

    <title>Log-in | Hamro Clinic</title>
    <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
    <style>
        body {
            background-image: url("../admin/images/bg-dlogin.jpg");
            background-position: left center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .d-login {
            width: 500px;
            margin: auto;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <!-- login form -->
        <div class="container shadow-lg p-md-2 d-login">
            <h3 class="text-center">Doctor Login Panel</h3>
            <div class="row p-md-3">
                <div class="col mx-auto">
                    <form action="index.php" method="POST" onsubmit="return(validateForm())">
                        <div class="form-group">
                            <i class="fas fa-user"></i>
                            <label for="email" class="col-auto col-form-label">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email..." name="email">
                            <div class="text-danger my-3" id="para-email"></div>
                        </div>

                        <div class="form-group">
                            <i class="fas fa-key"></i>
                            <label for="password" class="col-auto col-form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <div class="text-danger my-3" id="para-password"></div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="show" onclick="showFunction()">
                            <label class="form-check-label" for="show">Show Password</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <input type="submit" name="login_doctor" class="btn btn-primary my-2 p-2 px-5" value="Login">
                        </div>
                        <?php include "errors.php"; ?>
                        <!-- <div class="my-2 d-flex justify-content-end">
                            <a href="../home.php" class="btn btn-outline-dark">Home</a>
                        </div> -->

                    </form>
                </div>

            </div>
        </div>
        <!-- login form ends -->
    </div>

    <script>
        function showFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <script src="../admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

    <script>
        function validateForm() {
            var count = 0;
            var password = $("input[name='password']").val();
            var email = $("input[name='email']").val();

            if (password == "") {
                document.getElementById("para-password").innerHTML = "<small class='alert alert-danger'>Password is required</small>";
                count++;
            } else {
                document.getElementById("para-password").innerHTML = "";
            }

            if (email == "") {
                document.getElementById("para-email").innerHTML = "<small class='alert alert-danger'>Email is required</small>";
                count++;
            } else {
                document.getElementById("para-email").innerHTML = "";
            }

            if (count != 0) {
                return false;
            }
        }
    </script>

    <script src="../admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>