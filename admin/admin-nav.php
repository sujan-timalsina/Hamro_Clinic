<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    $nav_con = mysqli_connect("localhost", "root", "", "hcc_db") or die("Unable to connect" . mysqli_connect_error() . "<br>");
    $which_ad = "SELECT * FROM admin WHERE email='{$_SESSION['email']}'";
    $ad_res = mysqli_query($nav_con, $which_ad);
    $one_row1 = mysqli_fetch_assoc($ad_res);
    $role = $one_row1['role'];
    ?>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <div class="logo_name">
                    Hamro Clinic
                </div>
            </div>
            <i class="fa fa-bars" id="btn-ham"></i>
        </div>
        <?php
        if ($role == "admin") {
        ?>
            <ul class="sidebar-menu">
                <li>
                    <a href="admin-dashboard.php" data-text="Dashboard">
                        <i class="fas fa-th-large"></i>
                        <span class="links_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin-profile.php" data-text="Admin Profile">
                        <i class="far fa-address-card"></i>
                        <span class="links_name">Admin Profile</span>
                    </a>
                </li>
                <li>
                    <a href="admin-labreport.php" data-text="Upload Lab Report">
                        <i class="fas fa-file-upload"></i>
                        <span class="links_name">Upload Lab Report</span>
                    </a>
                </li>
                <li>
                    <a href="admin-doctors.php" data-text="Doctors">
                        <i class="fas fa-stethoscope"></i>
                        <span class="links_name">Doctors</span>
                    </a>
                </li>
                <li>
                    <a href="admin-department.php" data-text="Manage Department">
                        <i class="fas fa-building"></i>
                        <span class="links_name">Manage Department</span>
                    </a>
                </li>
                <li>
                    <a href="admin-manage.php" data-text="Manage User">
                        <i class="fas fa-users"></i>
                        <span class="links_name">Manage User</span>
                    </a>
                </li>
                <li>
                    <a href="admin-patient.php" data-text="Patients">
                        <i class="fas fa-user-injured"></i>
                        <span class="links_name">Patients</span>
                    </a>
                </li>
                <li>
                    <a href="admin-contact.php" data-text="Contact">
                        <i class="fas fa-comment-dots"></i>
                        <span class="links_name">Contact</span>
                    </a>
                </li>
                <li>
                    <a href="admin-Faqs.php" data-text="FAQ's">
                        <i class="fas fa-question"></i>
                        <span class="links_name">FAQ's</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php?logout='1'" data-text="Log out">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="links_name">Log out</span>
                    </a>
                </li>
            </ul>
        <?php
        } else if ($role == "lab_admin") {
        ?>
            <ul class="sidebar-menu">
                <li>
                    <a href="admin-dashboard.php" data-text="Dashboard">
                        <i class="fas fa-th-large"></i>
                        <span class="links_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin-profile.php" data-text="Admin Profile">
                        <i class="far fa-address-card"></i>
                        <span class="links_name">Admin Profile</span>
                    </a>
                </li>
                <li>
                    <a href="admin-labreport.php" data-text="Upload Lab Report">
                        <i class="fas fa-file-upload"></i>
                        <span class="links_name">Upload Lab Report</span>
                    </a>
                </li>
                <li>
                    <a href="admin-patient.php" data-text="Patients">
                        <i class="fas fa-user-injured"></i>
                        <span class="links_name">Patients</span>
                    </a>
                </li>
                <li>
                    <a href="admin-dashboard.php?logout='1'" data-text="Log out">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="links_name">Log out</span>
                    </a>
                </li>
            </ul>
        <?php
        }
        mysqli_close($nav_con);
        ?>
    </div>

    <script>
        let btn = document.querySelector("#btn-ham");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>
</body>

</html>