<?php

// 328/diner/controller/controller.php

class Control
{
    private $_f3; //Fat-Free object

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        $view = new Template(); // template is a fat free class
        echo $view->render("views/home.html"); // render method, return text on template
    }

    function info()
    {

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
                $this->_f3->set('errors["name"]',
                    'Name must have at least 2 characters');
            }

            // email validation
            $email = trim($_POST['email']);
            if(Validation::validEmail($email)) {
                $newApp->setEmail($email);
            }
            else $this->_f3->set('errors["email"]',
                'Email must follow format email@example.com');


            // phone validation
            $phone = trim($_POST['phone']);
            if(Validation::validPhone($phone))
            {
                $newApp->setPhone($phone);
            }
            else $this->_f3->set('errors["phone"]',
                'Phone number must have at least 10 digits');


            // checkbox for mailing
            $mailbox = $_POST['mailingBox'];
            if (isset($_POST['mailingBox'])){
                $newApp->setMail($mailbox);
            }

            // if no errors, then reroute
            if(empty($this->_f3->get('errors'))) {
                //mailing session
                $_SESSION['newApp'] = $newApp;
                $this->_f3->reroute('experience');
            }
        }
        //instantiate a view
        $view = new Template(); /// template is a fat free class
        echo $view->render("views/info.html"); // render method, return text on template
    }

    function expereince()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //set and session variables
            $_SESSION['newApp']->setBio($_POST['bio']);

            $_SESSION['newApp']->setRelocate($_POST['relocate']);

            //validate years selection
            $years = $_POST['years'];
            if(Validation::validYears($years)) {
                $_SESSION['newApp']->setExp($years);
            }
            else $this->_f3->set('errors["years"]',
                'Must Select Years');

            //validate link git hub
            $link = trim($_POST['link']);
            if(Validation::validGithub($link)) {
                $_SESSION['newApp']->setGitHub($link);
            }
            else $this->_f3->set('errors["link"]',
                'Valid URL Format: http://www.example.com');

            //Redirect to mailing page
            //if there are no errors
            if (empty($this->_f3->get('errors')) && ($_SESSION['newApp']->getMail() == 'mailingBox')) {
                $this->_f3->reroute('mailing');
            } elseif(empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('summary');
            }
        }

        //Add years to F3 hive
        $this->_f3->set('years', Validation::getYears());
        $this->_f3->set('relocate', OptionalValidation::getLocation());
        // instantiate a view
        $view = new Template();
        echo $view->render("views/experience.html");
    }

    function mailing()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //instantiate extend class
            $app = new Applicant_SubscribedToLists();

            if (isset($_POST['software'])) {
                // move data from POST array to SESSION array
                $arraySoftware = implode(", ", $_POST['software']);
                $app->setSelectionsJobs($arraySoftware);
            }
            if (isset($_POST['industry'])) {
                $arrayIndustry = implode(", ", $_POST['industry']);
                $app->setSelectionsVerticals($arrayIndustry);

            }
            $_SESSION['app'] = $app;
            $this->_f3->reroute('summary');
        }

        //Add array software and industry to the hive
        $this->_f3->set('software', OptionalValidation::getSelectionsJob());
        $this->_f3->set('industry', OptionalValidation::getSelectionsVertical());


        // instantiate a view
        $view = new Template();
        echo $view->render("views/mailing.html");
    }

    function summary()
    {
        print_r($_SESSION);
        // write to database
        $id = $GLOBALS['data']->saveApp($_SESSION['newApp']);
        echo "ORDER ID: ". $id;
        //instantiate a view
        $view = new Template(); // template is a fat free class
        echo $view->render("views/summary.html"); // render method, return text on template
        //destroy session array
        session_destroy();
    }

    function admin()
    {
        //instantiate a view
        $view = new Template(); // template is a fat free class
        echo $view->render("views/admin.html"); // render method, return text on template

    }
}