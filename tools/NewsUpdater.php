<?php
class NewsUpdater{
    
    function updateNews(){
        $numberOfNewsAdded = 0;

        $siteGateWay = new SitesGateway();
        $newsGateway = new NewsGateway();

        $sites = $siteGateWay->getAllSites();

        foreach($sites as $site){
            $news = $this->parseFluxAsDomObj($site);

            $lastNewsDate = $newsGateway->getLastNewsDateFrom($site);
            
            if($lastNewsDate != null) $lastNewsDate = date_create_from_format("Y-m-d H:i:s", $lastNewsDate);

            foreach($news as $new){
                if($lastNewsDate != null) $currentNewsDate = date_create_from_format("Y-m-d H:i:s", $new->getDate());

                if($lastNewsDate == null || $currentNewsDate > $lastNewsDate){
                    $numberOfNewsAdded++;
                    $newsGateway->addNews($new, $site->getId());                    
                }
            }
        }

        return $numberOfNewsAdded;
    }


    private function parseFluxAsDomObj($site){
        $domOBJ = new DOMDocument();
        $domOBJ->load($site->getfluxUrl());

        $websiteUrl = $domOBJ->getElementsByTagName("channel");
        $websiteUrl = $domOBJ->getElementsByTagName("link")->item(1)->nodeValue;

        $content = $domOBJ->getElementsByTagName("item");
        
        $news = [];
        foreach( $content as $data )
        {
            $title = $data->getElementsByTagName("title")->item(0)->nodeValue;
            $link = $data->getElementsByTagName("link")->item(0)->nodeValue;
            $description = $data->getElementsByTagName("description")->item(0)->nodeValue;
            $pubDate = $data->getElementsByTagName("pubDate")->item(0)->nodeValue;

            $pubDate = trim($pubDate);
            $pubDate = date_create_from_format('D, d M Y G:i:s O', $pubDate);;
            $pubDate = $pubDate->format('Y-m-d H:i:s');

            array_push($news, new News($pubDate, $site->getSiteName(), $title, $description, $link, $websiteUrl));
        }
        return $news;
    }

    /**
     * 
     * 
     * //////////DEPRECATED//////////
     * 
     * 

     * @Deprecated - Because was not working with all rss flux
     * Use the string given with a XMLFileParser as a file.
     * Go through with this file line by line and find the xml tags to create news
    *private function parseFluxWithXMLFileParser($site){
    *    // Use the url to get the online file
    *    $rss = file_get_contents($site->getfluxUrl());
*
    *    // Parse this file with a parser
    *    $parser = new XMLFileParser($rss);
    *    $parser->parse();
    *    $result = $parser->getResult();
*
    *    // Convert results string to a file
    *    $stream = fopen('php://memory','r+');
    *    fwrite($stream, $result);
    *    rewind($stream);
*
    *    $news = [];
    *    $websiteUrl;
*
    *    // Go though the parsed xml to parse news
    *    while(!feof($stream)){
    *        $line = fgets($stream);
*
 *           // The first link tag is the website url
  *          if(!isset($websiteUrl) && strpos($line, 'LINK') != false){
   *             $websiteUrl = "";
    *            $line = fgets($stream);
     *           while(strpos($line, 'LINK') != true){
      *              $websiteUrl = $line.$websiteUrl;
       *             $line = fgets($stream);
        *        }
         *   }
*
 *           $title = "";
  *          $link = "";
   *         $description = "";
    *        $pubDate = "";
*
 *           // ITEM tag found, it's a new news
  *          if(strpos($line, 'ITEM') != false){
   *             
    *            // Continue reading whil not finding another ITEM tag
     *           $line = fgets($stream);
      *          while(strpos($line, 'ITEM') != true){
*
 *                   // TITLE tag found, it's a title
  *                  if(strpos($line, 'TITLE') != false){
*
 *                       $line = fgets($stream);
  *                      while(strpos($line, 'TITLE') != true){
   *                         $title = $title.$line;
    *                        $line = fgets($stream);
     *                   }
      *              }
*
 *                   // LINK tag found, it's the url of the news
  *                  if(strpos($line, 'LINK') != false){
*
 *                       $line = fgets($stream);
  *                      while(strpos($line, 'LINK') != true){
   *                         $link = $link.$line;
    *                        $line = fgets($stream);
     *                   }
      *              }
*
 *                   // DESCRIPTION tag found, it's the description of the news
  *                  if(strpos($line, 'DESCRIPTION') != false){
   *                     $line = fgets($stream);
    *                    while(strpos($line, 'DESCRIPTION') != true){
     *                       $description = $description.$line;
      *                      $line = fgets($stream);
       *                 }
        *            }
*
 *                   // PUBDATE tag found, it's the description of the news
  *                  if(strpos($line, 'PUBDATE') != false){
   *                     $line = fgets($stream);
    *                    while(strpos($line, 'PUBDATE') != true){
     *                       $pubDate = $pubDate.$line;
      *                      $line = fgets($stream);
       *                 }
        *            }
         *           
          *          $line = fgets($stream);
           *     }
            *    
             *   // Remove useless space in date
              *  $pubDate = trim($pubDate);
               * // Get the date considering the format
                *$pubDate = date_create_from_format('D, d M Y G:i:s O', $pubDate);;
*                // Y-m-d H:i:s is mysql format. date convert a date to a string 
 *               $pubDate = $pubDate->format('Y-m-d H:i:s');
  *          }
   *     }
    *    return $news;
*    }*/
}