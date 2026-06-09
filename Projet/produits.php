<?php
session_start();
require 'config.php';
//To affiche just three phones
$sql = "SELECT * FROM Phones";
$stmt = $pdo->query($sql);
$phones = $stmt->fetchAll(PDO:: FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <img src="asset/admin.png" alt="Admin">
        <nav>
            <a href="admin/admin.php">Dashboard</a>
            <a href="admin/produits.php">Produits</a>
            <a href="#">Commandes</a>
        </nav>
    </header>
    <main>
        <div class="cards">
            <?php foreach($produits as $produit){?>
            <div class="card">
                <img src="asset/<?php echo ($produit['image']); ?>" alt="<?php echo ($produit['modele']); ?>" height="340">
                <p><?php echo ($produit['marque']); ?></p>
                <h3><?php echo ($produit['modele']); ?></h3>
                <p><?php echo ($produit['prix']); ?></p>
                <a href="details.php?id=<?= $produit['idPhone']; ?>">Voir Plus</a>
            </div>
            <?php }?>
        </div>
    </main>
</body>
</html>