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
        require_once "../../controllers/AdminController.php";

        $controller = new AdminController($pdo);

        $admins = $controller->getAll();

        ?>

        <!-- Main Content -->
        <!-- Main Content -->
        <div id="main-content">
            <h1 class="mb-4">Welcome <?= $_SESSION['userName'] ?></h1>

            <h3 class="mb-3">Admin Manager</h3>

            <!-- Add Admin Button (now links to addAdmin.php) -->
            <div class="mb-3">
                <a href="addAdmin.php" class="btn btn-primary">Add Admin</a>
            </div>

            <!-- Admins Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Username</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($admins)) {
                            foreach ($admins as $admin) {
                                // echo $admin['username'];
                        ?>
                                <tr>
                                    <td><?php echo $admin['id']; ?></td>
                                    <td><?php echo $admin['username']; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning me-1"
                                        href="addAdmin.php?id=<?= $admin['id'] ?>&name=<?=$admin['username']?> ">Edit</a>

                                        <a href="deleteAdmin.php?id=<?= $admin['id'] ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">No admins found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
</body>

</html>