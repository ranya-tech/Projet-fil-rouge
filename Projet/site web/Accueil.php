<?php
session_start();
require '../config.php';
//To affiche just three phones
$sql = "SELECT * FROM Phones LIMIT 3";
$stmt = $pdo->query($sql);
$phones = $stmt->fetchAll(PDO:: FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/style_acc.css">
</head>
<body>
    <header>
        <div class="head">
            <img src="../asset/Logo.png" alt="Smartphone">
            <nav>
                <a href="Accueil.php">Accueil</a>
                <a href="category.php">Categorie</a>
                <a href="panier.php"><img src="../asset/panier.png" alt="Panier" width="16">Panier</a>
                <?php 
                    //Showing user profile or login button based on session
                    if(isset($_SESSION['user'])){
                        $user = $_SESSION['user'];
                        echo "<a href='profil.php' class='profil'>" .$user['name'] . "</a>";
                    }else{
                        echo "<a href='login.php' class='profil'>Connecter</a>";
                    }
                ?>
        </nav>
        </div>
        <div class="hero">
            <h1>Trouver le Smartphones Parfait!</h1>
            <p>Les millieurs modèles aux meilleurs prix!</p>
<!-- To go to the category page and get filtered by the newest or the promotion -->
            <form action="category.php" method="get" class="buttons">
                <button type="submit" name="sort" value="price_asc" class="promo">Promotions</button>
                <button type="submit" name="sort" value="newest" class="nouveau">Nouveautés</button>
            </form>
        </div>
    </header>
    <main>
        <div class="event">
            <div class="card">
                <!-- To go to the category page and get filtered by the newest or the promotion or the accessoires-->
                <img src="../asset/modele.png" alt="" width="300">
                <a href="category.php?sort=newest">Voir Plus</a>
            </div>
            <div class="card">
                <img src="../asset/promo.jpg" alt="" width="300">
                <a href="category.php?sort=price_asc">Voir Plus</a>
            </div>
            <div class="card">
                <img src="../asset/accessoires.jpg" alt="" width="300">
                <a href="category.php?filtre=accessoirs">Voir Plus</a>
            </div> 
        </div>
        <div class="most_selling">
            <p>Les Plus Vendus</p>
            <!-- Affichage of the three phones from the request above -->
            <?php foreach($phones as $phone){?>
            <div class="card">
                <img src="../asset/<?php echo ($phone['image']); ?>" alt="<?php echo ($phone['modele']); ?>" width="300">
                <p><?php echo ($phone['marque']); ?></p>
                <h3><?php echo ($phone['modele']); ?></h3>
                <p><?php echo ($phone['prix']); ?></p>
                <a href="details.php?id=<?= $phone['idPhone']; ?>">Voir Plus</a>
            </div>
            <?php }?>
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