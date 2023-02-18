<?php
// return relocation options
function getLocation()
{
    return array("yes", "no",
        "maybe");
}

//checks each selected jobs checkbox selection against a list of valid options.
function getSelectionsJob() {
    return array("JavaScript","PHP","Java",
        "Python","HTML","CSS","ReactJS","NodeJs");


}

// checks each selected verticals checkbox selection against a list of valid options
function getSelectionsVerticals() {
    return array("SaaS","Health tech","Ag tech",
        "HR tech","Industrial tech","Cybersecurity");
}