<?php
/**
 * Class in charge of the SiteModel model
 */
class SiteModel{
    private $gw;

    function __construct(){
        $this->gw = new SitesGateway();
    }

    /**
     * Get all the website anbd their flux 
     * @return array[Sites]
     */
    function getAllSites(){
        return $this->gw->getAllSites();
    }

	/** 
	 * Add a news site
   * @param string $nomSite
   * @param string $rssUrl
	*/ 
    function addSite(string $nomSite, string $rssUrl){
        // First validate the values
        $errors = Validation::isSiteFormOk($nomSite, $rssUrl);

        if(!empty($errors)) throw new FormException("Website add form is invalid", 0, NULL, $errors);

        // Else, is form is valid :
        $this->gw->addSite($nomSite, $rssUrl);
    }

	/** 
	 * Delete a site by his id
     * @param int $siteId
	*/ 
    function deleteSite(int $siteId){
        $this->gw->deleteSite($siteId);
    }
}