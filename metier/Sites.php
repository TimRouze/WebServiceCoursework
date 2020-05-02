<?php 
/**
 * Class that simply describe what a sites is
 */
class Sites {
  private $id;
  private $siteName;
  private $fluxUrl;

  function __construct($id, $siteName, $fluxRss){
    $this->id = $id;
    $this->fluxUrl = $fluxRss;
    $this->siteName = $siteName;
  }

  function getId(){ return $this->id; }
  function getSiteName(){ return $this->siteName; }
  function getfluxUrl(){ return $this->fluxUrl; }

}