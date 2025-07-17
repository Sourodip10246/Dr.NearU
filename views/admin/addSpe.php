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
        ?>

        <!-- Main Content -->
        <div id="main-content">
            <h1 class="mb-4">
                <?php if (isset($_GET['id'])) { ?>Update Specialization<?php } else { ?>Add New Specialization<?php } ?>
            </h1>

            <!-- IMPORTANT: enctype added -->
            <form action="" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
                <div class="mb-3">
                    <label for="name" class="form-label">Specialization Name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                        <?php if (isset($_GET['id']) && isset($_GET['name'])) { ?> value="<?= $_GET['name'] ?>" <?php } ?>>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label">Icon Image:</label>
                    <input type="file" class="form-control" id="icon" name="icon">
                </div>

                <?php
                if (isset($_POST['submit'])) {
                    $name = $_POST['name'];
                    $iconPath = '';

                    // Handle image upload
                    if (isset($_FILES['icon']) && $_FILES['icon']['error'] === 0) {
                        $uploadDir = '../../assets/images/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $filename = time() . '_' . basename($_FILES['icon']['name']);
                        $targetFile = $uploadDir . $filename;

                        if (move_uploaded_file($_FILES['icon']['tmp_name'], $targetFile)) {
                            $iconPath = $targetFile;
                        } else {
                            echo '<p class="text-danger text-center mt-2"><strong>*Image upload failed.</strong></p>';
                        }
                    }

                    if (isset($_GET['id'])) {
                        // UPDATE logic
                        if (!empty($name)) {
                            $iconToSave = !empty($iconPath) ? $iconPath : $_GET['icon']; // keep old if not changed
                            $controller->updateSpe($_GET['id'], $name, $iconToSave);
                            echo "<script>window.location.href = 'speManager.php';</script>";
                            exit();
                        } else {
                            echo '<p class="text-danger text-center mt-2"><strong>*Name cannot be empty.</strong></p>';
                        }
                    } else {
                        // INSERT logic
                        if (!empty($name) && !empty($iconPath)) {
                            $controller->addNewSpe($name, $iconPath);
                            echo "<script>window.location.href = 'speManager.php';</script>";
                            exit();
                        } else {
                            echo '<p class="text-danger text-center mt-2"><strong>*All fields are required.</strong></p>';
                        }
                    }
                }
                ?>

                <div class="text-center">
                    <button type="submit" name="submit" value="submit" class="btn btn-success px-4">
                        <?php if (isset($_GET['id'])) { ?>Update<?php } else { ?>Add<?php } ?>
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