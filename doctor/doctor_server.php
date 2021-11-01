<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/ico" href="../admin/images/icon.ico" />
</head>

<body>

  <?php

  session_start();

  // initializing variable
  $email    = "";
  $errors = array();

  // connect to the database
  $con = mysqli_connect('localhost', 'root', '', 'hcc_db');

  // LOGIN USER

  if (isset($_POST['login_doctor'])) {

    $email = stripslashes($_REQUEST['email']);    // removes backslashes
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $password = stripslashes($_REQUEST['password']);    // removes backslashes
    $password = mysqli_real_escape_string($con, $_POST['password']);



    if (empty($email)) {
      array_push($errors, "Email is required");
    }
    if (empty($password)) {
      array_push($errors, "Password is required");
    }


    if (count($errors) == 0) {

      $password = md5($password);

      $query = "SELECT * FROM doctor 
                    WHERE email='$email' AND password='$password'";

      $result = mysqli_query($con, $query);

      $row = mysqli_num_rows($result);

      if ($row == 1) {

        $_SESSION['doctor_email'] = $email;

        $_SESSION['success'] = "You are now logged in";

        header('location: doctor-dashboard.php');
      } else {

        array_push($errors, "Wrong username/password combination");
      }
    }
  }

  ?>
</body>

</html>