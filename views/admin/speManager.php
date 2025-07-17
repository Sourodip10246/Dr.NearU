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
        require_once "../../controllers/SpecializationController.php";

        $controller = new SpecializationController($pdo);
        $specializations = $controller->index();
        ?>

        <!-- Main Content -->
        <div id="main-content">
            <h1 class="mb-4">Welcome <?= $_SESSION['userName'] ?></h1>

            <h3 class="mb-3">Specialization Manager</h3>
            <a href="addSpe.php" class="btn btn-primary mb-3">Add Specialization</a>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Icon</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($specializations)) {
                        foreach ($specializations as $spe) {
                    ?>
                            <tr>
                                <td><?= $spe['id'] ?></td>
                                <td><?= $spe['name'] ?></td>
                                <td><img src="../../assets/images/<?= $spe['icon'] ?>" alt="Cardiology Icon" width="40"></td>
                                <td class="text-center">
                                    <a href="addSpe.php?id=<?= $spe['id'] ?>&name=<?= $spe['name'] ?>&icon=<?= $spe['icon'] ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                                    <a href="deleteSpe.php?id=<?= $spe['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this specialization?');">
                                        Delete
                                    </a>

                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <strong>No Specialization found.</strong>
                            </td>
                        </tr>

                    <?php
                    }
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