<?php

class OptionalValidation
{

// return relocation options
    static function getLocation()
    {
        return array("yes", "no",
            "maybe");
    }

//checks each selected jobs checkbox selection against a list of valid options.
    static function getSelectionsJob() {
        return array("JavaScript","PHP","Java",
            "Python","HTML","CSS","ReactJS","NodeJs");


    }

// checks each selected verticals checkbox selection against a list of valid options
    static function getSelectionsVerticals() {
        return array("SaaS","Health tech","Ag tech",
            "HR tech","Industrial tech","Cybersecurity");
    }
}