<?php
session_start();
require 'config.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM Phones WHERE idPhone = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
    $phone = $stmt->fetch(PDO:: FETCH_ASSOC);
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
        exit;
    }else{
        $idphone = $_POST['phoneId']; 
        $quantite = 1;
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
        if (isset($_SESSION['panier'][$idphone])) {
            $_SESSION['panier'][$idphone] += $quantite;
        } else {
            $_SESSION['panier'][$idphone] = $quantite;
        }  
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style_det.css">
</head>
<body>
    <header>
        <img src="asset/Logo.png" alt="Smartphone">
        <nav>
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categorie</a>
            <a href="panier.php"><img src="asset/panier.png" alt="Panier" width="16">Panier</a>
            <?php 
                if(isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    echo "<a href='profil.php' class='profil'>" .$user['name'] . "</a>";
                }else{
                    echo "<a href='login.php' class='profil'>Connecter</a>";
                }
            ?>
        </nav>
    </header>
    <main>
        <a href="category.php">Retour</a>
        <div class="card">
            <div class="image">
                <img src="asset/<?php echo ($phone['image']); ?>" alt="<?php echo ($phone['modele']); ?>">
            </div>
            <div class="phone_info">
                <h1><?php echo ($phone['marque'] . ' ' . $phone['modele']); ?></h1>
                <div class="section">
                    <p class="section-title">À propos du produit :</p>
                    <p class="description"><?php echo ($phone['description'] ?? ''); ?></p>
                </div>

                <div class="section">
                    <p class="section-title">Prix :</p>
                    <p class="price"><?php echo ($phone['prix']); ?>DH</p>
                </div>
                <div class="section">
                    <p class="section-title">Couleur:</p>
                    <div class="color-options">
                        <span class="color-dot blue selected"></span>
                        <span class="color-dot silver"></span>
                        <span class="color-dot black"></span>
                    </div>
                </div>
                <div class="section">
                    <p class="section-title">Storage:</p>
                    <div class="storage-options">
                        <button class="storage-btn">256GB</button>
                        <button class="storage-btn active">512GB</button>
                        <button class="storage-btn">1TB</button>
                    </div>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="phoneId" value="<?=$phone['idPhone']; ?>">
                    <button class="add">&#128722;Ajouter au panier</button>
                </form>
            </div>
        </div>
        <section class="specs-section">
            <h2>Technical Specifications</h2>
            <div class="specs-table">
                <div class="spec-row">
                    <span class="spec-label">RAM</span>
                    <span class="spec-value"><?php echo ($phone['ram']); ?></span>
                </div>
                <div class="spec-row">
                    <span class="spec-label">BATTERIE</span>
                    <span class="spec-value"><?php echo ($phone['batterie']); ?></span>
                </div>
                <div class="spec-row">
                    <span class="spec-label">CAMERA</span>
                    <span class="spec-value"><?php echo ($phone['camera']); ?></span>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-container">
            <img src="asset/Logo.png" alt="Smartphone">
            <a href="">Accueil</a>
            <a href="">Categories</a>
            <a href="">Connexion</a>
            <img src="asset/facebook.png" alt="Facebook" width="40">
            <img src="asset/insta.png" alt="Instagram" width="40">
            <img src="asset/twiter.png" alt="Twitter" width="40">
        </div>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>