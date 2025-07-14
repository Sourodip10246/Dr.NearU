<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>Document</title>
</head>

<body>
    <?php
    require_once "../layout/header.php";
    require_once "../../config/db.php";
    require_once "../../controllers/AppointmentController.php";

    $controller = new AppointmentController($pdo);

    if (isset($_POST['submit'])) {
        $data = [
            'patient_name' => $_POST['patient_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'doctor_id' => $_POST['doctor_id'],
            'appointment_date' => $_POST['appointment_date'],
            'time_slot' => $_POST['time_slot'],
            'reason' => $_POST['reason'],
            'status' => ""
        ];


        $isAppointmentExist = $controller->isExist($data);
        if (!$isAppointmentExist) {
            $data['status'] = 'confirmed';
            $controller->add($data);
    ?>
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="card shadow-lg border-0 rounded-4">
                            <!-- Green header bar -->
                            <div class="w-100 rounded-top-4" style="height:12px; background-color:#28a745;"></div>

                            <div class="card-body p-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success bg-opacity-25 rounded-circle d-flex justify-content-center align-items-center me-3" style="width:60px; height:60px;">
                                        <i class="bi bi-check-circle-fill text-success" style="font-size:2rem;"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-success fw-bold mb-0">Appointment Confirmed</h3>
                                        <small class="text-muted">Your booking receipt</small>
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <div class="fs-5">
                                    <div class="mb-2"><strong>Patient Name:</strong> <?= htmlspecialchars($data['patient_name']) ?></div>
                                    <div class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></div>
                                    <div class="mb-2"><strong>Phone:</strong> <?= htmlspecialchars($data['phone']) ?></div>
                                    <!-- <div class="mb-2"><strong>Doctor:</strong> </div> -->
                                    <div class="mb-2"><strong>Date:</strong> <?= htmlspecialchars($data['appointment_date']) ?></div>
                                    <div class="mb-2"><strong>Time Slot:</strong> <?= htmlspecialchars($data['time_slot']) ?></div>
                                    <div class="mb-0"><strong>Reason:</strong> <?= htmlspecialchars($data['reason']) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="card shadow-lg border-0 rounded-4">
                            <!-- Red header bar -->
                            <div class="w-100 rounded-top-4" style="height:12px; background-color:#dc3545;"></div>

                            <div class="card-body p-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-danger bg-opacity-25 rounded-circle d-flex justify-content-center align-items-center me-3" style="width:60px; height:60px;">
                                        <i class="bi bi-x-octagon-fill text-danger" style="font-size:2rem;"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-danger fw-bold mb-0">Slot Already Booked</h3>
                                        <small class="text-muted">Please choose another time</small>
                                    </div>
                                </div>

                                <p class="fs-5 mb-0 text-secondary">
                                    The selected date and time slot is already reserved. Kindly go back and choose a different available slot to proceed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="container my-4">
            <div class="alert alert-warning">Invalid request.</div>
        </div>
    <?php
    }

    ?>


    <?php require_once "../layout/footer.php"; ?>
    <!-- Bootstrap 5 JS bundle (for collapse, modal, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>