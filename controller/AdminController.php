<?php

/**
 * Class AdminController
 * This controller will handle all the user admins actions
 */
class AdminController{

    // Model is often needed here, so we declare it as an attribute to avoid multiple instantiation
    private $siteModel;

    // We create display variables as attributes here, because we don't want them to be function scope dependant.
    // For example mainDisplay() won't be possible to factorize as this without this system.
    // newSiteName is assigned in the add function, not in the mainDisplay
    // With this system variable do not live just only in the functions
    private $views;
    private $errors;
    private $sites;

    // These are helpers to know when display the Materialize.toast 
    private $viewPerPageChanged = false;
    private $siteDeleted = false;
    private $numberOfNewsAdded = null;
    private $newSiteName = null;

    private $currentAdminName = null;

    // This is to set the viewNumber's cursor to the correct value
    private $viewPerPage;

    function __construct($action){
        global $views;

        $this->siteModel = new SiteModel();
        $this->views = $views;

        try{
            $this->handleAction($action);
        }
        catch(PDOException $e){
            $this->errors[] =	"AdminController : Erreur PDO".$e->getMessage();
            require ($views['error']);
        }
        catch(Exception $e){
            $this->errors[''] = "AdminController : Unknown Error".$e->getMessage();
            require($this->views['error']);
        }
    }

    function handleAction($action){
        switch($action){
            case 'goAdmin':
            case null:
                $this->mainDisplay();
                break;

            case 'addSite':
                $this->add();
                break;

            case 'changeViewsPerPage':
                $this->changeViewPerPage();
                break;

            case 'deleteSite':
                $this->deleteSite();
                break;
            
            case 'newsUpdater':
                $this->callNewsUpdater();
                break;
            
            default:
                $this->errors[] = "AdminController undefinedAction : " . $action;
                require($this->views['error']);
        }
    }

    /**
     * This function handle the main display.
     * (Sites, view per page range selector, etc ...)
     */
    function mainDisplay(){
        global $viewPerPagePath;

        $this->currentAdminName = (new AdminModel())->getCurrentAdminName();

        // Read the current number of view per page. (For display) (@ avoid useless warning)
        $file = @fopen($viewPerPagePath, "r");
        if($file){
            $this->viewPerPage = fgets($file);
            fclose($file);
        }

        // Get all the sites (For display)
        $this->sites = $this->siteModel->getAllSites();

        require($this->views['admin']);
    }

    /**
     * Funtion called when wanting to change the number of view per page for the news
     */
    function changeViewPerPage(){
        global $viewPerPagePath;

        // Sanitize the number : 
        $newNumber = Validation::sanitizeString($_POST['viewNumber']);

        // This number can only be a int :
        $newNumber = intval($newNumber);

        // Write the new number in the correct file. (@ avoid useless warning)
        $file = @fopen($viewPerPagePath, "w+");
        if(!$file) throw new Exception("Error writing viewPerPagePath file");

        fwrite($file, $newNumber);
        fclose($file);

        // This is for Materialize pop up info
        $this->viewPerPageChanged = true;

        $this->mainDisplay();
    }

    /**
     * Funtion called when adding a new rss flux of a site to the DB
     */
    function add(){
        $siteName = Validation::sanitizeString($_POST['siteName']);
        $rssUrl = Validation::sanitizeString($_POST['rssUrl']);

        try{
            $this->siteModel->addSite($siteName, $rssUrl);
        }catch (FormException $e){
            // The exception return the errors, display them
            $this->errors = $e->getFormErrors();
            $this->mainDisplay();
            return;
        }

        // $newSiteName used in the view, so defined it
        $this->newSiteName = $siteName;

        // Main display will display all the sites after the new one is added
        $this->mainDisplay();
    }

    /**
     * Function called when deleting a rss flux of a website
     */
    function deleteSite(){
        // Sanitize it, and force to int
        $siteId = Validation::sanitizeString($_POST['siteId']);
        $siteId = intval($siteId);

        $this->siteModel->deleteSite($siteId);

        // This is for Materialize pop up info
        $this->siteDeleted = true;

        $this->mainDisplay();
    }

    /**
     * Function in charge of updating the news of the application
     */
    function callNewsUpdater(){
        $newsUpdater = new NewsUpdater();
        $this->numberOfNewsAdded = $newsUpdater->updateNews();
        $this->mainDisplay();
    }
}