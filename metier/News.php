<?php 
/**
 * Class that simply describe what a news is
 */
class News {
  private $date;
  private $siteName;
  private $title;
  private $description;
  private $url;
  private $websiteUrl;

  function __construct($date, $siteName, $title, $description, $url, $websiteUrl){
    $this->date = $date;
    $this->siteName = $siteName;
    $this->title = $title;
    $this->description = $description;
    $this->url = $url;
    $this->websiteUrl = $websiteUrl;
  }

  function getDate(){ return $this->date; }
  function getSiteName(){ return $this->siteName; }
  function getTitle(){ return $this->title; }
  function getDescription(){ return $this->description; }
  function getUrl(){ return $this->url; }
  function getWebsiteUrl(){ return $this->websiteUrl; }

}