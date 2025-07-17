<?php

require_once "../../config/db.php";
require_once "../../controllers/SpecializationController.php";

$controller = new SpecializationController($pdo);

$id = $_GET['id'];

$controller->deleteById($id);

header("Location: speManager.php");
exit();