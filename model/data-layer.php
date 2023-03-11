<?php
require_once('/home/zackdith/app-pdo.php'); // connect sql via this file from home cPanel file manager

class DataLayer
{
    private $_dbh; // database connection object
    function __construct()
    {
        try {
            // Instantiate a PDO object
            $this->_dbh = new PDO(DB_DRIVER, USERNAME, PASSWORD);
            //echo "Working!";
        } catch(PDOException $exception) {
            echo $exception->getMessage();
        }
    }
}