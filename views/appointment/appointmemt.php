<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />

    <title>Book Appointment • Dr.NearU</title>
</head>

<body>
    <?php
    require_once "../layout/header.php";
    require_once "../../config/db.php";
    require_once __DIR__ . '/../../controllers/SpecializationController.php';
    require_once "../../controllers/DoctorController.php";

    $controller2   = new SpecializationController($pdo);
    $specializations = $controller2->index();

    $controller  = new DoctorController($pdo);
    $doctors     = $controller->index();

    ?>

    <!-- ===== Appointment Form ===== -->
    <section class="py-5 bg-light">
        <div class="container" style="max-width: 640px">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="h4 text-center mb-4">Book an Appointment</h2>

                    <form method="post" class="row g-3" action="appointmentCheck.php">
                        <!-- Patient Name -->
                        <div class="col-12">
                            <label for="patient_name" class="form-label">Patient Name</label>
                            <input
                                type="text"
                                id="patient_name"
                                name="patient_name"
                                class="form-control"
                                required />
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Email <small class="text-muted">(optional)</small>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control" />
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                inputmode="numeric"
                                minlength="10"
                                maxlength="10"
                                pattern="[6-9]{1}[0-9]{9}"
                                class="form-control"
                                required />
                        </div>

                        <!-- Specialization + Doctor -->
                        <div class="col-md-6">
                            <label for="specialization_id" class="form-label">Specialization</label>
                            <select
                                id="specialization_id"
                                name="specialization_id"
                                class="form-select"
                                required>
                                <option value="">-- Choose a Specialization --</option>
                                <?php foreach ($specializations as $sp): ?>
                                    <option value="<?= $sp['id'] ?>"><?= $sp['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="doctor_id" class="form-label">Doctor</label>
                            <select
                                id="doctor_id"
                                name="doctor_id"
                                class="form-select"
                                required>
                                <option value="">-- Choose a Doctor --</option>
                                <?php foreach ($doctors as $doc): ?>
                                    <option
                                        value="<?= $doc['id'] ?>"
                                        data-specialization="<?= $doc['specialization_id'] ?>">
                                        <?= $doc['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <!-- Date (now a dropdown) -->
                        <div class="col-md-6">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <select id="appointment_date"
                                name="appointment_date"
                                class="form-select"
                                disabled
                                required>
                                <option value="">--Select Date--</option>
                            </select>
                        </div>

                        <!-- Time (now a dropdown) -->
                        <div class="col-md-6">
                            <label for="time_slot" class="form-label">Time Slot</label>
                            <select id="time_slot"
                                name="time_slot"
                                class="form-select"
                                disabled
                                required>
                                <option value="">--Select Time Slot--</option>
                            </select>
                        </div>


                        <!-- Reason -->
                        <div class="col-12">
                            <label for="reason" class="form-label">
                                Reason <small class="text-muted">(optional)</small>
                            </label>
                            <textarea
                                id="reason"
                                name="reason"
                                rows="3"
                                class="form-control"
                                placeholder="Describe your symptoms or concerns..."></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit" name="submit" value="submit">
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "../layout/footer.php"; ?>

    <!-- Bootstrap 5 JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/appointment.js"></script>
    <script>
        const doctors = <?= json_encode($doctors); ?>;

        const doctorSelect = document.getElementById('doctor_id');
        const dateSelect = document.getElementById('appointment_date');
        const timeSlotSelect = document.getElementById('time_slot');

        function weekdayName(date) {
            return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][date.getDay()];
        }

        function generateSlots(startTime, endTime, everyMinutes) {
            const slots = [];
            const [sh, sm] = startTime.split(':').map(Number);
            const [eh, em] = endTime.split(':').map(Number);

            for (let min = sh * 60 + sm; min < eh * 60 + em; min += everyMinutes) {
                const hh = String(Math.floor(min / 60)).padStart(2, '0');
                const mm = String(min % 60).padStart(2, '0');
                slots.push(`${hh}:${mm}`);
            }
            return slots;
        }

        doctorSelect.addEventListener('change', () => {
            const doc = doctors.find(d => d.id == doctorSelect.value);
            dateSelect.innerHTML = '<option value="">--Select Date--</option>';
            timeSlotSelect.innerHTML = '<option value="">--Select Time Slot--</option>';
            timeSlotSelect.disabled = true;

            if (!doc) {
                dateSelect.disabled = true;
                return;
            }

            const allowed = doc.available_days.split(',');
            const today = new Date();

            // make list for the next 14 days
            for (let i = 0; i < 14; i++) {
                const d = new Date();
                d.setDate(today.getDate() + i);
                const wdn = weekdayName(d);
                if (!allowed.includes(wdn)) continue;

                const iso = d.toISOString().split('T')[0]; // yyyy-mm-dd
                const opt = document.createElement('option');
                opt.value = iso;
                opt.textContent = `${wdn} (${iso})`;
                dateSelect.appendChild(opt);
            }
            dateSelect.disabled = false;
        });


        dateSelect.addEventListener('change', () => {
            const doc = doctors.find(d => d.id == doctorSelect.value);
            if (!doc) return;

            const slots = generateSlots(doc.start_time, doc.end_time, doc.slot_duration);
            timeSlotSelect.innerHTML = '<option value="">--Select Time Slot--</option>';
            slots.forEach(t => {
                const o = document.createElement('option');
                o.value = t;
                o.textContent = t;
                timeSlotSelect.appendChild(o);
            });
            timeSlotSelect.disabled = false;
        });
    </script>

</body>

</html>