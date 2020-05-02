<?php
class AdminModel{
    private $gateway;

    function __construct(){
        $this->gateway = new AdminGateway();
    }

    function connection(string $userName, string $password){
        $errors = Validation::isAdminFormOk($userName, $password);

        if(!count($errors) == 0) throw new FormException("Admin connection form is invalid", 0, NULL, $errors);

        $admin = $this->gateway->getAdminByUsername($userName);

        if(!isset($admin)){
            $errors['userName'] = "There is no Admin with this login";
            throw new FormException("No admin found", 0, NULL, $errors);
        }

        if(!password_verify($password, $admin->getHashedPassword())){
            $errors['password'] = "Wrong password";
            throw new FormException("Admin connection failed", 0, NULL, $errors);
        }

        $_SESSION['role'] = 'admin';
        $_SESSION['login'] = $admin->getLogin();
    }

    function disconnect(){
        $_SESSION = array();
        session_destroy();
    }

    function isAdmin(){
        $role = $_SESSION['role'] ?? null;
        if($role == "admin") return true;
        return false;
    }

    function getCurrentAdminName(){
        if($this->isAdmin()) return $_SESSION['login'];
    }
}