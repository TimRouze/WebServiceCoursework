<?php

class NewsGateway{
  private $connexion;

  function __construct(){
    global $dbInfo, $dbUser, $dbPassword;

    $this->connexion = new Connection($dbInfo, $dbUser, $dbPassword);
  }

  function getNewsByPage(int $page, int $sitePerPage){
    $query = "SELECT * from news ORDER BY date DESC LIMIT :limit OFFSET :offset";
    
    $this->connexion->executeQuery($query, array(
                                                "limit" => array($sitePerPage, PDO::PARAM_INT),
                                                "offset" => array(($page -1) * $sitePerPage, PDO::PARAM_INT)
                                              ));

    $news = [];
    foreach($this->connexion->getResults() as $row){
      array_push($news, new News($row['date'], $row['SiteName'], $row['Title'], $row['Description'], $row['Url'], $row['UrlWebsite']));
    }

    return $news;
  }

  function countNews(){
      $query = "SELECT COUNT(*) from news";

      $this->connexion->executeQuery($query);

      return intval($this->connexion->getResults()[0][0]);
      
  }

  function addNews(News $news, int $idSite){
    $query = "INSERT INTO news VALUES(
      NULL,
      :idSite,
      :date,
      :siteName,
      :title,
      :description,
      :url,
      :urlWebSite
    )";

    $this->connexion->executeQuery($query, array(
      "idSite" => array($idSite, PDO::PARAM_INT),
      "date" => array($news->getDate(), PDO::PARAM_STR),
      "siteName" => array($news->getSiteName(), PDO::PARAM_STR),
      "title" => array($news->getTitle(), PDO::PARAM_STR),
      "description" => array($news->getDescription(), PDO::PARAM_STR),
      "url" => array($news->getUrl(), PDO::PARAM_STR),
      "urlWebSite" => array($news->getWebsiteUrl(), PDO::PARAM_STR),
    ));
  }

  function getLastNewsDateFrom(Sites $site){
    $query = "SELECT date FROM news WHERE id_Site = :idSite ORDER BY date DESC";
    $this->connexion->executeQuery($query, array(
      "idSite" => array($site->getId(), PDO::PARAM_INT),
    ));

    $results = $this->connexion->getResults();

    if(count($results) == 0) return null;

    return $results[0][0];
  }
}

?>