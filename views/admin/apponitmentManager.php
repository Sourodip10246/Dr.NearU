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
        <?php require_once "../layout/sidebar.php" ?>

        <!-- Main Content -->
        <?php
        require_once "../../config/db.php";
        require_once "../../controllers/AppointmentController.php";
        $controller = new AppointmentController($pdo);

        // Handle status update
        if (isset($_POST['update_status'])) {
            $controller->changeStatus($_POST['appointment_id'], $_POST['status']);
        }

        if (isset($_POST['delete_appointment']) && isset($_POST['appointment_id'])) {
            $controller->delete($_POST['appointment_id']);
        }

        // Pagination
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalAppointments = $controller->getTotalCount();
        $totalPages = ceil($totalAppointments / $limit);

        $appointments = $controller->getAppointments($limit, $offset);
        ?>

        <div id="main-content">
            <h1 class="mb-4">Welcome <?= $_SESSION['userName'] ?></h1>
            <h3 class="mb-3">Appointment Manager</h3>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Patient</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $app) { ?>
                            <tr>
                                <td><?= $app['id'] ?></td>
                                <td><?= htmlspecialchars($app['patient_name']) ?></td>
                                <td><?= htmlspecialchars($app['email']) ?></td>
                                <td><?= htmlspecialchars($app['phone']) ?></td>
                                <td><?= htmlspecialchars($app['doctor_name']) ?></td>
                                <td><?= $app['appointment_date'] ?></td>
                                <td><?= date('H:i', strtotime($app['time_slot'])) ?></td>
                                <td>
                                    <span class="badge 
            <?php
                            if ($app['status'] == 'confirmed') echo 'bg-success';
                            elseif ($app['status'] == 'cancelled') echo 'bg-danger';
                            else echo 'bg-warning text-dark';
            ?>">
                                        <?= ucfirst($app['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" class="d-flex gap-1 align-items-center">
                                        <input type="hidden" name="appointment_id" value="<?= $app['id'] ?>">

                                        <!-- Status Update -->
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" <?= $app['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="confirmed" <?= $app['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                            <option value="cancelled" <?= $app['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>

                                        <button type="submit" name="update_status" class="btn btn-primary btn-sm">Save</button>

                                        <!-- Delete Button -->
                                        <button type="submit" name="delete_appointment" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this appointment?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-4">
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
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
</body>

</html>