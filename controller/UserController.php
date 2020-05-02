<?php

/**
 * Class UserController
 * This controller will handle all the user actor actions
 */
class UserController{
    // Display :
    // We create display variables as attributes here, because we don't want them to be function scope dependant.
    // See AdminController for examples

    private $errors;
    private $news;
    private $currentPage;
    private $numberOfNews;
    private $viewPerPage;
    private $currentAdminName;
    private $pages;

    function __construct($action){
        global $views;

        try{
            $this->handleAction($action);
        }
        catch(PDOException $e){
            $this->errors[] =	"UserController : Erreur PDO".$e->getMessage();
            require ($views['error']);
        }
        catch(Exception $e){
            $this->errors[''] = "User Controller : Unknown Error".$e->getMessage();
            require ($views['error']);
        }
    }

    function handleAction($action){
        global $views;

        switch($action){
            case null:
                $this->seeNews();
                break;
            default:
                $this->errors[] = "UserController undefinedAction : " . $action;
                require ($views['error']);
        }
    }

    function seeNews(){
        global $views;

        $this->computePagination();

        // Get the connected admin name if possible
        $this->currentAdminName = (new AdminModel())->getCurrentAdminName();

        // Get the wanted page and shoudl be an int. (If no given page in url, display page 1)
        $wantedPage = Validation::sanitizeString($_GET['p'] ?? "1");
        $wantedPage = intval($wantedPage);
        
        // Verify wantedPage
        if($wantedPage < 0) throw new Exception("Error seeNews(), no valid page given");

        // Add it in class for display
        $this->currentPage = $wantedPage;

        // Get the news of this page
        $newsModel = new NewsModel();
        $this->news = $newsModel->getNews($this->currentPage, $this->viewPerPage);

        require ($views['main']);
    }

    /**
     * This function compute which number should the pagination have
     */
    function computePagination(){
        global $viewPerPagePath;

        // Read the defined number of view in the correct file (@ avoid useless warning)
        $file = @fopen($viewPerPagePath, "r");
        if($file){
            $this->viewPerPage = fgets($file);
            $this->viewPerPage = intval($this->viewPerPage);
            fclose($file);
        }

        // If there was a problem reading the viewPerPage, use 5 by default
        $this->viewPerPage = empty($this->viewPerPage) ? 5 : $this->viewPerPage;

        $newsModel = new NewsModel();
        $this->numberOfNews = $newsModel->countNews();

        //$pageMax is the total number of page, considering the number of news and the news per page
        $pageMax = ceil($this->numberOfNews / $this->viewPerPage);

        //$pages is the array int of page that we will display. Configured to display the 5 page before and after the current page
        if($pageMax != 0) $this->pages = range(max(1, $this->currentPage - 5) , min($this->currentPage+5, $pageMax), 1);
        else $this->pages = [];
    }
}
?>