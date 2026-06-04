<?php
require 'config.php';
$sql = 'SELECT * FROM Phones';
$stmt = $pdo->query($sql);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
//to affiche phones or accessoires
if (isset($_GET['filtre'])) {
    $categorie = $_GET['filtre'];
    $sql = "SELECT * FROM Phones WHERE categorie = :categorie";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'categorie' => $categorie
    ]);
}

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_cat.css">
</head>
<body>
    <header>
        <img src="asset/Logo.png" alt="Logo">
        <nav>
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categorie</a>
            <a href="panier.php"><img src="asset/panier.png" alt="Panier" width="14">Panier</a>
            <button>Connexion</button>
        </nav>
    </header>
    <main>
        <form method="get">
            <div class="filtrer">
                <div class="buttons" name="filtre">
                    <button class="btn" name="phones">Phones</button>
                    <button class="btn" name="accessoirs">Accessoirs</button>
                </div>
            
                <div class="search" name="search">
                    <span class="search-icon"><img src="asset/Search.png" width="19"></span>
                    <input type="text" placeholder="Recherche...">
                </div>
            
                <div class="sort" name="sort">
                    <label for="sort-select">Sort by:</label>
                    <select id="sort-select">
                        <option>Newest Arrivals</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </form>
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