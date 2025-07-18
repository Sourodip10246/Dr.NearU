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
        <?php require_once "../layout/sidebar.php";
        require_once "../../config/db.php";
        require_once "../../controllers/DoctorController.php";

        $controller = new DoctorController($pdo);
        $doctors = $controller->index();

        ?>

        <!-- Main Content -->
        <div id="main-content">
            <h1 class="mb-4">Welcome <?= $_SESSION['userName'] ?></h1>

            <h3 class="mb-3">Doctor Manager</h3>
            <a href="addDoctor.php" class="btn btn-primary mb-3">Add Doctor</a>

            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Image</th>
                        <th>Available Days</th>
                        <th>Time</th>
                        <th>Slot (mins)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Row 1 -->
                    <?php
                    if (!empty($doctors)):
                        foreach ($doctors as $doc):
                    ?>
                            <tr>
                                <td><?= $doc['id'] ?></td>
                                <td><?= $doc['name'] ?></td>
                                <td><?= $doc['sp_name'] ?></td>
                                <td><img src="../../assets/images/<?= $doc['image'] ?>" width="50" height="50" alt="Doctor"></td>
                                <td><?= $doc['available_days'] ?></td>
                                <td><?= date("H:i", strtotime($doc['start_time'])) ?>-<?= date("H:i", strtotime($doc['end_time'])) ?></td>
                                <td><?= $doc['slot_duration'] ?></td>
                                <td>
                                    <a href="addDoctor.php?id=<?= $doc['id'] ?>&name=<?= urlencode($doc['name']) ?>&specialization_id=<?= $doc['specialization_id'] ?>&available_days=<?= urlencode($doc['available_days']) ?>&start_time=<?= $doc['start_time'] ?>&end_time=<?= $doc['end_time'] ?>&slot_duration=<?= $doc['slot_duration'] ?>&image=<?= urlencode($doc['image']) ?>"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <a href="deleteDoctor.php?id=<?= $doc['id'] ?>&image=<?= urlencode($doc['image']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</a>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <strong>No doctor found.</strong>
                            </td>
                        </tr>

                    <?php
                    endif;
                    ?>
                </tbody>
            </table>
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