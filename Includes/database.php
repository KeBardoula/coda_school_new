<?php
$servername = "localhost";
$dbname = "Coda_school";
$username = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:servername=$servername;dbname=$dbname", $username, $password);
} catch (PDOException $e){
    die ("Erreur de connection à $dbname :" . $e->getMessage());
}
?>