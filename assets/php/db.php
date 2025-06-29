<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $dsn = "mysql:dbname=multibricolage;host=localhost;port=3306";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")
    );

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit; 
}
?>