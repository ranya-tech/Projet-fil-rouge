<?php
require 'config.php';
$sql = ""
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_acc.css">
</head>
<body>
    <header>
        <div class="head">
            <img src="asset/Logo.png" alt="Smartphone">
            <nav>
                <a href="Accueil.php">Accueil</a>
                <a href="category.php">Categorie</a>
                <a href="panier.php"><img src="asset/panier.png" alt="Panier" width="14"> Panier</a>
                <button>Connexion</button>
            </nav>
        </div>
        <div class="hero">
            <h1>Trouver le Smartphones Parfait!</h1>
            <p>Les millieurs modeles aux millieurs prix!</p>
            <form method="get" class="buttons">
                <button class="promo">Promotions</button>
                <button class="nouveau">Nouveautés</button>
            </form>
            
        </div>
    </header>
    <main>
        <div class="event">
            <div class="card">
                <img src="asset/modele.png" alt="" width="300">
                <a href="category.php">Voir Plus</a>
            </div>
            <div class="card">
                <img src="asset/promo.jpg" alt="" width="300">
                <a href="category.php">Voir Plus</a>
            </div>
            <div class="card">
                <img src="asset/accessoires.jpg" alt="" width="300">
                <a href="category.php">Voir Plus</a>
            </div> 
        </div>
        <div class="most_selling">
            <!-- foreach code php -->
            <p>Les Plus Vendus</p>
            <div class="card">
                <img src="asset/galaxy Z flip.jpg" alt="" width="300">
                <p></p>
                <h3></h3>
                <a href="">Voir Plus</a>
            </div>
            <div class="card">
                <img src="asset/iphone.png" alt="" width="300">
                <p></p>
                <h3></h3>
                <a href="">Voir Plus</a>
            </div>
            <div class="card">
                <img src="asset/galaxy A55µ.jpg" alt="" width="300">
                <p></p>
                <h3></h3>
                <a href="">Voir Plus</a>
            </div> 
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