<?php
$servername = "localhost";
$dbname = "Coda_school";
$username = "root";
$password = "root";

try {
    $connect = new PDO("mysql:servername=$servername;dbname=$dbname", $username, $password);
} catch (PDOException $e){
    die ("Erreur de connection à $dbname :" . $e->getMessage());
}
?>