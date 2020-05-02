<?php
/**
 * NewsGateway : class in charge in doing SQL request to the DB on the admin table
 */
class AdminGateway{
    private $connexion;

    function __construct(){
        global $dbInfo, $dbUser, $dbPassword;
        $this->connexion = new Connection($dbInfo, $dbUser, $dbPassword);
    }

	/** 
	 * Get an Admin object by this username
	 * @param string $userName 
	 * @return Admin
	*/ 
    function getAdminByUsername(string $userName){
        $query = "Select * From admin Where login = :login";
        $this->connexion->executeQuery($query, array(':login'=>array($userName, PDO::PARAM_STR)));
        $results = $this->connexion->getResults();
        
        if(count($results) == 0) return null;

        return new Admin($results[0]['login'], $results[0]['password']);
    }
}