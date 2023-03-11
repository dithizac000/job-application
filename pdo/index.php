<?php
//SDEV328/pdo/index.php

//error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);
echo "<h1>PDO TEST</h1>";

//app.pdo.php
require('/home/zackdith/app-pdo.php');

try {
    // instantiate a PDO object
    $dbh = new PDO(DB_DRIVER, USERNAME, PASSWORD);
    echo "Working!";
} catch(PDOException $exception) {
    echo $exception->getMessage();
}
/**
 * Insert Table row w/ 5 steps query into jobs
 */
// 1. Define SQL statement
$sql = "INSERT INTO jobs VALUES (null,:name,:link,:phone,:email,:state,:exp,:relocate,:list,:sub)";
// 2. Prepare the statement
$statement = $dbh->prepare($sql);
// 3. Bind the parameters
$name = "Ryan Z";
$link = "github.com/ryanZ";
$phone = "52345324";
$email = "ryan@gmail.com";
$state = "Alaska";
$exp = "3 years";
$relocate = "Yes";
$list = "No";
$sub = "Zoo.com, Animals.com";
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
// 5. Process the result if there is one. Usually for SELECT query