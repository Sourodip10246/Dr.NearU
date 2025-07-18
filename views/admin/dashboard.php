<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/sideBar.css">
    <title>Document</title>
</head>

<body>

    <?php require_once "../layout/header.php" ?>
    <div class="d-flex">
        <?php
        require_once "../layout/sidebar.php";
        require_once "../../config/db.php";
        require_once "../../controllers/DoctorController.php";
        require_once "../../controllers/SpecializationController.php";
        require_once "../../controllers/AppointmentController.php";

        $docController = new DoctorController($pdo);
        $speController = new SpecializationController($pdo);
        $appointController = new AppointmentController($pdo);
        ?>

        <!-- Main Content -->
        <div id="main-content">
            <h1 class="mb-4">Welcome <?= $_SESSION['userName'] ?></h1>

            <!-- Dashboard Summary Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                        <h5>Total Doctors</h5>
                        <h2 class="text-primary"><?= $docController->countDoctors() ?></h2> <!-- Replace with PHP -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                        <h5>Total Specializations</h5>
                        <h2 class="text-success"><?= $speController->countSpe() ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                        <h5>Total Appointments</h5>
                        <h2 class="text-warning"><?= $appointController->getTotalCount() ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-4">
                        <h5>Total Patients</h5>
                        <h2 class="text-danger"><?= $appointController->getPatientCount() ?></h2>
                    </div>
                </div>
            </div>

            <!-- Appointment Chart + Recent Appointments -->
            <div class="row g-4">
                <!-- Chart -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Appointments Overview</h5>

                            <!-- Dropdown -->
                            <div class="mb-3 text-end dropdown">
                                <label class="form-label me-2 fw-semibold">Select Range:</label>
                                <?php
                                $rangeOptions = [
                                    'this_week' => 'This Week',
                                    'last_week' => 'Last Week',
                                    'this_month' => 'This Month',
                                    'last_month' => 'Last Month',
                                    'this_year' => 'This Year',
                                    'last_year' => 'Last Year'
                                ];

                                $selectedRange = $_GET['range'] ?? 'this_week'; // default to this_week
                                $selectedText = $rangeOptions[$selectedRange] ?? 'This Week';

                                $data = $appointController->getAppointmentsChartData($selectedRange);
                                // echo "<pre>";
                                // echo $data;
                                // echo "</pre>";
                                ?>

                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="rangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= htmlspecialchars($selectedText) ?>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="rangeDropdown">
                                    <li><a class="dropdown-item" href="dashboard.php?range=this_week">This Week</a></li>
                                    <li><a class="dropdown-item" href="dashboard.php?range=last_week">Last Week</a></li>
                                    <li><a class="dropdown-item" href="dashboard.php?range=this_month">This Month</a></li>
                                    <li><a class="dropdown-item" href="dashboard.php?range=last_month">Last Month</a></li>
                                    <li><a class="dropdown-item" href="dashboard.php?range=this_year">This Year</a></li>
                                    <li><a class="dropdown-item" href="dashboard.php?range=last_year">Last Year</a></li>

                                </ul>
                            </div>
                        </div>

                        <!-- Chart Canvas -->
                        <canvas id="appointmentsChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>


                <!-- Recent Appointments -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="mb-3">Recent Appointments</h5>
                        <ul class="list-group list-group-flush">
                            <?php
                            $recentsAppointments = $appointController->getRecentAppointments();
                            if (!empty($recentsAppointments)) {
                                foreach ($recentsAppointments as $appointment) {
                                    $status = strtolower($appointment['status']); // Convert to lowercase for consistency

                                    switch ($status) {
                                        case 'confirmed':
                                            $badgeClass = 'bg-success';
                                            break;
                                        case 'pending':
                                            $badgeClass = 'bg-warning text-dark';
                                            break;
                                        case 'cancelled':
                                        case 'canceled': // in case you use either spelling
                                            $badgeClass = 'bg-danger';
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary';
                                    }
                            ?>
                                    <li class="list-group-item"><?= $appointment['patient_name'] ?> with <?= $appointment['doctor_name'] ?><br><span class="badge <?= $badgeClass ?>"><?= ucfirst($appointment['status']) ?></span></li>
                                <?php
                                }
                            } else {
                                ?>
                                <li class="list-group-item">No Recent Appointments</li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>


        </div>



    </div>

    <?php require_once "../layout/footer.php" ?>
    <!-- Bootstrap 5 JS bundle (for collapse, modal, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
    <!-- <?php
    // $data2 = json_encode([
    //     "labels" => ["2025-07-14", "2025-07-15", "2025-07-16", "2025-07-17", "2025-07-18", "2025-07-19", "2025-07-20"],
    //     "data" => [0, 0, 0, 0, 5, 0, 0]
    // ]);
    ?> -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = <?= $data ?>;

        const ctx = document.getElementById('appointmentsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Appointments',
                    data: chartData.data,
                    backgroundColor: '#0d6efd',
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>