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
    }

    function expereince()
    {

    }

    function mailing()
    {
    }

    function summary()
    {

    }

}