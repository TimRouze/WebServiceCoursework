<?php
class NewsModel{
    private $gateway;

    function __construct(){
        $this->gateway = new NewsGateway();
    }

    function getNews(int $page,int  $viewPerPage){
        return $this->gateway->getNewsByPage($page, $viewPerPage);
    }

    function countNews(){
        return $this->gateway->countNews();
    }
}