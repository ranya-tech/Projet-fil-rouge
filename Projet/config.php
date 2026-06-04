<?php
$host = 'localhost';
$dbname = 'smartphone';
$username = 'root';
$password = '';
try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
}catch(PDOxception $a){
    echo "Erreur: " . $a->getMessage();
}
?>