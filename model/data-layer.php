<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../app-pdo.php'); // connect sql via this file from home cPanel file manager

/**
 * This class connects to our database in cPanel
 */
class DataLayer
{
    private $_dbh; // database connection object

    // default constructor that try catch PDO
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

    /** This functions insert save application into our data base
     * @param $orderObj
     * @return void
     */
    function saveOrder($orderObj) {
        // 1. DEFINE QUERY
        $sql = "INSERT INTO jobs VALUES (null,:name,:link,:phone,:email,:state,:exp,:relocate,:list,:sub)";
        // 2. PREPARE THE STATEMENT
        $statement = $this->_dbh->prepare($sql);
        // 3. BIND THE PARAMETERS
        $statement->bindParam(':name',
         );
    }
}