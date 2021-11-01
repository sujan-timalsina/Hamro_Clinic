<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <!-- navbar section -->
    <nav class="navbar navbar-expand-lg p-0">
        <a class="navbar-brand py-0" href="home.php">
            <span id="logo-name" class="ml-3">Hamro Clinic</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">&Xi;</span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item mx-2">
                    <a class="nav-link<?php if ($page == 'home') {
                                            echo ' active';
                                        } ?>" href="home.php">Home</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link<?php if ($page == 'lab') {
                                            echo ' active';
                                        } ?>" href="labreport.php">Lab Report</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link<?php if ($page == 'doctor') {
                                            echo ' active';
                                        } ?>" href="doctors.php">Doctors</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link<?php if ($page == 'contact') {
                                            echo ' active';
                                        } ?>" href="contact.php">Contact us</a>
                </li>
            </ul>

        </div>
    </nav>
    <hr>
    <!-- navbar section ends -->
</body>

</html>