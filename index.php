<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

//require autoload file
require_once('vendor/autoload.php');
require_once('model/validate.php');
require_once('model/optional-valid.php');

//instantiate F3 base class
$f3 = Base::instance();

// define a home route (SDEV328/job-application)
$f3->route('GET /', function() {
    //instantiate a view
    $view = new Template(); // template is a fat free class
    echo $view->render("views/home.html"); // render method, return text on template
});

// info.html route (328/job-application/info.html)
$f3->route('GET|POST /info', function ($f3) {

    // if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST); // For development process

        //trim post names
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        if(validName($fname) && validName($lname)) {
            // move data from POST array to SESSION array
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
        } else {
            $f3->set('name must have at least 2 characters');
        }

        // if no errors, then reroute
        if(empty($f3->get('errors'))) $f3->reroute('experience');
    }
    //instantiate a view
    $view = new Template(); /// template is a fat free class
    echo $view->render("views/info.html"); // render method, return text on template
});

//reroute from info to views/experience.html
$f3->route('GET|POST /experience', function ($f3) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var dump for development
        var_dump($_POST);

        // variables
        $_SESSION['bio'] = $_POST['bio'];
        $_SESSION['link'] = $_POST['link'];
        $_SESSION['years'] = $_POST['years'];
        $_SESSION['relocate'] = $_POST['relocate'];

        // direct to mailing
        $f3->reroute('mailing');
    }
    // instantiate a view
    $view = new Template();
    echo $view->render("views/experience.html");
});

//reroute from experience to views/mailing.html
$f3->route('GET|POST /mailing', function ($f3) {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var dump for development
        var_dump($_POST);

        // variables for arrays
        $_SESSION['software'] = implode(", ",$_POST['software']);
        $_SESSION['industry'] = implode(", ",$_POST['industry']);


        // direct to mailing
        $f3->reroute('summary');
    }
    // instantiate a view
    $view = new Template();
    echo $view->render("views/mailing.html");
});

// route from mailing and var dump to views/summary.html
$f3->route('GET /summary', function() {
    //instantiate a view
    $view = new Template(); // template is a fat free class
    echo $view->render("views/summary.html"); // render method, return text on template
});

//run fat free
$f3->run();