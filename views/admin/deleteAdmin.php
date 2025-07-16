<?php
require_once "../../config/db.php";
require_once "../../controllers/AdminController.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $controller = new AdminController($pdo);

    $controller->deleteById($id);
    header("Location: adminManager.php?deleted=1");
    exit();
}
