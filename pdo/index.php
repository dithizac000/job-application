<?php

//SDEV328/pdo/index.php

//error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
echo "<h1>PDO TEST</h1>";

require('/home/zackdith/app-pdo.php');
try {
    // instantiate a PDO object
    $dbh = new PDO(DB_DRIVER, USERNAME, PASSWORD);
    //echo "Working!";
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
