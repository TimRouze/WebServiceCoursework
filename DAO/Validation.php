<?php

class Validation {

    static function sanitizeString($string){ return filter_var($string, FILTER_SANITIZE_STRING); }

    static function isStringNull(string $string){ return !isset($string) || $string==""; }

    static function isSiteFormOk(string $siteName, string $rssUrl) {
        $errors = [];

        if (self::isStringNull($siteName)) $errors['siteName'] = "Name is required";
        if (self::isStringNull($rssUrl)) $errors['rssUrl'] =	"Url is required";
        if(!filter_var($rssUrl, FILTER_VALIDATE_URL)) $errors['rssUrl'] =	"Url is not valid";

        return $errors;
    }

    static function isAdminFormOk(string $userName, string $password){
        $errors = [];

        if (self::isStringNull($userName)) $errors['userName'] = "Admin Name is required";
        if (self::isStringNull($password)) $errors['password'] = "Password is required";

        return $errors;
    }
}
?>