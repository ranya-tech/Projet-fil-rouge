<?php
require 'config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_log.css">
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
        <form method="post">
            <!-- if connexion afficher form w ila inscrire afiicher form akhra (PHP)-->
            <button class="login">Connexion</button><button class="signup" name>S'inscrire</button>
            <label for="">Email</label>
            <input type="email" name="email" placeholder="">
            <label for="">Mot de passe</label>
            <input type="password" name="password" placeholder="">
            <button class="connecter">Se connecter</button>
        </form> 
    </main>
    <footer>
        <p>&copy; 2026 Smartphone. All rights reserved.</p>
    </footer>
</body>
</html>