<?php

require_once __DIR__."/../models/Admin.php";

class AdminController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Admin($pdo);
    }

    public function addNewAdmin($name, $password)
    {
        $admin = $this->model->findByName($name);
        if (!$admin) {
            return $this->model->addAdmin($name, $password);
        } else {
            return false;
        }
    }

    public function login($name, $password)
    {
        $admin = $this->model->findByName($name);
        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }

        return false;
    }
}
