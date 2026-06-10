<?php
require '../config.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM Phones WHERE idPhone = :id";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
    header('Location: produits.php');
    exit;
}
?>