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
        <div id="main-content">
            <h1 class="mb-4">Welcome <?= $_SESSION['userName'] ?></h1>

            <div class="alert alert-warning border-warning-subtle rounded-4 shadow-sm d-flex align-items-center p-4" role="alert">
                <div class="flex-shrink-0 me-4">
                    <img src="../../assets/images/construction.png" alt="Under Construction" width="240" height="160">
                </div>
                <div>
                    <h4 class="alert-heading mb-2">Manage Appointments</h4>
                    <p class="mb-0 text-secondary">
                        This page is currently <strong>under construction</strong>.<br>
                        We're working diligently to bring this feature to life. Please check back again soon.
                    </p>
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
</body>

</html>