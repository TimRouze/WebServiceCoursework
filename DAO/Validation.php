<?php
/**
 * This class is in charge to validate what the client send us.
 * Our sanitization policy is that the controllers directly sanitize the string that the client send us. (action, username etc ...) 
 * And after this sanitization, this class can be called again to verify the coherence of the data. (Ex : is this field really and url ?)
 */
class Validation {
	/** 
	 * Sanitize a string. Can handle a null object
	 * @param $string
	 * @return string
	*/ 
    static function sanitizeString($string){ return filter_var($string, FILTER_SANITIZE_STRING); }

	/** 
	 * Verify if a string is null or empty
	 * @param string $string
	 * @return bool
	*/ 
    static function isStringNull(string $string){ return !isset($string) || $string==""; }

	/** 
	 * Verify that the form to add a website and a rss flux is correct
	 * @param string $siteName
	 * @param string $rssUrl
	 * @return bool
	*/ 
    static function isSiteFormOk(string $siteName, string $rssUrl) {
        $errors = [];

        if (self::isStringNull($siteName)) $errors['siteName'] = "Name is required";
        if (self::isStringNull($rssUrl)) $errors['rssUrl'] =	"Url is required";
        if(!filter_var($rssUrl, FILTER_VALIDATE_URL)) $errors['rssUrl'] =	"Url was not a valid URL";

        return $errors;
    }

	/** 
	 * Verify that the form to connect as an admin is correct
	 * @param string $userName
	 * @param string $password
	 * @return bool
	*/ 
    static function isAdminFormOk(string $userName, string $password){
        $errors = [];

        if (self::isStringNull($userName)) $errors['userName'] = "Admin Name is required";
        if (self::isStringNull($password)) $errors['password'] = "Password is required";

        return $errors;
    }
}
?>