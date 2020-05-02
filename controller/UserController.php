<?php

class UserController{

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
            $this->errors[] =	"UserController : PDO Error ".$e->getMessage();
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
            case 'aboutPage':
                $this->aboutPage();
                break;
            default:
                $this->errors[] = "UserController undefinedAction : " . $action;
                require ($views['error']);
        }
    }

    function seeNews(){
        global $views;

        $this->computePagination();

        $this->currentAdminName = (new AdminModel())->getCurrentAdminName();

        $wantedPage = Validation::sanitizeString($_GET['p'] ?? "1");
        $wantedPage = intval($wantedPage);

        if($wantedPage < 0) throw new Exception("Error seeNews(), no valid page given");

        $this->currentPage = $wantedPage;

        $newsModel = new NewsModel();
        $this->news = $newsModel->getNews($this->currentPage, $this->viewPerPage);

        require ($views['main']);
    }

    function aboutPage(){
        global $views;

        $this->currentAdminName = (new AdminModel())->getCurrentAdminName();
    }

    function computePagination(){
        global $viewPerPagePath;

        $file = @fopen($viewPerPagePath, "r");
        if($file){
            $this->viewPerPage = fgets($file);
            $this->viewPerPage = intval($this->viewPerPage);
            fclose($file);
        }

        $this->viewPerPage = empty($this->viewPerPage) ? 5 : $this->viewPerPage;

        $newsModel = new NewsModel();
        $this->numberOfNews = $newsModel->countNews();

        $pageMax = ceil($this->numberOfNews / $this->viewPerPage);

        if($pageMax != 0) $this->pages = range(max(1, $this->currentPage - 5) , min($this->currentPage+5, $pageMax), 1);
        else $this->pages = [];
    }
}
?>