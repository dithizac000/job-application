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
    function insertApplicant($orderObj)
    {
        // 1. Define SQL statement
        $sql = "INSERT INTO jobs VALUES (null,:fname,:lname,:link,:phone,:email,:state,:exp,:relocate,null,null)";
        // 2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);
        // 3. Bind the parameters
        $fname = $orderObj->getfname();
        $lname = $orderObj->getlname();
        $link = $orderObj->getGitHub();
        $phone = $orderObj->getPhone();
        $email = $orderObj->getEmail();
        $state = $orderObj->getState();
        $exp = $orderObj->getExp();
        $relocate = $orderObj-> getRelocate();

        $statement->bindParam(':fname', $fname);
        $statement->bindParam(':flame', $lname);
        $statement->bindParam(':link', $link);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':state', $state);
        $statement->bindParam(':exp', $exp);
        $statement->bindParam(':relocate', $relocate);

        // 4. Execute teh query
        $statement->execute();

    }

    /** This functions fetch all of the file in the data
     * @return void
     */
    function getApplicants()
    {
        $sql = "SELECT * FROM jobs"; // multi. rows
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    /** This functions selects the id and showcase the seleted row conencted with the id
     * @param $app_id
     * @return voidT
     */
    function getApplicant($app_id) {

    }

    /** This functiongs returns the subscription selection from the job page
     * @param $app_id
     * @return void
     */
    function getSubscrtiptions($app_id) {

    }

}