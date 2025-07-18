<?php

require_once "../../config/db.php";
require_once "../../controllers/DoctorController.php";

$id = $_GET['id'];
$image = $_GET['image'];

echo $image;

if(!empty($image)){
    $imagePath = "../../assets/images/" . $image;
    unlink($imagePath);
} else {
    echo "Error";
}

$controller = new DoctorController($pdo);

$controller->delete($id);

header("Location: doctorManager.php");
exit();