<?php

class FrontController{
    private $errors;

    function __construct(){
        global $views;

        $action = $_REQUEST['action'] ?? null;
        $action = Validation::sanitizeString($action);

        try{
            $this->handleAction($action);
        }catch(Exception $e){
            $this->errors[''] = "Front Controller : Unknown Error".$e->getMessage();
            require($views['error']);
        }
    }

    function handleAction($action){
        global $views;

        $adminActions = array('addSite', 'changeViewsPerPage', 'deleteSite', 'goAdmin', 'newsUpdater');
        $usersActions = array();

        switch ($action) {
            case null:

            case in_array($action, $usersActions):
                new UserController($action);
                break;

            case in_array($action, $adminActions):
                if($this->isAdmin()) new AdminController($action);
                else require ($views['adminForm']);
                break;

            case 'connectAsAdmin':
                $this->tryConnectAsAdmin();
                break;

            case 'adminDisconnect':
                $this->adminDisconnect();
                break;

            default:
                $this->errors[] = "FrontController undefinedAction : " . $action;
                require($views['error']);
        }
    }

    function isAdmin(){
        $mdlAdmin = new AdminModel();
        return $mdlAdmin->isAdmin();
    }

    function tryConnectAsAdmin(){
        global $views;
        
        $userName = Validation::sanitizeString($_POST['userName']);
        $password = Validation::sanitizeString($_POST['password']);

        $adminModel = new AdminModel(null);

        try{
            $adminModel->connection($userName, $password);
        }catch(FormException $e){
            $this->errors = $e->getFormErrors();
            require ($views['adminForm']);
            return;
        }

        new AdminController(null);
    }

    function adminDisconnect(){
        $adminModel = new AdminModel(null);
        $adminModel->disconnect();

        new UserController(null);
    }

}