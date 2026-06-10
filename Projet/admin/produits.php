<?php
session_start();
require '../config.php';
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
    <link rel="stylesheet" href="../CSS/style_admin.css">

</head>
<body>
    <header>
        <img src="../asset/admin.png" alt="Admin">
        <nav>
            <a href="admin.php">Dashboard</a>
            <a href="produits.php">Produits</a>
            <a href="ajouter.php">Ajouter</a>
        </nav>
    </header>
    <main>
        <div class="cards">
            <?php foreach($phones as $phone): ?>
            <div class="card">
                <img src="../asset/<?= $phone['image'] ?>" alt="<?= $phone['modele'] ?>">
                <div class="card-info">
                    <p class="card-marque"><?= $phone['marque'] ?></p>
                    <h3 class="card-modele"><?= $phone['modele'] ?></h3>
                    <p class="card-prix"><?= number_format($phone['prix'], 0, '.', ',') ?>DH</p>
                    <div class="card-specs">
                        <span><strong> Stock:</strong> <?= $phone['stock'] ?></span>
                        <span><strong> RAM:</strong> <?= $phone['ram'] ?></span>
                        <span><strong> Stockage:</strong> <?= $phone['stockage'] ?></span>
                        <span><strong> Batterie:</strong> <?= $phone['batterie'] ?></span>
                        <span><strong> Caméra:</strong> <?= $phone['camera'] ?></span>
                    </div>
                    <p class="card-description"><?= $phone['description'] ?></p>
                    <div class="card-actions">
                        <a href="modifier.php?id=<?= $phone['idPhone'] ?>" class="btn-modifier"> Modifier</a>
                        <a href="remove.php?id=<?= $phone['idPhone'] ?>"   class="btn-supprimer"> Supprimer</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>