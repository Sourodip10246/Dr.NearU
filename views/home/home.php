<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />

    <title>Dr.NearU</title>
</head>

<body>
    <?php
    require_once __DIR__ . '/../layout/header.php';
    require_once __DIR__ . '/../../config/db.php';
    require_once __DIR__ . '/../../controllers/SpecializationController.php';
    require_once __DIR__ . '/../../controllers/DoctorController.php';

    $controller2   = new SpecializationController($pdo);
    $specializations = $controller2->index();

    $controller  = new DoctorController($pdo);
    $doctors     = $controller->index();
    ?>

    <!-- ===== Hero / Landing ===== -->
    <section class="py-5 text-center bg-light">
        <div class="container">
            <h1 class="display-5 fw-bold">Welcome to Dr.NearU</h1>
            <p class="lead mb-4">Your Health, Our Priority — Just a Click Away.</p>
            <a href="../appointment/appointmemt.php" class="btn btn-primary btn-lg">
                Book Appointment
            </a>
        </div>
    </section>

    <!-- ===== Categories ===== -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Categories</h2>

            <div class="row g-4 justify-content-center">
                <?php foreach ($specializations as $spe): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0">
                            <a href="../doctors/allDoctors.php?q=&specialization=<?= $spe['id'] ?>" class="stretched-link"></a>
                            <div class="card-body">
                                <img
                                    src="../../assets/images/<?= $spe['icon'] ?>"
                                    class="img-fluid mb-2"
                                    style="width: 72px; height: 72px; object-fit: contain"
                                    alt="icon" />
                                <p class="fw-semibold mb-0"><?= $spe['name'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===== Doctors ===== -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Doctors</h2>

            <div class="row g-4">
                <?php foreach ($doctors as $doc): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="row g-0 h-100">
                                <div class="col-4 d-flex align-items-center">
                                    <img
                                        src="../../assets/images/<?= !empty($doc['image']) ? htmlspecialchars($doc['image']) : 'doctor.png' ?>"
                                        class="img-fluid rounded-start w-100 h-100 object-fit-cover"
                                        alt="Doctor" />
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($doc['name']) ?></h5>
                                        <p class="card-text text-muted small mb-0"><?= $doc['sp_name'] ?></p>
                                        <a href="../appointment/appointmemt.php?id=<?= urlencode($doc['id']) ?>&specialization=<?= urlencode($doc['specialization_id']) ?>"
                                            class="btn btn-primary btn-sm w-100 mt-2">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="../doctors/allDoctors.php" class="btn btn-outline-primary">
                    See All Doctors
                </a>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../layout/footer.php'; ?>

    <!-- Bootstrap 5 JS bundle (for collapse, modal, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>