<?php
/**
 * SitesGateway : class in charge in doing SQL request to the DB on the sites table
 */
class SitesGateway{
  private $con;

  function __construct(){
      global $dbInfo, $dbUser, $dbPassword;
      $this->con = new Connection($dbInfo, $dbUser, $dbPassword);
  }

	/** 
	 * Get all the sites and their rss flux from DB
	 * @return array[Sites]
	*/ 
  function getAllSites(){
    $query = "SELECT * from sites";
    
    $this->con->executeQuery($query);

    $sites = [];
    foreach($this->con->getResults() as $row){
      array_push($sites, new Sites($row['ID'], $row['name'], $row['fluxURL']));
    }

    return $sites;
  }

	/** 
	 * Add a news site to the DB
   * @param string $nomSite
   * @param string $rssUrl
	*/ 
  function addSite(string $nomSite, string $rssUrl){
    $query = "INSERT into sites values(null, :name, :flux)";
    
    $this->con->executeQuery($query, array(':name'=>array($nomSite, PDO::PARAM_STR), ':flux'=>array($rssUrl, PDO::PARAM_STR)));
  }

	/** 
	 * Delete a site of the DB with his id
   * @param int $siteId
	*/ 
  function deleteSite(int $siteId){
    $query = "DELETE FROM sites where ID = :id";
    
    $this->con->executeQuery($query, array(':id' =>array($siteId, PDO::PARAM_INT)));
  }
}