<?php

require_once "../../config/db.php";
require_once "../../controllers/SpecializationController.php";

$controller = new SpecializationController($pdo);

$id = $_GET['id'];
$image = $_GET['image'];

if(!empty($image)){
    $imagePath = "../../assets/images/" . $image;
    unlink($imagePath);
}

$controller->deleteById($id);

header("Location: speManager.php");
exit();