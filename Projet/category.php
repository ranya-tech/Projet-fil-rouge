<?php
require 'config.php';
// Shows all the products
$sql = "SELECT * FROM Phones";
// Array to stock the values that come from the filtre
$params = [];

// Filter by category
if (isset($_GET['filtre']) && !empty($_GET['filtre'])) {
    $sql .= " WHERE categorie = :categorie";
    $params['categorie'] = $_GET['filtre'];
}

// Search by model
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $sql .= (empty($params) ? " WHERE" : " AND") . " modele LIKE :search";
    $params['search'] = "%" . $_GET['search'] . "%";
}

// Sort
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] === 'price_asc')  $sql .= " ORDER BY prix ASC";
    if ($_GET['sort'] === 'price_desc') $sql .= " ORDER BY prix DESC";
    if ($_GET['sort'] === 'newest')     $sql .= " ORDER BY idPhone DESC";
}
// Prepare & Executation de request $sql
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style_cat.css">
</head>
<body>
    <header>
        <img src="asset/Logo.png" alt="Logo">
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
        <form method="get">
            <div class="filter-panel">
                <div class="buttons">
                    <button class="btn" name="filtre" value="phones">Phones</button>
                    <button class="btn" name="filtre" value="accessoirs">Accessoirs</button>
                </div>
            
                <div class="search">
                    <span class="search-icon"><img src="asset/Search.png" width="19"></span>
                    <input type="text" placeholder="Recherche..." name="search">
                </div>
            
                <div class="sort" name="sort">
                    <label for="sort-select">Trier par:</label>
                    <select id="sort-select" name="sort" onchange="this.form.submit()">
                        <option value="">--</option>
                        <option value="newest">Nouveautés</option>
                        <option value="price_asc">Du moins cher au plus cher</option>
                        <option value="price_desc">Du plus cher au moins cher</option>
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
            <a href="Accueil.php">Accueil</a>
            <a href="category.php">Categories</a>
            <a href="login.php">Connexion</a>
            <img src="asset/facebook.png" alt="Facebook" width="40">
            <img src="asset/insta.png" alt="Instagram" width="40">
            <img src="asset/twiter.png" alt="Twitter" width="40">
        </div>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>