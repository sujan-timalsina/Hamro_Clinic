<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <div class="logo_name">
                    Hamro Clinic
                </div>
            </div>
            <i class="fa fa-bars" id="btn-ham"></i>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="doctor-dashboard.php" data-text="Dashboard">
                    <i class="fas fa-th-large"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="doctor-profile.php" data-text="Doctor Profile">
                    <i class="far fa-address-card"></i>
                    <span class="links_name">Doctor Profile</span>
                </a>
            </li>
            <li>
                <a href="doctor-schedule.php" data-text="Schedule">
                    <i class="fas fa-clock"></i>
                    <span class="links_name">Manage Schedule</span>
                </a>
            </li>
            <li>
                <a href="doctor-appointment.php" data-text="Appointment">
                    <i class="fas fa-calendar-check"></i>
                    <span class="links_name">Appointments</span>
                </a>
            </li>
            <li>
                <a href="doctor-patient.php" data-text="Patient Details">
                    <i class="fas fa-user-injured"></i>
                    <span class="links_name">Patient Details</span>
                </a>
            </li>
            <li>
                <a href="doctor-dashboard.php?logout='1'" data-text="Log out">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
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