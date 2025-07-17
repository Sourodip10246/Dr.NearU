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
        require_once "../../controllers/SpecializationController.php";

        $controller = new DoctorController($pdo);
        $controller2 = new SpecializationController($pdo);
        $specializations = $controller2->index();

        ?>

        <!-- Main Content -->
        <div id="main-content">
            <h1 class="mb-4">
                <?php if (isset($_GET['id'])) { ?>Update Doctor<?php } else { ?>Add New Doctor<?php } ?>
            </h1>

            <form action="" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">

                <div class="mb-3">
                    <label for="name" class="form-label">Doctor Name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                        <?php if (isset($_GET['id']) && isset($_GET['name'])) { ?> value="<?= $_GET['name'] ?>" <?php } ?>>
                </div>

                <div class="mb-3">
                    <label for="specialization" class="form-label">Specialization:</label>
                    <select class="form-select" id="specialization" name="specialization_id">
                        <option value="">-- Select Specialization --</option>
                        <?php foreach ($specializations as $spec) { ?>
                            <option value="<?= $spec['id'] ?>"
                                <?php if (isset($_GET['specialization_id']) && $_GET['specialization_id'] == $spec['id']) echo "selected"; ?>>
                                <?= $spec['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Doctor Image:</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="mb-3">
                    <label class="form-label">Available Days:</label><br>
                    <?php
                    $days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
                    $selectedDays = isset($_GET['available_days']) ? explode(',', $_GET['available_days']) : [];

                    foreach ($days as $day) {
                        $checked = in_array($day, $selectedDays) ? "checked" : "";
                        echo "<div class='form-check form-check-inline'>
                        <input class='form-check-input' type='checkbox' name='available_days[]' value='$day' $checked>
                        <label class='form-check-label'>$day</label>
                      </div>";
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time:</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"
                        <?php if (isset($_GET['start_time'])) { ?> value="<?= $_GET['start_time'] ?>" <?php } ?>>
                </div>

                <div class="mb-3">
                    <label for="end_time" class="form-label">End Time:</label>
                    <input type="time" class="form-control" id="end_time" name="end_time"
                        <?php if (isset($_GET['end_time'])) { ?> value="<?= $_GET['end_time'] ?>" <?php } ?>>
                </div>

                <div class="mb-3">
                    <label for="slot_duration" class="form-label">Slot Duration (minutes):</label>
                    <input type="number" class="form-control" id="slot_duration" name="slot_duration" min="5"
                        value="<?= isset($_GET['slot_duration']) ? $_GET['slot_duration'] : 15 ?>">
                </div>

                <?php
                if (isset($_POST['submit'])) {
                    $name = $_POST['name'];
                    $specialization_id = $_POST['specialization_id'];
                    $available_days = isset($_POST['available_days']) ? implode(',', $_POST['available_days']) : '';
                    $start_time = $_POST['start_time'];
                    $end_time = $_POST['end_time'];
                    $slot_duration = $_POST['slot_duration'];
                    $imagePath = '';

                    // Handle image upload
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                        $uploadDir = '../../assets/images/';
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                        $filename = time() . '_' . basename($_FILES['image']['name']);
                        $targetFile = $uploadDir . $filename;

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                            $imagePath = 'assets/images/' . $filename;
                        } else {
                            echo "<p class='text-danger text-center'>*Image upload failed.</p>";
                        }
                    }

                    if (!empty($name) && !empty($specialization_id) && !empty($available_days) && $start_time && $end_time) {
                        if (isset($_GET['id'])) {
                            $imageToSave = !empty($imagePath) ? $filename : $_GET['image'];
                            $controller->updateDoc($_GET['id'], $name, $specialization_id, $imageToSave, $available_days, $start_time, $end_time, $slot_duration);
                        } else {
                            $controller->addDoc($name, $specialization_id, $filename, $available_days, $start_time, $end_time, $slot_duration);
                        }
                        echo "<script>window.location.href = 'doctorManager.php';</script>";
                        exit();
                    } else {
                        echo "<p class='text-danger text-center'>*All required fields must be filled.</p>";
                    }
                }
                ?>

                <div class="text-center">
                    <button type="submit" name="submit" value="submit" class="btn btn-success px-4">
                        <?php if (isset($_GET['id'])) { ?>Update<?php } else { ?>Add Doctor<?php } ?>
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