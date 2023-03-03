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
        $_SESSION['state'] = $_POST['state'];

        $newApp = new Application();
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


        // if no errors, then reroute
        if(empty($f3->get('errors'))) {
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
        //var dump for development
        //var_dump($_POST);

        // variables
        $_SESSION['bio'] = $_POST['bio'];

        $_SESSION['relocate'] = $_POST['relocate'];

        //validate years selection
        $years = $_POST['years'];;
        if(Validation::validYears($years)) $_SESSION['years'] = $years;
        else $f3->set('errors["years"]',
            'Must Select Years');

        //validate link git hub
        $link = trim($_POST['link']);
        if(Validation::validGithub($link)) $_SESSION['link'] = $link;
        else $f3->set('errors["link"]',
            'Valid URL Format: http://www.example.com');

        //Redirect to mailing page
        //if there are no errors
        if (empty($f3->get('errors'))) {
            $f3->reroute('mailing');
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
        //var dump for development
       // var_dump($_POST);


        if (isset($_POST['software']) && ($_POST['industry'])) {
            // Checkbox is selected
            // variables for arrays
            $_SESSION['software'] = implode(", ",$_POST['software']);
            $_SESSION['industry'] = implode(", ",$_POST['industry']);
        }
        else $f3->set('errors["select"]',
            'Must select at least one check box of both Software and Verticals');

        // direct to summary if no errors
        if (empty($f3->get('errors')))
            $f3->reroute('summary');

    }

    //Add array software and industry to the hive
    $f3->set('software', OptionalValidation::getSelectionsJob());
    $f3->set('industry', OptionalValidation::getSelectionsVerticals());


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