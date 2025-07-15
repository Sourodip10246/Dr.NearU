<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <title>Document</title>
</head>

<body>

    <?php require_once "../layout/header.php" ?>

    <!-- Login form -->
    <section class="d-flex align-items-center justify-content-center py-5">
        <div class="card shadow-sm" style="max-width: 420px; width: 100%;">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 fw-semibold">Admin Login</h2>

                <!-- Flash message (optional) -->
                <?php if (!empty($_SESSION['login_error'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['login_error']);
                        unset($_SESSION['login_error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            required
                            autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            required>
                    </div>

                    <?php
                    require_once "../../config/db.php";
                    require_once __DIR__ . "/../../controllers/AdminController.php";

                    $controller = new AdminController($pdo);

                    if (isset($_POST['submit'])) {
                        $name = $_POST['username'];
                        $password = $_POST['password'];

                        if (empty($name) or empty($password)) {
                            echo '<p class="text-danger mt-2 text-center">
                                        <strong>Validation error:</strong> All fields are required.
                                    </p>';
                        } else {
                            $admin = $controller->login($name, $password);

                            if ($admin) {
                                $_SESSION['userName'] = $name;
                                header("Location: ../admin/dashboard.php");
                                exit();
                            } else {
                                echo '<p class="text-danger mt-2 text-center">
                                        <strong>Login failed:</strong> Wrong username or password.
                                    </p>';
                            }
                        }
                    }
                    ?>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </section>




    <?php require_once "../layout/footer.php" ?>
    <!-- Bootstrap 5 JS bundle (for collapse, modal, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>