<?php
session_start();
require '../config.php';

$idCommande = $_GET['commande'] ?? null;
if (!$idCommande) {
    header('Location: panier.php');
    exit;
}

// Fetch order + delivery date
$stmt = $pdo->prepare("
    SELECT c.*, l.dateLivraison 
    FROM Commande c 
    JOIN Livraison l ON l.idCommande = c.idCommande 
    WHERE c.idCommande = :id
");
$stmt->execute(['id' => $idCommande]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch ordered products
$stmt = $pdo->prepare("
    SELECT p.*, pc.quantite, pc.couleur, pc.stockage
    FROM ProduitCmd pc 
    JOIN Phones p ON p.idPhone = pc.idPhones 
    WHERE pc.idCommande = :id
");
$stmt->execute(['id' => $idCommande]);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($produits as $p) {
    $total += $p['prix'] * $p['quantite'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Confirmée</title>
    <link rel="stylesheet" href="../CSS/style_panier.css">
    <link rel="stylesheet" href="../CSS/style_confirmer.css">
</head>
<body>
    <header>
        <img src="../asset/Logo.png" alt="Logo">
        <nav>
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categorie</a>
            <a href="panier.php"><img src="../asset/panier.png" alt="Panier" width="16">Panier</a>
            <?php 
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    echo "<a href='profil.php' class='profil'>" . $user['name'] . "</a>";
                } else {
                    echo "<a href='login.php' class='profil'>Connecter</a>";
                }
            ?>
        </nav>
    </header>

    <main>
        <a href="category.php" class="back-btn">← Retour</a>

        <div class="confirm-title">
            COMMANDE CONFIRMÉE
            <span class="checkmark">✓</span>
        </div>

        <!-- Order ID + Delivery Date -->
        <div class="order-meta">
            <div class="order-meta-item">
                <label>Order ID</label>
                <div class="order-id-val"><?= $idCommande ?></div>
            </div>
            <div class="order-meta-item">
                <label>Estimation de livraison</label>
                <div class="delivery-date">
                    PRÉVU POUR LE <?= strtoupper(date('d F', strtotime($commande['dateLivraison']))) ?>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="commande-card">
            <h3>Commande</h3>

            <?php foreach ($produits as $p): ?>
            <div class="commande-item">
                <img src="../asset/<?= $p['image'] ?>" alt="<?= $p['modele'] ?>">
                <div class="commande-item-info">
                    <strong><?= $p['marque'] . ' ' . $p['modele'] ?></strong>
                    <small><?= $p['couleur'] ?>, <?= $p['stockage'] ?></small>
                </div>
                <span class="commande-item-price"><?= number_format($p['prix'] * $p['quantite'], 0, '.', ',') ?>DH</span>
            </div>
            <?php endforeach; ?>

            <hr class="summary-divider">
            <div class="summary-row">
                <span>Sous-total</span>
                <span><?= number_format($total, 0, '.', ',') ?>DH</span>
            </div>
            <div class="summary-row">
                <span>Livraison</span>
                <span class="free">Gratuite</span>
            </div>
            <hr class="summary-divider">
            <div class="summary-total">
                <span>Total</span>
                <span><?= number_format($total, 0, '.', ',') ?>DH</span>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <img src="../asset/Logo.png" alt="Smartphone">
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categories</a>
            <a href="login.php">Connexion</a>
            <img src="../asset/facebook.png" alt="Facebook" width="40">
            <img src="../asset/insta.png" alt="Instagram" width="40">
            <img src="../asset/twiter.png" alt="Twitter" width="40">
        </div>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>