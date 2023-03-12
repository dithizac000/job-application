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
    function saveApp($orderObj) {
        // 1. Define SQL statement
        $sql = "INSERT INTO jobs VALUES (null,:name,:link,:phone,:email,:state,:exp,:relocate,:list,:sub)";
// 2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);
// 3. Bind the parameters
        $name = $orderObj->getfname();
        $link = $orderObj->getGitHub();
        $phone = $orderObj->getPhone();
        $email = $orderObj->getEmail();
        $state = $orderObj->getState();
        $exp = $orderObj->getExp();
        $relocate = $orderObj-> getRelocate();
        $list = "";
        $sub = "";
        $statement->bindParam(':name', $name);
        $statement->bindParam(':link', $link);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':state', $state);
        $statement->bindParam(':exp', $exp);
        $statement->bindParam(':relocate', $relocate);
        $statement->bindParam(':list', $list);
        $statement->bindParam(':sub', $sub);
// 4. Execute teh query
        $statement->execute();

    }
}