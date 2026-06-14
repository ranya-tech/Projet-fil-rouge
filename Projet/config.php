<?php
$host = 'localhost';
$dbname = 'smartphone_store';
$username = 'root';
$password = '';
try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
}catch(PDOxception $a){
    echo "Erreur: " . $a->getMessage();
}
?>