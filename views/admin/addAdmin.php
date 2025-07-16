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
        ?>

        <div id="main-content">
            <h1 class="mb-4">Add New Admin</h1>

            <form action="" method="POST" class="w-50 mx-auto">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username"
                        <?php if (isset($_GET['id'])) { ?> value="<?= $_GET['name'] ?>" <?php } ?>>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>

                <?php
                if (isset($_POST['submit'])) {

                    // echo $_POST;
                    $username = $_POST['username'];
                    $pass = $_POST['password'];
                    $confirmPass = $_POST['confirm_password'];

                    if (isset($_GET['id']) and isset($_GET['name'])) {
                        if (!empty($username)) {
                            $controller->updateAdmin($_GET['id'], $username, $pass);
                            echo "<script>window.location.href = 'adminManager.php';</script>";
                            exit();
                        } else {
                ?>
                            <p class="text-danger text-center mt-2">
                                <strong>*Username can't be empty.</strong>
                            </p>

                            <?php
                        }
                    } else {

                        if (!empty($username) and !empty($pass) and !empty($confirmPass)) {
                            if ($pass === $confirmPass) {
                                $controller->addNewAdmin($username, $pass);
                                echo "<script>window.location.href = 'adminManager.php';</script>";
                                exit();
                            } else {
                            ?>
                                <p class="text-danger text-center mt-2">
                                    <strong>*Password mismatch.</strong> Please verify your entries.
                                </p>

                            <?php
                            }
                        } else {
                            ?>
                            <p class="text-danger text-center mt-2">
                                <strong>*Fields can't be empty.</strong>
                            </p>

                <?php
                        }
                    }
                }
                ?>

                <div class="text-center">
                    <button type="submit" name="submit" value="submit" class="btn btn-success px-4">
                        <?php if (isset($_GET['id'])) { ?>Update<?php } else { ?>Add Admin<?php } ?>

                    </button>
                </div>
            </form>
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