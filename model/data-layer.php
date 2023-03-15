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
        $sql = "INSERT INTO jobs (`id`, `fname`, `lname`, `github`, `phone`, `email`, `state`, `experience`, `relocate`) 
VALUES (null,:fname,:lname,:link,:phone,:email,:state,:exp,:relocate)";
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
        $statement->bindParam(':lname', $lname);
        $statement->bindParam(':link', $link);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':state', $state);
        $statement->bindParam(':exp', $exp);
        $statement->bindParam(':relocate', $relocate);

        // 4. Execute teh query
        $statement->execute();

    }

    function insertList($order,$otherOrder)
    {
        $sql = "UPDATE INTO jobs SET lists = :list,subscriptions = :sub, verticals = :vert WHERE id = :id";
        $statement = $this->_dbh->prepare($sql);

        $list = $otherOrder->getMail();
        $sub = $order->getSelectionsJobs();
        $vert = $order->getSelectionsVerticals();
        $id = $this->_dbh->lastInsertId();
        $statement->bindParam(':list', $list);
        $statement->bindParam(':sub', $sub);
        $statement->bindParam(':vert', $vert);
        $statement->bindParam(':id', $id);
        $statement->execute();


    }

    /** This functions fetch all the file in the data
     * @return void
     */
    function getApplicants()
    {
        $sql = "SELECT * FROM jobs ORDER BY lname"; // multi. rows
        $statement = $this->_dbh->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    /** This functions selects the id and showcase the seleted row conencted with the id
     * @param $app_id
     * @return voidT
     */
    function getApplicant($app_id) {
        $sql = "SELECT * FROM jobs WHERE id = :id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /** This functiongs returns the subscription selection from the job page
     * @param $app_id
     * @return void
     */
    function getSubscrtiptions($app_id) {
        $sql = "SELECT subscriptions FROM jobs  WHERE id = :id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);

    }

}