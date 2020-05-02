<?php

/**
 * Class FrontController.
 * This controller will receive all the client's actions.
 * His job is to redirect to the correct ressource in function of users status and request.
 * He try to delegate the action to other's controllers if possible.
 */
class FrontController{
    private $errors;

    function __construct(){
        global $views;

        // First get the action and sanitize it
        $action = $_REQUEST['action'] ?? null;
        $action = Validation::sanitizeString($action);

        // Then handle it
        try{
            $this->handleAction($action);
        }catch(Exception $e){
            $this->errors[''] = "Front Controller : Unknown Error".$e->getMessage();
            require($views['error']);
        }
    }

    function handleAction($action){
        global $views;

        // Store admin/users specific actions in array :
        $adminActions = array('addSite', 'changeViewsPerPage', 'deleteSite', 'goAdmin', 'newsUpdater');
        $usersActions = array();

        switch ($action) {
            case null:

            // If it's a user action
            case in_array($action, $usersActions):
                new UserController($action);
                break;

            // If it's an admin action
            case in_array($action, $adminActions):
                // If not admin, redirect to the adminForm
                if($this->isAdmin()) new AdminController($action);
                else require ($views['adminForm']);
                break;

            /**
             *  Connection/Disconnection actions here:
             *  This type of action can lead to different controllers. Ex : a failed connection as admin tentative will lead to the UserController, but not a successful one.
             *  And some actions are done by on actor, but will lead them to an other actor controller. Ex : adminDisconnect is done by and admin, but will lead to the UserController.
             *  So they are handled here in the FrontController, because we don't know for sure the user status.
             */
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

    /**
     * --------------------
     *  ADMIN SPECIFIC FN
     * --------------------
     */
    /**
     * Test if current actor is an admin
	 * @return bool
     */
    function isAdmin(){
        $mdlAdmin = new AdminModel();
        return $mdlAdmin->isAdmin();
    }

    /**
     * Try to get admin privilege through the adminForm
     */
    function tryConnectAsAdmin(){
        global $views;
        
        $userName = Validation::sanitizeString($_POST['userName']);
        $password = Validation::sanitizeString($_POST['password']);

        $adminModel = new AdminModel(null);

        // Try connect as admin
        try{
            $adminModel->connection($userName, $password);
        }catch(FormException $e){
            // If there is a connexion error, redirect to the form again
            $this->errors = $e->getFormErrors();
            require ($views['adminForm']);
            return;
        }

        new AdminController(null);
    }

    /**
     * Disconnect, drop the session, and go back as a normal user
     */
    function adminDisconnect(){
        $adminModel = new AdminModel(null);
        $adminModel->disconnect();

        new UserController(null);
    }

}