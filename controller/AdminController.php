<?php

class AdminController{

    private $siteModel;

    private $views;
    private $errors;
    private $sites;

    private $viewPerPageChanged = false;
    private $siteDeleted = false;
    private $numberOfNewsAdded = null;
    private $newSiteName = null;

    private $currentAdminName = null;

    private $viewPerPage;

    function __construct($action){
        global $views;

        $this->siteModel = new SiteModel();
        $this->views = $views;

        try{
            $this->handleAction($action);
        }
        catch(PDOException $e){
            $this->errors[] =	"AdminController : PDO Error ".$e->getMessage();
            require ($views['error']);
        }
        catch(Exception $e){
            $this->errors[''] = "AdminController : Unknown Error ".$e->getMessage();
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

    function mainDisplay(){
        global $viewPerPagePath;

        $this->currentAdminName = (new AdminModel())->getCurrentAdminName();

        $file = @fopen($viewPerPagePath, "r");
        if($file){
            $this->viewPerPage = fgets($file);
            fclose($file);
        }

        $this->sites = $this->siteModel->getAllSites();

        require($this->views['admin']);
    }

    function changeViewPerPage(){
        global $viewPerPagePath;

        $newNumber = Validation::sanitizeString($_POST['viewNumber']);

        $newNumber = intval($newNumber);

        $file = @fopen($viewPerPagePath, "w+");
        if(!$file) throw new Exception("Error writing viewPerPagePath file");

        fwrite($file, $newNumber);
        fclose($file);

        $this->viewPerPageChanged = true;

        $this->mainDisplay();
    }

    function add(){
        $siteName = Validation::sanitizeString($_POST['siteName']);
        $rssUrl = Validation::sanitizeString($_POST['rssUrl']);

        try{
            $this->siteModel->addSite($siteName, $rssUrl);
        }catch (FormException $e){
            $this->errors = $e->getFormErrors();
            $this->mainDisplay();
            return;
        }

        $this->newSiteName = $siteName;

        $this->mainDisplay();
    }

    function deleteSite(){
        $siteId = Validation::sanitizeString($_POST['siteId']);
        $siteId = intval($siteId);

        $this->siteModel->deleteSite($siteId);

        $this->siteDeleted = true;

        $this->mainDisplay();
    }

    function callNewsUpdater(){
        $newsUpdater = new NewsUpdater();
        $this->numberOfNewsAdded = $newsUpdater->updateNews();
        $this->mainDisplay();
    }
}