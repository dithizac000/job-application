<?php
require_once('/home/zackdith/app-pdo.php'); // connect sql via this file from home cPanel file manager

class DataLayer
{
    function __construct()
    {
        try {
            // Instantiate a PDO object
            $dbh = new PDO(DB_DRIVER, USERNAME, PASSWORD);
            //echo "Working!";
        } catch(PDOException $exception) {
            echo $exception->getMessage();
        }
    }
}