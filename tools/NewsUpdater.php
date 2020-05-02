<?php
/**
 * Class NewsUpdater is in charge of updating the news.
 * This class get the rss flux from the DB, then parse them, and finnaly add news to the DB 
 */
class NewsUpdater{
    
    /**
     * This function is charge of updating the news
     * @return int $numberOfNewsAdded
     */
    function updateNews(){
        // Number of news added that will be returned (usefull for the display)
        $numberOfNewsAdded = 0;

        // create the gateway that we will use
        $siteGateWay = new SitesGateway();
        $newsGateway = new NewsGateway();

        // Get all the sites's rssFlux to contact
        $sites = $siteGateWay->getAllSites();

        // For each site
        foreach($sites as $site){
            // Get the flux and parse it 
            $news = $this->parseFluxAsDomObj($site);

            // Get the date of the last news added coming form this site
            $lastNewsDate = $newsGateway->getLastNewsDateFrom($site);
            
            // If date found, convert the string Date to a true date object
            if($lastNewsDate != null) $lastNewsDate = date_create_from_format("Y-m-d H:i:s", $lastNewsDate);

            // For each parsed news in the flux
            foreach($news as $new){
                // Get the Date object from this news if needed. (If there was already news form this website in the DB)
                if($lastNewsDate != null) $currentNewsDate = date_create_from_format("Y-m-d H:i:s", $new->getDate());

                // Add the news if the date is more recent OR if there was no news coming form this website
                if($lastNewsDate == null || $currentNewsDate > $lastNewsDate){
                    $numberOfNewsAdded++;
                    // Add this news  in DB :
                    // Nice to have : We add news on by one. It will be better to add them all at once, to avoid DB overloading
                    $newsGateway->addNews($new, $site->getId());                    
                }
            }
        }

        // Return the number of news
        return $numberOfNewsAdded;
    }

    /**
     * Consider the xml flux as a DOM document
     * And use getElementsByTagName to find the tags
     * Seems to work with most of the RSS flux
     * @param Site site
     * @return array[News]
     */
    private function parseFluxAsDomObj($site){
        $domOBJ = new DOMDocument();
        $domOBJ->load($site->getfluxUrl());//XML page URL

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

            // Remove useless space in date
            $pubDate = trim($pubDate);
            // Get the date considering the format
            $pubDate = date_create_from_format('D, d M Y G:i:s O', $pubDate);;
            // Y-m-d H:i:s is mysql format. date convert a date to a string 
            $pubDate = $pubDate->format('Y-m-d H:i:s');

            // Afer reading an item add the news in the array :
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
     */

    /**
     * @Deprecated - Because was not working with all rss flux
     * Use the string given with a XMLFileParser as a file.
     * Go through with this file line by line and find the xml tags to create news
     */
    private function parseFluxWithXMLFileParser($site){
        // Use the url to get the online file
        $rss = file_get_contents($site->getfluxUrl());

        // Parse this file with a parser
        $parser = new XMLFileParser($rss);
        $parser->parse();
        $result = $parser->getResult();

        // Convert results string to a file
        $stream = fopen('php://memory','r+');
        fwrite($stream, $result);
        rewind($stream);

        $news = [];
        $websiteUrl;

        // Go though the parsed xml to parse news
        while(!feof($stream)){
            $line = fgets($stream);

            // The first link tag is the website url
            if(!isset($websiteUrl) && strpos($line, 'LINK') != false){
                $websiteUrl = "";
                $line = fgets($stream);
                while(strpos($line, 'LINK') != true){
                    $websiteUrl = $line.$websiteUrl;
                    $line = fgets($stream);
                }
            }

            $title = "";
            $link = "";
            $description = "";
            $pubDate = "";

            // ITEM tag found, it's a new news
            if(strpos($line, 'ITEM') != false){
                
                // Continue reading whil not finding another ITEM tag
                $line = fgets($stream);
                while(strpos($line, 'ITEM') != true){

                    // TITLE tag found, it's a title
                    if(strpos($line, 'TITLE') != false){

                        $line = fgets($stream);
                        while(strpos($line, 'TITLE') != true){
                            $title = $title.$line;
                            $line = fgets($stream);
                        }
                    }

                    // LINK tag found, it's the url of the news
                    if(strpos($line, 'LINK') != false){

                        $line = fgets($stream);
                        while(strpos($line, 'LINK') != true){
                            $link = $link.$line;
                            $line = fgets($stream);
                        }
                    }

                    // DESCRIPTION tag found, it's the description of the news
                    if(strpos($line, 'DESCRIPTION') != false){
                        $line = fgets($stream);
                        while(strpos($line, 'DESCRIPTION') != true){
                            $description = $description.$line;
                            $line = fgets($stream);
                        }
                    }

                    // PUBDATE tag found, it's the description of the news
                    if(strpos($line, 'PUBDATE') != false){
                        $line = fgets($stream);
                        while(strpos($line, 'PUBDATE') != true){
                            $pubDate = $pubDate.$line;
                            $line = fgets($stream);
                        }
                    }
                    
                    $line = fgets($stream);
                }
                
                // Remove useless space in date
                $pubDate = trim($pubDate);
                // Get the date considering the format
                $pubDate = date_create_from_format('D, d M Y G:i:s O', $pubDate);;
                // Y-m-d H:i:s is mysql format. date convert a date to a string 
                $pubDate = $pubDate->format('Y-m-d H:i:s');
            }
        }
        return $news;
    }
}