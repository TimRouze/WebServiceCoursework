<?php
class NewsModel{
    private $gateway;

    function __construct(){
        $this->gateway = new NewsGateway();
    }

	/** 
	 * Get news by page and knowing how many news each page should have
	 * @param int $page 
     * @param int $sitePerPage
	 * @return array[News]
	*/ 
    function getNews(int $page,int  $viewPerPage){
        return $this->gateway->getNewsByPage($page, $viewPerPage);
    }

	/** 
	 * Count the number of existing news
     * @return int number
	*/ 
    function countNews(){
        return $this->gateway->countNews();
    }
}