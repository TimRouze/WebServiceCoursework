<?php
/**
 * Class in charge of the Admin model
 */
class AdminModel{
    private $gateway;

    function __construct(){
        $this->gateway = new AdminGateway();
    }

    /**
     * Method called when trying to connect as admin
     * @param string $userName
     * @param string $password
     */
    function connection(string $userName, string $password){
        // First validate the forms values
        $errors = Validation::isAdminFormOk($userName, $password);

        if(!count($errors) == 0) throw new FormException("Admin connection form is invalid", 0, NULL, $errors);

        // Then verify if this login exist
        $admin = $this->gateway->getAdminByUsername($userName);

        if(!isset($admin)){
            $errors['userName'] = "There is no Admin with this login";
            throw new FormException("No admin found", 0, NULL, $errors);
        }

        // Then verify if the password is correct
        if(!password_verify($password, $admin->getHashedPassword())){
            $errors['password'] = "Wrong password";
            throw new FormException("Admin connection failed", 0, NULL, $errors);
        }

        // Now we are sure that the user is an admin
        $_SESSION['role'] = 'admin';
        $_SESSION['login'] = $admin->getLogin();
    }

    /**
     * Method called when an admin want to go back as user status
     */
    function disconnect(){
        // Destry all the var of the sessions :
        $_SESSION = array();
        session_destroy();
    }

    /**
     * This function test if the current user got admin privileges
     */
    function isAdmin(){
        $role = $_SESSION['role'] ?? null;
        if($role == "admin") return true;
        return false;
    }

    /**
     * Get the name of the connected admin if possible
     */
    function getCurrentAdminName(){
        if($this->isAdmin()) return $_SESSION['login'];
    }
}