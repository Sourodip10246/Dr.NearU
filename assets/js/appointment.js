document.addEventListener("DOMContentLoaded", function () {
    const specSelect   = document.getElementById("specialization_id");
    const doctorSelect = document.getElementById("doctor_id");
    const allOptions   = Array.from(doctorSelect.options); // original list (inc. placeholder)

    /** Rebuild doctor list for a given specialization ID */
    function renderDoctors(specId) {
        doctorSelect.innerHTML = "";
        // placeholder
        doctorSelect.insertAdjacentHTML(
            "beforeend",
            '<option value="">-- Choose a Doctor --</option>'
        );

        allOptions.forEach((opt) => {
            if (!specId || opt.dataset.specialization === specId) {
                doctorSelect.appendChild(opt);
            }
        });
    }

    /* 0️⃣  Pre‑fill from ?id=…&specialization=… (if present) */
    (function prefillFromQuery () {
        const params = new URLSearchParams(window.location.search);
        const specId   = params.get("specialization"); // e.g. 1
        const doctorId = params.get("id");             // e.g. 3

        if (specId) {
            specSelect.value = specId;   // select the specialization
            renderDoctors(specId);       // rebuild the doctor list for it
        }

        if (doctorId) {
            doctorSelect.value = doctorId; // pick the doctor
            /*  ────────────────
                If only a doctor id is in the URL (no specialization param),
                the “change” handler on doctorSelect will auto‑select the
                matching specialization for you.
            */
            doctorSelect.dispatchEvent(new Event("change"));
        }
    })();

    /* 1️⃣ When user picks a specialization */
    specSelect.addEventListener("change", function () {
        renderDoctors(this.value);
    });

    /* 2️⃣ When user picks a doctor first */
    doctorSelect.addEventListener("change", function () {
        const chosen = doctorSelect.selectedOptions[0];
        const specId = chosen?.dataset.specialization || "";
        // auto‑select the matching specialization (if not already)
        if (specId && specSelect.value !== specId) {
            specSelect.value = specId;
            renderDoctors(specId); // keep doctor list filtered
        }
    });
});
