<?php

require_once "../../config/db.php";
require_once "../../controllers/DoctorController.php";

$id = $_GET['id'];

$controller = new DoctorController($pdo);

$controller->delete($id);

header("Loacation: doctorManager.php");
exit();