<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />

    <title>Your Page • Dr.NearU</title>
</head>

<body>
    <?php require_once "../layout/header.php";
    require_once __DIR__ . '/../../config/db.php';
    require_once __DIR__ . '/../../controllers/SpecializationController.php';
    require_once __DIR__ . '/../../controllers/DoctorController.php';

    $controller2   = new SpecializationController($pdo);
    $specializations = $controller2->index();

    $controller  = new DoctorController($pdo);

    // echo var_dump(isset($_GET['q']));
    // echo var_dump(!empty($_GET['q']));
    // echo var_dump(isset($_GET['specialization']));
    // echo var_dump(!empty($_GET['specialization']));

    if ((isset($_GET['q']) and !empty($_GET['q'])) or (isset($_GET['specialization']) and !empty($_GET['specialization']))) {
        $doctors = $controller->filterDoc($_GET['q'], $_GET['specialization']);
    } else {
        $doctors = $controller->index();
    }
    ?>

    <main class="py-5">
        <div class="container">
            <!-- Search & Filter Bar -->
            <form class="row justify-content-center align-items-center g-2 mb-4" method="get" action="">
                <div class="col-12 col-sm-6 col-lg-4">
                    <input type="search" name="q" id="searchInput" class="form-control form-control-lg" placeholder="Search doctors…" />
                </div>
                <div class="col-auto">
                    <select name="specialization" id="filterSelect" class="form-select form-select-lg">
                        <option value="">All Specializations</option>
                        <?php foreach ($specializations as $sp): ?>
                            <option value="<?= $sp['id']; ?>" <?= isset($_GET['specialization']) && $_GET['specialization'] == $sp['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($sp['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-lg">Search</button>
                </div>
            </form>

            <!-- Doctor Cards -->
            <div class="row g-4">
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doc): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="row g-0 h-100">
                                    <div class="col-4 d-flex align-items-center">
                                        <img src="../../assets/images/<?= !empty($doc['image']) ? htmlspecialchars($doc['image']) : 'doctor.png' ?>"
                                            class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="Doctor" />
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title mb-1"><?= htmlspecialchars($doc['name']) ?></h5>
                                            <p class="card-text text-muted small mb-0"><?= htmlspecialchars($doc['sp_name']) ?></p>
                                            <a href="../appointment/appointmemt.php?id=<?= urlencode($doc['id']) ?>&specialization=<?= urlencode($doc['specialization_id']) ?>" class="btn btn-primary btn-sm w-100 mt-2">
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <h4 class="fw-semibold">No doctors found</h4>
                        <p class="text-muted">Try a different search or filter.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php require_once "../layout/footer.php"; ?>

    <!-- Bootstrap 5 JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>