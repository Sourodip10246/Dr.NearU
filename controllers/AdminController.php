<?php

require_once __DIR__ . "/../models/Admin.php";


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
        if ($admin && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }

        return false;
    }

    public function getAll()
    {
        $admins = $this->model->getAllAdmin();
        return $admins;
    }

    public function deleteById($id)
    {
        return $this->model->deleteById($id);
    }

    public function updateAdmin($id, $username, $password) {
        if(empty($password)){
            return $this->model->updateNameById($id, $username);
        } else {
            return $this->model->updateAllById($id, $username, $password);
        }
    }
}
