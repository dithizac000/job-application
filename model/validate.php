<?php

class Validation
{

// checks to see that a string is all alphabetic, first name .
    static function validName($name) {

        // must have a tleast two char
        return strlen($name) > 2;

    }

// checks to see that a string is a valid github url.
    static function validGithub($link) {
        return (bool)filter_var($link, FILTER_VALIDATE_URL);
    }

// checks to see that a phone number is valid (you can decide what constitutes a valid phone number, just make sure to check that there are numeric values entered).
    static function validPhone($phone) {
        return (bool)preg_match("/^[0-9]{10}+$/", $phone);
    }

//get years value
    static function getYears() {
        return array("0-2", "2-4",
            "4+");

    }
// checks to see that a string is a valid “value” property.
    static function validYears($years)
    {
        return in_array($years,self::getYears());
    }

//checks to see that an email address is valid
    static function validEmail($email) {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}


