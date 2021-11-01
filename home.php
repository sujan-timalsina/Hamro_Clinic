<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="admin/bootstrap-4.6.0-dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS  -->
  <link rel="stylesheet" href="admin/css/style.css">

  <!-- Font Awesome CSS  -->
  <link rel="stylesheet" href="admin/fontawesome/all.min.css">
  <link rel="stylesheet" href="admin/fontawesome/fontawesome.min.css">

  <title>Home | Hamro Clinic</title>
  <link rel="shortcut icon" type="image/ico" href="admin/images/icon.ico" />
</head>

<body>
  <?php
  $con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error());
  ?>

  <!-- Modal -->
  <div class="modal fade" id="about" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">About us</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-justify p-md-3 my-3">
            Hamro Clinic Pvt. Ltd. is a polyclinic based health facility located at Mid-Banehswor, Kathmandu. It was established in 2021, with the aim to provide basic health and specialist services to the neighboring localities as well as to the public of the Kathmandu Valley. The polyclinic is easily accessible via public transports.<br><br>

            Our services include Doctor consultations, pathology lab, USG, digital X-rays, health packages as well as minor surgeries, physiotherapy and Dental Clinic. Our polyclinic provides Specialists Consultations in the field of Internal Medicine, Heart Clinic, Diabetes, Thyroid & Hormone Clinic, Chest Clinic, Child Health, Women’s Health, Orthopedic clinic, Neuro Clinic, Skin & Aesthetic Clinic, ENT & Audiology, Mental Health and Dental clinic. Our specialists are affiliated to the major national level hospitals and health institutes.<br><br>

            Our aim is to provide quality health & diagnostic services at a reasonable affordable price.<br><br>

            We welcome advices, suggestions & feedbacks especially from the public who have taken services from our polyclinic.. The clinic is run by team of experts in medical field to provide best of service to peoples health in Nepal.
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Ends -->

  <!--Appointment Modal -->
  <div class="modal fade" id="appointment" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content bg-light">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Make Appointment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="home.php" method="POST" name="myForm" onsubmit="return(validateForm())">
            <div class="conainer bg-white p-md-3">
              <div class="h3 text-center font-weight-normal">Appointment Details</div>
              <div class="form-group col-md-6 my-5">
                <label>Departments</label>
                <select name="dept" class="form-control" onchange="myfun(this.value)">
                  <option value="default">Choose Department</option>


                  <?php
                  $select_dept = "SELECT * FROM department";
                  $select_dept_result = mysqli_query($con, $select_dept);
                  if (mysqli_num_rows($select_dept_result) > 0) {
                    while ($row = mysqli_fetch_assoc($select_dept_result)) {
                  ?>
                      <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                  <?php
                    }
                  }
                  ?>
                </select>
                <small id="para-dept" class="text-danger"></small>
              </div>
              <div class="form-group col-md-6 my-5">
                <label for="">Doctor Name</label>
                <select name="doctor_id" id="doctor_id" class="form-control">
                  <option value="default">Choose Doctor</option>
                </select>
                <small id="para-doc" class="text-danger"></small>
              </div>
              <div class="form-group col-md-6 my-5">
                <label>Appointment Date</label>
                <input type="date" name="date" class="form-control" onchange="date_fun(this.value)">
                <small id="para-date" class="text-danger"></small>
              </div>
              <div class="row" id="time_day_row">
              </div>
              <div class="form-group col-md-6 my-5">
                <label>Reason For Appointment</label>
                <textarea name="reason" cols="30" rows="3" class="form-control"></textarea>
                <small id="para-reason" class="text-danger"></small>
              </div>
            </div>
            <div class="container bg-white my-5 p-md-3">
              <div class="h3 text-center font-weight-normal">Patient Details</div>
              <div class="form-group col-md-6 my-5 p-0">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control">
                <small id="para-pname" class="text-danger"></small>
              </div>
              <div class="p-0 row my-5">
                <div class="form-group col-md-6 pt-4">
                  <label>Gender:</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input ml-1" type="radio" value="Male" name="gender" checked="checked">
                    <label class="form-check-label" for="male">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input ml-1" type="radio" value="Female" name="gender">
                    <label class="form-check-label" for="female">Female</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input ml-1" type="radio" value="Others" name="gender">
                    <label class="form-check-label" for="others">Others</label>
                  </div>
                </div>
              </div>
              <div class="p-0 row my-5">
                <div class="form-group col-md-6">
                  <label>Age</label>
                  <input type="number" name="age" class="form-control">
                  <small id="para-age" class="text-danger"></small>
                </div>
              </div>
              <div class="p-0 row my-5">
                <div class="form-group col-md-6">
                  <label>Address</label>
                  <input type="text" name="address" class="form-control">
                  <small id="para-address" class="text-danger"></small>
                </div>
              </div>
              <div class="p-0 row my-5">
                <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control">
                  <small id="para-email" class="text-danger"></small>
                </div>
                <div class="form-group col-md-6">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control">
                  <small id="para-phone" class="text-danger"></small>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="submit" value="Book Appointment" name="book" class="btn btn-danger">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--Appointment Modal Ends -->

  <div class="container-fluid px-0 d-flex flex-column justify-content-between" style="min-height:100vh;">
    <div class="except-footer">
      <div class="bg-home col-12 px-0">
        <?php $page = 'home';
        include 'nav.php'; ?>
        <?php

        ?>
        <div class="container-fluid p-md-3">
          <div class="row" style="min-height: 600px;">
            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column">
              <div class="display-4 my-3">Lets Cure Together</div>
              <button class="btn btn-lg btn-outline-dark my-3" data-toggle="modal" data-target="#appointment">Make Appointment</button>
              <?php
              if (isset($_POST['book'])) {

                $email = $_POST['email'];
                $phone = $_POST['phone'];

                $name = $_POST['full_name'];
                $age = $_POST['age'];
                $address = $_POST['address'];
                $gender = $_POST['gender'];

                $appointment_time = $_POST['appointment_time'];
                $reason = $_POST['reason'];

                $appointment_date = $_POST['date'];
                $appointment_day = date("l", strtotime($appointment_date));
                // $appointment_day = $_POST['appointment_day'];
                $doctor_id = $_POST['doctor_id'];

                $select_patient = "SELECT * FROM patient WHERE email='$email' OR phone_number='$phone'";
                $select_patient_result = mysqli_query($con, $select_patient);
                if ($select_patient_result && !empty($appointment_time)) {
                  if (mysqli_num_rows($select_patient_result) > 0) {
                    $row_patient = mysqli_fetch_assoc($select_patient_result);
                    $patient_id = $row_patient['patient_id'];

                    $update_patient = "UPDATE patient
                                  SET full_name='$name',
                                  gender='$gender',
                                  age=$age,
                                  phone_number='$phone',
                                  email='$email',
                                  address='$address'
                                  WHERE patient_id=$patient_id";

                    $update_patient_result = mysqli_query($con, $update_patient);

                    if ($update_patient_result) {

                      $make_appointment = "INSERT INTO appointment(appointment_date,appointment_time,day,reason,doctor_id,patient_id)
                      VALUES('$appointment_date','$appointment_time','$appointment_day','$reason','$doctor_id','$patient_id')";

                      $make_appointment_result = mysqli_query($con, $make_appointment);

                      if ($make_appointment_result) {
                        echo "<div class='alert alert-success text-success'>Appointment made successfully From Existing Patient</div>";
                      } else {
                        echo "<div class='alert alert-danger text-danger'>Failed to make Appointment</div>";
                      }
                    } else {
                      echo "<div class='alert alert-danger text-danger'>Failed to Update Patient</div>";
                    }
                  } else {
                    $insert_new_patient = "INSERT INTO patient(full_name,gender,age,phone_number,email,address)
                                      VALUES('$name','$gender',$age,'$phone','$email','$address')";

                    $insert_new_patient_result = mysqli_query($con, $insert_new_patient);
                    if ($insert_new_patient_result) {

                      $select_new_patient = "SELECT * FROM patient WHERE email='$email' OR phone_number='$phone'";
                      $select_new_patient_result = mysqli_query($con, $select_new_patient);
                      if ($select_new_patient_result) {
                        if (mysqli_num_rows($select_new_patient_result) > 0) {
                          $row_new_patient = mysqli_fetch_assoc($select_new_patient_result);
                          $new_patient_id = $row_new_patient['patient_id'];

                          $make_new_appointment = "INSERT INTO appointment(appointment_date,appointment_time,day,reason,doctor_id,patient_id)
                          VALUES('$appointment_date','$appointment_time','$appointment_day','$reason','$doctor_id','$new_patient_id')";

                          $make_new_appointment_result = mysqli_query($con, $make_new_appointment);

                          if ($make_new_appointment_result) {
                            echo "<div class='alert alert-success text-success'>Appointment made successfully From New Patient</div>";
                          } else {
                            echo "<div class='alert alert-danger text-danger'>Failed to make Appointment From New Patient</div>";
                          }
                        }
                      } else {
                        echo "<div class='alert alert-danger text-danger'>Failed to SELECT New Patient</div>";
                      }
                    } else {
                      echo "<div class='alert alert-danger text-danger'>Failed to Insert New Patient</div>";
                    }
                  }
                } else {
                  echo "<div class='alert alert-danger text-danger'>Failed to SELECT Patient</div>";
                }
              }
              ?>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
              <img src="admin/images/home.jpg" class="img-fluid rounded">
            </div>
          </div>
        </div>
        <div class="container">
          <div class="about-section row my-5">
            <div class="col-md-6 p-1 p-md-3">
              <img src="admin/images/about.jpg" class="img-fluid rounded">
            </div>
            <div class="col-md-6 p-1 p-md-3">
              <h2 class="text-center"><u>ABOUT US</u></h2>
              <div class="text-justify my-5">
                Hamro Clinic Pvt. Ltd. is a polyclinic based health facility located at Mid-Banedswor, Kathmandu. It was established in 2021, with the aim to provide basic health and specialist services to the neighboring localities as well as to the public of the Kathmandu Valley. The polyclinic is easily accessible via public transports.
              </div>
              <button class="btn btn-outline-dark my-2" data-toggle="modal" data-target="#about">Learn More...</button>
            </div>
          </div>
          <div class="services-section row my-5">
            <h2 class="text-center mx-auto my-3">Our Services</h2>
            <div class="cards-sec d-flex justify-content-center flex-wrap">
              <div class="card m-2 bg-dark text-white" style="width: 300px;">
                <div class="card-body">
                  <div class="mx-auto text-center display-4 my-2"><i class="fas fa-clinic-medical"></i></i></div>
                  <h5 class="card-title text-center">Whole Body Checkup</h5>
                </div>
              </div>
              <div class="card m-2 bg-dark text-white" style="width: 300px;">
                <div class="card-body">
                  <div class="mx-auto text-center display-4 my-2"><i class="fas fa-notes-medical"></i></div>
                  <h5 class="card-title text-center">Get Report Quick Online</h5>
                </div>
              </div>
              <div class="card m-2 bg-dark text-white" style="width: 300px;">
                <div class="card-body">
                  <div class="mx-auto text-center display-4 my-2"><i class="fas fa-user-md"></i></div>
                  <h5 class="card-title text-center">See a Doctor or Specialist</h5>
                </div>
              </div>
              <div class="card m-2 bg-dark text-white" style="width: 300px;">
                <div class="card-body">
                  <div class="mx-auto text-center display-4 my-2"><i class="fas fa-cut"></i></div>
                  <h5 class="card-title text-center">Minor Surguries or Procedures</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-part">
      <?php include 'footer.php'; ?>
    </div>

  </div>

  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>

  <script src="admin/bootstrap-4.6.0-dist/js/jquery.js"></script>

  <?php
  date_default_timezone_set('Asia/Kathmandu');
  $todays_date = date('Y/m/d');
  ?>

  <script>
    function myfun(datavalue) {
      $.ajax({
        url: "ajax-dropdown-doctor.php",
        type: 'POST',
        data: {
          datapost: datavalue
        },
        success: function(result) {
          $('#doctor_id').html(result);
        }
      });
    }

    function date_fun(appointment_date) {
      let doctor_id = $("#doctor_id").val();
      $.ajax({
        url: "ajax-appointment-time.php",
        type: 'POST',
        data: {
          date: appointment_date,
          doctor_id: doctor_id
        },
        success: function(result) {
          $('#time_day_row').html(result);
        }
      });
    }

    function validateForm() {
      var count = 0;
      var pname = $("input[name='full_name']").val();
      var age = $("input[name='age']").val();
      var address = $("input[name='address']").val();
      var email = $("input[name='email']").val();
      var phone = $("input[name='phone']").val();
      var date = $("input[name='date']").val();
      var reason = $("textarea[name='reason']").val();
      var doc = $("select[name='doctor_id']").val();
      var dept = $("select[name='dept']").val();

      if (pname == "") {
        document.getElementById("para-pname").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-pname").innerHTML = "";
      }

      if (age == "") {
        document.getElementById("para-age").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-age").innerHTML = "";
      }

      if (address == "") {
        document.getElementById("para-address").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-address").innerHTML = "";
      }

      if (email == "") {
        document.getElementById("para-email").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-email").innerHTML = "";
      }

      if (phone == "") {
        document.getElementById("para-phone").innerHTML = "This field is required";
        count++;
      } else if (isNaN(phone)) {
        document.getElementById("para-phone").innerHTML = "Invalid Number";
        count++;
      } else {
        document.getElementById("para-phone").innerHTML = "";
      }

      if (reason == "") {
        document.getElementById("para-reason").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-reason").innerHTML = "";
      }

      if (date == "") {
        document.getElementById("para-date").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-date").innerHTML = "";
      }

      // if (date < "<?php //echo $todays_date; 
                      ?>") {
      //   document.getElementById("para-date").innerHTML = "Invalid Date";
      //   count++;
      // } else {
      //   document.getElementById("para-date").innerHTML = "";
      // }

      if (doc == "default") {
        document.getElementById("para-doc").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-doc").innerHTML = "";
      }

      if (dept == "default") {
        document.getElementById("para-dept").innerHTML = "This field is required";
        count++;
      } else {
        document.getElementById("para-dept").innerHTML = "";
      }

      // if (date != "") {
      //   var time = $("select[name='appointment_time']").val();
      //   if (time == "") {
      //     document.getElementById("para-time").innerHTML = "This field is required";
      //     count++;
      //     return false;
      //   } else {
      //     document.getElementById("para-time").innerHTML = "";
      //   }
      // }

      if (count != 0) {
        return false;
      }
    }
  </script>

  <script src="admin/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>