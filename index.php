<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');

//Start a session AFTER requiring autoload.php
session_start();
//var_dump($_SESSION);
//instantiate F3 base class
$f3 = Base::instance();

//Instantiate a Controller and DataLayer object
$control = new Control($f3);

// define a home route (SDEV328/job-application)
$f3->route('GET /', function() {
    //instantiate a view
    $GLOBALS['control']->home();
});

// info.html route (328/job-application/info.html)
$f3->route('GET|POST /info', function ($f3) {
    $GLOBALS['control']->info();

});

//reroute from info to views/experience.html
$f3->route('GET|POST /experience', function ($f3) {
    $GLOBALS['control']->expereince();

});

//reroute from experience to views/mailing.html
$f3->route('GET|POST /mailing', function ($f3) {
    $GLOBALS['control']->mailing();

});

// route from mailing and var dump to views/summary.html
$f3->route('GET /summary', function($f3) {
    $GLOBALS['control']->summary();

});

// render views/admin.html
$f3->route('GET /admin', function($f3) {
    $GLOBALS['control']->admin();

});

//run fat free
$f3->run();