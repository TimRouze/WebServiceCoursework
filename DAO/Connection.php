<?php
/**
 * Class Connection
 * Class in charge the connect to the DB, execute SQL query with PDO and return the results
 */
class Connection extends PDO { 
	private $stmt;

	/** 
	 * Connection class constructor
	 * @param string $dsn 
	 * @param string $username
	 * @param string $password 
	*/ 
	public function __construct(string $dsn, string $username, string $password) { 
		parent::__construct($dsn,$username,$password,  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 
	
	/** 
	 * Method that execute a given sql query
	 * @param string $query 
	 * @param array $parameters * 
	 * @return bool Returns `true` on success, `false` otherwise 
	*/ 
	public function executeQuery(string $query, array $parameters = []) : bool{ 
		$this->stmt = parent::prepare($query); 
		foreach ($parameters as $name => $value) { 
			$this->stmt->bindValue($name, $value[0], $value[1]); 
		}

		return $this->stmt->execute(); 
	}

	/**
	 * Method that return the result of the last query
	 */
	public function getResults() : array {
		return $this->stmt->fetchall();
	}
}

?>
