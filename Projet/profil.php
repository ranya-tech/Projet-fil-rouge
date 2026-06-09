<?php
session_start();
require 'config.php';

// Redirect if not logged in
if (!$_SESSION['user']) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="CSS/style_profil.css">
</head>
<body>

<header>
    <div class="header-logo">
        <img src="asset/Logo.png" alt="Smartphone">
    </div>
    <nav>
        <a href="Accueil.php">Accueil</a>
        <a href="category.php">Categorie</a>
        <a href="panier.php"><img src="asset/panier.png" alt="Panier" width="16">Panier</a>
        <a href="logout.php" class="btn-deconnexion">Déconnexion</a>
    </nav>
</header>
<main>
    <div></div>
</main>

<footer>
    <p>&copy; 2026 Smartphone. All rights reserved.</p>
</footer>

</body>
</html>