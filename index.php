<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

//require autoload file
require_once('vendor/autoload.php');

//instantiate F3 base class
$f3 = Base::instance();

// define a home route (SDEV328/job-application)
$f3->route('GET /', function() {
    //instantiate a view
    $view = new Template(); // template is a fat free class
    echo $view->render("views/home.html"); // render method, return text on template
});

// info.html route (328/job-application/info.html)
$f3->route('GET /info', function () {
    //instantiate a view
    $view = new Template(); /// template is a fat free class
    echo $view->render("views/info.html"); // render method, return text on template
});

// info route -> views/info.html
$f3->route('GET|POST /process_1', function ($f3) {

    // if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_POST); // For development process

        // move data from POST array to SESSION array
        $_SESSION['food'] = $_POST['food'];
        $_SESSION['meal'] = $_POST['meal'];

        // redirect to summary page
        $f3->reroute('experience');
    }


    //instantiate a view
    $view = new Template(); /// template is a fat free class
    echo $view->render("views/info.html"); // render method, return text on template
});

//run fat free
$f3->run();