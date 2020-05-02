<?php
class SiteModel{
    private $gw;

    function __construct(){
        $this->gw = new SitesGateway();
    }


    function getAllSites(){
        return $this->gw->getAllSites();
    }

    function addSite(string $nomSite, string $rssUrl){
        $errors = Validation::isSiteFormOk($nomSite, $rssUrl);

        if(!empty($errors)) throw new FormException("Website is invalid", 0, NULL, $errors);

        $this->gw->addSite($nomSite, $rssUrl);
    }

    function deleteSite(int $siteId){
        $this->gw->deleteSite($siteId);
    }
}