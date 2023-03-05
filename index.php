<?php
//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');
require_once('model/validate.php');
require_once('model/optional-valid.php');

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

    // if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // instantiate new app
        $newApp = new Application();

        /// set state
        $newApp->setState($_POST['state']);

        //trim post names
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        if(Validation::validName($fname) && Validation::validName($lname)) {
            // set app with post when validated
            $newApp->setfname($fname);
            $newApp->setlname($lname);

        } else {
            $f3->set('errors["name"]',
                'Name must have at least 2 characters');
        }

        // email validation
        $email = trim($_POST['email']);
        if(Validation::validEmail($email)) {
            $newApp->setEmail($email);
        }
        else $f3->set('errors["email"]',
            'Email must follow format email@example.com');


        // phone validation
        $phone = trim($_POST['phone']);
        if(Validation::validPhone($phone))
        {
            $newApp->setPhone($phone);
        }
        else $f3->set('errors["phone"]',
            'Phone number must have at least 10 digits');


        // checkbox for mailing
        $mailbox = $_POST['mailingBox'];
        if (isset($_POST['mailingBox'])){
            $newApp->setMail($mailbox);
        }

        // if no errors, then reroute
        if(empty($f3->get('errors'))) {
            //mailing session
            $_SESSION['newApp'] = $newApp;
            $f3->reroute('experience');
        }
    }
    //instantiate a view
    $view = new Template(); /// template is a fat free class
    echo $view->render("views/info.html"); // render method, return text on template
});

//reroute from info to views/experience.html
$f3->route('GET|POST /experience', function ($f3) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //set and session variables
        $_SESSION['newApp']->setBio($_POST['bio']);

        $_SESSION['newApp']->setRelocate($_POST['relocate']);

        //validate years selection
        $years = $_POST['years'];
        if(Validation::validYears($years)) {
            $_SESSION['newApp']->setExp($years);
        }
        else $f3->set('errors["years"]',
            'Must Select Years');

        //validate link git hub
        $link = trim($_POST['link']);
        if(Validation::validGithub($link)) {
            $_SESSION['newApp']->setGitHub($link);
        }
        else $f3->set('errors["link"]',
            'Valid URL Format: http://www.example.com');

        //Redirect to mailing page
        //if there are no errors
        if (empty($f3->get('errors')) && ($_SESSION['newApp']->getMail() == 'mailingBox')) {
            $f3->reroute('mailing');
        } elseif(empty($f3->get('errors'))) {
            $f3->reroute('summary');
        }
    }

    //Add years to F3 hive
    $f3->set('years', Validation::getYears());
    $f3->set('relocate', OptionalValidation::getLocation());
    // instantiate a view
    $view = new Template();
    echo $view->render("views/experience.html");
});

//reroute from experience to views/mailing.html
$f3->route('GET|POST /mailing', function ($f3) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //instantiate extend class
        $app = new Applicant_SubscribedToLists();

        if (isset($_POST['software']) && ($_POST['industry'])) {
            // move data from POST array to SESSION array
            $arraySoftware = implode(", ", $_POST['software']);
            $arrayIndustry = implode(", ", $_POST['industry']);
            $app->setSelectionsJobs($arraySoftware);
            $app->setSelectionsVerticals($arrayIndustry);
        }
            $_SESSION['app'] = $app;
            $f3->reroute('summary');
    }

    //Add array software and industry to the hive
    $f3->set('software', OptionalValidation::getSelectionsJob());
    $f3->set('industry', OptionalValidation::getSelectionsVertical());


    // instantiate a view
    $view = new Template();
    echo $view->render("views/mailing.html");
});

// route from mailing and var dump to views/summary.html
$f3->route('GET /summary', function($f3) {

    //instantiate a view
    $view = new Template(); // template is a fat free class
    echo $view->render("views/summary.html"); // render method, return text on template
    //destroy session array
    session_destroy();

});

//run fat free
$f3->run();