<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // echo $_SESSION['username'];
}
?>

<header class="sticky-top bg-white shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">

            <!-- Brand / Logo -->
            <a class="navbar-brand fw-bold text-primary" href="../home/home.php">
                Dr.NearU
            </a>

            <!-- Mobile toggler -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav"
                aria-controls="mainNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-dark px-2 link-primary link-underline-opacity-0 link-underline-opacity-75-hover" href="../home/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark px-2 link-primary link-underline-opacity-0 link-underline-opacity-75-hover" href="../doctors/allDoctors.php">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark px-2 link-primary link-underline-opacity-0 link-underline-opacity-75-hover" href="../appointment/appointmemt.php">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark px-2 link-primary link-underline-opacity-0 link-underline-opacity-75-hover" href="#contact">Contact</a>
                    </li>
                </ul>

                <?php if (isset($_SESSION['userName']) && !empty($_SESSION['userName'])) { ?>
                    <a href="../admin/dashboard.php" 
                        class="btn btn-outline-primary ms-lg-3 px-4">
                        Dashboard
                    </a>
                <?php } else { ?>
                    <a href="../auth/login.php"
                        class="btn btn-outline-primary ms-lg-3 px-4">
                        Login
                    </a>
                <?php } ?>
            </div>

        </div>
    </nav>
</header>